<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employees extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model');
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

        $data['employees'] = $this->employee_model->get_all($per_page, $offset, $search);
        $total = $this->employee_model->count_all($search);

        // pagination config
        $config['base_url'] = site_url('employees') . ($search ? '?q=' . urlencode($search) : '');
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
        $this->load->view('employees', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('join_date', 'Join Date');
        $this->form_validation->set_rules('position', 'Position');
        $this->form_validation->set_rules('salary_base', 'Salary Base', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $data['employee'] = null;
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('employees/form', $data);
            $this->load->view('templates/footer');
            return;
        }

        $payload = [
            'name' => $this->input->post('name', TRUE),
            'nik' => $this->input->post('nik', TRUE),
            'join_date' => date('Y-m-d'),
            'position' => $this->input->post('position', TRUE),
            'salary_base' => $this->input->post('salary_base', TRUE),
            'status' => $this->input->post('status', TRUE),
        ];

        $this->employee_model->insert($payload);
        $this->session->set_flashdata('success', 'Karyawan berhasil ditambahkan.');
        redirect('employees');
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $employee = $this->employee_model->get_by_id($id);
        if (!$employee) {
            show_404();
        }

        // Jika email diubah, callback akan memeriksa unik kecuali sama dengan email lama
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        // password optional: jika kosong maka tidak diupdate
        $this->form_validation->set_rules('join_date', 'Join Date', 'trim|required');
        $this->form_validation->set_rules('position', 'Position', 'trim|required');
        $this->form_validation->set_rules('salary_base', 'Salary Base', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $data['employee'] = $employee;
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('employees/form', $data);
            $this->load->view('templates/footer');
            return;
        }

        $payload = [
            'name' => $this->input->post('name', TRUE),
            'nik' =>  $this->input->post('nik', TRUE),
            'position' => $this->input->post('position', TRUE),
            'salary_base' => $this->input->post('salary_base', TRUE),
            'join_date' => $this->input->post('join_date', TRUE),
            'status' => $this->input->post('status', TRUE),
        ];

        // $pw = $this->input->post('password', TRUE);
        // if (!empty($pw)) {
        //     $payload['password'] = password_hash($pw, PASSWORD_DEFAULT);
        // }

        $this->employee_model->update($id, $payload);
        $this->session->set_flashdata('success', 'Data karyawan berhasil diperbarui.');
        redirect('employees');
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        // jangan hapus diri sendiri (opsional)
        if ($this->session->userdata('user_id') == $id) {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus user yang sedang login.');
            redirect('employee');
        }

        $employee = $this->employee_model->get_by_id($id);
        if (!$employee) {
            $this->session->set_flashdata('error', 'Karyawan tidak ditemukan.');
            redirect('employees');
        }

        $this->employee_model->delete($id);
        $this->session->set_flashdata('success', 'Karyawan berhasil dihapus.');
        redirect('employees');
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
