<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mutations extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory/Stock_mutation_model', 'mutation');
        $this->load->model('inventory/Product_model', 'product');
        $this->load->library(['form_validation', 'pagination']);
    }

    public function index()
    {
        $per_page = 15;
        $page = (int)$this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;
        $search = $this->input->get('q', TRUE);

        $data['mutations'] = $this->mutation->get_all($per_page, $offset, $search);
        $total = $this->mutation->count_all($search);

        $config['base_url'] = base_url('inventory/mutations') . ($search ? '?q=' . urlencode($search) : '');
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
        $this->load->view('inventory/mutations/index', $data);
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
            'qty' => (int)$this->input->post('qty', TRUE),
            'type' => $this->input->post('type', TRUE),
            'ref_id' => $this->input->post('ref_id', TRUE),
            'note' => $this->input->post('note', TRUE),
            'warehouse_id' => (int)$this->input->post('warehouse_id', TRUE),
        ];

        $res = $this->mutation->insert_with_stock_update($payload);
        if ($res) {
            $this->session->set_flashdata('success', 'Mutasi stok berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan mutasi stok.');
        }
        redirect('inventory/mutations');
    }

    public function delete($id)
    {
        $this->mutation->delete((int)$id);
        $this->session->set_flashdata('success', 'Mutasi dihapus.');
        redirect('inventory/mutations');
    }

    private function _rules()
    {
        $this->form_validation->set_rules('product_id', 'Produk', 'required');
        $this->form_validation->set_rules('qty', 'Jumlah', 'required|integer');
        $this->form_validation->set_rules('type', 'Tipe', 'required|in_list[in,out,adjust]');
        $this->form_validation->set_rules('warehouse_id', 'Gudang', 'required|integer');
    }

    private function _form($data = [])
    {
        $data['products'] = $this->product->get_all_for_select();
        $data['warehouses'] = [
            1 => 'Gudang Utama',
            2 => 'Bar',
            3 => 'Dapur'
        ];
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('inventory/mutations/form', $data);
        $this->load->view('templates/footer');
    }
}
