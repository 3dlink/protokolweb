<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdTableTax_rates {
  public $id = 0;
  public $country = 0;
  public $state = '';
  public $zipcode = '';
  public $city = '';
  public $rate = '';
  public $tax_name = '';
  public $priority = 1;
  public $compound = 0;
  public $shipping_rate = '';
  public $ordering = 0;
  public $tax_id = 0;
}
