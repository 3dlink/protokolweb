<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);
// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);

$row = $this->row;
?>

<form name="adminForm" id="adminForm" action="" method="post">
  <?php echo $this->generate_message(); ?>
  <table class="adminlist table">
    <!-- name -->
    <tr>
      <td class="col_key">
        <label for="name">
            <?php _e('Name', 'wde'); ?>
            <span class="star">*</span>
        </label>
      </td>
      <td class="col_value">
        <input type="text"
               name="name"
               id="name"
               class="required_field"
               value="<?php echo $row->name; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
  </table>


  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
  <input type="hidden" name="task" value=""/>
  <input type="hidden" name="id" value="<?php echo $row->id; ?>"/>
</form>