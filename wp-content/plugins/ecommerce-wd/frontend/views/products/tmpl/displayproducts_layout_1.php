<?php

defined('ABSPATH') || die('Access Denied');

$options = $this->options;
$arrangement_data = $this->arrangement_data;

$product_rows = $this->product_rows;

$show_filters = ($options->filter_manufacturers == 1) || ($options->filter_price == 1) || ($options->filter_date_added == 1) || ($options->filter_minimum_rating == 1) || ($options->filter_tags == 1) ? true : false;
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
  <!-- search, filters, arrangement and sort bars -->
  <div class="row">
    <div class="col-sm-12">
      <div class="well">
        <?php
        require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_barsearch.php';
        if ($show_filters == true) {
          require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_barfilters.php';
        }
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