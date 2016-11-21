<?php
 
defined('ABSPATH') || die('Access Denied');

class EcommercewdTableCurrencies {
  public $id = 0;
  public $name = '';
  public $code = '';
  public $sign = '';
  public $sign_position = 0;
  public $exchange_rate = 1;
  public $default = 0;
}