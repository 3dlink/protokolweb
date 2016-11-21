<?php
 
defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;

$pagination = $this->pagination;
$order_rows = $this->order_rows;
?>
<form name="wd_shop_main_form" action="" method="POST">
  <input type="hidden" name="pagination_limit_start" value="" />
  <input type="hidden" name="pagination_limit" value="" />
</form>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php'; ?>
    </div>
  </div>
  <?php
  if (!empty($order_rows)) {
    ?>
    <div class="row">
      <?php
      foreach ($order_rows as $order_row) {
        ?>
      <div class="wd_shop_order_container col-sm-12" order_id="<?php echo $order_row->id; ?>">
        <div class="wd_shop_panel_product panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-3">
                  <?php
                  // Show big image if there is one product or 4 small images.
                  if (count($order_row->product_images) > 1) {
                    $class_img_container_col = 'col-xs-6';
                    $class_img_container_single = '';
                  }
                  else {
                    $class_img_container_col = 'col-xs-12';
                    $class_img_container_single = 'wd_shop_order_product_image_container_single';
                  }
                  foreach ($order_row->product_images as $key => $product_image) {
                    if ($key >= 4) {
                      break;
                    }
                    ?>
                  <div class="<?php echo $class_img_container_col; ?> order_product_image">
                    <div class="wd_shop_order_product_image_container <?php echo $class_img_container_single; ?> wd_center_wrapper">
                      <div>
                        <?php
                        if ($product_image != '') {
                          ?>
                        <img class="wd_shop_order_product_image" src="<?php echo $product_image; ?>" />
                          <?php
                        }
                        else {
                          ?>
                        <div class="wd_shop_order_product_no_image">
                          <span class="glyphicon glyphicon-picture"></span><br />
                          <span><?php _e('No Image', 'wde'); ?></span>
                        </div>
                          <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                    <?php
                  }
                  // Add ... image if there is more than 4 images.
                  if (count($order_row->product_images) > 4) {
                    ?>
                  <div class="wd_shop_order_product_image_container <?php echo $class_img_container_col; ?> wd_center_wrapper">
                    <div>
                      <div class="wd_shop_order_product_image_more">
                        <span>...</span>
                      </div>
                    </div>
                  </div>
                    <?php
                  }
                  ?>
              </div>
              <div class="col-sm-6">
                <a href="<?php echo $order_row->order_link; ?>" class="wd_shop_order_btn_product_names wd_shop_product_name_all btn btn-link">
                  <?php echo $order_row->product_names; ?>
                </a>
                <p class="wd_shop_order_detail">
                  <small><?php _e('Order ID', 'wde'); ?>:</small>
                  <small><?php echo $order_row->id; ?></small>
                </p>
                <p class="wd_shop_order_detail">
                  <small><?php _e('Checkout date', 'wde'); ?>:</small>
                  <small><?php echo date($options->option_date_format, strtotime($order_row->checkout_date)); ?></small>
                </p>
                <p class="wd_shop_order_detail">
                  <small><?php _e('Status', 'wde'); ?>:</small>
                  <small><?php echo $order_row->status_name; ?></small>
                </p>
              </div>
              <div class="col-sm-3 text-right">
                <?php
                if ($order_row->price_text) {
                  ?>
                <p class="wd_shop_order_price_container">
                  <span class="wd_shop_order_price wd_shop_product_price_all">
                    <?php echo $order_row->price_text; ?>
                  </span>
                </p>
                  <?php
                }
                if ($order_row->tax_price_text) {
                  ?>
                <p class="wd_shop_order_tax_price_container">
                  <span class="wd_shop_order_price_title wd_shop_product_price_small">
                    <?php _e('Tax', 'wde'); ?>:
                  </span>
                  <span class="wd_shop_order_price wd_shop_product_price_small">
                    <?php echo $order_row->tax_price_text; ?>
                  </span>
                </p>
                  <?php
                }
                if ($order_row->shipping_price_text) {
                  ?>
                <p class="wd_shop_order_shipping_price_container">
                  <span class="wd_shop_order_price_title wd_shop_product_price_small">
                    <?php _e('Shipping', 'wde'); ?>:
                  </span>
                  <span class="wd_shop_order_price wd_shop_product_price_small">
                    <?php echo $order_row->shipping_price_text; ?>
                  </span>
                </p>
                  <?php
                }
                ?>
              </div>
            </div>
            <?php
            if ($order_row->total_price_text) {
              ?>
            <div class="wd_divider"></div>
            <div class="row">
              <div class="col-sm-12 text-right">
              <p>                                     
                <span class="wd_shop_order_price_title wd_shop_product_price_all">
                  <?php _e('Total price', 'wde'); ?>:
                </span>
                <span class="wd_shop_order_price wd_shop_product_price_all">
                  <?php echo $order_row->total_price_text; ?>
                </span>
              </p>
              </div>
            </div>
              <?php
            }
            ?>
          </div>
          <div class="panel-footer">
            <div class="row">
              <div class="col-sm-12 text-right">
                <div class="wd_shop_order_ctrls">
                  <a class="btn btn-link btn-sm"
                     href="<?php echo $order_row->print_orders_link; ?>" target="_blank">
                    <?php _e('Print order', 'wde'); ?>
                  </a>
                  <a class="btn btn-link btn-sm"
                     href="<?php echo $order_row->order_link; ?>" >
                    <?php _e('View order details', 'wde'); ?>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <?php
      }
      ?>
    </div>
    <?php require WD_E_DIR . '/frontend/views/orders/tmpl/displayorders_barpagination.php'; ?>
    <?php
  }
  else {
    ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-info">
          <?php _e('No orders yet.', 'wde') ?>
        </div>
      </div>
    </div>
    <?php
  }
  ?>
</div>