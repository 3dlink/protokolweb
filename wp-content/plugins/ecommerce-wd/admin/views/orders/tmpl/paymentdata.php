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
wp_print_styles('wde_layout_edit');
wp_print_styles('wde_' . $controller . '_' . $this->_layout);
// js
wp_print_scripts('wde_view');
wp_print_scripts('wde_layout_edit');

$lists = $this->lists;
$list_order_statuses = $lists['order_statuses'];

$row = $this->row;

$payment_data = $row->view_payment_data;
?>
<form name="adminForm" id="adminForm" action="" method="post">
    <h1><?php _e('Payment data', 'wde'); ?></h1>
    <table class="adminlist table">
      <thead>
        <tr>
          <td><label><?php _e('Payment method', 'wde'); ?> - <?php echo $row->payment_method; ?></label></td>
          <td></td>
        </tr>	
      </thead>
    </table>
    <?php
    if ($payment_data) {
      foreach ($payment_data as $key => $value) {
        if (is_array($value)) {
          ?>
    <table class="adminlist table">
      <?php
      foreach ($value as $k => $v) {
        ?>
      <tr>
        <td class="col_key">
          <label><?php echo $k; ?>:</label>
        </td>
        <td class="col_value">
          <?php
          if (gettype($v) == "boolean") {
            echo $v ? __('true', 'wde') : __('false', 'wde');
          }
          else {
            echo $v;
          }
          ?>
        </td>
        <?php					
      }
      ?>
      </tr>
    </table>
          <?php
        }
        elseif (gettype($value) == "boolean") {
          echo $value ? 'true' : 'false';
        }
        else {
          echo $value;
        }
      }
    }
    ?>
  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
  <input type="hidden" name="task" value=""/>
  <input type="hidden" name="id" value="<?php echo $row->id;?>"/>
</form>

<?php
die();