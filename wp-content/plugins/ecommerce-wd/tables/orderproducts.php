<?php
 
defined('ABSPATH') || die('Access Denied');

class EcommercewdTableOrderProducts {
  public $id = 0;
  public $order_id = 0;
  public $j_user_id = 0;
  public $user_ip_address = 0;
  public $product_id = 0;
  public $product_name = '';
  public $product_image = '';
  public $product_parameters = '';
  public $product_price = 0;
  public $product_count = 0;
  public $tax_id = 0;
  public $tax_name = '';
  public $tax_price = 0;
  public $shipping_method_id = 0;
  public $shipping_method_name = '';
  public $shipping_method_price = 0;
  public $currency_id = 0;
  public $currency_code = '';
  public $discount_rate = '';
  public $discount = 0;
  public $shipping_method_type = '';
  public $tax_info = '';
}