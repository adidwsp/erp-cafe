<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Salary_model extends CI_Model
{
    protected $table = 'salaries';

    public function get_all($month, $year)
    {
        $this->db->select('salaries.*, employees.name, employees.nik');
        $this->db->join('employees', 'employees.id = salaries.employee_id');
        $this->db->where('period_month', $month);
        $this->db->where('period_year', $year);
        return $this->db->get($this->table)->result();
    }

    public function get_by_employee_period($employee_id, $month, $year)
    {
        return $this->db->where([
            'employee_id' => $employee_id,
            'period_month' => $month,
            'period_year' => $year
        ])->get($this->table)->row();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function approve($id)
    {
        return $this->db->where('id', $id)->update($this->table, [
            'status' => 'approved',
            'approved_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function get_slip($id)
    {
        return $this->db
            ->select('salaries.*, employees.name, employees.nik, employees.position')
            ->join('employees', 'employees.id = salaries.employee_id')
            ->where('salaries.id', $id)
            ->get($this->table)
            ->row();
    }
}
