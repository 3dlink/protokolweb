<?php

defined('ABSPATH') || die('Access Denied');

$lists = $this->lists;
$list_date_formats = $lists['date_formats'];
$list_order_shipping_type = $lists['order_shipping_type'];
$list_tax_based_on = $lists['tax_based_on'];
$list_tax_total_display = $lists['tax_total_display'];

$options = $this->options;
$initial_values = $options['initial_values'];

?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="col_key">
        <label for="option_include_discount_in_price">
          <?php _e('Include discount in price', 'wde'); ?>:
        </label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('option_include_discount_in_price', $initial_values['option_include_discount_in_price'], __('Yes', 'wde'), __('No', 'wde')); ?>
        <a class="jfbutton jfbutton_color_blue jfbutton_size_medium"
           target="_blank"
           href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=wde_discounts')); ?>"
           title="<?php _e('To add a new discount or edit the existing one, please click on the button.', 'wde'); ?>"><?php _e('Manage discount', 'wde'); ?></a>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="enable_tax">
          <?php _e('Enable taxes', 'wde'); ?>:
        </label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('enable_tax', $initial_values['enable_tax'], __('Yes', 'wde'), __('No', 'wde')); ?>
        <a class="jfbutton jfbutton_color_blue jfbutton_size_medium"
           target="_blank"
           href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=wde_taxes')); ?>"
           title="<?php _e('To add a new tax or edit the existing one, please click on the button.', 'wde'); ?>"><?php _e('Manage tax', 'wde'); ?></a>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="price_entered_with_tax">
          <?php _e('Prices entered with tax', 'wde'); ?>:
        </label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('price_entered_with_tax', $initial_values['price_entered_with_tax'], __('Yes', 'wde'), __('No', 'wde')); ?>
        <p class="description"><?php _e('Changing this option will not update existing products.', 'wde'); ?></p>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="option_include_tax_in_price">
          <?php _e('Include tax in price', 'wde'); ?>:
        </label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('option_include_tax_in_price', $initial_values['option_include_tax_in_price'], __('Yes', 'wde'), __('No', 'wde')); ?>
        <p class="description"><?php _e('This option works only when tax is calculated based on shop address.', 'wde'); ?></p>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="option_include_tax_in_checkout_price">
          <?php _e('Include tax in price during checkout and in shopping cart', 'wde'); ?>:
        </label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('option_include_tax_in_checkout_price', $initial_values['option_include_tax_in_checkout_price'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="option_include_tax_in_checkout_price">
          <?php _e('Round tax', 'wde'); ?>:
        </label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('round_tax_at_subtotal', $initial_values['round_tax_at_subtotal'], __('At subtotal', 'wde'), __('Per line', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="tax_based_on"><?php _e('Calculate tax based on', 'wde'); ?>:</label>
      </td>
      <td class="col_value">   
        <?php echo WDFHTML::wd_select('tax_based_on', $list_tax_based_on, 'value', 'text', $initial_values['tax_based_on']); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="price_display_suffix"><?php _e('Price display suffix', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="price_display_suffix" id="price_display_suffix" value="<?php echo $initial_values['price_display_suffix']; ?>" />
        <p class="description"><?php _e('You can also have prices substituted here using one of the following: {price_including_tax},{price_excluding_tax}', 'wde'); ?></p>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="tax_total_display"><?php _e('Display tax totals', 'wde'); ?>:</label>
      </td>
      <td class="col_value">   
        <?php echo WDFHTML::wd_select('tax_total_display', $list_tax_total_display, 'value', 'text', $initial_values['tax_total_display']); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="option_order_shipping_type">
          <?php _e('Shipping rate calculation', 'wde'); ?>:
        </label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio_list('option_order_shipping_type', $list_order_shipping_type, 'value', 'text', $initial_values['option_order_shipping_type']) ?>
      </td>
    </tr>
  </tbody>
  <!-- ctrls -->
  <tbody>
    <tr>
      <td class="btns_container" colspan="2">
        <?php
        echo WDFHTML::jfbutton(__('Reset', 'wde'), '', '', 'onclick="onBtnResetClick(event, this, \'other\');"');
        echo WDFHTML::jfbutton(__('Load default values', 'wde'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'other\');"');
        ?>
      </td>
    </tr>
  </tbody>
</table>