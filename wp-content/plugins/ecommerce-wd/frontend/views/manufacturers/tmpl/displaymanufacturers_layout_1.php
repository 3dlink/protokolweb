<?php

defined('ABSPATH') || die('Access Denied');

$options = $this->options;
$rows = $this->row;

?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php'; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <?php
      if ($options->search_enable_search == 1) {
        ?>
      <div class="well">
        <?php
        require WD_E_DIR . '/frontend/views/' . $this->_folder . '/tmpl/' . $this->_layout . '_barsearch.php';
        ?>
      </div>
      <div class="wd_divider"></div>
        <?php
      }
      if (empty($rows) == false) {
        require WD_E_DIR . '/frontend/views/' . $this->_folder . '/tmpl/' . $this->_layout . '_arrangementlist.php';
      }
      else {
        require WD_E_DIR . '/frontend/views/' . $this->_folder . '/tmpl/' . $this->_layout . '_noresults.php';
      }
      ?>
      <div class="wd_divider"></div>
      <?php
      require WD_E_DIR . '/frontend/views/' . $this->_folder . '/tmpl/' . $this->_layout . '_barpagination.php';
      ?>
    </div>
  </div>
</div>