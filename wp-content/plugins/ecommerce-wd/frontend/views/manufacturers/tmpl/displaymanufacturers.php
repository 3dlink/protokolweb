<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

require WD_E_DIR . '/frontend/views/' . $this->_folder . '/tmpl/' . $this->_layout . '_mainform.php';
require WD_E_DIR . '/frontend/views/' . $this->_folder . '/tmpl/' . $this->_layout . '_layout_1.php';