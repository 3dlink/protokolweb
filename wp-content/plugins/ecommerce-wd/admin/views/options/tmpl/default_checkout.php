<?php

defined('ABSPATH') || die('Access Denied');

$options = $this->options;
$initial_values = $options['initial_values'];
$payment_systems = $this->payment_systems;
?>

<table class="adminlist table">
  <tbody>
    <tr>
      <td class="col_key">
        <label for="checkout_enable_checkout"><?php _e('Enable checkout', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('checkout_enable_checkout', $initial_values['checkout_enable_checkout'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="checkout_allow_guest_checkout"><?php _e('Allow guest checkout', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('checkout_allow_guest_checkout', $initial_values['checkout_allow_guest_checkout'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="checkout_redirect_to_cart_after_adding_an_item"><?php _e('Redirect to cart after adding an item', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('checkout_redirect_to_cart_after_adding_an_item', $initial_values['checkout_redirect_to_cart_after_adding_an_item'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <a class="jfbutton jfbutton_color_blue jfbutton_size_medium"
           target="_blank"
           href="<?php echo esc_url(admin_url('admin.php?page=wde_payments')); ?>"
           title="<?php _e('To add a new payment or edit the existing one, please click on the button.', 'wde'); ?>"><?php _e('Payments systems', 'wde'); ?></a>
      </td>
      <td class="col_value"></td>
    </tr>
    <tr>
      <td colspan="2">
        <form name="adminForm" id="adminForm" action="" method="post">
          <?php
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('wde_jquery-ordering');
            $class_name = 'icon-drag';
          ?>
          <table class="adminlist table table-striped wp-list-table widefat fixed pages wde_payments">
            <thead>
              <th class="col_num"></th>
              <th class="col_name"><?php _e('Name', 'wde'); ?></th>
              <th class="col_image"></th>
              <th class="col_published"><?php _e('Published', 'wde'); ?></th>
            </thead>
            <tbody>
              <?php
              if ($payment_systems) {
                for ($i = 0; $i < count($payment_systems); $i++) {
                  $row = $payment_systems[$i];
                  ?>
                  <tr id="tr_<?php echo $row->id; ?>" class="row<?php echo $i % 2; ?>" <?php echo ($row->short_name == 'paypalexpress') ? 'onclick="alert(\'' . addslashes(__("You can't edit this payment system in free version.", 'wde')) . '\')"' : ''; ?>>
                    <td class="col_ordering">
                      <?php
                      if ($row->short_name == 'paypalexpress') {
                        ?><span class="wde_pro_btn wde_pro_btn_small">Paid</span><?php
                      }
                      else {
                        echo $this->generate_order_cell_content($i, $row->ordering, $class_name); ?>
                        <input id="cb<?php echo $row->id; ?>" name="cid[]" value="<?php echo $row->id; ?>" type="hidden" class="wde_check" /><?php
                      } ?>
                    </td>
                    <td class="col_name">
                      <?php
                      if ($row->short_name == 'paypalexpress') {
                        echo $row->name;
                      }
                      else {
                        ?><a href="<?php echo $row->edit_url; ?>" title="<?php _e('Edit', 'wde'); ?>" onclick="if (!confirm('<?php addcslashes(_e('Are you sure you want to continue? Unsaved changes will be lost.', 'wde')); ?>')) return false;"><?php echo $row->name; ?></a><?php
                      } ?>
                    </td>
                    <td class="col_image">
                      <?php if ($row->short_name != 'without_online_payment') { ?>
                      <img src="<?php echo WD_E_URL . '/images/payments/' . $row->base_name . '.png' ;?>" width="75" />
                      <?php } ?>	
                    </td>
                    <td class="col_published">
                      <?php echo WDFHTML::icon_boolean_inactive($row->id, $row->published, 'publish', 'unpublish', TRUE); ?>
                    </td>
                  </tr>
                  <?php
                }
              }
              ?>
            </tbody>
          </table>
        </form>
      </td>
    </tr>
  </tbody>
</table>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="btns_container">
        <?php
        echo WDFHTML::jfbutton(__('Reset', 'wde'), '', '', 'onclick="onBtnResetClick(event, this, \'checkout\');"');
        echo WDFHTML::jfbutton(__('Load default values', 'wde'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'checkout\');"');
        ?>
      </td>
    </tr>
  </tbody>
</table>