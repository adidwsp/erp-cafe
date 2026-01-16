<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('bisa_akses')) {
    /**
     * Cek apakah user bisa mengakses modul tertentu berdasarkan database
     */
    function bisa_akses($module)
    {
        $CI = &get_instance();
        $role = $CI->session->userdata('role');

        // Admin dan owner bisa akses semua
        if (in_array($role, ['administrator', 'owner'])) {
            return true;
        }

        // Cek dari database
        $CI->load->database();
        $permission = $CI->db->where('role', $role)
            ->where('module', $module)
            ->where('can_view', 1)
            ->get('permissions')
            ->row();

        return $permission ? true : false;
    }
}

if (!function_exists('hanya_untuk_role')) {
    /**
     * Hanya untuk role tertentu
     */
    function hanya_untuk_role($allowed_roles = [])
    {
        $CI = &get_instance();
        $current_role = $CI->session->userdata('role');
        return in_array($current_role, $allowed_roles);
    }
}

if (!function_exists('is_submenu_active')) {
    /**
     * Cek apakah menu/submenu aktif
     */
    function is_submenu_active($segment)
    {
        $CI = &get_instance();

        if (is_array($segment)) {
            foreach ($segment as $s) {
                if ($CI->uri->segment(1) == $s || $CI->uri->segment(2) == $s) {
                    return true;
                }
            }
            return false;
        }

        return ($CI->uri->segment(1) == $segment || $CI->uri->segment(2) == $segment);
    }
}

if (!function_exists('get_user_role_name')) {
    /**
     * Dapatkan nama role dari kode role
     */
    function get_user_role_name($role_code)
    {
        $role_names = [
            'administrator' => 'Administrator',
            'owner' => 'Owner',
            'cashier' => 'Kasir',
            'hr_manager' => 'Manager HR',
            'sales_manager' => 'Manager Penjualan',
            'purchase_manager' => 'Manager Pembelian',
            'inventory_manager' => 'Manager Inventori'
        ];

        return isset($role_names[$role_code]) ? $role_names[$role_code] : $role_code;
    }
}
