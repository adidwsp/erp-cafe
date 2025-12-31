<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employees extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employees/Employee_model', 'employee_model');
        $this->load->library(['form_validation', 'pagination']);
        $this->load->helper(['url', 'form', 'security']);
    }

    public function index()
    {
        // params
        $page     = (int) $this->input->get('page', TRUE);
        $page     = $page > 0 ? $page : 1;
        $per_page = 10;
        $offset  = ($page - 1) * $per_page;
        $search  = $this->input->get('q', TRUE);

        $data['employees'] = $this->employee_model->get_all($per_page, $offset, $search);
        $total             = $this->employee_model->count_all($search);

        // pagination config
        $config['base_url']            = site_url('employees') . ($search ? '?q=' . urlencode($search) : '');
        $config['total_rows']          = $total;
        $config['per_page']            = $per_page;
        $config['page_query_string']   = TRUE;
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['search']     = $search;
        $data['total']      = $total;

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('employees/employees/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->_set_rules();

        if ($this->form_validation->run() === FALSE) {
            $data['employee'] = null;
            $this->_render_form($data);
            return;
        }

        $payload = [
            'name'         => $this->input->post('name', TRUE),
            'nik'          => $this->input->post('nik', TRUE),
            'join_date'    => $this->input->post('join_date', TRUE) ?: date('Y-m-d'),
            'position'     => $this->input->post('position', TRUE),
            'salary_base'  => $this->input->post('salary_base', TRUE),
            'status'       => $this->input->post('status', TRUE),
        ];

        $this->employee_model->insert($payload);
        $this->session->set_flashdata('success', 'Karyawan berhasil ditambahkan.');
        redirect('employees');
    }

    public function edit($id = null)
    {
        $id = (int) $id;
        $employee = $this->employee_model->get_by_id($id);

        if (!$employee) {
            show_404();
        }

        $this->_set_rules();

        if ($this->form_validation->run() === FALSE) {
            $data['employee'] = $employee;
            $this->_render_form($data);
            return;
        }

        $payload = [
            'name'        => $this->input->post('name', TRUE),
            'nik'         => $this->input->post('nik', TRUE),
            'join_date'   => $this->input->post('join_date', TRUE),
            'position'    => $this->input->post('position', TRUE),
            'salary_base' => $this->input->post('salary_base', TRUE),
            'status'      => $this->input->post('status', TRUE),
        ];

        $this->employee_model->update($id, $payload);
        $this->session->set_flashdata('success', 'Data karyawan berhasil diperbarui.');
        redirect('employees');
    }

    public function delete($id = null)
    {
        $id = (int) $id;

        $employee = $this->employee_model->get_by_id($id);
        if (!$employee) {
            $this->session->set_flashdata('error', 'Karyawan tidak ditemukan.');
            redirect('employees');
        }

        $this->employee_model->delete($id);
        $this->session->set_flashdata('success', 'Karyawan berhasil dihapus.');
        redirect('employees');
    }

    /* ===============================
       PRIVATE HELPER METHODS
       =============================== */

    private function _set_rules()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
        $this->form_validation->set_rules('join_date', 'Join Date', 'trim|required');
        $this->form_validation->set_rules('position', 'Position', 'trim|required');
        $this->form_validation->set_rules('salary_base', 'Salary Base', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
    }

    private function _render_form($data)
    {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('employees/employees/form', $data);
        $this->load->view('templates/footer');
    }
}
