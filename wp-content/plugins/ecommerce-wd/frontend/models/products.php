<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdModelProducts extends EcommercewdModel {
  private $search_data;
  private $filters_data;

  public function get_product_view_product_row($params) {
    if (WDFInput::get('type')) {
      $id = WDFInput::get('id');
    }
    else {
      $id = WDFInput::get('product_id', WDFParams::get($params, 'product_id', 0), 'int');
    }
    $product_rows = WDFProduct::get_product_rows($id, FALSE);
    if (($product_rows === false) || (empty($product_rows) == true)) {
      WDFHelper::show_error(2);
    }
    if ((WDFProduct::add_product_parameters($product_rows) === false) 
        || (WDFProduct::add_product_selectable_parameters($product_rows) === false) 
        || (WDFProduct::add_product_tags($product_rows) === false) 
        || (WDFProduct::add_product_shipping_methods($product_rows) === false) 
        || (WDFProduct::add_product_related_products($product_rows) === false)
      ) {
      WDFHelper::show_error(2);
    }
    $product_row = empty($product_rows) == false ? $product_rows[0] : null;
    return $product_row;
  }

  public function get_quick_view_product_row($id = 0) {
    if ($id == 0) {
      $id = WDFInput::get('product_id', 0, 'int');
    }
    $product_rows = WDFProduct::get_product_rows($id, false, null, false, null, true);
    if (($product_rows === false) || (empty($product_rows) == true)) {
        return false;
    }
    WDFProduct::add_product_parameters($product_rows);
    WDFProduct::add_product_selectable_parameters($product_rows);

    $product_row = $product_rows[0];
    $description_max_length = WDFProduct::MAX_LENGTH_DESCRIPTION_WRITE_REVIEW;
    if ($product_row->short_description) {
      $product_row->description = $product_row->short_description;
    }
    if (strlen($product_row->description) > $description_max_length) {
      $product_row->description = substr($product_row->description, 0, $description_max_length - 3) . '...';
    }

    $product_row->image = WDFHelper::get_image_original_url($product_row->image);
    return $product_row;
  }

  public function get_compare_products_view_product_row($id = 0) {
    if ($id == 0) {
      $id = get_the_ID();
    }
    $product_rows = WDFProduct::get_product_rows($id);
    if (($product_rows === false) || (empty($product_rows) == true) || (WDFProduct::add_product_parameters($product_rows) === false)) {
      WDFHelper::show_error(2);
    }
    $product_row = $product_rows[0];
    return $product_row;
  }

  public function get_compare_products_lists($product_row) {
    $lists['products'] = array();
    $lists['products'][0] = array('id' => '', 'name' => __('Select product', 'wde'));
    $categories = get_the_terms($product_row->id, 'wde_categories');
    if ($categories) {
      foreach ($categories as $category) {
        wp_reset_query();
        $args = array(
          'post_type' => 'wde_products',
          'post__not_in' => array($product_row->id),
          'post_status' => array('publish'),
          'tax_query' => array(
            array(
              'taxonomy' => 'wde_categories',
              'field' => 'slug',
              'terms' => $category->slug,
              'nopaging' => TRUE
            ),
          ),
         );
        $loop = new WP_Query($args);
        $i = 1;
        while ($loop->have_posts()) {
          $loop->the_post();
          $lists['products'][$i++] = array('id' => get_the_ID(), 'name' => get_the_title());
        }
        wp_reset_query();
      }
    }
    return $lists;
  }
}