<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerOrders extends EcommercewdController {
  public function remove() {
    $this->remove_order_products(WDFInput::get_checked_ids());
    parent::remove();
  }

  public function view() {
    WDFDb::set_checked_row_data('', '`read`', 1);
    parent::view();
  }

  public function set_as_read() {
    WDFDb::set_checked_rows_data('', '`read`', 1);
    WDFHelper::redirect('', '', '', '', 8);
  }

  public function set_as_unread() {
    WDFDb::set_checked_rows_data('', '`read`', 0);
    WDFHelper::redirect('', '', '', '', 9);
  }

  public function edit($task = NULL, $attrs = NULL) {
    WDFDb::set_checked_row_data('', '`read`', 1);
    parent::display();
  }

  public function send_invoice() {
    $checked_id = WDFInput::get_checked_id();
    $row_order = WDFDb::get_row_by_id('orders', $checked_id);
    $message_id = $this->send_invoice_mail($row_order);
    $redirect_task = WDFInput::get('redirect_task', '');
    switch ($redirect_task) {
      case 'view':
      case 'edit':
        $cids = $row_order->id;
        break;
      default:
        $cids = '';
        break;
    }
    WDFHelper::redirect('', $redirect_task, $cids, '', $message_id);
  }

  public static function send_invoice_mail($row_order) {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options_row();

    $order_products = WDFChecoutHelper::order_products_template($row_order);
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

    // Get user email.
    $user_email = $row_order->billing_data_email;
    if (is_email($user_email) == false) {
      $j_user = get_user_by('id', $row_order->j_user_id);
      $user_email = isset($j_user->user_email) ? $j_user->user_email : '';
      if (is_email($user_email) == false) {
        return 17;
      }
    }

    // Get order details.
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
    );

    $subject = $options->invoice_subject;
    $mode = $options->invoice_mode;
    $body = $options->invoice_body;
    $body = str_replace($search, $replace, $body);

    // Send mail to customer.
    $sent = WDFMail::send_mail($from_mail, $user_email, $subject, $body, $mode, $from_name, $options->mailer);
    return ($sent ? 16 : 17);
  }

  public function update_order_status() {
    $checked_id = WDFInput::get_checked_id();
    $row_order = WDFDb::get_row_by_id('orders', $checked_id);

    // get status data
    $row_status = WDFDb::get_row_by_id('orderstatuses', WDFInput::get('order_status_' . $row_order->id));

    if (($row_order->id != null) && ($row_status->id != null)) {
      $old_status_id = $row_order->status_id;
      $old_status_name = $row_order->status_name;
      $new_status_id = $row_status->id;
      $new_status_name = $row_status->name;
      if ($old_status_id != $new_status_id) {
        global $wpdb;
        $update = $wpdb->update($wpdb->prefix . 'ecommercewd_orders', array(
          'status_id' => $new_status_id,
          'status_name' => $new_status_name,
          'date_modified' => current_time('Y-m-d H:i:s')
        ), array('id' => $row_order->id));
        if ($update !== FALSE) {
          $sent = $this->send_status_changed_mail($row_order, $old_status_name, $new_status_name, $new_status_id);
          if ($sent) {
            $message_id = 18;
          }
          else {
            $message_id = 19;
          }
        }
        else {
          $message_id = 20;
        }
      }
      else {
        $message_id = 21;
      }
    }
    else {
      $message_id = 20;
    }

    $redirect_task = WDFInput::get('redirect_task', '');
    switch ($redirect_task) {
      case 'view':
        $cids = $row_order->id;
        break;
      default:
        $cids = '';
        break;
    }

    WDFHelper::redirect('', $redirect_task, $cids, '', $message_id);
  }

  public function pdfinvoicebulk() {
    $model = WDFHelper::get_model('orders');		
    $ids = WDFInput::get_checked_ids();		
    $id =  reset($ids);	
    $pdfinvoice_model = WDFHelper::get_model('pdfinvoice');
    $options = $pdfinvoice_model->get_invoice_options();
    $row = $model->get_row($id);

    EcommercewdOrder::get_pdf_invoice($row,$options);
  }

  public function pdfinvoice() {
    $model = WDFHelper::get_model('orders');		
    $id = (WDFInput::get('boxchecked')) ? WDFInput::get('boxchecked') : WDFInput::get('id');
    $pdfinvoice_model = WDFHelper::get_model('pdfinvoice');
    $options = $pdfinvoice_model->get_invoice_options();
    $row = $model->get_row($id);

    EcommercewdOrder::get_pdf_invoice($row,$options);
  }

  private function remove_order_products($ids) {
    if (empty($ids) == true) {
        return false;
    }

    global $wpdb;
    $query = 'DELETE FROM ' . $wpdb->prefix . 'ecommercewd_orderproducts WHERE order_id IN (' . implode(',', $ids) . ')';
    $wpdb->query($query);
  }

  protected function store_input_in_row() {
    // fill additional input data
    // status name
    $row_status = WDFDb::get_row_by_id('orderstatuses', WDFInput::get('status_id'));
    WDFInput::set('status_name', $row_status->name != null ? $row_status->name : '');

    // date modified
    WDFInput::set('date_modified', current_time('Y-m-d H:i:s'));

    $row = WDFDb::get_row_by_id('orders', WDFInput::get('id'));
    $row_new_order_status = WDFDb::get_row_by_id('orderstatuses', WDFInput::get('status_id'));

    $old_status_id = $row->status_id;
    $old_status_name = $row->status_name;
    $new_status_id = $row_new_order_status->id;
    $new_status_name = $row_new_order_status->name;

    $row = parent::store_input_in_row();

    if ($row != false) {
      if ($old_status_id != $new_status_id) {
        $this->send_status_changed_mail($row, $old_status_name, $new_status_name, $new_status_id);
      }
    }
    else {
      WDFHelper::redirect('', '', '', '', 22);
    }
    return $row;
  }

  private function send_status_changed_mail($row_order, $old_status_name, $new_status_name, $new_status_id) {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options_row();

    if (!$options->user_email_status_enable) {
      return;
    }

    $order_products = WDFChecoutHelper::order_products_template($row_order);

    // Data for email to customer.
    $sitename = get_bloginfo();
    $siteurl = site_url();
    $from_mail = is_email($options->from_mail) == TRUE ? $options->from_mail : '';
    $from_name = $options->from_name;
    $subject = $options->user_email_status_subject;
    $mode = $options->user_email_status_mode;
    $body = $options->user_email_status_body;

    $wp_user = get_userdata($row_order->j_user_id);
    // Get user email.
    $mailto = $row_order->billing_data_email;
    if (filter_var($mailto, FILTER_VALIDATE_EMAIL) == false) {
      $mailto = isset($wp_user->user_email) ? $wp_user->user_email : '';
      if (filter_var($mailto, FILTER_VALIDATE_EMAIL) == false) {
        return false;
      }
    }

    // Get user name.
    $name_parts = array();
    if ($row_order->billing_data_first_name != '') {
      $name_parts[] = $row_order->billing_data_first_name;
    }
    if ($row_order->billing_data_middle_name != '') {
      $name_parts[] = $row_order->billing_data_middle_name;
    }
    if ($row_order->billing_data_last_name != '') {
      $name_parts[] = $row_order->billing_data_last_name;
    }
    $name = implode(' ', $name_parts);
    $checkout_date = date($options->option_date_format, strtotime($row_order->checkout_date));
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
    $customer_email = isset($wp_user->user_email) ? $wp_user->user_email : $row_order->billing_data_email;
    $customer_phone = $form_fields['billing_fields_list'][10]['value'] ? $form_fields['billing_fields_list'][10]['value'] : $row_order->billing_data_phone;

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
      '{old_status_name}',
      '{new_status_name}',
      '{order_id}',
      '{product_details}',
      '{total_price_text}',
      '{billing_data}',
      '{shipping_data}',
      '{order_details}',
      '{customer_details}',
    );
    $replace = array(
      $name,
      $sitename,
      $siteurl,
      $checkout_date,
      $old_status_name,
      $new_status_name,
      $row_order->id,
      $order_products['products_details'],
      $order_products['total'],
      $body_billing_data,
      $body_shipping_data,
      $order_details,
      $customer_details,
    );
    $body = str_replace($search, $replace, $body);

    // Send mail to user.
    $is_mail_to_user_sent = WDFMail::send_mail($from_mail, $mailto, $subject, $body, $mode, $from_name, $options->mailer);
    if ($is_mail_to_user_sent == false) {
      // $model_options->enqueue_message(__('MSG_FAILED_TO_SEND_ORDER_STATUS_UPDATE_MAIL', 'wde'), 'warning');
    }

    $admin_email = is_email($options->admin_email) == TRUE ? $options->admin_email : '';
    $admin_email_subject = $options->admin_email_subject;
    $admin_email_mode = $options->admin_email_mode;
    $admin_email_body = $options->admin_email_body;
    $user_email = $row_order->billing_data_email;
    if (is_email($user_email) == false) {
      $j_user = get_user_by('id', $row_order->j_user_id);
      $user_email = isset($j_user->user_email) ? $j_user->user_email : '';
    }
    $user_email_subject = $options->user_email_subject;
    $user_email_mode = $options->user_email_mode;
    $user_email_body = $options->user_email_body;
    $user_email_body = str_replace($search, $replace, $user_email_body);
    // $is_mail_to_user_sent = FALSE;
    if ($new_status_id == 3) {
      if ($options->user_email_enable == 3) {
        // Send mail to customer.
        $is_mail_to_user_sent = WDFMail::send_mail($from_mail, $user_email, $user_email_subject, $user_email_body, $user_email_mode, $from_name, $options->mailer);
      }
      if ($options->admin_email_enable == 3) {
        $search[] = '{is_mail_to_user_sent}';
        $replace[] = $is_mail_to_user_sent == TRUE ? __('Yes', 'wde') : __('No', 'wde');
        $admin_email_body = str_replace($search, $replace, $admin_email_body);

        // Send mail to administrator.
        WDFMail::send_mail($from_mail, $admin_email, $admin_email_subject, $admin_email_body, $admin_email_mode, $from_name, $options->mailer);
      }
    }
    return $is_mail_to_user_sent;
  }
}