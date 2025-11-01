<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Base controller untuk semua controller custom.
 * Karena Anda memakai HMVC (MX), extend MX_Controller.
 */
class MY_Controller extends MX_Controller
{
    public $user;

    public function __construct()
    {
        parent::__construct();
        // Pastikan autoload database & session di application/config/autoload.php
        $this->load->helper('url');
        $this->user = $this->session->userdata();
    }

    /**
     * Panggil di constructor child jika ingin memaksa login.
     */
    protected function require_login()
    {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth/login');
            exit;
        }
    }

    /**
     * Cek role (contoh sederhana).
     */
    protected function require_role($role)
    {
        $this->require_login();
        if ($this->session->userdata('role') !== $role) {
            show_error('Forbidden: you do not have permission to access this page', 403);
        }
    }
}
