<?php
 
defined('ABSPATH') || die('Access Denied');

class EcommercewdTableOrders {
  public $id = 0;
  public $checkout_type = '';
  public $checkout_date = '';
  public $date_modified = '';
  public $j_user_id = 0;
  public $user_ip_address = 0;
  public $status_id = 0;
  public $status_name = '';
  public $payment_method = '';
  public $payment_data = '';
  public $payment_data_status = '';
  public $billing_data_first_name = '';
  public $billing_data_middle_name = '';
  public $billing_data_last_name = '';
  public $billing_data_company = '';
  public $billing_data_email = '';
  public $billing_data_country_id = 0;
  public $billing_data_country = '';
  public $billing_data_state = '';
  public $billing_data_city = '';
  public $billing_data_address = '';
  public $billing_data_mobile = '';
  public $billing_data_phone = '';
  public $billing_data_fax = '';
  public $billing_data_zip_code = '';
  public $shipping_data_first_name = '';
  public $shipping_data_middle_name = '';
  public $shipping_data_last_name = '';
  public $shipping_data_company = '';
  public $shipping_data_country_id = 0;
  public $shipping_data_country = '';
  public $shipping_data_state = '';
  public $shipping_data_city = '';
  public $shipping_data_address = '';
  public $shipping_data_zip_code = '';
  public $currency_id = 0;
  public $currency_code = '';
  public $read = 0;
}