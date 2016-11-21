<?php
 
defined('ABSPATH') || die('Access Denied');

class EcommercewdTableShippingmethods {
  public $id = 0;
  public $name = '';
  public $description = '';
  public $price = 0;
  public $free_shipping = 0;
  public $free_shipping_start_price = 0;
  public $shipping_type = 'per_bundle';
  public $tax_name = '';
  public $tax_id = 0;
  public $ordering = 0;
  public $published = 1;
}