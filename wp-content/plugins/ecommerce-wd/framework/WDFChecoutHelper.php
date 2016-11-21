<?php

defined('ABSPATH') || die('Access Denied');

class WDFChecoutHelper {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////	
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  public static function check_can_checkout() {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();

    // check if checkout is enabled
    if ($options->checkout_enable_checkout == 0) {
      wp_redirect(get_permalink($options->option_all_products_page));
      exit;
    }

    // if not registered users can't checkout and user is not logged in goto login page
    if (($options->checkout_allow_guest_checkout == 0) && (!is_user_logged_in())) {
      $model_options->enqueue_message(__('Please login', 'wde'), 'warning');
      wp_redirect(get_permalink($options->option_usermanagement_page));
      exit;
    }
  }

  public static function check_checkout_data() {
    $model = WDFHelper::get_model('checkout');
    $checkout_data = $model->get_checkout_data();
    if (($checkout_data == null) || (empty($checkout_data['products_data']) == true)) {
      WDFHelper::show_error(1);
    }
  }

  public static function send_checkout_finished_mail($row_order, $type = '') {
    $is_mail_to_user_sent = FALSE;
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();

    // get user name
    $name_parts = array();
    if ($row_order->shipping_data_first_name != '') {
      $name_parts[] = $row_order->billing_data_first_name;
    }
    if ($row_order->shipping_data_middle_name != '') {
      $name_parts[] = $row_order->billing_data_middle_name;
    }
    if ($row_order->shipping_data_last_name != '') {
      $name_parts[] = $row_order->billing_data_last_name;
    }
    $name = implode(' ', $name_parts);

    $j_user = get_user_by('id', $row_order->j_user_id);
    // Get user email.
    $user_email = $row_order->billing_data_email;
    if (is_email($user_email) == false) {
      $user_email = isset($j_user->user_email) ? $j_user->user_email : '';
      if (is_email($user_email) == false) {
        $model_options->enqueue_message(__('Failed to send out the mail with checkout details.', 'wde'), 'danger');
        return false;
      }
    }

    $admin_email = is_email($options->admin_email) == TRUE ? $options->admin_email : '';

    $recipient_array = array(
      'admin_email' => $admin_email,
      'user_email' => $user_email
    );
    $order_products = self::order_products_template($row_order);
    $checkout_date = date($options->option_date_format, strtotime($row_order->checkout_date));

    $from_mail = is_email($options->from_mail) == TRUE ? $options->from_mail : '';
    $from_name = $options->from_name;
    $sitename = get_bloginfo();
    $siteurl = site_url();

    if (is_user_logged_in()) {
      $order_details_url = WDFPath::add_pretty_query_args(get_permalink($options->option_orders_page), $options->option_endpoint_orders_displayorder, $row_order->id, TRUE);
      $order_details = '<a href="' . $order_details_url . '" target="_blank">' . __('Order details', 'wde') . '</a>';
    }
    else {
      $order_details = '';
    }

    $body_shipping_data = '<div style="display: table-cell; padding: 0 40px 0 0;"><strong>' . __('Shipping data', 'wde') . '</strong><br />' .
    ($row_order->shipping_data_first_name ? __('First name', 'wde') . ': ' . $row_order->shipping_data_first_name . '<br />' : '') .
    ($row_order->shipping_data_last_name ? __('Last name', 'wde').': '.$row_order->shipping_data_last_name . '<br />' : '') .
    ($row_order->shipping_data_company ? __('Company', 'wde').': '.$row_order->shipping_data_company . '<br />' : '') .
    ($row_order->shipping_data_address ? __('Address', 'wde').': '.$row_order->shipping_data_address . '<br />' : '') .
    ($row_order->shipping_data_city ? __('City', 'wde').': '.$row_order->shipping_data_city . '<br />' : '') .
    ($row_order->shipping_data_state ? __('State', 'wde').': '.$row_order->shipping_data_state . '<br />' : '') .
    ($row_order->shipping_data_zip_code ? __('Zip code', 'wde').': '.$row_order->shipping_data_zip_code . '<br />' : '') .
    ($row_order->shipping_data_country ? __('Country', 'wde').': '.$row_order->shipping_data_country . '<br />' : '') . '</div>';

    $body_billing_data = '<div style="display: table-cell; padding: 0 40px 0 0;"><strong>'.__('Billing data', 'wde').'</strong><br />'.
    ($row_order->billing_data_first_name ? __('First name', 'wde').': '.$row_order->billing_data_first_name . '<br />' : '') .
    ($row_order->billing_data_last_name ? __('Last name', 'wde').': '.$row_order->billing_data_last_name . '<br />' : '') .
    ($row_order->billing_data_company ? __('Company', 'wde').': '.$row_order->billing_data_company . '<br />' : '') .
    ($row_order->billing_data_address ? __('Address', 'wde').': '.$row_order->billing_data_address . '<br />' : '') .
    ($row_order->billing_data_city ? __('City', 'wde').': '.$row_order->billing_data_city . '<br />' : '') .
    ($row_order->billing_data_state ? __('State', 'wde').': '.$row_order->billing_data_state . '<br />' : '') .
    ($row_order->billing_data_zip_code ? __('Zip code', 'wde').': '.$row_order->billing_data_zip_code . '<br />' : '') .
    ($row_order->billing_data_country ? __('Country', 'wde').': '.$row_order->billing_data_country . '<br />' : '') .
    ($row_order->billing_data_phone ? __('Phone', 'wde').': '.$row_order->billing_data_phone . '<br />' : '') .
    ($row_order->billing_data_fax ? __('Fax', 'wde').': '.$row_order->billing_data_fax . '<br />' : '') .
    ($row_order->billing_data_email ? __('Email', 'wde').': '.$row_order->billing_data_email . '<br />' : '') . '</div>';

    $form_fields = WDFDb::get_user_meta_fields_list($row_order->j_user_id, false, true);
    $customer_name = '';
    if ($form_fields['billing_fields_list'][0]['value']) {
      $customer_name .= $form_fields['billing_fields_list'][0]['value'];
    }
    if ($form_fields['billing_fields_list'][1]['value']) {
      $customer_name .= ' ' . $form_fields['billing_fields_list'][1]['value'];
    }
    if ($form_fields['billing_fields_list'][2]['value']) {
      $customer_name .= ' ' . $form_fields['billing_fields_list'][2]['value'];
    }
    $customer_name = $customer_name ? $customer_name : $name;
    $customer_email = isset($j_user->user_email) ? $j_user->user_email : $row_order->billing_data_email;
    $customer_phone = $form_fields['billing_fields_list'][10]['value'] ? $form_fields['billing_fields_list'][10]['value'] : $row_order->billing_data_phone;

    $customer_details = '';
    if ($customer_name || $customer_email || $customer_phone) {
      $customer_details = '<ul>' .
       ($customer_name ? '<li><strong>' . __('Name', 'wde') . ': </strong>' . $customer_name . '</li>' : '') .
       ($customer_email ? '<li><strong>' . __('Email', 'wde') . ': </strong><a target="_blank" href="mailto:' . $customer_email . '">' . $customer_email . '</a></li>' : '') .
       ($customer_phone ? '<li><strong>' . __('Tel', 'wde') . ': </strong>' . $customer_phone . '</li>' : '') .
       '</ul>';
    }

    $search = array(
      '{customer_name}',
      '{site_name}',
      '{site_url}',
      '{checkout_date}',
      '{billing_data}',
      '{shipping_data}',
      '{order_id}',
      '{order_details}',
      '{product_details}',
      '{total_price_text}',
      '{customer_details}',
    );
    $replace = array(
      $name,
      $sitename,
      $siteurl,
      $checkout_date,
      $body_billing_data,
      $body_shipping_data,
      $row_order->id,
      $order_details,
      $order_products['products_details'],
      $order_products['total'],
      $customer_details,
    );

    $admin_email_subject = $options->admin_email_subject;
    $admin_email_mode = $options->admin_email_mode;
    $admin_email_body = $options->admin_email_body;
    $user_email_subject = $options->user_email_subject;
    $user_email_mode = $options->user_email_mode;
    $user_email_body = $options->user_email_body;
    $user_email_body = str_replace($search, $replace, $user_email_body);

    if ($type == 'notify') {
      switch ($row_order->payment_data_status) {
        case 'Failed': {
          if (!$options->failed_enable) {
            $recipient_array['admin_email'] = '';
          }
          if (!$options->failed_user_enable) {
            $recipient_array['user_email'] = '';
          }
          $subject = $options->failed_subject;
          $mode = $options->failed_mode;
          $body = $options->failed_body;
          break;
        }
        case 'Refunded': {
          if (!$options->refunded_enable) {
            $recipient_array['admin_email'] = '';
          }
          if (!$options->refunded_user_enable) {
            $recipient_array['user_email'] = '';
          }
          $subject = $options->refunded_subject;
          $mode = $options->refunded_mode;
          $body = $options->refunded_body;
          break;
        }
        case 'Completed': {
          if (!$options->completed_enable) {
            $recipient_array['admin_email'] = '';
          }
          if (!$options->pending_user_enable) {
            $recipient_array['user_email'] = '';
          }
          $subject = $options->completed_subject;
          $mode = $options->completed_mode;
          $body = $options->completed_body;

          if ($options->user_email_enable == 1) {
            // Send mail to customer.
            $is_mail_to_user_sent = WDFMail::send_mail($from_mail, $user_email, $user_email_subject, $user_email_body, $user_email_mode, $from_name, $options->mailer);
          }

          if ($options->admin_email_enable == 1) {
            $search[] = '{is_mail_to_user_sent}';
            $replace[] = $is_mail_to_user_sent == TRUE ? __('Yes', 'wde') : __('No', 'wde');
            $admin_email_body = str_replace($search, $replace, $admin_email_body);

            // Send mail to administrator.
            WDFMail::send_mail($from_mail, $admin_email, $admin_email_subject, $admin_email_body, $admin_email_mode, $from_name, $options->mailer);
          }
          break;
        }
        case 'Pending': {
          if (!$options->pending_enable) {
            $recipient_array['admin_email'] = '';
          }
          if (!$options->pending_user_enable) {
            $recipient_array['user_email'] = '';
          }
          $subject = $options->pending_subject;
          $mode = $options->pending_mode;
          $body = $options->pending_body;
          break;
        }
        default : {
          break;
        }
      }
      $recipient = implode(',', $recipient_array);
      $body = str_replace($search, $replace, $body);
      $sent = WDFMail::send_mail($from_mail, $recipient, $subject, $body, $mode, $from_name, $options->mailer);
    }
    elseif ($type == 'new') {
      if ($options->user_email_enable == 2) {
        // Send mail to customer.
        $is_mail_to_user_sent = WDFMail::send_mail($from_mail, $user_email, $user_email_subject, $user_email_body, $user_email_mode, $from_name, $options->mailer);
      }

      if ($options->admin_email_enable == 2) {
        $search[] = '{is_mail_to_user_sent}';
        $replace[] = $is_mail_to_user_sent == TRUE ? __('Yes', 'wde') : __('No', 'wde');
        $admin_email_body = str_replace($search, $replace, $admin_email_body);

        // Send mail to administrator.
        WDFMail::send_mail($from_mail, $admin_email, $admin_email_subject, $admin_email_body, $admin_email_mode, $from_name, $options->mailer);
      }

      if ($is_mail_to_user_sent == TRUE) {
        $model_options->enqueue_message(__('Please, check your email for checkout details.', 'wde'), 'info');
      }
      elseif ($options->user_email_enable == 2) {
        $model_options->enqueue_message(__('Failed to send out the mail with checkout details.', 'wde'), 'warning');
      }
    }
  }

  public static function get_country_name($country_id) {
    $row_country = WDFDb::get_row('countries', 'id = ' . $country_id);
    return $row_country->name;
  }

  public static function order_products_template($order) {
    $row = WDFHelper::get_order($order->id);
    $products = $row->product_rows;
    if (!$products) {
      return array('products_details' => '', 'total' => '');
    }
    ob_start();
    ?>
    <table style="width: 100%; border-collapse: collapse;">
      <thead style="font-weight: bold;">
        <tr>
          <th style="text-align: center; width: 10px; padding: 5px 4px; border: 1px solid #CCCCCC;">#</th>
          <th style="text-align: left; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php _e('Name', 'wde'); ?></th>
          <th style="text-align: center; width: 55px; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php _e('Price', 'wde'); ?></th>
          <th style="text-align: center; width: 55px; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php _e('Discount', 'wde'); ?></th>
          <th style="text-align: center; width: 55px; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php _e('Tax', 'wde'); ?></th>
          <th style="text-align: center; width: 60px; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php _e('Quantity', 'wde'); ?></th>
          <?php
          if ($order->shipping_type == 'per_item') {
            ?>
          <th style="text-align: right; width: 55px; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php _e('Shipping', 'wde'); ?></th>
            <?php
          }
          ?>
          <th style="text-align: center; width: 80px; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php _e('Total', 'wde'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($products as $i => $product) {
          ?>
        <tr>
          <td style="text-align: right; width: 10px; padding: 4px; border: 1px solid #CCCCCC;"><?php echo $i + 1; ?></td>
          <td style="text-align: left; padding: 4px; border: 1px solid #CCCCCC;">
            <?php echo $product->product_name; ?>
            <?php
            if ($product->product_parameters) {
              ?>
            <small><p style="margin: 0;"><?php echo __('Parameters', 'wde') . ': ' . str_replace('%br%', '<br />', $product->product_parameters); ?></p></small>
              <?php
            }
            ?>
          </td>
          <td style="text-align: right; width: 55px; padding: 4px; border: 1px solid #CCCCCC;"><?php echo $product->price_text; ?></td>
          <td style="text-align: right; width: 55px; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php echo $product->discount_rate; ?></td>
          <td style="text-align: right; width: 55px; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php echo $product->tax_price_text; ?></td>
          <td style="text-align: center; width: 60px; padding: 4px; border: 1px solid #CCCCCC;"><?php echo $product->product_count; ?></td>
          <?php
          if ($order->shipping_type == 'per_item') {
            ?>
          <td style="text-align: right; width: 55px; padding: 5px 4px; border: 1px solid #CCCCCC;"><?php echo $product->shipping_method_price_text; ?></td>
            <?php
          }
          ?>
          <td style="text-align: right; width: 80px; padding: 4px; border: 1px solid #CCCCCC;"><?php echo $product->subtotal_text; ?></td>
        </tr>
          <?php
        }
        ?>
      </tbody>
      <tfoot style="font-weight: bold;">
        <tr>
          <td colspan="<?php echo $order->shipping_type == 'per_item' ? 7 : 6; ?>" style="text-align: right; border: 1px solid #CCCCCC;">
            <?php if ($row->tax_price_text) { ?>
            <div style="padding: 5px 4px;"><?php _e('Total tax', 'wde'); ?>:</div>
            <?php } if ($row->total_shipping_price_text) { ?>
            <div style="padding: 5px 4px;"><?php _e('Total shipping', 'wde'); ?>:</div>
            <?php } ?>
            <div style="padding: 5px 4px;"><?php _e('Order total', 'wde'); ?>:</div>
          </td>
          <td colspan="2" style="text-align: right; border: 1px solid #CCCCCC;">
            <?php if ($row->tax_price_text) { ?>
            <div style="padding: 5px 4px;"><?php echo $row->tax_price_text; ?></div>
            <?php } if ($row->total_shipping_price_text) { ?>
            <div style="padding: 5px 4px;"><?php echo $row->total_shipping_price_text; ?></div>
            <?php } ?>
            <div style="padding: 5px 4px;"><?php echo $row->total_price_text; ?></div>
          </td>
        </tr>
      </tfoot>
    </table>
    <?php
    return array('products_details' => str_replace(array("\r\n", "\n", "\r"), '', ob_get_clean()), 'total' => $totals->total_price_text);
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}
