<?php

defined('ABSPATH') || die('Access Denied');
$order_link = $this->order_link;
?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php'; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="wd_shop_panel_user_data panel panel-default">
        <div class="panel-body">
          <!--<h3 class="wd_shop_header">
            <?php _e('Congratulations', 'wde'); ?>
          </h3>-->
          <p>
            <?php _e('Checkout finished successfully ', 'wde'); ?>
          </p>
        </div>
        <a href="<?php echo $order_link; ?>" class="btn btn-link btn-sm"><?php _e('Order details', 'wde'); ?></a>
      </div>
      </div>
  </div>
</div>