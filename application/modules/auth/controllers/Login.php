<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form', 'cookie', 'security']);
        $this->load->model('user_model');

        // Jika belum login coba auto-login via remember_me cookie
        if (!$this->session->userdata('logged_in')) {
            $token = get_cookie('remember_me', TRUE);
            if ($token) {
                $user = $this->user_model->get_by_remember_token($token);
                if ($user && strtotime($user->remember_expire) > time()) {
                    // set session
                    $this->_set_session($user);
                    // optional: refresh remember token expiry (extend)
                    $this->user_model->extend_remember_token($user->id, 30); // extend 30 days
                } else {
                    // invalid or expired token => delete cookie
                    delete_cookie('remember_me');
                }
            }
        }
    }

    public function index()
    {
        // Jika sudah login redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // handle POST login
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() === TRUE) {
                $email = strtolower(trim($this->input->post('email', TRUE)));
                $password = $this->input->post('password', TRUE);
                $remember = $this->input->post('remember') ? TRUE : FALSE;

                $user = $this->user_model->get_by_email($email);
                if (!$user) {
                    $this->session->set_flashdata('error', 'Email belum terdaftar.');
                    redirect('auth/login');
                }

                if (!password_verify($password, $user->password)) {
                    // optional: implement attempt counter here
                    $this->session->set_flashdata('error', 'Password salah.');
                    redirect('auth/login');
                }

                // berhasil login -> set session
                $this->_set_session($user);

                // remember me -> buat token, simpan di DB dan cookie
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    // simpan token & expire di DB
                    $this->user_model->set_remember_token($user->id, $token, 30); // 30 hari
                    // set cookie (httpOnly)
                    $cookie = [
                        'name'   => 'remember_me',
                        'value'  => $token,
                        'expire' => 30 * 24 * 60 * 60, // 30 hari
                        'secure' => isset($_SERVER['HTTPS']), // only over https in production
                        'httponly' => TRUE,
                        'path' => '/'
                    ];
                    set_cookie($cookie);
                }

                redirect('dashboard');
            }
        }

        // tampilkan view
        $this->load->view('login');
    }

    private function _set_session($user)
    {
        $sess = [
            'user_id' => $user->id,
            'name'    => $user->name,
            'email'   => $user->email,
            'role'    => $user->role,
            'logged_in' => TRUE
        ];
        $this->session->set_userdata($sess);
    }

    public function logout()
    {
        // clear remember token in DB if exists
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->user_model->clear_remember_token($user_id);
        }
        delete_cookie('remember_me');
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
