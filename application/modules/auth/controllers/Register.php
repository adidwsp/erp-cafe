<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Register extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
        $this->load->model('user_model');
    }

    public function index()
    {


        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Retype Password', 'trim|required|matches[password]');
            $this->form_validation->set_rules('terms', 'Terms', 'required', ['required' => 'You must agree to terms.']);

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s'),
                    'role' => 'customer'
                ];

                $insert_id = $this->user_model->insert($data);
                if ($insert_id) {
                    $this->session->set_flashdata('success', 'Registration successful. Please login.');
                    redirect('auth/login'); // arahkan ke login module/page Anda
                } else {
                    $data['error'] = 'Gagal menyimpan data. Silakan coba lagi.';
                    $this->load->view('register', $data);
                    return;
                }
            }
        }

        $this->load->view('register');
    }

    // callback untuk validasi email unique
    // public function email_check($email)
    // {
    //     if ($this->user_model->get_by_email($email)) {
    //         $this->form_validation->set_message('email_check', 'This email is already registered.');
    //         return FALSE;
    //     }
    //     return TRUE;
    // }
}
