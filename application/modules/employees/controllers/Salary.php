<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Salary extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employees/Salary_model', 'salary');
        $this->load->model('employees/Employee_model', 'employee');
        $this->load->library('employees/SalaryCalculator', null, 'calculator');
    }

    public function index()
    {
        $month = date('m');
        $year  = date('Y');

        $data['salaries'] = $this->salary->get_all($month, $year);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('employees/salary/index', $data);
        $this->load->view('templates/footer');
    }

    public function generate()
    {
        $month = date('m');
        $year  = date('Y');

        $employees = $this->employee->get_all(1000, 0, null);

        foreach ($employees as $e) {
            if ($this->salary->get_by_employee_period($e->id, $month, $year)) {
                continue; // sudah digenerate
            }

            $calc = $this->calculator->calculate(
                $e->id,
                $month,
                $year,
                $e->salary_base
            );

            $this->salary->insert([
                'employee_id' => $e->id,
                'period_month' => $month,
                'period_year' => $year,
                'base_salary' => $calc['base_salary'],
                'allowance' => $calc['allowance'],
                'overtime_pay' => $calc['overtime'],
                'deduction' => $calc['deduction'],
                'total_salary' => $calc['total'],
                'status' => 'draft'
            ]);
        }

        $this->session->set_flashdata('success', 'Gaji berhasil digenerate.');
        redirect('employees/salary');
    }

    public function slip($id)
    {
        $data['slip'] = $this->salary->get_slip($id);
        if (!$data['slip']) show_404();


        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('employees/salary/slip', $data);
        $this->load->view('templates/footer');
    }
}
