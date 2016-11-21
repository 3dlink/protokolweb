<?php
defined('ABSPATH') || die('Access Denied');

$row_default_currency = $this->default_currency_row;
$row = $this->row;
$model_options = WDFHelper::get_model('options');
$options = $model_options->get_options();
$initial_values = $options['initial_values'];

?>

<table class="adminlist table">
  <tbody>
    <!-- model-->
    <tr>
      <td class="col_key">
        <label for="model"><?php _e('Model', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text"
               name="model"
               id="model"
               value="<?php echo $row->model; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
    <!-- price -->
    <tr>
      <td class="col_key ">
        <label for="price"><?php _e('Price', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text"
               name="price"
               id="price"
               value="<?php echo $row->price; ?>">
        <?php echo $row_default_currency->code; ?>
      </td>
    </tr>
    <!-- discount -->
    <tr>
      <td class="col_key">
        <label><?php _e('Discount', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="discount_name" value="<?php echo $row->discount_name; ?>" disabled="disabled" />
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveDiscountClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', 'thickbox', 'onclick="onBtnSelectDiscountClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_discounts', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="discount_id" id="discount_id" value="<?php echo $row->discount_id; ?>">
        <input type="hidden" name="discount_rate" id="discount_rate" value="<?php echo $row->discount_rate; ?>">
      </td>
    </tr>
    <!-- tax -->
    <tr>
      <td class="col_key">
        <label><?php _e('Tax', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="tax_name" value="<?php echo $row->tax_name; ?>" disabled="disabled" />
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveTaxClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', 'thickbox', 'onclick="onBtnSelectTaxClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_taxes', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="tax_id" id="tax_id" value="<?php echo $row->tax_id; ?>">
        <input type="hidden" name="tax_rate" id="tax_rate" value="<?php echo $row->tax_rate; ?>">
      </td>
    </tr>
    <!-- market price -->
    <tr>
      <td class="col_key">
        <label for="market_price"><?php _e('Market price', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text"
               name="market_price"
               id="market_price"
               value="<?php echo $row->market_price; ?>">
        <?php echo $row_default_currency->code; ?>
      </td>
    </tr>
    <!-- amount in stock -->
    <tr>
      <td class="col_key">
        <label for="amount_in_stock"><?php _e('Amount in stock', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <div>
          <label>
            <input type="checkbox"
                   name="unlimited"
                   value="1"
                   <?php echo $row->unlimited == 1 ? 'checked="checked"' : ''; ?>
                   onchange="onUnlimitedChange(event, this);">
            <?php _e('Unlimited', 'wde'); ?>
          </label>
        </div>
        <div>
          <input type="text"
                 name="amount_in_stock"
                 id="amount_in_stock"
                 class="<?php echo $row->unlimited == 1 ? "hidden" : ""; ?>"
                 value="<?php echo $row->amount_in_stock; ?>">
        </div>
      </td>
    </tr>
    <?php if ($initial_values['enable_sku'] == 1) { ?>
    <!-- sku-->
    <tr>
      <td class="col_key">
        <label for="sku" ><?php _e('SKU', 'wde'); ?>:</label>
      <div><small><?php _e('Stock Keeping Unit', 'wde'); ?></small></div>
      </td>
      <td class="col_value">
        <input type="text"
               name="sku"
               id="sku"
               value="<?php echo $row->sku; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
    <?php }
    if ($initial_values['enable_upc'] == 1) {
    ?>
    <!-- upc-->
    <tr>
      <td class="col_key">
        <label for="upc" ><?php _e('UPC', 'wde'); ?>:</label>
      <div><small><?php _e('Universal Product Code', 'wde'); ?></small></div>
      </td>
      <td class="col_value">
        <input type="text"
               name="upc"
               id="upc"
               value="<?php echo $row->upc; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
    <?php }
    if ($initial_values['enable_ean'] == 1) {
    ?>
    <!-- ean-->
    <tr>
      <td class="col_key">
        <label for="ean" ><?php _e('EAN', 'wde'); ?>:</label>
      <div><small><?php _e('European Article Number', 'wde'); ?></small></div>
      </td>
      <td class="col_value">
        <input type="text"
               name="ean"
               id="ean"
               value="<?php echo $row->ean; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
    <?php }
    if ( $initial_values['enable_jan'] == 1) {
    ?>
    <!-- jan-->
    <tr>
      <td class="col_key">
        <label for="jan" ><?php _e('JAN', 'wde'); ?>:</label>
      <div><small><?php _e('Japanese Article Number', 'wde'); ?></small></div>
      </td>
      <td class="col_value">
        <input type="text"
               name="jan"
               id="jan"
               value="<?php echo $row->jan; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
    <?php }
    if ($initial_values['enable_isbn'] == 1) {
    ?>
    <!-- isbn-->
    <tr>
      <td class="col_key">
        <label for="isbn" ><?php _e('ISBN', 'wde'); ?>:</label>
      <div><small><?php _e('International Standard Book Number', 'wde'); ?></small></div>
      </td>
      <td class="col_value">
        <input type="text"
               name="isbn"
               id="isbn"
               value="<?php echo $row->isbn; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
    <?php }
    if ($initial_values['enable_mpn'] == 1) {
    ?>
    <!-- mpn-->
    <tr>
      <td class="col_key">
        <label for="mpn" ><?php _e('MPN', 'wde'); ?>:</label>
      <div><small><?php _e('Manufacturer Part Number', 'wde'); ?></small></div>
      </td>
      <td class="col_value">
        <input type="text"
               name="mpn"
               id="mpn"
               value="<?php echo $row->mpn; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
    <?php } ?>
  </tbody>
  <input type="hidden" name="tax_id" id="tax_id" value="<?php echo $row->tax_id; ?>" />
  <input type="hidden" name="tax_rate" id="tax_rate" value="<?php echo $row->tax_rate; ?>" />
  <input type="hidden" name="discount_id" id="discount_id" value="<?php echo $row->discount_id; ?>" />
  <input type="hidden" name="discount_rate" id="discount_rate" value="<?php echo $row->discount_rate; ?>" />
</table>
