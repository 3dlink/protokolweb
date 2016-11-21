<?php
defined('ABSPATH') || die('Access Denied');

$row_default_currency = $this->default_currency_row;
$lists = $this->lists;
$list_shipping_data_field = $lists['list_shipping_data_field'];
$row = $this->row;

?>

<!-- parameters -->
<fieldset>
  <legend><?php _e('Parameters', 'wde'); ?>:</legend>

  <table class="adminlist table parameters">
    <thead>
      <tr>
        <th class=""><?php _e('Ordering', 'wde'); ?></th>
        <th class="col_name"><?php _e('Name', 'wde'); ?></th>
        <th class="col_type"><?php _e('Type', 'wde'); ?></th>
        <th class="col_values"><?php _e('Values', 'wde'); ?><span class="price"><?php _e('Price', 'wde'); ?></span></th>
        <th class=""></th>
      </tr>
    </thead>
    <tbody id="parameters_container">
      <tr class="template parameter_container required_parameter_container" parameter_id="" parameter_name="" parameter_type_id="">
        <td class="col-ordering"><i class="hasTooltip icon-drag" title="" data-original-title=""></i></td>
        <td class="col_parameter_key">
          <span class="parameter_name"></span>
          <span class="star required_sign">*</span>
        </td>
        <td class="col_parameter_type">
          <span class="parameter_type"></span>
        </td>
        <td class="col_parameter_value parameter_values_container">
          <div class="template parameter_value_container single_parameter_value_container">
            <i class="hasTooltip icon-drag" title="" data-original-title=""></i>
            <input type="text"
                   name=""
                   class="required_field parameter_value" />
            <input type="hidden"
                   name=""
                   class="parameter_value_id" />
            <select class="price_sign">
              <option value="+">+</option>
              <option value="-">-</option>
            </select>
            <input type="text" name="" class="parameter_price" />	   
            <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', 'btn_remove_parameter_value', 'onclick="onBtnRemoveParameterValueClick(event, this);"'); ?>
          </div>
        </td>
        <td>
          <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_ADD, '', 'btn_add_parameter_value', 'onclick="onBtnAddParameterValueClick(event, this);"'); ?>
          <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', 'btn_remove_parameter', 'onclick="onBtnRemoveParameterClick(event, this);"'); ?>
        </td>
      </tr>
    </tbody>
    <tbody>
      <tr>
        <td colspan="6">
        <span>
            <?php echo '* - ' . __('Required parameters', 'wde'); ?>
        </span>
        <span id="parameter_buttons_container">
            <?php echo WDFHTML::jfbutton(__('Add parameter', 'wde'), '', 'thickbox', 'onclick="onBtnAddParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
            <?php echo WDFHTML::jfbutton(__('Add category parameters', 'wde'), '', '', 'onclick="onBtnInheritCategoryParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
            <?php echo WDFHTML::jfbutton(__('Remove all', 'wde'), '', '', 'onclick="onBtnRemoveAllParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
            <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_parameters', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        </span>
        </td>
      </tr>
      <tr>
        <input type="hidden" name="parameters"/>
      </tr>
    </tbody>
  </table>
</fieldset>
