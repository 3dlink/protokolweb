<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_edit');
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_edit');
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_order_' . $this->_layout);

$lists = $this->lists;
$list_order_statuses = $lists['order_statuses'];

$row = $this->row;
?>
<a target="_blank" class="button secondary-button wde_print_btn" href="<?php echo $row->print_url; ?>" title="<?php _e('Print', 'wde'); ?>"><?php _e('Print', 'wde'); ?></a>
<a class="button secondary-button thickbox wde_payment_data_btn" href="javascript:void(0)" onclick="onBtnPaymentsDataClick(event, this);" data-payment-data-url="<?php echo $row->view_payment_data_url; ?>" title="<?php _e('View payment data', 'wde'); ?>"><?php _e('View payment data', 'wde'); ?></a>
<a class="button secondary-button wde_invoice_btn" onclick="onBtnSendInvoice(event, this)" title="<?php _e('Send invoice', 'wde'); ?>"><?php _e('Send invoice', 'wde'); ?></a>
<form name="adminForm" id="adminForm" action="" method="post">
  <?php echo $this->generate_message(); ?>
  <fieldset>
    <legend>
      <?php _e('Main data', 'wde'); ?>
    </legend>
    <table class="adminlist table">
      <tbody>
        <tr>
          <td class="col_key">
            <label><?php _e('User', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php
            if ($row->user_id != 0) {
              echo WDFHTML::jfbutton_inline($row->user_name, WDFHTML::BUTTON_INLINE_TYPE_GOTO, '', '', 'href="' . $row->user_view_url . '" target="_blank"', WDFHTML::BUTTON_ICON_POS_RIGHT);
            }
            else {
              echo $row->user_name;
            }
            ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('User IP address', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->user_ip_address; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Checkout date', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->checkout_date; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Date modified', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->date_modified; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Status', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php
            echo WDFHTML::wd_select('status_id', $list_order_statuses, 'id', 'name', $row->status_id);
            echo WDFHTML::jfbutton(__('Save', 'wde'), '', '', 'onclick="onBtnUpdateOrderStatusClick(event, this, ' . $row->id . ');"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL);
            ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Payment method', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->payment_method_name; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Payment status', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->payment_data_status; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </fieldset>
  <?php require WD_E_DIR . "/admin/views/orders/tmpl/orderproducts.php"; ?>
  <div>
    <fieldset>
      <legend>
        <?php _e('Billing data', 'wde'); ?>
      </legend>
      <table class="adminlist table">
        <tbody>
        <tr>
          <td class="col_key">
            <label><?php _e('First name', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_first_name; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Middle name', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_middle_name; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Last name', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_last_name; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Company', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_company; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Email', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_email; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Country', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_country; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('State', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_state; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('City', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_city; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Address', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_address; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Zip code', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_zip_code; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Phone', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_phone; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Fax', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_fax; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Mobile', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->billing_data_mobile; ?>
          </td>
        </tr>
        </tbody>
      </table>
    </fieldset>
    <fieldset>
      <legend>
        <?php _e('Shipping data', 'wde'); ?>
      </legend>
      <table class="adminlist table">
        <tbody>
        <tr>
          <td class="col_key">
            <label><?php _e('First name', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->shipping_data_first_name; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Middle name', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->shipping_data_middle_name; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Last name', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->shipping_data_last_name; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Company', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->shipping_data_company; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Country', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->shipping_data_country; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('State', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->shipping_data_state; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('City', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->shipping_data_city; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Address', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->shipping_data_address; ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Zip code', 'wde'); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo $row->shipping_data_zip_code; ?>
          </td>
        </tr>
        </tbody>
      </table>
    </fieldset>
  </div>
  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>" />
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="redirect_task" value="" />
  <input type="hidden" name="order_status_<?php echo $row->id; ?>" value="" />
  <input type="hidden" name="boxchecked" value="<?php echo $row->id; ?>" />
  <input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
  <input type="hidden" name="redirect_task" value="view" />
</form>