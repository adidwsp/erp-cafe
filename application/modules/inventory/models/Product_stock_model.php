<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_stock_model extends CI_Model
{
    protected $table = 'product_stocks';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($limit = 10, $offset = 0, $search = NULL)
    {
        $this->db->select('ps.id, ps.product_id, p.name AS product_name, ps.warehouse_id, ps.qty, ps.created_at');
        $this->db->from('product_stocks ps');
        $this->db->join('products p', 'p.id = ps.product_id', 'left');

        if (!empty($search)) {
            $this->db->group_start()
                ->like('p.name', $search)
                ->or_like('p.sku', $search)
                ->group_end();
        }

        $this->db->order_by('p.name', 'ASC');
        return $this->db->get($this->table . ' ps', (int)$limit, (int)$offset)->result();
    }

    public function count_all($search = NULL)
    {
        $this->db->from('product_stocks ps');
        $this->db->join('products p', 'p.id = ps.product_id', 'left');

        if (!empty($search)) {
            $this->db->group_start()
                ->like('p.name', $search)
                ->or_like('p.sku', $search)
                ->group_end();
        }

        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->select('ps.*, p.name AS product_name')
            ->from('product_stocks ps')
            ->join('products p', 'p.id = ps.product_id', 'left')
            ->where('ps.id', (int)$id)
            ->get()
            ->row();
    }

    public function get_by_product_warehouse($product_id, $warehouse_id)
    {
        return $this->db->where(['product_id' => (int)$product_id, 'warehouse_id' => (int)$warehouse_id])->get($this->table)->row();
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

    public function update_qty($product_id, $warehouse_id, $delta)
    {
        // If row exists update, else insert
        $row = $this->get_by_product_warehouse($product_id, $warehouse_id);
        if ($row) {
            $this->db->where('id', $row->id)->set('qty', 'qty + (' . (int)$delta . ')', FALSE)->update($this->table);
            return $row->id;
        } else {
            return $this->insert([
                'product_id' => (int)$product_id,
                'warehouse_id' => (int)$warehouse_id,
                'qty' => (int)$delta
            ]);
        }
    }

    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }
}
