<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalaryCalculator
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('employees/Attendance_model', 'attendance');
    }

    public function calculate($employee_id, $month, $year, $base_salary)
    {
        // contoh sederhana
        $overtime = 0;
        $deduction = 0;

        // di sini nanti bisa:
        // - hitung telat
        // - hitung lembur
        // - potong alpha

        return [
            'base_salary' => $base_salary,
            'allowance' => 0,
            'overtime' => $overtime,
            'deduction' => $deduction,
            'total' => $base_salary + $overtime - $deduction
        ];
    }
}
