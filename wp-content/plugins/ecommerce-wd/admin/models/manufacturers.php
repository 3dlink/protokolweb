<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelManufacturers extends EcommercewdModel {
  public function get_row($id = 0) {
    global $post;
    $fields = array(
      'site',
      'show_info',
      'show_products',
      'products_count',
      'meta_title',
      'meta_description',
      'meta_keyword',
    );

    $row = new stdClass();
    foreach ($fields as $field) {
      $row->$field = esc_attr(get_post_meta($post->ID, 'wde_' . $field, TRUE));
    }
    $row->id = $post->ID;
    // Default values for radio buttons.
    if ($row->show_info === '') {
      $row->show_info = 1;
    }
    if ($row->show_products === '') {
      $row->show_products = 1;
    }

    return $row;
  }

  public function get_rows() {
    $rows = parent::get_rows();

    // additional data
    if ($rows) {
      foreach ($rows as $row) {
        $row->logo = stripslashes($row->logo);
        // logo
        $logos = WDFJson::decode($row->logo);
        $row->logo = ($logos == null) || (empty($logos) == true) ? '' : $logos[0];
      }
    }

    return $rows;
  }
}