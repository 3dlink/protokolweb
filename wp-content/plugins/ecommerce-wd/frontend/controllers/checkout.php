<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerCheckout extends EcommercewdController {
  
  public function checkout_product() {
    WDFChecoutHelper::check_can_checkout();
    $model = WDFHelper::get_model('checkout');
    $session_id = $model->init_checkout();
    $options_model = WDFHelper::get_model('options');
    $options = $options_model->get_options();
    $url = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_shipping_data, '1', FALSE);
    $url = add_query_arg('session_id' , $session_id, $url);
    wp_redirect($url);
    exit;
  }

  public function checkout_all_products() {
    WDFChecoutHelper::check_can_checkout();
    $model = WDFHelper::get_model('checkout');
    $session_id = $model->init_checkout();
    $options_model = WDFHelper::get_model('options');
    $options = $options_model->get_options();
    $url = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_shipping_data, '1', FALSE);
    $url = add_query_arg('session_id' , $session_id, $url);
    wp_redirect($url);
    exit;
  }

  public function quick_checkout($params) {
    WDFChecoutHelper::check_can_checkout();
    $model = WDFHelper::get_model('checkout');
    $session_id = $model->init_checkout();
    WDFInput::set('session_id', $session_id);
    WDFInput::set('task', 'displayshippingdata');
    $options_model = WDFHelper::get_model('options');
    $options = $options_model->get_options();
    $url = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_shipping_data, '1', FALSE);
    $url = add_query_arg('session_id' , $session_id, $url);
    wp_redirect($url);
    exit;
  }

  public function displayshippingdata($params) {
    WDFChecoutHelper::check_can_checkout();
    WDFChecoutHelper::check_checkout_data();
    $params['layout'] = 'displayshippingdata';
    parent::display($params);
  }

  public function displayproductsdata($params) {
    WDFChecoutHelper::check_can_checkout();
    WDFChecoutHelper::check_checkout_data();
    parent::display($params);
  }

  public function displaylicensepages($params) {
    WDFChecoutHelper::check_can_checkout();
    WDFChecoutHelper::check_checkout_data();
    parent::display($params);
  }

  public function displayconfirmorder($params) {
    if (isset($_GET['controller'])) {
      $input_controller = esc_html($_GET['controller']);
      $local_task = WDFInput::get('local_task', 'finish_checkout');
      $controller_path = WDFPath::get_com_path('', TRUE) . '/controllers/' . $input_controller . '.php';
      if (file_exists($controller_path)) {
        require_once $controller_path;
      }
      $controller_class = ucfirst(WDFHelper::get_com_name()) . 'Controller' . ucfirst($input_controller);
      $controller = new $controller_class();
      $controller->$local_task();
      return;
    }
    WDFChecoutHelper::check_can_checkout();
    WDFChecoutHelper::check_checkout_data();
    parent::display($params);
  }

  public function displaycheckoutfinishedsuccess($params) {
    WDFChecoutHelper::check_can_checkout();
    parent::display($params);
  }

  public function displaycheckoutfinishedfailure($params) {
    WDFChecoutHelper::check_can_checkout();
    parent::display($params);
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