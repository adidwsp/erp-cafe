<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_mutation_model extends CI_Model
{
    protected $table = 'stock_mutations';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory/Product_stock_model', 'product_stock');
    }

    public function get_all($limit = 20, $offset = 0, $search = NULL)
    {
        $this->db->select('sm.id, sm.product_id, p.name AS product_name, sm.qty, sm.type, sm.ref_id, sm.note, sm.created_at');
        $this->db->from('stock_mutations sm');
        $this->db->join('products p', 'p.id = sm.product_id', 'left');

        if (!empty($search)) {
            $this->db->group_start()
                ->like('p.name', $search)
                ->or_like('sm.ref_id', $search)
                ->group_end();
        }

        $this->db->order_by('sm.created_at', 'DESC');
        return $this->db->get($this->table, (int)$limit, (int)$offset)->result();
    }

    public function count_all($search = NULL)
    {
        $this->db->from('stock_mutations sm');
        $this->db->join('products p', 'p.id = sm.product_id', 'left');

        if (!empty($search)) {
            $this->db->group_start()
                ->like('p.name', $search)
                ->or_like('sm.ref_id', $search)
                ->group_end();
        }

        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int)$id)
            ->get($this->table)
            ->row();
    }

    /**
     * Insert mutation and update product_stocks inside transaction.
     * $payload = [
     *   product_id, qty (int), type ('in'|'out'|'adjust'), ref_id, note, warehouse_id (int)
     * ]
     */
    public function insert_with_stock_update($payload)
    {
        $this->db->trans_start();

        // insert mutation
        $this->db->insert($this->table, [
            'product_id' => (int)$payload['product_id'],
            'qty' => (int)$payload['qty'],
            'type' => $payload['type'],
            'ref_id' => isset($payload['ref_id']) ? $payload['ref_id'] : null,
            'note' => isset($payload['note']) ? $payload['note'] : null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $mutation_id = $this->db->insert_id();

        // update stock per warehouse
        $warehouse_id = isset($payload['warehouse_id']) ? (int)$payload['warehouse_id'] : 1;
        $qty = (int)$payload['qty'];

        if ($payload['type'] === 'in') {
            $this->product_stock->update_qty($payload['product_id'], $warehouse_id, $qty);
        } elseif ($payload['type'] === 'out') {
            $this->product_stock->update_qty($payload['product_id'], $warehouse_id, -$qty);
        } elseif ($payload['type'] === 'adjust') {
            // adjust can be positive or negative; apply delta
            $this->product_stock->update_qty($payload['product_id'], $warehouse_id, $qty);
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $mutation_id : false;
    }

    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }
}
