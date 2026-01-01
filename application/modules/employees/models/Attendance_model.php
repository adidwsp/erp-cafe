<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_model extends CI_Model
{

    protected $table = 'attendances';

    public function get_all($limit = 10, $offset = 0)
    {
        $this->db->select('
        a.id,
        a.employee_id,
        a.date,
        a.time_in,
        a.time_out,
        a.status,
        a.location,
        e.name AS employee_name
    ');
        $this->db->from('attendances a');
        $this->db->join('employees e', 'e.id = a.employee_id', 'left');
        $this->db->order_by('a.date', 'DESC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($payload)
    {
        $this->db->insert($this->table, $payload);
        return $this->db->insert_id();
    }

    public function update($id, $payload)
    {
        return $this->db->where('id', $id)->update($this->table, $payload);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
