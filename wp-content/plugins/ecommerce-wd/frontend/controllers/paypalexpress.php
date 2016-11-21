<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerPaypalexpress extends EcommercewdController {
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

	public function finish_checkout() {
    WDFChecoutHelper::check_can_checkout();
    WDFChecoutHelper::check_checkout_data();

		$model = WDFHelper::get_model('checkout');
    $options_model = WDFHelper::get_model('options');
    $options = $options_model->get_options();
    if ($model->is_final_checkout_data_valid(false) == false) {
      $action_display_finished_failure = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_finished_failure, '1', FALSE);
      $action_display_finished_failure = add_query_arg('session_id' , 0, $action_display_finished_failure);
      wp_redirect($action_display_finished_failure);
      exit;
    }
    $final_checkout_data = $model->get_final_checkout_data();
    if ($final_checkout_data === false) {
      $action_display_finished_failure = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_finished_failure, '1', FALSE);
      $action_display_finished_failure = add_query_arg('session_id' , 0, $action_display_finished_failure);
      wp_redirect($action_display_finished_failure);
      exit;
    }
    $this->finish_checkout_with_paypal($final_checkout_data);
  }

	/* Paypal return and cancel handler functions.*/
  public function handle_paypal_checkout_return() {
    WDFChecoutHelper::check_can_checkout();

    $j_user = wp_get_current_user();
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();

    $model = WDFHelper::get_model('checkout');
    $checkout_data = $model->store_checkout_data();
		$checkout_api_options =  $model->checkout_api_options('paypalexpress');
    if ($checkout_data === false) {
      $action_display_finished_failure = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_finished_failure, '1', FALSE);
      $action_display_finished_failure = add_query_arg('session_id' , 0, $action_display_finished_failure);
      wp_redirect($action_display_finished_failure);
      exit;
    }

    $model_orders = WDFHelper::get_model('orders');
    // $row_order = WDFDb::get_row_by_id('orders', $checkout_data['order_id']);
    $row_order = WDFHelper::get_order($checkout_data['order_id']);

    $failed = false;

    // Check token parameter.
    if ((isset($_GET['token']) == false) || (empty($_GET['token']))) {
      $failed = true;
      $model_orders->enqueue_message(__('Invalid token', 'wde'), 'danger');
    }

    // Check order, and if user can checkout this order.
    if ($failed == false) {
      if (is_user_logged_in()) {
        if ($row_order->j_user_id != $j_user->ID) {
          $failed = true;
        }
      }
      else {
        $order_rand_ids = WDFInput::cookie_get_array('order_rand_ids');
        if ((empty($order_rand_ids) == true) || (in_array($row_order->rand_id, $order_rand_ids) == false)) {
          $failed = true;
        }
      }
    }

    if ($failed == false) {
      // get payment checkout details
      $is_production = $checkout_api_options->mode == 1 ? true : false;
      WDFPaypalexpress::set_production_mode($is_production);
      $credentials = array('USER' => $checkout_api_options->paypal_user, 'PWD' => $checkout_api_options->paypal_password, 'SIGNATURE' => $checkout_api_options->paypal_signature);
      WDFPaypalexpress::set_credentials($credentials);

      $params = array('TOKEN' => $_GET['token']);
      $checkout_details = WDFPaypalexpress::get_express_checkout_details($params);

      // store checkout details in orders table
      $payment_data = WDFJson::decode($row_order->payment_data);
      if ($payment_data == null) {
        $payment_data = array();
      }
      $payment_data[] = $checkout_details;
      $row_order->payment_data = WDFJson::encode($payment_data);
      global $wpdb;
      $saved = $wpdb->replace($wpdb->prefix . 'ecommercewd_orders', (array) $row_order);
      if (!$saved) {
        //TODO: handle error storing paypal checkout details
      }
    }
    // get order product details and complete the checkout transaction
    if ($failed == false) {
      // $row_order = $model_orders->add_order_products_data($row_order, true);
      // if ($row_order === false) {
        // $failed = true;
      // }
      // else {
        $request_url = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_confirm_order, '1', FALSE);
        $data = array(
          'local_task' => 'handle_paypal_checkout_notify',
          'controller' => 'paypalexpress',
          'order_id' => $row_order->id
        );
        $notify_url = add_query_arg($data, $request_url);
        $params = array(
          'TOKEN' => $_GET['token'],
          'PAYMENTACTION' => 'Sale',
          'PAYERID' => $_GET['PayerID'], // same amount as in the original request
          'PAYMENTREQUEST_0_ITEMAMT' => $row_order->price,
          'PAYMENTREQUEST_0_TAXAMT' => $row_order->tax_total,
          'PAYMENTREQUEST_0_SHIPPINGAMT' => $row_order->shipping_price,
          'PAYMENTREQUEST_0_AMT' => $row_order->total_price, // same currency as the original request
          'PAYMENTREQUEST_0_CURRENCYCODE' => $row_order->currency_code,
          'PAYMENTREQUEST_0_NOTIFYURL' => $notify_url
        );
        $response = WDFPaypalexpress::do_express_checkout_payment($params);
        if ((is_array($response) == false) || ($response['ACK'] != 'Success')) {
          $failed = true;
          $errors = WDFPaypalexpress::get_errors();
          $msg = empty($errors) == true ? __('Checkout failed', 'wde') : $errors[0];
          $model_orders->enqueue_message($msg, 'danger');
        }
        else {
          // TODO: send transaction ids to user
          // $transaction_id = $response['PAYMENTINFO_0_TRANSACTIONID'];
        }
      // }
    }
    if ($failed == true) {
      $action_display_finished_failure = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_finished_failure, '1', FALSE);
      $action_display_finished_failure = add_query_arg('session_id' , $checkout_data['session_id'], $action_display_finished_failure);
      wp_redirect($action_display_finished_failure);
      exit;
    }
    else {
      WDFChecoutHelper::send_checkout_finished_mail($row_order, 'new');
      $action_display_finished_success = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_finished_success, '1', FALSE);
      $action_display_finished_success = add_query_arg(array('session_id' => $checkout_data['session_id'], 'order_id' => $checkout_data['order_id']), $action_display_finished_success);
      wp_redirect($action_display_finished_success);
      exit;
    }
  }

  public function handle_paypal_checkout_cancel() {
    WDFChecoutHelper::check_can_checkout();
    
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();

    $model = WDFHelper::get_model('checkout');
    $checkout_data = $model->store_checkout_data();
    if ($checkout_data === false) {
      $action_display_finished_failure = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_finished_failure, '1', FALSE);
      $action_display_finished_failure = add_query_arg('session_id' , 0, $action_display_finished_failure);
      wp_redirect($action_display_finished_failure);
      exit;
    }

    $session_id = WDFSession::get('session_id');
    $msg = __('Checkout canceled', 'wde');
    $action_display_finished_failure = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_finished_failure, '1', FALSE);
    $action_display_finished_failure = add_query_arg(array('session_id' => $session_id, 'error_msg' => urlencode($msg)), $action_display_finished_failure);
    wp_redirect($action_display_finished_failure);
    exit;
  }

  public function handle_paypal_checkout_notify() {
    $order_id = WDFInput::get('order_id', 0, 'int');
    if ($order_id == 0) {
      return false;
    }

    $model_checkout = WDFHelper::get_model('checkout');
    $checkout_api_options = $model_checkout->checkout_api_options('paypalexpress');
    $is_production = $checkout_api_options->mode == 1 ? true : false;
    WDFPaypalexpress::set_production_mode($is_production);

    // validate ipn
    $ipn_data = WDFPaypalexpress::validate_ipn();
    if (is_array($ipn_data) == false) {
      return false;
    }

    // store ipn in db
    $row_order = WDFDb::get_row_by_id('orders', $order_id);

    // insert new data in payment_data
    $payment_data = WDFJson::decode($row_order->payment_data);
    if ($payment_data == null) {
      $payment_data = array();
    }
    $payment_data[] = $ipn_data;
    $row_order->payment_data = WDFJson::encode($payment_data);

    // update payment data status
    $row_order->payment_data_status = $ipn_data['payment_status'];
    // mark as unread
    $row_order->read = 0;

    global $wpdb;
    $saved = $wpdb->replace($wpdb->prefix . 'ecommercewd_orders', (array) $row_order);
    if ($saved === FALSE) {
      $this->save_paypal_ipn_error_log($row_order->id, $ipn_data);
    }
    else {
      $model_orders = WDFHelper::get_model('orders');
      // $row_order = $model_orders->add_order_products_data($row_order, true);
      WDFChecoutHelper::send_checkout_finished_mail($row_order, 'notify');
    }
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////	
	private function finish_checkout_with_paypal($final_checkout_data) {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();
    $checkout_api_options = WDFHelper::get_model('checkout')->checkout_api_options('paypalexpress');
    $is_production = $checkout_api_options->mode == 1 ? true : false;
    WDFPaypalexpress::set_production_mode($is_production);

    // credentials
    $credentials = array('USER' => $checkout_api_options->paypal_user, 'PWD' => $checkout_api_options->paypal_password, 'SIGNATURE' => $checkout_api_options->paypal_signature);
    WDFPaypalexpress::set_credentials($credentials);

    // callbacks
    $request_url = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_confirm_order, '1', FALSE);
    $data = array(
      'session_id' => $final_checkout_data['session_id'],
      'controller' => 'paypalexpress',
    );
    $request_url = add_query_arg($data, $request_url);
    $request_params = array(
      'RETURNURL' => add_query_arg('local_task', 'handle_paypal_checkout_return', $request_url),
      'CANCELURL' => add_query_arg('local_task', 'handle_paypal_checkout_cancel', $request_url),
    );

    $products_price_total = 0;
    $product_taxes_price_total = 0;
    $product_shipping_price_total = 0;
    // products data
    $products_data = $final_checkout_data['products_data'];
    $items_params = array();
    $i = 0;
    if (is_array($products_data)) {
      foreach ($products_data as $product_data) {
        $items_params['L_PAYMENTREQUEST_0_NAME' . $i] = $product_data->name;
        $items_params['L_PAYMENTREQUEST_0_DESC' . $i] = $product_data->description;
        $items_params['L_PAYMENTREQUEST_0_AMT' . $i] = $product_data->price;
        $items_params['L_PAYMENTREQUEST_0_TAXAMT' . $i] = $product_data->tax_total;
        $items_params['L_PAYMENTREQUEST_0_QTY' . $i] = $product_data->count;
        $items_params['L_PAYMENTREQUEST_0_ITEMURL' . $i] = $product_data->url;

        $products_price_total += $product_data->count * $product_data->price;
        $product_taxes_price_total += $product_data->count * $product_data->tax_total;
        $product_shipping_price_total += /* $product_data->count *  */$product_data->shipping_method_price;

        $i++;
      }
    }

    if ($final_checkout_data['shipping_method']) {
      $product_shipping_price_total = $final_checkout_data['shipping_method']->shipping_method_price;
    }
    
    // order data
    $order_params = array(
      'PAYMENTREQUEST_0_AMT' => $products_price_total + $product_taxes_price_total + $product_shipping_price_total,
      'PAYMENTREQUEST_0_ITEMAMT' => $products_price_total,
      'PAYMENTREQUEST_0_TAXAMT' => $product_taxes_price_total,
      'PAYMENTREQUEST_0_SHIPPINGAMT' => $product_shipping_price_total,
      'PAYMENTREQUEST_0_CURRENCYCODE' => $final_checkout_data['currency_code'],
    );

    WDFPaypalexpress::set_express_checkout($request_params, $order_params, $items_params);

    $errors = WDFPaypalexpress::get_errors();
    if (empty($errors) == false) {
      $error_msg = $errors[0];
      $action_display_finished_failure = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_finished_failure, '1', FALSE);
      $action_display_finished_failure = add_query_arg(array('session_id' => $final_checkout_data['session_id'], 'error_msg' => urlencode($error_msg)), $action_display_finished_failure);
      wp_redirect($action_display_finished_failure);
      exit;
    }
  }

	private function save_paypal_ipn_error_log($order_id, $ipn_data) {
    // TODO: user friendly log
    $log_content = WDFJson::encode($ipn_data);
    file_put_contents($order_id . '_' . date("Y_m_d_H_i_s") . '.txt', $log_content);
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}