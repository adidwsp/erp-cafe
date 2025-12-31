<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'pagination']);
        $this->load->helper(['url', 'form', 'security']);

        $this->load->model('profile_model');
        $this->load->library('session');
    }


    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $profile = $this->profile_model->get_profile($user_id);

        if (!$profile) {
            show_error('Data profile tidak ditemukan. Hubungi administrator.', 500);
        }

        $data['profile'] = $profile;


        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('profile/index', $data);
        $this->load->view('templates/footer');
    }
}
