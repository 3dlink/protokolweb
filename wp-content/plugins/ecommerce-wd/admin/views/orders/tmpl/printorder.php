<?php

defined('ABSPATH') || die('Access Denied');

// js
wp_print_scripts('jquery');
$controller = WDFInput::get_controller();
wde_register_ajax_scripts($controller);
wp_print_scripts('wde_' . $controller . '_' . $this->_layout);

$row = $this->row;
EcommercewdOrder::print_order($row);
