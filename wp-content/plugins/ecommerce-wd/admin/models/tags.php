<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelTags extends EcommercewdModel {
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
    $rows = get_terms('wde_tag', $args);
    foreach ($rows as $row) {
      $row->id = $row->term_id;
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
}