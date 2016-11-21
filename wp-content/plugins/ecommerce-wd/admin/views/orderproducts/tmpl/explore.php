<?php

defined('ABSPATH') || die('Access Denied');

// WD js
wp_print_scripts('jquery');
// WD css
wp_print_styles('dashicons');
wp_print_styles('wp-admin');
wp_print_styles('buttons');
wp_print_styles('wp-auth-check');

$controller = WDFInput::get_controller();
wde_register_ajax_scripts($controller);

// css
wp_print_styles('wde_' . $controller . '_' . $this->_layout);
// js
wp_print_scripts('wde_view');
wp_print_scripts('wde_' . $controller . '_' . $this->_layout);

$order_array = $this->order_data;
$order_data = $order_array[0];
$rows = $this->rows;
?>
<form class="wp-core-ui" name="adminForm" id="adminForm" action="#" method="post">
  <?php echo $this->generate_message(); ?>
  <table class="adminlist table table-striped widefat fixed pages">
    <thead>
      <tr>
        <th class="col_num">#</th>
        <th class="col_product_name"><?php _e('Product name', 'wde'); ?></th>
        <th class="col_product_image"><?php _e('Product image', 'wde'); ?></th>
        <th class="col_parameters"><?php _e('Parameters', 'wde'); ?></th>
        <th class="col_price">
          <?php _e('Price', 'wde'); ?>
          <br />
          <?php echo $order_data->currency_code; ?>
        </th>
        <th class="col_tax">
          <?php _e('Tax', 'wde'); ?>
          <br />
          <?php echo $order_data->currency_code; ?>
        </th>
        <th class="col_shipping">
          <?php _e('Shipping', 'wde'); ?>
          <br />
          <?php echo $order_data->currency_code; ?>
        </th>
        <th class="col_count">
          <?php _e('Quantity', 'wde'); ?>
        </th>
        <th class="col_subtotal">
          <?php _e('Subtotal', 'wde'); ?>
          <br />
          <?php echo $order_data->currency_code; ?>
        </th>
        <th class="col_btns"><?php _e('Edit', 'wde'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($rows) {
        for ($i = 0; $i < count($rows); $i++) {
          $row = $rows[$i];
          $alternate = (!isset($alternate) || $alternate == 'alternate') ? '' : 'alternate';
          ?>
      <tr class="row<?php echo $i % 2; ?> <?php echo $alternate; ?>" item_id="<?php echo $row->id; ?>">
        <td class="col_num">
            <?php echo $i + 1; ?>
        </td>
        <td class="col_product_name">
          <input type="text"
                 name="product_name_<?php echo $row->id; ?>"
                 value="<?php echo $row->product_name; ?>">
        </td>
        <td class="col_product_image">
          <?php
          if ($row->product_image != '') {
            ?>
          <img class="order_product_image" src="<?php echo $row->product_image; ?>" />
            <?php
          }
          else {
            ?>&nbsp;<?php
          }
          ?>
        </td>
        <td class="col_parameters">
          <textarea name="product_parameters_<?php echo $row->id; ?>" style="resize:vertical"><?php echo $row->product_parameters; ?></textarea>
        </td>
        <td class="col_price">
          <input type="text"
                 name="product_price_<?php echo $row->id; ?>"
                 value="<?php echo $row->product_price; ?>">
        </td>
        <td class="col_tax">
          <?php echo $row->tax_name; ?>
          <input type="text"
                 name="tax_price_<?php echo $row->id; ?>"
                 value="<?php echo $row->tax_price; ?>">
        </td>
        <td class="col_shipping">
          <?php
          echo $row->shipping_method_name;
          if ($order_data->shipping_type != 'per_order') { ?>
            <input type="text"
                   name="shipping_method_price_<?php echo $row->id; ?>"
                   value="<?php echo $row->shipping_method_price; ?>">
          <?php
          }
          ?>
        </td>
        <td class="col_count">
          <input type="text"
                 name="product_count_<?php echo $row->id; ?>"
                 value="<?php echo $row->product_count; ?>">
        </td>
        <td class="col_subtotal">
          <span><?php echo $row->subtotal; ?></span>
        </td>
        <td class="col_btns">
          <?php echo WDFHTML::jfbutton(__('Delete', 'wde'), '', '', 'onclick="onBtnDeleteProductClick(event, this);"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
          <?php echo WDFHTML::jfbutton(__('Update', 'wde'), '', '', 'onclick="onBtnUpdateProductClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        </td>
      </tr>
          <?php
        }
      }
      else {
        echo WDFHTML::no_items(WDFToolbar::$item_name);
      }
      ?>
    </tbody>
  </table>

  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
  <input type="hidden" name="task" value=""/>
  <input type="hidden" name="order_id" value="<?php echo WDFInput::get('order_id'); ?>">
  <input type="hidden" name="callback" value="<?php echo WDFInput::get('callback'); ?>">
  <input type="hidden" name="id" value="">
  <input type="hidden" name="product_name" value="">
  <input type="hidden" name="product_parameters" value="">
  <input type="hidden" name="product_price" value="">
  <input type="hidden" name="product_count" value="">
  <input type="hidden" name="tax_price" value="">
  <input type="hidden" name="shipping_method_price" value="">
</form>

<script>
  var MSG_DELETE_CONFIRM_SINGLE = "<?php _e('Are you sure you want to delete this item?', 'wde'); ?>";
  var _orderDataJson = "<?php echo addslashes(stripslashes(WDFJson::encode($order_data, 256))); ?>";
  var _callback = "<?php echo WDFInput::get('callback'); ?>";
</script>

<?php
die();