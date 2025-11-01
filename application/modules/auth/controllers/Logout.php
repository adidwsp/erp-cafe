<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth/user_model');
    }

    public function index()
    {
        // clear remember token in DB if exists
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->user_model->clear_remember_token($user_id);
        }
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
