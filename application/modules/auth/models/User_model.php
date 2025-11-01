<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_by_email($email)
    {
        return $this->db->where('email', $email)->get($this->table)->row();
    }

    // set remember token (simpan token dan expire date)
    public function set_remember_token($user_id, $token, $days = 30)
    {
        $expire_at = date('Y-m-d H:i:s', strtotime("+{$days} days"));
        return $this->db->where('id', $user_id)
            ->update($this->table, ['remember_token' => $token, 'remember_expire' => $expire_at]);
    }

    public function get_by_remember_token($token)
    {
        return $this->db->where('remember_token', $token)->get($this->table)->row();
    }

    public function extend_remember_token($user_id, $days = 30)
    {
        $expire_at = date('Y-m-d H:i:s', strtotime("+{$days} days"));
        return $this->db->where('id', $user_id)
            ->update($this->table, ['remember_expire' => $expire_at]);
    }

    public function clear_remember_token($user_id)
    {
        return $this->db->where('id', $user_id)
            ->update($this->table, ['remember_token' => NULL, 'remember_expire' => NULL]);
    }
}
