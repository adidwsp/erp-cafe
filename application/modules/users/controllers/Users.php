<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library(['form_validation', 'pagination']);
        $this->load->helper(['url', 'form', 'security']);
    }

    public function index()
    {
        // params
        $page = (int)$this->input->get('page', TRUE) ?: 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        $search = $this->input->get('q', TRUE);

        $data['users'] = $this->user_model->get_all($per_page, $offset, $search);
        $total = $this->user_model->count_all($search);

        // pagination config
        $config['base_url'] = site_url('users') . ($search ? '?q=' . urlencode($search) : '');
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;
        $data['total'] = $total;


        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('users', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $data['user'] = null;
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('users/form', $data);
            $this->load->view('templates/footer');
            return;
        }

        $payload = [
            'name' => $this->input->post('name', TRUE),
            'email' => strtolower(trim($this->input->post('email', TRUE))),
            'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
            'role' => $this->input->post('role', TRUE),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->user_model->insert($payload);
        $this->session->set_flashdata('success', 'User berhasil dibuat.');
        redirect('users');
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $user = $this->user_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        // Jika email diubah, callback akan memeriksa unik kecuali sama dengan email lama
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        // password optional: jika kosong maka tidak diupdate
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $data['user'] = $user;
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('users/form', $data);
            $this->load->view('templates/footer');
            return;
        }

        $payload = [
            'name' => $this->input->post('name', TRUE),
            'email' => strtolower(trim($this->input->post('email', TRUE))),
            'role' => $this->input->post('role', TRUE),
        ];

        $pw = $this->input->post('password', TRUE);
        if (!empty($pw)) {
            $payload['password'] = password_hash($pw, PASSWORD_DEFAULT);
        }

        $this->user_model->update($id, $payload);
        $this->session->set_flashdata('success', 'User berhasil diperbarui.');
        redirect('users');
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        // jangan hapus diri sendiri (opsional)
        if ($this->session->userdata('user_id') == $id) {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus user yang sedang login.');
            redirect('users');
        }

        $user = $this->user_model->get_by_id($id);
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('users');
        }

        $this->user_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus.');
        redirect('users');
    }

    // callback untuk validasi email unik
    // public function _email_unique($email, $id = null)
    // {
    //     $email = strtolower(trim($email));
    //     $existing = $this->user_model->get_by_email($email);
    //     if ($existing) {
    //         if ($id && $existing->id == (int)$id) {
    //             return TRUE; // sama user -> boleh
    //         }
    //         $this->form_validation->set_message('_email_unique', 'Email sudah digunakan.');
    //         return FALSE;
    //     }
    //     return TRUE;
    // }
}
