<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{

    public $user;

    public function __construct()
    {
        parent::__construct();

        $this->require_login();
        // Pastikan autoload database & session di application/config/autoload.php
        $this->load->helper('url');
        $this->user = $this->session->userdata();
    }


    // public function __construct()
    // {

    //     parent::__construct();
    //     // Semua controller yang extend Admin_Controller otomatis dilindungi
    //     $this->require_login();

    // contoh cek role admin (opsional)
    // if ($this->session->userdata('role') !== 'admin') {
    //     show_error('Forbidden', 403);
    // }
    // }
}
