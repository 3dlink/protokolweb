<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

$row = $this->row;
$parameter_types = $this->parameter_types;

if (!$row->id) {
  ?>
  <div class="form-field">
    <label><?php _e('Type', 'wde'); ?></label>
    <?php echo WDFHTML::wd_select('type_id', $parameter_types, 'id', 'name', $row->type_id, 'onchange="OnParameterTypesChange(event, this)"'); ?>
    <p></p>
  </div>
  <div>
    <label><?php _e('Required', 'wde'); ?></label>
    <?php echo WDFHTML::wd_radio('required', $row->required, __('Yes', 'wde'), __('No', 'wde')); ?>
    <p></p>
  </div>
<?php 
}
else {
?>
  <tr class="form-field">
    <th scope="row" valign="top"><label><?php _e('Type', 'wde'); ?></label></th>
    <td>
      <?php echo WDFHTML::wd_select('type_id', $parameter_types, 'id', 'name', $row->type_id, 'onchange="OnParameterTypesChange(event, this)"'); ?>
      <p class="description"></p>
    </td>
  </tr>
  <tr>
    <th scope="row" valign="top"><label><?php _e('Required', 'wde'); ?></label></th>
    <td>
      <?php echo WDFHTML::wd_radio('required', $row->required, __('Yes', 'wde'), __('No', 'wde')); ?>
      <p class="description"></p>
    </td>
  </tr>
  <?php
}
?>
<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>" />
<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />