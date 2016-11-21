<?php
defined('ABSPATH') || die('Access Denied');

$lists = $this->lists;
$list_shipping_data_field = $lists['list_shipping_data_field'];
$row = $this->row;
$model_options = WDFHelper::get_model('options');
$options = $model_options->get_options();
$initial_values = $options['initial_values'];

?>

<table class="adminlist table">
  <tbody>
    <!-- shipping methods -->
    <tr>
      <td class="col_key">
        <label><?php _e('Enable shipping', 'wde') ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio_list('enable_shipping', $list_shipping_data_field, 'value', 'text', $row->enable_shipping, 'onchange="onShippingChange(event, this);"'); ?>
      </td>
    </tr>
    <tr id="shipping_methods" class="shipping_info">
      <td class="col_key">
        <label><?php _e('Shipping methods', 'wde') ?>:</label>
        <span class="star">*</span>
      </td>
      <td class="col_value">
        <textarea type="text"
                  name="shipping_method_names"
                  id="shipping_method_names"
                  class="names_list" 
                  disabled="disabled"
                  data-tab-index='shipping'><?php echo $row->shipping_method_names; ?></textarea>
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveShippingMethodsClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', 'thickbox', 'onclick="onBtnSelectShippingMethodsClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_shippingmethods', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden"
               name="shipping_method_ids"
               id="shipping_method_ids"
               value="<?php echo $row->shipping_method_ids; ?>"/>
      </td>
    </tr>
    <!-- product weight -->
    <tr class="shipping_info">
      <td class="col_key">
        <label for="weight"><?php _e('Weight', 'wde'); ?>:</label>
      </td>
    <td class="col_value">
      <input type="text"
         name="weight"
         id="weight"
         value="<?php echo $row->weight; ?>"
         onKeyPress="return disableEnterKey(event);"/>
         <span><?php echo ' ('.$initial_values['weight_unit'].')';?></span>
      </td>	
    </tr>
    <!-- product dimensions -->
    <tr class="shipping_info">
      <td class="col_key">
          <label for="dimensions_length"><?php _e('Dimensions (LxWxH)', 'wde') ?>:</label>
      </td>
      <td class="col_value">
        <input type="text"
           name="dimensions_length"
           id="dimensions_length"
           value="<?php echo $row->dimensions_length; ?>"
           onKeyPress="return disableEnterKey(event);"/>
        <input type="text"
         name="dimensions_width"
         id="dimensions_width"
         value="<?php echo $row->dimensions_width; ?>"
         onKeyPress="return disableEnterKey(event);"/>  
        <input type="text"
         name="dimensions_height"
         id="dimensions_height"
         value="<?php echo $row->dimensions_height; ?>"
         onKeyPress="return disableEnterKey(event);"/> 
        <span><?php echo ' ('.$initial_values['dimensions_unit'].')';?></span> 
       <input type="hidden" name="dimensions" value="<?php echo $row->dimensions; ?>" />
      </td>	
    </tr>
  </tbody>
</table>
