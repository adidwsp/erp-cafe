<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends Admin_Controller
{
    protected $current_role;
    protected $allowed_roles = ['administrator', 'owner'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library(['form_validation', 'pagination']);
        $this->load->helper(['url', 'form', 'permission']);

        // Ambil role dari session
        $this->current_role = $this->session->userdata('role');

        // // Hanya admin dan owner yang bisa akses user management
        // if (!is_admin_or_owner()) {
        //     show_error('Akses ditolak. Hanya administrator dan owner yang dapat mengakses halaman ini.', 403);
        // }
    }

    public function index()
    {
        // Pagination setup
        $page = (int)$this->input->get('page', TRUE) ?: 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        $search = $this->input->get('q', TRUE);

        // Get users data
        $data['users'] = $this->user_model->get_all($per_page, $offset, $search);
        $total = $this->user_model->count_all($search);

        // Pagination config
        $config['base_url'] = site_url('users');
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        if ($search) {
            $config['suffix'] = '?q=' . urlencode($search);
            $config['first_url'] = site_url('users') . '?q=' . urlencode($search);
        }

        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;
        $data['total'] = $total;
        $data['roles'] = $this->user_model->get_roles_list(); // Tambahkan ini untuk dropdown

        // Load views
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('users/users/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('name', 'Nama', 'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|in_list[administrator,owner,cashier,hr_manager,sales_manager,purchase_manager,inventory_manager]');

        if ($this->form_validation->run() === FALSE) {
            $data['user'] = null;
            $data['roles'] = $this->user_model->get_roles_list();

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('users/users/form', $data);
            $this->load->view('templates/footer');
            return;
        }

        $payload = [
            'name' => $this->input->post('name', TRUE),
            'email' => $this->input->post('email', TRUE),
            'password' => $this->input->post('password', TRUE),
            'role' => $this->input->post('role', TRUE)
        ];

        if ($this->user_model->insert($payload)) {
            $this->session->set_flashdata('success', 'User berhasil dibuat.');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat user.');
        }

        redirect('users/users');
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $user = $this->user_model->get_by_id($id);

        if (!$user) {
            show_404();
        }

        // Validasi email unik kecuali untuk user yang sedang diedit
        $email_unique = '';
        if ($user->email !== $this->input->post('email')) {
            $email_unique = '|is_unique[users.email]';
        }

        $this->form_validation->set_rules('name', 'Nama', 'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email' . $email_unique);
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|in_list[administrator,owner,cashier,hr_manager,sales_manager,purchase_manager,inventory_manager]');

        if ($this->form_validation->run() === FALSE) {
            $data['user'] = $user;
            $data['roles'] = $this->user_model->get_roles_list();

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('users/users/form', $data);
            $this->load->view('templates/footer');
            return;
        }

        $payload = [
            'name' => $this->input->post('name', TRUE),
            'email' => strtolower(trim($this->input->post('email', TRUE))),
            'role' => $this->input->post('role', TRUE),
        ];

        $password = $this->input->post('password', TRUE);
        if (!empty($password)) {
            $payload['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($this->user_model->update($id, $payload)) {
            $this->session->set_flashdata('success', 'User berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui user.');
        }

        redirect('users/users');
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        $current_user_id = $this->session->userdata('id');

        // Jangan hapus diri sendiri
        if ($current_user_id == $id) {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus user yang sedang login.');
            redirect('users/users');
        }

        $user = $this->user_model->get_by_id($id);
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('users/users');
        }

        // Jangan hapus user dengan role administrator (opsional)
        if ($user->role === 'administrator') {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus user dengan role Administrator.');
            redirect('users/users');
        }

        if ($this->user_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user.');
        }

        redirect('users/users');
    }

    public function toggle_status($id = null)
    {
        $id = (int)$id;
        $user = $this->user_model->get_by_id($id);

        if (!$user) {
            show_404();
        }

        // Jangan nonaktifkan diri sendiri
        $current_user_id = $this->session->userdata('id');
        if ($current_user_id == $id) {
            $this->session->set_flashdata('error', 'Tidak bisa menonaktifkan user yang sedang login.');
            redirect('users/users');
        }

        $new_status = $user->is_active ? 0 : 1;
        $status_text = $new_status ? 'diaktifkan' : 'dinonaktifkan';

        if ($this->user_model->update($id, ['is_active' => $new_status])) {
            $this->session->set_flashdata('success', "User berhasil $status_text.");
        } else {
            $this->session->set_flashdata('error', "Gagal mengubah status user.");
        }

        redirect('users/users');
    }

    // Profile user yang sedang login
    public function profile()
    {
        $email = $this->session->userdata('email');
        $user = $this->user_model->get_by_email($email);

        if (!$user) {
            redirect('auth/logout');
        }

        $data['user'] = $user;

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('users/users/profile', $data);
        $this->load->view('templates/footer');
    }

    // Ubah password
    public function change_password()
    {
        $user_id = $this->session->userdata('id');
        $user = $this->user_model->get_by_id($user_id);

        if (!$user) {
            redirect('auth/logout');
        }

        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'trim|required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'trim|required|matches[new_password]');

        if ($this->form_validation->run() === FALSE) {
            $data['user'] = $user;

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('users/users/change_password', $data);
            $this->load->view('templates/footer');
            return;
        }

        $current_password = $this->input->post('current_password', TRUE);
        $new_password = $this->input->post('new_password', TRUE);

        // Verifikasi password saat ini
        if (!password_verify($current_password, $user->password)) {
            $this->session->set_flashdata('error', 'Password saat ini salah.');
            redirect('users/change_password');
        }

        // Update password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        if ($this->user_model->update($user_id, ['password' => $hashed_password])) {
            $this->session->set_flashdata('success', 'Password berhasil diubah.');
            redirect('users/profile');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah password.');
            redirect('users/change_password');
        }
    }
}
