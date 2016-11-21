<?php

defined('ABSPATH') || die('Access Denied');

$products = $row->product_rows;
if (!$products) {
  return;
}

wp_enqueue_style('wde_orderproducts');
?>
<fieldset>
  <legend><?php _e('Order products', 'wde'); ?></legend>
  <table class="adminlist table table-striped widefat fixed pages">
    <thead>
      <tr>
        <th class="col_num">#</th>
        <th class="col_product_image"><?php _e('Image', 'wde'); ?></th>
        <th class="col_product_name"><?php _e('Name', 'wde'); ?></th>
        <th class="col_price"><?php _e('Price', 'wde'); ?></th>
        <th class="col_discount"><?php _e('Discount', 'wde'); ?></th>
        <th class="col_price"><?php _e('Tax', 'wde'); ?></th>
        <th class="col_count"><?php _e('Quantity', 'wde'); ?></th>
        <?php
        if ($row->shipping_type == 'per_item') {
          ?>
        <th class="col_price"><?php _e('Shipping', 'wde'); ?></th>
          <?php
        }
        ?>
        <th class="col_subtotal"><?php _e('Total', 'wde'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($products as $i => $product) {
        $alternate = (!isset($alternate) || $alternate == 'alternate') ? '' : 'alternate';
        ?>
      <tr class="<?php echo $alternate; ?>">
        <td class="col_num"><?php echo $i + 1; ?></td>
        <td class="col_product_image">
          <?php
          if ($product->product_image != '') {
            ?>
          <img class="order_product_image" src="<?php echo $product->product_image; ?>" alt="<?php echo $product->product_name; ?>" title="<?php echo $product->product_name; ?>" />
            <?php
          }
          else {
            ?>&nbsp;<?php
          }
          ?>
        </td>
        <td class="col_product_name">
          <a href="<?php echo $product->product_edit_link; ?>" target="_blank"><?php echo $product->product_name; ?></a>
          <?php
          if ($product->product_parameters) {
            ?>
          <small><p><?php echo __('Parameters', 'wde') . ': ' . str_replace('%br%', '<br />', $product->product_parameters); ?></p></small>
            <?php
          }
          ?>
        </td>
        <td class="col_price"><?php echo $product->price_text; ?></td>
        <td class="col_discount"><?php echo $product->discount_rate; ?></td>
        <td class="col_price"><?php echo $product->tax_price_text; ?></td>
        <td class="col_count"><?php echo $product->product_count; ?></td>
        <?php
        if ($row->shipping_type == 'per_item') {
          ?>
        <td class="col_price"><?php echo $product->shipping_method_price_text; ?></td>
          <?php
        }
        ?>
        <td class="col_subtotal"><?php echo $product->subtotal_text; ?></td>
      </tr>
        <?php
      }
      ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="<?php echo $row->shipping_type == 'per_item' ? 7 : 6; ?>" class="col_total">
          <?php if ($row->tax_price_text) { ?>
          <div><?php _e('Total tax', 'wde'); ?>:</div>
          <?php } if ($row->total_shipping_price_text) { ?>
          <div><?php _e('Total shipping', 'wde'); ?>:</div>
          <?php } ?>
          <div><?php _e('Order total', 'wde'); ?>:</div>
        </td>
        <td colspan="2" class="col_total">
          <?php if ($row->tax_price_text) { ?>
          <div><?php echo $row->tax_price_text; ?></div>
          <?php } if ($row->total_shipping_price_text) { ?>
          <div><?php echo $row->total_shipping_price_text; ?></div>
          <?php } ?>
          <div><?php echo $row->total_price_text; ?></div>
        </td>
      </tr>
    </tfoot>
  </table>
</fieldset>