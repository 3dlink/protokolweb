<?php

defined('ABSPATH') || die('Access Denied');

$options = $this->options;
$initial_values = $options['initial_values'];
?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="col_key">
        <label for="admin_email"><?php _e('Administrator email', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="admin_email" id="admin_email" value="<?php echo $initial_values['admin_email']; ?>" />
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="from_mail"><?php _e('Email From', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="from_mail" id="from_mail" value="<?php echo $initial_values['from_mail']; ?>" />
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="from_name"><?php _e('From name', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="from_name" id="from_name" value="<?php echo $initial_values['from_name']; ?>" />
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Mailer', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('mailer', $initial_values['mailer'], 'wp_mail()', 'PHP mail()'); ?>
      </td>
    </tr>
  </tbody>
</table>
<?php
WDFHTMLTabs::startTabs('subtab_group_options', WDFInput::get('subtab_index'), 'onsubTabActivated', FALSE);
WDFHTMLTabs::startTab('wde_admin_email', __('Email to Administrator', 'wde'));
WDFHTMLTabs::startTab('wde_user_email', __('Email to Customer', 'wde'));
WDFHTMLTabs::startTab('wde_customer_note', __('Customer note', 'wde'));
// WDFHTMLTabs::startTab('wde_canceled', __('Canceled', 'wde'));
WDFHTMLTabs::startTab('wde_failed', __('Failed', 'wde'));
WDFHTMLTabs::startTab('wde_pending', __('Pending', 'wde'));
WDFHTMLTabs::startTab('wde_completed', __('Completed', 'wde'));
WDFHTMLTabs::startTab('wde_refunded', __('Refunded', 'wde'));
WDFHTMLTabs::startTab('wde_invoice', __('Customer invoice', 'wde'));

if (is_array($custom_subtabs) && isset($custom_subtabs['options_email']) && is_array($custom_subtabs['options_email'])) {
  foreach ($custom_subtabs['options_email'] as $custom_subtab) {
    if (!version_compare($custom_subtab['version_required'], substr_replace(WD_E_VERSION, '2', 0, 1), '>')) {
      WDFHTMLTabs::startTab($custom_subtab['id'], $custom_subtab['title']);
    }
  }
}

WDFHTMLTabs::endTabs();

WDFHTMLTabs::startTabsContent('subtab_group_options');

WDFHTMLTabs::startTabContent('wde_admin_email');
echo wde_admin_email($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_user_email');
echo wde_customer_email($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_customer_note');
echo wde_customer_status_change_email($initial_values);
WDFHTMLTabs::endTabContent();

// WDFHTMLTabs::startTabContent('wde_canceled');
// echo wde_canceled($initial_values);
// WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_failed');
echo wde_failed($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_pending');
echo wde_pending($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_completed');
echo wde_completed($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_refunded');
echo wde_refunded($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_invoice');
echo wde_invoice($initial_values);
WDFHTMLTabs::endTabContent();

if (is_array($custom_subtabs) && isset($custom_subtabs['options_email']) && is_array($custom_subtabs['options_email'])) {
  foreach ($custom_subtabs['options_email'] as $custom_subtab) {
    if (!version_compare($custom_subtab['version_required'], substr_replace(WD_E_VERSION, '2', 0, 1), '>')) {
      WDFHTMLTabs::startTabContent($custom_subtab['id']);
      if (file_exists($custom_subtab['content'])) {
        require $custom_subtab['content'];
      }
      WDFHTMLTabs::endTabContent();
    }
  }
}

WDFHTMLTabs::endTabsContent();

WDFHTMLTabs::scripts('subtab_group_options', FALSE, 'onsubTabActivated');
?>
<!-- ctrls -->
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="btns_container">
        <?php
        echo WDFHTML::jfbutton(__('Reset', 'wde'), '', '', 'onclick="onBtnResetClick(event, this, \'email\');"');
        echo WDFHTML::jfbutton(__('Load default values', 'wde'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'email\');"');
        ?>
      </td>
    </tr>
  </tbody>
</table>
<?php

function wde_admin_email($initial_values) {
  $additional_datas = array(
    'customer_name' => __('Customer name', 'wde'),
    'site_name' => __('Site name', 'wde'),
    'site_url' => __('Site url', 'wde'),
    'checkout_date' => __('Checkout date', 'wde'),
    'order_id' => __('Order id', 'wde'),
    'product_details' => __('Product details', 'wde'),
    'billing_data' => __('Billing data', 'wde'),
    'shipping_data' => __('Shipping data', 'wde'),
    'total_price_text' => __('Total price', 'wde'),
    'is_mail_to_user_sent' => __('Is email sent to user', 'wde'),
    'customer_details' => __('Customer details', 'wde'),
  );
  echo wde_email_options_template($initial_values, 'admin_email', $additional_datas, array('user_email'));
}

function wde_customer_email($initial_values) {
  $additional_datas = array(
    'customer_name' => __('Customer name', 'wde'),
    'site_name' => __('Site name', 'wde'),
    'site_url' => __('Site url', 'wde'),
    'checkout_date' => __('Checkout date', 'wde'),
    'billing_data' => __('Billing data', 'wde'),
    'shipping_data' => __('Shipping data', 'wde'),
    'order_id' => __('Order id', 'wde'),
    'order_details' => __('Order details', 'wde'),
    'product_details' => __('Product details', 'wde'),
    'total_price_text' => __('Total price', 'wde'),
  );
  echo wde_email_options_template($initial_values, 'user_email', $additional_datas, array('user_email'));
}

function wde_customer_status_change_email($initial_values) {
  _e('Customer note email is sent when you change the status of the order.', 'wde');
  $additional_datas = array(
    'customer_name' => __('Customer name', 'wde'),
    'site_name' => __('Site name', 'wde'),
    'site_url' => __('Site url', 'wde'),
    'checkout_date' => __('Checkout date', 'wde'),
    'old_status_name' => __('Old status', 'wde'),
    'new_status_name' => __('New status', 'wde'),
    'order_id' => __('Order id', 'wde'),
    'product_details' => __('Product details', 'wde'),
    'total_price_text' => __('Total price', 'wde'),
  );
  echo wde_email_options_template($initial_values, 'user_email_status', $additional_datas, array('user_email'));
}

function wde_failed($initial_values) {
  _e('Email is sent to customer when orders have been marked failed.', 'wde');
  $additional_datas = array(
    'customer_name' => __('Customer name', 'wde'),
    'order_id' => __('Order id', 'wde'),
  );
  echo wde_email_options_template($initial_values, 'failed', $additional_datas);
}

function wde_refunded($initial_values) {
  _e('Email is sent to customer when orders have been marked refunded.', 'wde');
  $additional_datas = array(
    'customer_name' => __('Customer name', 'wde'),
    'order_id' => __('Order id', 'wde'),
  );
  echo wde_email_options_template($initial_values, 'refunded', $additional_datas);
}

function wde_completed($initial_values) {
  _e('Email is sent to customer when orders have been marked completed.', 'wde');
  $additional_datas = array(
    'customer_name' => __('Customer name', 'wde'),
    'order_id' => __('Order id', 'wde'),
  );
  echo wde_email_options_template($initial_values, 'completed', $additional_datas);
}

function wde_pending($initial_values) {
  _e('Email is sent to customer when orders have been marked pending.', 'wde');
  $additional_datas = array(
    'customer_name' => __('Customer name', 'wde'),
    'order_id' => __('Order id', 'wde'),
  );
  echo wde_email_options_template($initial_values, 'pending', $additional_datas);
}

function wde_canceled($initial_values) {
  _e('Email is sent to customer when orders have been marked canceled.', 'wde');
  $additional_datas = array(
    'customer_name' => __('Customer name', 'wde'),
    'order_id' => __('Order id', 'wde'),
  );
  echo wde_email_options_template($initial_values, 'canceled', $additional_datas);
}

function wde_invoice($initial_values) {
  _e('Customer invoice email manually sent to customers containing their order information and seller information.', 'wde');
  $additional_datas = array(
    'customer_name' => __('Customer name', 'wde'),
    'site_name' => __('Site name', 'wde'),
    'site_url' => __('Site url', 'wde'),
    'checkout_date' => __('Checkout date', 'wde'),
    'billing_data' => __('Billing data', 'wde'),
    'shipping_data' => __('Shipping data', 'wde'),
    'order_id' => __('Order id', 'wde'),
    'order_details' => __('Order details', 'wde'),
    'product_details' => __('Product details', 'wde'),
    'total_price_text' => __('Total price', 'wde'),
  );
  echo wde_email_options_template($initial_values, 'invoice', $additional_datas, array('admin_email', 'user_email'));
}

function wde_email_options_template($initial_values, $prefix = 'admin', $additional_datas = array(), $exclude = array()) {
  ?>
  <table class="adminlist table">
    <tbody>
    <?php
      if ($prefix == 'admin_email' || $prefix == 'user_email') {
        ?>
      <tr>
        <td class="col_key">
          <label><?php _e('Send Email when', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <?php
          $options = array(
            (object) array('value' => 2, 'text' => __('Order is submitted', 'wde')),
            (object) array('value' => 1, 'text' => __('Payment status is completed', 'wde')),
            (object) array('value' => 3, 'text' => __('Order is confirmed', 'wde')),
            (object) array('value' => 0, 'text' => __("Don't send", 'wde')),
          );
          echo WDFHTML::wd_radio_list($prefix . '_enable', $options, 'value', 'text', $initial_values[$prefix . '_enable'], '', 'wde_block_radios');
          ?>
        </td>
      </tr>
        <?php
      }
      elseif (!in_array('admin_email', $exclude)) {
        ?>
      <tr>
        <td class="col_key">
          <label><?php echo !in_array('user_email', $exclude) ? __('Send Email to Administrator', 'wde') : __('Send Email', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <?php echo WDFHTML::wd_radio($prefix . '_enable', $initial_values[$prefix . '_enable'], __('Yes', 'wde'), __('No', 'wde')); ?>
        </td>
      </tr>
        <?php
      }
      if (!in_array('user_email', $exclude)) {
        ?>
      <tr>
        <td class="col_key">
          <label><?php _e('Send Email to Customer', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <?php echo WDFHTML::wd_radio($prefix . '_user_enable', $initial_values[$prefix . '_user_enable'], __('Yes', 'wde'), __('No', 'wde')); ?>
        </td>
      </tr>
        <?php
      }
      if (!in_array('subject', $exclude)) {
        ?>
      <tr>
        <td class="col_key">
          <label for="<?php echo $prefix; ?>_subject"><?php _e('Subject', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <input class="wde_email_subject" type="text" name="<?php echo $prefix; ?>_subject" id="<?php echo $prefix; ?>_subject" value="<?php echo $initial_values[$prefix . '_subject']; ?>" />
        </td>
      </tr>
        <?php
      }
      if (!in_array('mode', $exclude)) {
        ?>
      <tr>
        <td class="col_key">
          <label><?php _e('Mode', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <?php echo WDFHTML::wd_radio($prefix . '_mode', $initial_values[$prefix . '_mode'], __('HTML', 'wde'), __('Text', 'wde')); ?>
        </td>
      </tr>
        <?php
      }
      if (!in_array('body', $exclude)) {
        ?>
      <tr>
        <td class="col_key">
          <label><?php _e('Text in Email', 'wde'); ?>:</label>
        </td>
        <td class="col_value wde_editor">
          <div class="wde_additional_data_cont">
            <?php
            foreach ($additional_datas as $key => $additional_data) {
              ?>
            <input title="<?php $key == 'order_details' ? _e('Only for registered users', 'wde') : _e('Click to insert to text in Email', 'wde'); ?>"
                   class="wde_additional_data_btn"
                   type="button"
                   value="<?php echo $additional_data; ?>"
                   onClick="wde_insert_additional_data('<?php echo $prefix; ?>_body', '<?php echo $key; ?>')" />
              <?php
            }
            ?>
          </div>
          <?php
          if (user_can_richedit()) {
            wp_editor($initial_values[$prefix . '_body'], $prefix . '_body', array('teeny' => FALSE, 'textarea_name' => $prefix . '_body', 'media_buttons' => TRUE, 'editor_height' => 500));
          }
          else {
            ?>
            <textarea name="<?php echo $prefix; ?>_body" id="<?php echo $prefix; ?>_body" rows="10"><?php echo $initial_values[$prefix . '_body']; ?></textarea>
            <?php
          }
          ?>
        </td>
      </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
  <?php
}