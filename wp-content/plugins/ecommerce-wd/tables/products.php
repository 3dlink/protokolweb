<?php
 
defined('ABSPATH') || die('Access Denied');

class EcommercewdTableProducts {
  public $id = 0;
  public $name = '';
  public $alias = '';
  public $downloadable = 0;
  public $virtual = 0;
  public $category_id = 0;
  public $manufacturer_id = 0;
  public $model = '';
  public $sku = '';
  public $upc = '';
  public $ean = '';
  public $jan = '';
  public $isbn = '';
  public $weight = '';
  public $dimensions = '';
  public $mpn = '';
  public $description = '';
  public $images = '';
  public $videos = '';
  public $download_limit = 0;
  public $download_expiry = 0;
  public $expiry_unlimited = 0;
  public $download_unlimited = 0;	
  public $price = 0;
  public $market_price = 0;
  public $tax_id = 0;
  public $enable_shipping = 0;
  public $discount_id = 0;
  public $amount_in_stock = 0;
  public $unlimited = 1;
  public $label_id = 0;
  public $meta_title = '';
  public $meta_description = '';
  public $meta_keyword = '';
  public $date_added = '';
  public $ordering = 0;
  public $published = 1;
}