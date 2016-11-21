<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelTaxes extends EcommercewdModel {
  public function get_rows() {
    $limit = WDFSession::get_pagination_limit();
    $limitstart = WDFSession::get_pagination_start();
    $offset = ($limitstart - 1) * $limit;
    $args = array(
      'orderby'           => WDFSession::get('sort_by', 'name'),
      'order'             => WDFSession::get('sort_order', 'ASC'),
      'hide_empty'        => FALSE,
      'exclude'           => array(),
      'exclude_tree'      => array(),
      'include'           => array(),
      'number'            => WDFSession::get_pagination_limit(),
      'fields'            => 'all',
      'slug'              => '',
      'parent'            => '',
      'hierarchical'      => TRUE,
      'child_of'          => 0,
      'childless'         => FALSE,
      'get'               => '',
      'name__like'        => WDFSession::get('search_name', ''),
      'description__like' => '',
      'pad_counts'        => FALSE,
      'offset'            => $offset,
      'search'            => '',
      'cache_domain'      => 'core'
    );
    $rows = get_terms('wde_taxes', $args);

    foreach ($rows as $row) {
      $row->id = $row->term_id;
      $term_meta = get_option("wde_taxes_" . $row->term_id);
      $row->rate = '';
      $row->rate_text = '';
      $row->details = $row->name;
    }
    return $rows;
  }

  protected function init_rows_filters() {
    $filter_items = array();

    // name
    $filter_item = new stdClass();
    $filter_item->type = 'string';
    $filter_item->name = 'name';
    $filter_item->default_value = null;
    $filter_item->operator = 'like';
    $filter_item->input_type = 'text';
    $filter_item->input_label = __('Name', 'wde');
    $filter_item->input_name = 'search_name';
    $filter_items[$filter_item->name] = $filter_item;

    $this->rows_filter_items = $filter_items;

    parent::init_rows_filters();
  }

  public function get_tax_rates_defaults() {
    global $wpdb;
    $defaults = $wpdb->get_col('DESC `' . $wpdb->prefix . 'ecommercewd_tax_rates`');
    if (!$defaults) {
      $defaults = array('id', 'country', 'state', 'zipcode', 'city', 'rate', 'tax_name', 'priority', 'compound', 'shipping_rate', 'ordering', 'tax_id');
    }
    $object = new stdClass;
    foreach ($defaults as $default) {
      $object->$default = '';
    }
    $object->id = 'default';
    return $object;
  }
}