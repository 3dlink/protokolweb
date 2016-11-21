<?php
defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);

$row = $this->order_row;
EcommercewdOrder::print_order($row);
