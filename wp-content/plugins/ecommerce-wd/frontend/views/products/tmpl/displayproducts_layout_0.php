<?php

defined('ABSPATH') || die('Access Denied');

$arrangement_data = $this->arrangement_data;

$product_rows = $this->product_rows;
?>
<div class="container">
  <!-- user bar -->
  <div class="row">
    <div class="col-sm-12">
      <?php
      require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php';
      ?>
    </div>
  </div>
  <!-- search, arrangement and sort bars -->
  <div class="row">
    <div class="col-sm-12">
      <div class="well">
        <?php
        require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_barsearch.php';
        ?>
        <div class="row">
          <div class="col-sm-6 hidden-xs">
            <?php
            require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bararrangement.php';
            ?>
          </div>
          <div class="col-sm-6 col-xs-12 pull-right">
            <?php
            require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_barsort.php';
            ?>
          </div>
        </div>
      </div>
      <div class="wd_divider"></div>
      <?php
      if (empty($product_rows) == false) {
        require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_arrangement' . $arrangement_data['arrangement'] . '.php';
      }
      else {
        require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_noresults.php';
      }
      ?>
      <div class="wd_divider"></div>
      <?php
      require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_barpagination.php';
      ?>
    </div>
  </div>
</div>