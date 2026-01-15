<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory/Product_model', 'product');
        $this->load->library(['form_validation', 'pagination']);
    }

    public function index()
    {
        $per_page = 10;
        $offset = (int)$this->input->get('page');
        $search = $this->input->get('q', TRUE);

        $data['products'] = $this->product->get_all($per_page, $offset, $search);
        $total = $this->product->count_all($search);

        $config['base_url'] = base_url('inventory/products') . ($search ? '?q=' . urlencode($search) : '');
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
        $this->load->view('inventory/products/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->_set_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->_render_form(['product' => null]);
            return;
        }

        $payload = [
            'sku' => $this->input->post('sku', TRUE),
            'name' => $this->input->post('name', TRUE),
            'category_id' => (int)$this->input->post('category_id', TRUE),
            'unit' => $this->input->post('unit', TRUE),
            'min_stock' => (int)$this->input->post('min_stock', TRUE),
        ];

        $this->product->insert($payload);
        $this->session->set_flashdata('success', 'Produk berhasil ditambahkan.');
        redirect('inventory/products');
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        $product = $this->product->get_by_id($id);
        if (!$product) show_404();

        $this->_set_rules();

        if ($this->form_validation->run() === FALSE) {
            $this->_render_form(['product' => $product]);
            return;
        }

        $payload = [
            'sku' => $this->input->post('sku', TRUE),
            'name' => $this->input->post('name', TRUE),
            'category_id' => (int)$this->input->post('category_id', TRUE),
            'unit' => $this->input->post('unit', TRUE),
            'min_stock' => (int)$this->input->post('min_stock', TRUE),
        ];

        $this->product->update($id, $payload);
        $this->session->set_flashdata('success', 'Produk berhasil diperbarui.');
        redirect('inventory/products');
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        if ($id <= 0) redirect('inventory/products');

        $this->product->delete($id);
        $this->session->set_flashdata('success', 'Produk berhasil dihapus.');
        redirect('inventory/products');
    }

    private function _set_rules()
    {
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
        $this->form_validation->set_rules('min_stock', 'Min Stock', 'trim|required|numeric');
    }

    private function _render_form($data = [])
    {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('inventory/products/form', $data);
        $this->load->view('templates/footer');
    }
}
