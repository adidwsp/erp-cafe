<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends CI_Model
{
    protected $table = 'roles';

    public function get_all($limit = 10, $offset = 0, $search = null)
    {
        $this->db->from($this->table);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('role_name', $search);
            $this->db->or_like('display_name', $search);
            $this->db->group_end();
        }

        $this->db->limit($limit, $offset)
            ->order_by('display_name', 'ASC');

        return $this->db->get()->result();
    }

    public function count_all($search = null)
    {
        $this->db->from($this->table);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('role_name', $search);
            $this->db->or_like('display_name', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function get_by_name($role_name)
    {
        return $this->db->where('role_name', $role_name)->get($this->table)->row();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function get_permissions($role_id)
    {
        return $this->db->where('id', $role_id)
            ->get('permissions')
            ->result();
    }

    public function get_permission($role_id, $module)
    {
        // Cari nama role dulu
        $role = $this->db->select('role_name')
            ->where('id', $role_id)
            ->get('roles')
            ->row();

        if (!$role) return null;

        return $this->db->where('role', $role->role_name)
            ->where('module', $module)
            ->get('permissions')
            ->row();
    }

    public function get_permissions_by_role_name($role_name)
    {
        return $this->db->where('role', $role_name)
            ->get('permissions')
            ->result();
    }
}
