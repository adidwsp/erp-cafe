<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendances extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employees/Attendance_model', 'attendance');
        // load employee model untuk select employee_id di form
        $this->load->model('employees/Employee_model', 'employee_model');

        $this->load->library(['form_validation', 'pagination']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $per_page = 10;
        $page = (int)$this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;

        $data['attendances'] = $this->attendance->get_all($per_page, $offset);
        $data['total'] = $this->attendance->count_all();

        $config['base_url'] = site_url('employees/attendances');
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('employees/attendances/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->_rules();

        if ($this->form_validation->run() === FALSE) {
            // panggil _form tanpa data attendance (create mode)
            $this->_form();
            return;
        }

        $this->attendance->insert($this->_payload());
        $this->session->set_flashdata('success', 'Absensi berhasil ditambahkan');
        redirect('employees/attendances');
    }

    public function edit($id = null)
    {
        $id = (int) $id;
        if ($id <= 0) {
            show_404();
        }

        $attendance = $this->attendance->get_by_id($id);
        if (!$attendance) {
            show_404();
        }

        $this->_rules();

        if ($this->form_validation->run() === FALSE) {
            // kirim attendance supaya view tahu ini edit dan terisi default value
            $this->_form(['attendance' => $attendance]);
            return;
        }

        $this->attendance->update($id, $this->_payload());
        $this->session->set_flashdata('success', 'Absensi berhasil diperbarui');
        redirect('employees/attendances');
    }

    public function delete($id)
    {
        $id = (int) $id;
        if ($id <= 0) {
            $this->session->set_flashdata('error', 'ID tidak valid');
            redirect('employees/attendances');
        }

        $this->attendance->delete($id);
        $this->session->set_flashdata('success', 'Absensi dihapus');
        redirect('employees/attendances');
    }

    /* ===== PRIVATE ===== */

    private function _rules()
    {
        $this->form_validation->set_rules('employee_id', 'Employee', 'required');
        $this->form_validation->set_rules('date', 'Tanggal', 'required');
        $this->form_validation->set_rules('time_in', 'Jam Masuk', 'required');
        $this->form_validation->set_rules('time_out', 'Jam Keluar', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('location', 'Lokasi', 'required');
    }

    private function _payload()
    {
        return [
            'employee_id' => $this->input->post('employee_id', TRUE),
            'date'        => $this->input->post('date', TRUE),
            'time_in'     => $this->input->post('time_in', TRUE),
            'time_out'    => $this->input->post('time_out', TRUE),
            'status'      => $this->input->post('status', TRUE),
            'location'    => $this->input->post('location', TRUE),
        ];
    }

    private function _form($data = [])
    {
        // WAJIB: ambil data dari tabel employees (bukan attendances)
        $data['employees'] = $this->employee_model->get_all_for_select();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('employees/attendances/form', $data);
        $this->load->view('templates/footer');
    }
}
