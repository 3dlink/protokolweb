<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelParameters extends EcommercewdModel {
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
    $rows = get_terms('wde_parameters', $args);
    
    foreach ($rows as $row) {
      $row->id = $row->term_id;
      $row_temp = get_option("wde_parameters_" . $row->id);
      $row->type_id = isset($row_temp['type_id']) ? $row_temp['type_id'] : 1;
      $row->required = isset($row_temp['required']) ? $row_temp['required'] : 0;
      $row->type_name =  WDFDb::get_row_by_id('parametertypes', $row->type_id)->name;

      $term = get_term($row->term_id, 'wde_parameters');
      $parameters = get_terms('wde_par_' . $term->slug, array( 'hide_empty' => 0 ));
      $params = array();
      $params_ids = array();
      foreach ($parameters as $param) {
        array_push($params, $param->name);
        array_push($params_ids, $param->term_id);
      }
      $row->default_values = WDFJson::encode($params);
      $row->default_values_ids = WDFJson::encode($params_ids);
    }
    return $rows;
  }

  public function get_row($id = 0){
    $row = new stdClass;
    if ($id) {
      $row_temp = get_option("wde_parameters_" . $id);
      $row->id = $id;
      $row->type_id = isset($row_temp['type_id']) ? $row_temp['type_id'] : 1;
      $row->default_values = isset($row_temp['default_values']) ? $row_temp['default_values'] : "";
      $row->required = isset($row_temp['required']) ? $row_temp['required'] : 0;
    }
    else {
      $row->id = 0;
      $row->type_id = 1;
      $row->default_values = "";
      $row->required = 0;
    }
    return $row;
  }

  public function get_parameter_types() {
    $parameter_types = WDFDb::get_list('parametertypes', 'id', 'name', array(), '', '');
    return $parameter_types;
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