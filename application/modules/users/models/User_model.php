<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    // ambil list dengan pagination & search
    public function get_all($limit = 10, $offset = 0, $search = NULL)
    {
        $this->db->select('id, name, email, role, created_at');
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get($this->table, (int)$limit, (int)$offset);
        return $query->result();
    }

    // hitung total untuk pagination
    public function count_all($search = NULL)
    {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int)$id)->get($this->table)->row();
    }

    public function get_by_email($email)
    {
        $email = strtolower(trim($email));
        return $this->db->where('email', $email)->get($this->table)->row();
    }

    public function insert($data)
    {
        // pastikan email lowercase
        if (isset($data['email'])) $data['email'] = strtolower(trim($data['email']));
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        if (isset($data['email'])) $data['email'] = strtolower(trim($data['email']));
        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }
}
