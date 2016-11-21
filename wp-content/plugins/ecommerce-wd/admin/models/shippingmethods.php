<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelShippingmethods extends EcommercewdModel {
  public function get_row($id = 0) {
    if (!$id) {
      return 0;
    }
    $row = get_option("wde_shippingmethods_" . $id);
    $country_names = array();
    $country_ids = isset($row['country_ids']) ? explode(',', $row['country_ids']) : FALSE;
    if ($country_ids) {
      foreach ($country_ids as $country_id) {
        $term = get_term($country_id, 'wde_countries');
        if (!is_wp_error($term)) {
          $country_names[] = $term->name;
        }
      }
    }
    $row['tax_id'] = isset($row['tax_id']) ? $row['tax_id'] : 0;
    $term = get_term($row['tax_id'], 'wde_taxes');
    if (!is_wp_error($term)) {
      $tax = get_option("wde_taxes_" . $row['tax_id']);
      $row['tax_name'] = $term->name . ' (' . $tax['rate'] . '%)';
    }
    else {
      $row['tax_name'] = '';
    }

    $row['price'] = isset($row['price']) ? WDFText::wde_number_format($row['price'], 2) : '0.00';
    $row['free_shipping_start_price'] = isset($row['free_shipping_start_price']) ? WDFText::wde_number_format($row['free_shipping_start_price'], 2) : '0.00';
    $row['shipping_type'] = isset($row['shipping_type']) ? $row['shipping_type'] : 'per_bundle';
    $row['country_names'] = implode('&#13;', $country_names);
    return $row;
  }

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
    $rows = get_terms('wde_shippingmethods', $args);

    $row_default_currency = WDFDb::get_row('currencies', '`default` = 1');

    // additional data
    foreach ($rows as $row) {
      $row->id = $row->term_id;
      $term_meta = get_option("wde_shippingmethods_" . $row->term_id);
      $row->price = (isset($term_meta['price']) && $term_meta['price']) ? WDFText::wde_number_format($term_meta['price'], 2) : '0.00';
      $row->free_shipping_start_price = (isset($term_meta['free_shipping_start_price']) && $term_meta['free_shipping_start_price']) ? WDFText::wde_number_format($term_meta['free_shipping_start_price'], 2) : '0.00';
      // price text
      if (isset($term_meta['free_shipping']) && $term_meta['free_shipping'] == 1) {
        $row->price_text = __('Free shipping', 'wde');
      }
      else {
        $row->price_text = $row->price . ' ' . $row_default_currency->code;
      }
    }

    return $rows;
  }

  public function get_rows_pagination() {
    $task = WDFInput::get_task();
    if ($task == 'explore') {
      $pagination = new stdClass;
      $pagination->_count = 0;
      $pagination->_offset = 1;
      $pagination->limit = 0;
      $pagination->limitstart = 0;
      return $pagination;
    }
    return parent::get_rows_pagination();
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
}