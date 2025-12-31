<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_profile($user_id)
    {
        $this->db->select('
            u.id,
            u.name,
            u.email,
            u.role,
            e.nik,
            e.join_date,
            e.position,
            e.salary_base,
            e.status
        ');
        $this->db->from('users u');
        $this->db->join('employees e', 'e.user_id = u.id', 'left');
        $this->db->where('u.id', $user_id);

        return $this->db->get()->row();
    }
}
