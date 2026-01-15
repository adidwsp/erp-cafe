<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($limit = 10, $offset = 0, $search = NULL)
    {
        $this->db->select('id, sku, name, category_id, unit, min_stock, created_at');
        if (!empty($search)) {
            $this->db->group_start()
                ->like('name', $search)
                ->or_like('sku', $search)
                ->group_end();
        }
        $this->db->order_by('name', 'ASC');
        return $this->db->get($this->table, (int)$limit, (int)$offset)->result();
    }

    public function count_all($search = NULL)
    {
        if (!empty($search)) {
            $this->db->group_start()
                ->like('name', $search)
                ->or_like('sku', $search)
                ->group_end();
        }
        return $this->db->count_all_results($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int)$id)->get($this->table)->row();
    }

    public function get_all_for_select()
    {
        $this->db->select('id, name')->from($this->table)->order_by('name', 'ASC');
        $result = [];
        foreach ($this->db->get()->result() as $r) {
            $result[$r->id] = $r->name;
        }
        return $result;
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }
}
