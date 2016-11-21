<?php
defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;
$order_row = $this->order_row;
$billing_datas = array(
  array('name' => ($order_row->billing_data_middle_name || $order_row->billing_data_last_name) ? __('First name', 'wde') : __('Name', 'wde'), 'value' => $order_row->billing_data_first_name),
  array('name' => __('Middle name', 'wde'), 'value' => $order_row->billing_data_middle_name),
  array('name' => __('Last name', 'wde'), 'value' => $order_row->billing_data_last_name),
  array('name' => __('Company', 'wde'), 'value' => $order_row->billing_data_company),
  array('name' => __('Email', 'wde'), 'value' => $order_row->billing_data_email),
  array('name' => __('Country', 'wde'), 'value' => $order_row->billing_data_country),
  array('name' => __('State', 'wde'), 'value' => $order_row->billing_data_state),
  array('name' => __('City', 'wde'), 'value' => $order_row->billing_data_city),
  array('name' => __('Address', 'wde'), 'value' => $order_row->billing_data_address),
  array('name' => __('Mobile', 'wde'), 'value' => $order_row->billing_data_mobile),
  array('name' => __('Phone', 'wde'), 'value' => $order_row->billing_data_phone),
  array('name' => __('Fax', 'wde'), 'value' => $order_row->billing_data_fax),
  array('name' => __('Zip code', 'wde'), 'value' => $order_row->billing_data_zip_code),
);
$shipping_datas = array(
  array('name' => ($order_row->shipping_data_middle_name || $order_row->shipping_data_last_name) ? __('First name', 'wde') : __('Name', 'wde'), 'value' => $order_row->shipping_data_first_name),
  array('name' => __('Middle name', 'wde'), 'value' => $order_row->shipping_data_middle_name),
  array('name' => __('Last name', 'wde'), 'value' => $order_row->shipping_data_last_name),
  array('name' => __('Company', 'wde'), 'value' => $order_row->shipping_data_company),
  array('name' => __('Country', 'wde'), 'value' => $order_row->shipping_data_country),
  array('name' => __('State', 'wde'), 'value' => $order_row->shipping_data_state),
  array('name' => __('City', 'wde'), 'value' => $order_row->shipping_data_city),
  array('name' => __('Address', 'wde'), 'value' => $order_row->shipping_data_address),
  array('name' => __('Zip code', 'wde'), 'value' => $order_row->shipping_data_zip_code),
);
?>
<div class="container">
  <h1 class="wd_shop_header"><?php _e('Order', 'wde'); ?></h1>
  <div class="row">
    <div class="col-sm-12">
      <?php require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php'; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <h4 class="wd_shop_order_id">
        <?php echo __('Order ID', 'wde') . ': ' . $order_row->id; ?>
      </h4>
      <p class="wd_shop_order_checkout_date">
        <small><?php echo __('Checkout date', 'wde') . ': ' . date($options->option_date_format, strtotime($order_row->checkout_date)); ?></small>
      </p>
      <div class="wd_divider"></div>
      <?php
      foreach ($order_row->product_rows as $order_product_row) {
        ?>
      <div class="row">
        <div class="col-sm-3">
          <div class="wd_shop_order_product_image_container wd_center_wrapper">
            <div>
              <?php
              if ($order_product_row->product_image != '') {
                ?>
              <img class="wd_shop_order_product_image" src="<?php echo $order_product_row->product_image; ?>" />
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
        <div class="col-sm-6">
          <h4 class="wd_shop_order_product_name wd_shop_product_name text-left">
            <?php echo $order_product_row->product_name; ?>
            <small>(<?php echo __('Product ID', 'wde') . ': ' . $order_product_row->product_id; ?>)</small>
          </h4>
          <?php
          if ($order_product_row->enable_shipping == 1) {
            ?>
          <p class="wd_shop_order_product_shipping_method_name">
            <?php echo __('Shipping', 'wde') . ': ' . $order_product_row->shipping_method_name; ?>
          </p>
            <?php
          }
          if ($order_product_row->product_parameters) {
            ?>
          <p class="wd_shop_order_product_parameters">
            <?php echo __('Parameters', 'wde') . ': ' . stripslashes(str_replace('%br%', '<br />', $order_product_row->product_parameters)); ?>
          </p>
            <?php
          }
          ?>
        </div>
        <div class="col-sm-3 text-right">
          <?php
          if ($order_product_row->price_text) {
            ?>
          <p>
            <span class="wd_shop_order_product_price wd_shop_product_price"><?php echo $order_product_row->price_text; ?></span>
          </p>
            <?php
          }
          if ($order_product_row->discount_rate) {
            ?>
          <p class="wd_shop_order_product_price_container">
            <span class="wd_shop_order_product_price_title wd_shop_product_price_small"><?php _e('Discount', 'wde'); ?>:</span>
            <span class="wd_shop_order_product_price wd_shop_product_price_small"><?php echo $order_product_row->discount_rate; ?></span>
          </p>
            <?php
          }
          if ($order_product_row->tax_price_text) {
            ?>
          <p class="wd_shop_order_product_price_container">
            <!--<span class="wd_shop_order_product_price_title wd_shop_product_price_small"><?php _e('Tax', 'wde'); ?>:</span>-->
            <span class="wd_shop_order_product_price wd_shop_product_price_small"><?php echo $order_product_row->tax_price_text; ?></span>
          </p>
            <?php
          }
          ?>
          <p class="wd_shop_order_product_price_container">
            <span class="wd_shop_order_product_price_title wd_shop_product_price_small">
              <?php echo __('Quantity', 'wde') . ': ' . $order_product_row->product_count; ?>
            </span>
          </p>
          <?php
          if ($order_product_row->shipping_method_price_text) {
            ?>
          <p class="wd_shop_order_product_price_container">
            <span class="wd_shop_order_product_shipping_price_title wd_shop_product_price_small"><?php _e('Shipping', 'wde'); ?>:</span>
            <span class="wd_shop_order_product_shipping_price wd_shop_product_price_small"><?php echo $order_product_row->shipping_method_price_text; ?></span>
          </p>
            <?php
          }
          ?>
        </div>
      </div>
      <div class="wd_divider"></div>
        <?php
      }
      ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <h4 class="wd_shop_header_sm"><?php _e('Billing info', 'wde'); ?></h4>
      <dl class="wd_shop_order_product_shipiing_info_data dl-horizontal">
        <?php
        foreach ($billing_datas as $billing_data) {
          if ($billing_data['value']) {
            ?>
        <dt>
          <?php echo $billing_data['name']; ?>:
        </dt>
        <dd>
          <?php echo str_replace("'", "", $billing_data['value']); ?>
        </dd>
            <?php
          }
        }
        ?>
      </dl>		
    </div>
    <div class="col-sm-6">
      <h4 class="wd_shop_header_sm">
        <?php _e('Shipping info', 'wde'); ?>
      </h4>
      <dl class="wd_shop_order_product_shipiing_info_data dl-horizontal">
        <?php
        foreach ($shipping_datas as $shipping_data) {
          if ($shipping_data['value']) {
            ?>
        <dt>
          <?php echo $shipping_data['name']; ?>:
        </dt>
        <dd>
          <?php echo str_replace("'", "", $shipping_data['value']); ?>
        </dd>
            <?php
          }
        }
        ?>
      </dl>
    </div>
  </div>
  <div class="wd_divider"></div>
  <div class="row">
    <div class="col-sm-4">
      <span class="wd_shop_order_status_title"><?php _e('Status', 'wde'); ?>:</span>
      <span class="wd_shop_order_status"><?php echo $order_row->status_name; ?></span>
    </div>
    <?php
    if ($order_row->total_shipping_price_text) {
      ?>
    <div class="col-sm-8 text-right">
      <span class="wd_shop_order_price_title wd_shop_product_price"><?php _e('Shipping', 'wde'); ?>:</span>
      <span class="wd_shop_order_price wd_shop_product_price"><?php echo $order_row->total_shipping_price_text; ?></span>
    </div>
      <?php
    }
    if ($order_row->total_price_text) {
      ?>
    <div class="col-sm-<?php echo $order_row->total_shipping_price_text ? 12 : 8; ?> text-right">
      <span class="wd_shop_order_price_title wd_shop_product_price"><?php _e('Total price', 'wde'); ?>:</span>
      <span class="wd_shop_order_price wd_shop_product_price"><?php echo $order_row->total_price_text; ?></span>
    </div>
      <?php
    }
    ?>
  </div>
  <div class="wd_divider"></div>
  <div class="row">
    <div class="col-sm-12 text-right">
      <a class="btn btn-primary" href="<?php echo WDFPath::add_pretty_query_args(get_permalink($options->option_orders_page), $options->option_endpoint_orders_printorder, $order_row->id, TRUE);?>" target="_blank"><?php _e('Print order', 'wde') ?></a>
      <a class="btn btn-default" onclick="wdShop_onBtnBackClick(event, this); return false;"><?php _e('Back', 'wde') ?></a>
    </div>
  </div>
</div>
