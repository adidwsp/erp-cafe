<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Roles extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_model');
        $this->load->library(['form_validation', 'pagination']);
        $this->load->helper(['url', 'form']);

        // Hanya admin dan owner yang bisa akses
        if (!in_array($this->session->userdata('role'), ['administrator', 'owner'])) {
            show_error('Anda tidak memiliki izin untuk mengakses halaman ini.', 403);
        }
    }

    // Daftar Role
    public function index()
    {
        $page = (int)$this->input->get('page', TRUE) ?: 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        $search = $this->input->get('q', TRUE);

        $data['roles'] = $this->role_model->get_all($per_page, $offset, $search);
        $total = $this->role_model->count_all($search);

        // Pagination
        $config['base_url'] = site_url('users/roles');
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        if ($search) {
            $config['suffix'] = '?q=' . urlencode($search);
            $config['first_url'] = site_url('users/roles') . '?q=' . urlencode($search);
        }

        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;
        $data['total'] = $total;

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('users/roles/index', $data);
        $this->load->view('templates/footer');
    }

    // Tambah Role
    public function create()
    {
        $this->form_validation->set_rules('role_name', 'Kode Role', 'trim|required|min_length[3]|max_length[50]|is_unique[roles.role_name]');
        $this->form_validation->set_rules('display_name', 'Nama Tampilan', 'trim|required|min_length[3]|max_length[100]');

        if ($this->form_validation->run() === FALSE) {
            $data['role'] = null;
            $data['modules'] = $this->get_modules_list();
            $data['permissions'] = [];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('users/roles/form', $data);
            $this->load->view('templates/footer');
            return;
        }

        $payload = [
            'role_name' => $this->input->post('role_name', TRUE),
            'display_name' => $this->input->post('display_name', TRUE),
            'description' => $this->input->post('description', TRUE)
        ];

        $role_id = $this->role_model->insert($payload);

        // Simpan permissions
        $modules = $this->input->post('modules');
        if ($modules) {
            $this->save_permissions($role_id, $modules);
        }

        $this->session->set_flashdata('success', 'Role berhasil dibuat.');
        redirect('users/roles');
    }

    // Edit Role
    public function edit($id = null)
    {
        $id = (int)$id;
        $role = $this->role_model->get_by_id($id);

        if (!$role) {
            show_404();
        }

        $this->form_validation->set_rules('display_name', 'Nama Tampilan', 'trim|required|min_length[3]|max_length[100]');

        if ($this->form_validation->run() === FALSE) {
            $data['role'] = $role;
            $data['modules'] = $this->get_modules_list();

            // Ambil permissions berdasarkan role_name (bukan role_id)
            $data['permissions'] = [];
            if ($role->role_name) {
                $data['permissions'] = $this->db->where('role', $role->role_name)
                    ->get('permissions')
                    ->result();
            }

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('users/roles/form', $data);
            $this->load->view('templates/footer');
            return;
        }

        $payload = [
            'display_name' => $this->input->post('display_name', TRUE),
            'description' => $this->input->post('description', TRUE)
        ];

        $this->role_model->update($id, $payload);

        // Update permissions
        $modules = $this->input->post('modules');
        $this->save_permissions($id, $modules);

        $this->session->set_flashdata('success', 'Role berhasil diperbarui.');
        redirect('users/roles');
    }

    // Hapus Role
    public function delete($id = null)
    {
        $id = (int)$id;

        // Cek apakah role sedang digunakan
        $user_count = $this->db->where('role', $id)->count_all_results('users');
        if ($user_count > 0) {
            $this->session->set_flashdata('error', 'Role tidak bisa dihapus karena sedang digunakan oleh ' . $user_count . ' user.');
            redirect('users/roles');
        }

        if ($this->role_model->delete($id)) {
            $this->session->set_flashdata('success', 'Role berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus role.');
        }

        redirect('users/roles');
    }

    // View permissions untuk role
    public function view($id = null)
    {
        $id = (int)$id;
        $role = $this->role_model->get_by_id($id);

        if (!$role) {
            show_404();
        }

        $data['role'] = $role;
        $data['permissions'] = $this->role_model->get_permissions($id);
        $data['modules'] = $this->get_modules_list();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('users/roles/view', $data);
        $this->load->view('templates/footer');
    }

    // Helper: Simpan permissions
    private function save_permissions($role_id, $modules)
    {
        // Dapatkan role_name dari role_id
        $role_name = $this->get_role_name($role_id);

        if (!$role_name) {
            log_message('error', 'Role tidak ditemukan untuk ID: ' . $role_id);
            return false;
        }

        echo "<!-- Debug: Role Name: $role_name -->";
        echo "<!-- Debug: Modules: " . print_r($modules, true) . " -->";

        // Hapus permissions lama berdasarkan role_name
        $this->db->where('role', $role_name);
        $delete_result = $this->db->delete('permissions');

        echo "<!-- Debug: Delete result: " . ($delete_result ? 'success' : 'failed') . " -->";
        echo "<!-- Debug: Delete query: " . $this->db->last_query() . " -->";

        // Insert permissions baru
        if ($modules && is_array($modules)) {
            $insert_count = 0;
            foreach ($modules as $module => $actions) {
                if (!is_array($actions)) {
                    continue;
                }

                $permission_data = [
                    'role' => $role_name,
                    'module' => $module,
                    'can_view' => isset($actions['view']) && $actions['view'] == '1' ? 1 : 0,
                    'can_create' => isset($actions['create']) && $actions['create'] == '1' ? 1 : 0,
                    'can_edit' => isset($actions['edit']) && $actions['edit'] == '1' ? 1 : 0,
                    'can_delete' => isset($actions['delete']) && $actions['delete'] == '1' ? 1 : 0,
                ];

                echo "<!-- Debug: Inserting: " . print_r($permission_data, true) . " -->";

                $insert_result = $this->db->insert('permissions', $permission_data);
                if ($insert_result) {
                    $insert_count++;
                }

                echo "<!-- Debug: Insert result: " . ($insert_result ? 'success' : 'failed') . " -->";
                echo "<!-- Debug: Insert query: " . $this->db->last_query() . " -->";
            }

            echo "<!-- Debug: Total inserted: $insert_count -->";
            return $insert_count > 0;
        }

        return true;
    }

    private function get_role_name($role_id)
    {
        $role = $this->db->select('role_name')
            ->from('roles')
            ->where('id', $role_id)
            ->get()
            ->row();

        return $role ? $role->role_name : null;
    }

    // Helper: Daftar modul
    private function get_modules_list()
    {
        return [
            'dashboard' => 'Dashboard',
            'hr' => 'Human Resources',
            'sales' => 'Sales',
            'purchasing' => 'Purchasing',
            'inventory' => 'Inventory',
            'users' => 'User Management',
            'reports' => 'Laporan'
        ];
    }
}
