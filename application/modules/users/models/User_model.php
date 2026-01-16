<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    // Ambil list dengan pagination & search
    public function get_all($limit = 10, $offset = 0, $search = null)
    {
        $this->db->select('id, name, email, role, created_at');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('role', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        $this->db->limit((int)$limit, (int)$offset);

        return $this->db->get($this->table)->result();
    }

    // Hitung total untuk pagination
    public function count_all($search = null)
    {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('role', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results($this->table);
    }

    // Ambil user by ID
    public function get_by_id($id)
    {
        return $this->db->where('id', (int)$id)->get($this->table)->row();
    }

    // Ambil user by email
    public function get_by_email($email)
    {
        $email = strtolower(trim($email));
        return $this->db->where('email', $email)->get($this->table)->row();
    }

    // Insert user baru
    public function insert($data)
    {
        // Pastikan email lowercase dan trim
        if (isset($data['email'])) {
            $data['email'] = strtolower(trim($data['email']));
        }

        // Hash password jika ada
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Set created_at jika tidak ada
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // Update user
    public function update($id, $data)
    {
        // Pastikan email lowercase dan trim
        if (isset($data['email'])) {
            $data['email'] = strtolower(trim($data['email']));
        }

        // Hash password jika ada dan tidak kosong
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }

    // Delete user
    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }

    // Dapatkan daftar role yang tersedia
    public function get_roles_list()
    {
        return [
            'administrator' => 'Administrator',
            'owner' => 'Owner',
            'cashier' => 'Cashier',
            'hr_manager' => 'HR Manager',
            'sales_manager' => 'Sales Manager',
            'purchase_manager' => 'Purchase Manager',
            'inventory_manager' => 'Inventory Manager'
        ];
    }

    // Validasi login
    public function validate_login($email, $password)
    {
        $user = $this->get_by_email($email);

        if (!$user) {
            return false;
        }

        // Verifikasi password
        if (password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }

    // Update remember token
    public function update_remember_token($id, $token, $expire)
    {
        return $this->db->where('id', (int)$id)
            ->update($this->table, [
                'remember_token' => $token,
                'remember_expire' => $expire
            ]);
    }

    // Cari user berdasarkan remember token
    public function get_by_remember_token($token)
    {
        return $this->db->where('remember_token', $token)
            ->where('remember_expire >', date('Y-m-d H:i:s'))
            ->get($this->table)
            ->row();
    }

    // Clear remember token
    public function clear_remember_token($id)
    {
        return $this->db->where('id', (int)$id)
            ->update($this->table, [
                'remember_token' => null,
                'remember_expire' => null
            ]);
    }

    // Cek apakah email sudah terdaftar (untuk validasi)
    public function email_exists($email, $exclude_id = null)
    {
        $this->db->where('email', strtolower(trim($email)));

        if ($exclude_id) {
            $this->db->where('id !=', (int)$exclude_id);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    // Dapatkan semua user berdasarkan role tertentu
    public function get_by_role($role)
    {
        return $this->db->where('role', $role)
            ->order_by('name', 'ASC')
            ->get($this->table)
            ->result();
    }

    // Count user by role
    public function count_by_role($role)
    {
        return $this->db->where('role', $role)
            ->count_all_results($this->table);
    }

    // Update last login (jika Anda ingin menambahkan kolom last_login)
    public function update_last_login($id)
    {
        // Jika Anda memiliki kolom last_login di tabel
        if ($this->db->field_exists('last_login', $this->table)) {
            return $this->db->where('id', (int)$id)
                ->update($this->table, [
                    'last_login' => date('Y-m-d H:i:s')
                ]);
        }
        return true;
    }

    // Reset password
    public function reset_password($id, $new_password)
    {
        return $this->update($id, [
            'password' => password_hash($new_password, PASSWORD_DEFAULT),
            'remember_token' => null,
            'remember_expire' => null
        ]);
    }

    // Ambil total user
    public function get_total_users()
    {
        return $this->db->count_all($this->table);
    }

    // Ambil user dengan pagination untuk API (jika diperlukan)
    public function get_paginated_users($page = 1, $per_page = 10)
    {
        $offset = ($page - 1) * $per_page;

        $this->db->select('id, name, email, role, created_at')
            ->order_by('created_at', 'DESC')
            ->limit($per_page, $offset);

        return $this->db->get($this->table)->result();
    }
}
