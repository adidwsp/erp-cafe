<?php
// application/controllers/Debug.php
defined('BASEPATH') or exit('No direct script access allowed');

class Debug extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load database
        $this->load->database();

        // Load helper
        $this->load->helper('url');

        // Only allow in development
        if (ENVIRONMENT !== 'development') {
            show_error('Debug hanya boleh diakses di environment development', 403);
        }
    }

    public function index()
    {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Debug Database</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .success { color: green; }
                .error { color: red; }
                pre { background: #f4f4f4; padding: 10px; overflow: auto; }
            </style>
        </head>
        <body>
        <h1>Debug Database Structure</h1>";

        // Cek koneksi database
        echo "<h2>1. Koneksi Database</h2>";
        try {
            $this->db->query('SELECT 1');
            echo "<p class='success'>✓ Koneksi database berhasil</p>";
        } catch (Exception $e) {
            echo "<p class='error'>✗ Koneksi database gagal: " . $e->getMessage() . "</p>";
        }

        // Cek apakah tabel permissions ada
        echo "<h2>2. Cek Tabel Permissions</h2>";
        if ($this->db->table_exists('permissions')) {
            echo "<p class='success'>✓ Tabel permissions ADA</p>";

            // Tampilkan struktur
            $fields = $this->db->list_fields('permissions');
            echo "<p>Kolom: " . implode(', ', $fields) . "</p>";

            // Tampilkan data
            $data = $this->db->get('permissions')->result();
            echo "<p>Jumlah data: " . count($data) . "</p>";

            if ($data) {
                echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Role/Role ID</th>
                        <th>Module</th>
                        <th>View</th>
                        <th>Create</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>";

                foreach ($data as $row) {
                    echo "<tr>
                        <td>{$row->id}</td>
                        <td>";

                    // Cek apakah kolomnya role atau role_id
                    if (isset($row->role_id)) {
                        echo "role_id: {$row->role_id}";
                    } elseif (isset($row->role)) {
                        echo "role: {$row->role}";
                    } else {
                        echo "Tidak ada kolom role/role_id";
                    }

                    echo "</td>
                        <td>{$row->module}</td>
                        <td>{$row->can_view}</td>
                        <td>{$row->can_create}</td>
                        <td>{$row->can_edit}</td>
                        <td>{$row->can_delete}</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='error'>Tabel permissions kosong</p>";
            }

            // Tampilkan CREATE TABLE syntax
            $query = $this->db->query("SHOW CREATE TABLE permissions");
            $row = $query->row();
            echo "<h3>Struktur Tabel Permissions:</h3>
                  <pre>" . htmlspecialchars($row->{'Create Table'}) . "</pre>";
        } else {
            echo "<p class='error'>✗ Tabel permissions TIDAK ADA</p>";

            // Coba buat tabel
            echo "<h3>Membuat Tabel Permissions...</h3>";
            $sql = "CREATE TABLE IF NOT EXISTS permissions (
                id INT PRIMARY KEY AUTO_INCREMENT,
                role VARCHAR(50) NOT NULL,
                module VARCHAR(50) NOT NULL,
                can_view TINYINT(1) DEFAULT 0,
                can_create TINYINT(1) DEFAULT 0,
                can_edit TINYINT(1) DEFAULT 0,
                can_delete TINYINT(1) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY unique_role_module (role, module)
            )";

            if ($this->db->query($sql)) {
                echo "<p class='success'>✓ Tabel permissions berhasil dibuat</p>";
            } else {
                echo "<p class='error'>✗ Gagal membuat tabel permissions</p>";
            }
        }

        // Cek tabel roles
        echo "<h2>3. Cek Tabel Roles</h2>";
        if ($this->db->table_exists('roles')) {
            echo "<p class='success'>✓ Tabel roles ADA</p>";

            $fields = $this->db->list_fields('roles');
            echo "<p>Kolom: " . implode(', ', $fields) . "</p>";

            $data = $this->db->get('roles')->result();
            echo "<p>Jumlah data: " . count($data) . "</p>";

            if ($data) {
                echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Role Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                    </tr>";

                foreach ($data as $row) {
                    echo "<tr>
                        <td>{$row->id}</td>
                        <td>{$row->role_name}</td>
                        <td>{$row->display_name}</td>
                        <td>{$row->description}</td>
                    </tr>";
                }
                echo "</table>";
            }
        } else {
            echo "<p class='error'>✗ Tabel roles TIDAK ADA</p>";
        }

        // Cek tabel users
        echo "<h2>4. Cek Tabel Users</h2>";
        if ($this->db->table_exists('users')) {
            echo "<p class='success'>✓ Tabel users ADA</p>";

            $fields = $this->db->list_fields('users');
            echo "<p>Kolom: " . implode(', ', $fields) . "</p>";

            // Cek apakah kolom role ada
            if ($this->db->field_exists('role', 'users')) {
                echo "<p class='success'>✓ Kolom 'role' ADA di tabel users</p>";

                // Hitung user per role
                $this->db->select('role, COUNT(*) as total');
                $this->db->group_by('role');
                $result = $this->db->get('users')->result();

                echo "<table>
                    <tr>
                        <th>Role</th>
                        <th>Total User</th>
                    </tr>";

                foreach ($result as $row) {
                    echo "<tr>
                        <td>{$row->role}</td>
                        <td>{$row->total}</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='error'>✗ Kolom 'role' TIDAK ADA di tabel users</p>";
            }
        }

        echo "</body></html>";
    }

    // Cek query terakhir yang error
    public function last_query()
    {
        echo "<h1>Last Query Debug</h1>";

        // Enable profiler
        $this->output->enable_profiler(TRUE);
    }
}
