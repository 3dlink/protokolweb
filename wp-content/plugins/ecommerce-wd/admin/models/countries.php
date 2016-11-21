<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelCountries extends EcommercewdModel {
  public function get_row($id = 0) {
    if (!$id) {
      return 0;
    }
    $row = get_option("wde_countries_" . $id);
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
      'number'            => $limit,
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
    $rows = get_terms('wde_countries', $args);

    foreach ($rows as $row) {
      $row->id = $row->term_id;
      $term_meta = get_option("wde_countries_" . $row->term_id);
      $row->code = $term_meta['code'];
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