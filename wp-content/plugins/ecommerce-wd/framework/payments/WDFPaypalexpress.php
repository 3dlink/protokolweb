<?php

defined('ABSPATH') || die('Access Denied');

class WDFPaypalexpress {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  /**
   * API Version
   * @var string
   */
  public static $currencies_without_decimal_support = array('HUF', 'TWD', 'JPY');

  /**
   * Editable field types
   * 
   */

  public static $field_types = array();

  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  /**
   * API Version
   * @var string
   */
  private static $version = '74.0';

  /**
   * production or sandbox(testing)
   * @var boolean
   */
  private static $is_production = false;

  /**
   * default API Credentials
   * @var array
   */
  private static $credentials = array();

  /**
   * error message(s)
   * @var array
   */
  private static $errors = array();

  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  /**
   * set checkout mode. production if true, sandbox if false
   *
   * @param array $credentials seller credentials (USER, PWD, SIGNATURE)
   */
  public static function set_production_mode($is_production) {
  }

  /**
   * set paypal seller credentials
   *
   * @param array $credentials seller credentials (USER, PWD, SIGNATURE)
   */
  public static function set_credentials($credentials = array()) {
  }

  /**
   * Make API request
   *
   * @param string $method string API method to request
   * @param array $params Additional request parameters
   * @return array / boolean Response array / boolean false on failure
   */
  public static function request($method, $params = array()) {
  }

  /**
   * Make SetExpressCheckout request (redirects to paypal for user to log in and accept payment)
   *
   * @param string $request_params request params (RETURNURL, CANCELURL)
   * @param array $order_params order params (PAYMENTREQUEST_0_AMT, PAYMENTREQUEST_0_SHIPPINGAMT, PAYMENTREQUEST_0_CURRENCYCODE, PAYMENTREQUEST_0_ITEMAMT)
   * @param array $items_params item parms (L_PAYMENTREQUEST_0_NAME_0, L_PAYMENTREQUEST_0_DESC_0, L_PAYMENTREQUEST_0_AMT_0, L_PAYMENTREQUEST_0_QTY_0)
   *
   * @return boolean false on failure
   */
  public static function set_express_checkout($request_params = array(), $order_params = array(), $items_params = array()) {
  }

  /**
   * Make GetExpressCheckoutDetails request (get detail after payer accept payment)
   *
   * @param string $params params (TOKEN)
   *
   * @return array response details
   */
  public static function get_express_checkout_details($params) {
  }

  /**
   * Make DoExpressCheckoutPayment request (do checkout based on params from paypal)
   *
   * @param string $request_params request params (RETURNURL, CANCELURL)
   *
   * @return array response details / boolean false on failure
   */
  public static function do_express_checkout_payment($params) {
  }

  /**
   * checks is payment notification valid and returns it
   *
   * @return array ipn data / boolean false if notification is invalid
   */
  public static function validate_ipn() {
  }

  /**
   * get errors
   *
   * @return array array of error msgs
   */
  public static function get_errors() {
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