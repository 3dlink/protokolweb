<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);
// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

$row_default_currency = $this->row_default_currency;

$list_shipping_type = array();
$list_shipping_type[] = (object)array('value' => 'per_bundle', 'text' => __('Per bundle', 'wde'));
$list_shipping_type[] = (object)array('value' => 'per_unit', 'text' => __('Per unit', 'wde'));

$row = $this->row;
if (!$row) {
  ?>
  <div class="form-field form-required">
    <label><?php _e('Countries', 'wde'); ?></label>
    <textarea type="text" name="country_names" id="country_names" class="names_list" disabled="disabled"></textarea>
    <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveCountriesClick(event, this);"'); ?>
    <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', 'thickbox', 'onclick="onBtnSelectCountriesClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
    <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_countries', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
    <input type="hidden" name="country_ids" id="country_ids" value="" />
    <p class="description"><?php _e('To set for all countries leave the field empty.', 'wde'); ?></p>
  </div>
  <div class="form-field">
    <label><?php _e('Tax', 'wde'); ?></label>
    <input type="text" name="tax_name" value="<?php echo $row['tax_name']; ?>" disabled="disabled" class="wde-width-initial" />
    <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveTaxClick(event, this);"'); ?>
    <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', 'thickbox', 'onclick="onBtnSelectTaxClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
    <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_taxes', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
    <input type="hidden" name="tax_id" id="tax_id" value="<?php echo $row['tax_id']; ?>">
  </div>
  <div>
    <label><?php _e('Free shipping', 'wde'); ?>:</label>
    <?php
    $free_shipping = 0;
    $free_shipping_0_checked = $free_shipping != 1 ? 'checked="checked"' : '';
    $free_shipping_1_checked = $free_shipping == 1 ? 'checked="checked"' : '';
    $free_shipping_after_certain_price_checked = '';
    $price_container_class_hidden = $free_shipping == 1 ? 'hidden' : '';
    $free_shipping_start_price_container_class_hidden = $free_shipping != 2 ? 'hidden' : '';
    ?>
    <input type="radio"
           name="free_shipping"
           id="free_shipping_0"
           value="0"
           <?php echo $free_shipping_0_checked; ?>
           onchange="onFreeShippingChange(event, this);"/>
    <label for="free_shipping_0" class="wde_label">
      <?php _e('No', 'wde'); ?>
    </label>
    <input type="radio"
           name="free_shipping"
           id="free_shipping_1"
           value="1"
           <?php echo $free_shipping_1_checked; ?>
           onchange="onFreeShippingChange(event, this);"/>
    <label for="free_shipping_1" class="wde_label">
      <?php _e('Yes', 'wde'); ?>
    </label>
    <p class="description"></p>
  </div>
  <div class="price_container <?php echo $price_container_class_hidden; ?>">
    <label for="price"><?php _e('Price', 'wde'); ?>:</label>
    <input type="text" name="price" id="price" value="0.00" onKeyPress="return disableEnterKey(event);"/>
    <?php echo $row_default_currency->code; ?>
    <br />
    (<label for="free_shipping_after_certain_price" class="wde_label">
        <input type="checkbox"
               name="free_shipping_after_certain_price"
               id="free_shipping_after_certain_price"
               value="1"
            <?php echo $free_shipping_after_certain_price_checked; ?>
               onchange="onFreeShippingAfterCertainPriceChange(event, this);"/>
        <?php _e('Free shipping for orders over a certain price', 'wde'); ?>
    </label>
    <span class="free_shipping_start_price_container <?php echo $free_shipping_start_price_container_class_hidden; ?>">
      <input type="text" name="free_shipping_start_price" value="0.00" />
      <?php echo $row_default_currency->code; ?>
    </span>)
    <p class="description"></p>
  </div>  
  <div class="price_container <?php echo $price_container_class_hidden; ?>">
    <label><?php _e('Shipping rate calculation', 'wde'); ?>:</label>
    <?php echo WDFHTML::wd_radio_list('shipping_type', $list_shipping_type, 'value', 'text', $list_shipping_type[0]->value); ?>
  </div>
  <?php
}
else {
  ?>
  <tr class="form-field form-required">
    <th scope="row" valign="top"><label><?php _e('Countries', 'wde'); ?></label></th>
    <td>
      <textarea type="text" name="country_names" id="country_names" class="names_list" disabled="disabled"><?php echo $row['country_names']; ?></textarea>
      <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveCountriesClick(event, this);"'); ?>
      <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', 'thickbox', 'onclick="onBtnSelectCountriesClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
      <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_countries', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
      <input type="hidden" name="country_ids" id="country_ids" value="<?php echo $row['country_ids']; ?>" />
      <p class="description"><?php _e('To set for all countries leave the field empty.', 'wde'); ?></p>
    </td>
  </tr>
  <tr>
    <th scope="row" valign="top"><label><?php _e('Tax', 'wde'); ?></label></th>
    <td>
      <input type="text" name="tax_name" value="<?php echo $row['tax_name']; ?>" disabled="disabled" />
      <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveTaxClick(event, this);"'); ?>
      <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', 'thickbox', 'onclick="onBtnSelectTaxClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
      <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_taxes', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
      <input type="hidden" name="tax_id" id="tax_id" value="<?php echo $row['tax_id']; ?>">
    </td>
  </tr>
  <tr>
    <th scope="row" valign="top"><label for="free_shipping"><?php _e('Free shipping', 'wde'); ?></label></th>
    <td>
      <?php
      $free_shipping = $row['free_shipping'];
      $free_shipping_0_checked = $free_shipping != 1 ? 'checked="checked"' : '';
      $free_shipping_1_checked = $free_shipping == 1 ? 'checked="checked"' : '';
      $free_shipping_after_certain_price_checked = $free_shipping == 2 ? 'checked="checked"' : '';
      $price_container_class_hidden = $free_shipping == 1 ? 'hidden' : '';
      $free_shipping_start_price_container_class_hidden = $free_shipping != 2 ? 'hidden' : '';
      ?>
      <input type="radio" name="free_shipping" id="free_shipping_0" value="0"
             <?php echo $free_shipping_0_checked; ?>
             onchange="onFreeShippingChange(event, this);"/>
      <label for="free_shipping_0">
        <?php _e('No', 'wde'); ?>
      </label>
      <input type="radio"
             name="free_shipping"
             id="free_shipping_1"
             value="1"
             <?php echo $free_shipping_1_checked; ?>
             onchange="onFreeShippingChange(event, this);"/>
      <label for="free_shipping_1">
        <?php _e('Yes', 'wde'); ?>
      </label>
      <p class="description"></p>
    </td>
  </tr>
  <tr class="price_container <?php echo $price_container_class_hidden; ?>">
    <th scope="row" valign="top"><label for="price"><?php _e('Price', 'wde'); ?></label></td>
    <td>
      <input type="text" name="price" id="price" value="<?php echo $row['price']; ?>" onKeyPress="return disableEnterKey(event);"/>
      <?php echo $row_default_currency->code; ?>
      <br />
      (<label for="free_shipping_after_certain_price">
          <input type="checkbox"
                 name="free_shipping_after_certain_price"
                 id="free_shipping_after_certain_price"
                 value="1"
                 <?php echo $free_shipping_after_certain_price_checked; ?>
                 onchange="onFreeShippingAfterCertainPriceChange(event, this);"/>
          <?php _e('Free shipping for orders over a certain price', 'wde'); ?>
      </label>
      <span
          class="free_shipping_start_price_container <?php echo $free_shipping_start_price_container_class_hidden; ?>">
          <input type="text"
                 name="free_shipping_start_price"
                 value="<?php echo $row['free_shipping_start_price']; ?>"/>
          <?php echo $row_default_currency->code; ?>
      </span>)
      <p class="description"></p>
    </td>
  </tr>
  <tr class="price_container <?php echo $price_container_class_hidden; ?>">
    <th scope="row" valign="top"><label><?php _e('Shipping rate calculation', 'wde'); ?></label></td>
    <td>
      <?php echo WDFHTML::wd_radio_list('shipping_type', $list_shipping_type, 'value', 'text', $row['shipping_type']); ?>
    </td>
  </tr>
  <?php
}
?>

<script>
  var _wde_admin_url = "<?php echo admin_url(); ?>";
</script>