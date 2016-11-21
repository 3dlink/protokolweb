<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;
$rows = $this->row;

require WD_E_DIR . '/frontend/views/categories/tmpl/displaycategories_mainform.php';
require WD_E_DIR . '/frontend/views/categories/tmpl/displaycategories_layout_1.php';