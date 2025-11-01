<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('is_menu_active')) {
    function is_menu_active($segment, $uri_segment = 1)
    {
        $CI = &get_instance();
        return $CI->uri->segment($uri_segment) == $segment ? 'active' : '';
    }
}

if (!function_exists('is_submenu_active')) {
    function is_submenu_active($uri)
    {
        $CI = &get_instance();
        return $CI->uri->uri_string() == $uri ? 'active' : '';
    }
}

if (!function_exists('is_parent_menu_open')) {
    function is_parent_menu_open($segments = [])
    {
        $CI = &get_instance();
        $current_segment = $CI->uri->segment(1);

        foreach ($segments as $segment) {
            if ($current_segment == $segment) {
                return 'menu-open';
            }
        }
        return '';
    }
}
