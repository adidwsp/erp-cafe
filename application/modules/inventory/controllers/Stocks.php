<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stocks extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory/Product_stock_model', 'stock');
        $this->load->model('inventory/Product_model', 'product');
        $this->load->library(['form_validation', 'pagination']);
    }

    public function index()
    {
        $per_page = 10;
        $page = (int)$this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;
        $search = $this->input->get('q', TRUE);

        $data['stocks'] = $this->stock->get_all($per_page, $offset, $search);
        $total = $this->stock->count_all($search);

        $config['base_url'] = base_url('inventory/stocks') . ($search ? '?q=' . urlencode($search) : '');
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;
        $data['total'] = $total;

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('inventory/stocks/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->_form();
            return;
        }

        $payload = [
            'product_id' => (int)$this->input->post('product_id', TRUE),
            'warehouse_id' => (int)$this->input->post('warehouse_id', TRUE),
            'qty' => (int)$this->input->post('qty', TRUE),
        ];

        $this->stock->insert($payload);
        $this->session->set_flashdata('success', 'Stok berhasil ditambahkan.');
        redirect('inventory/stocks');
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $row = $this->stock->get_by_id($id);
        if (!$row) show_404();

        $this->_rules();
        if ($this->form_validation->run() === FALSE) {
            $this->_form(['stock' => $row]);
            return;
        }

        $payload = [
            'product_id' => (int)$this->input->post('product_id', TRUE),
            'warehouse_id' => (int)$this->input->post('warehouse_id', TRUE),
            'qty' => (int)$this->input->post('qty', TRUE),
        ];
        $this->stock->update($id, $payload);
        $this->session->set_flashdata('success', 'Stok berhasil diperbarui.');
        redirect('inventory/stocks');
    }

    public function delete($id)
    {
        $id = (int)$id;
        $this->stock->delete($id);
        $this->session->set_flashdata('success', 'Stok dihapus.');
        redirect('inventory/stocks');
    }

    private function _rules()
    {
        $this->form_validation->set_rules('product_id', 'Produk', 'required');
        $this->form_validation->set_rules('warehouse_id', 'Gudang', 'required');
        $this->form_validation->set_rules('qty', 'Qty', 'required|integer');
    }

    private function _form($data = [])
    {
        $data['products'] = $this->product->get_all_for_select();
        // static warehouses for small cafe
        $data['warehouses'] = [
            1 => 'Gudang Utama',
            2 => 'Bar',
            3 => 'Dapur'
        ];

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('inventory/stocks/form', $data);
        $this->load->view('templates/footer');
    }
}
