<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee_model extends CI_Model
{
    protected $table = 'employees';

    public function __construct()
    {
        parent::__construct();
    }

    // ambil list dengan pagination & search
    public function get_all($limit = 10, $offset = 0, $search = NULL)
    {
        $this->db->select('id, nik, name, join_date, position, salary_base, status');
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('nik', $search);
            $this->db->or_like('position', $search);
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
            $this->db->like('name', $search);
            $this->db->or_like('nik', $search);
            $this->db->or_like('position', $search);
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
        if (isset($data['nik'])) $data['nik'] = trim($data['nik']);
        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }
}
