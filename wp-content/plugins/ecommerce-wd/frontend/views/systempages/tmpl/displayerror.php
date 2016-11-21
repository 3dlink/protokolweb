<?php

defined('ABSPATH') || die('Access Denied');

$error = $this->error;
?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php'; ?>
    </div>
  </div>
  <div class="alert alert-danger">
    <h2 class="wd_shop_header text-center">
      <?php echo $error->header; ?>
    </h2>
    <p class="text-center">
      <?php echo $error->msg; ?>
    </p>
  </div>
</div>