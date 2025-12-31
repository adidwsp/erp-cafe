<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_model extends CI_Model
{
    protected $table = 'attendances';

    public function __construct()
    {
        parent::__construct();
    }

    // ambil list dengan pagination & search
    public function get_all($limit = 10, $offset = 0, $search = NULL)
    {
        $this->db->select('id, employee_id, date, time_in, time_out, status, location');
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('employee_id', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }
        // $this->db->order_by('joined_at', 'DESC');
        $query = $this->db->get($this->table, (int)$limit, (int)$offset);
        return $query->result();
    }

    // hitung total untuk pagination
    public function count_all($search = NULL)
    {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('employee_id', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int)$id)->get($this->table)->row();
    }

    public function get_by_email($nik)
    {
        $nik = strtolower(trim($nik));
        return $this->db->where('nik', $nik)->get($this->table)->row();
    }

    public function insert($data)
    {
        // pastikan email lowercase
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        if (isset($data['employee_id'])) $data['employee_id'] = trim($data['employee_id']);
        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }
}
