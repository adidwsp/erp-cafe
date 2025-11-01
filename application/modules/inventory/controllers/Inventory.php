<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library(['form_validation', 'pagination']);
        $this->load->helper(['url', 'form', 'security']);
    }


    public function index()
    {
        $data['user'] = $this->session->userdata();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('inventory', $data);
        $this->load->view('templates/footer');
    }
}
