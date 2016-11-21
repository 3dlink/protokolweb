<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelUsers extends EcommercewdModel {
  public function get_row($id = 0) {
    $row = WDFDb::get_user_meta_fields_list($id);
    return $row;
  }

  public function get_rows() {
    $rows = parent::get_rows();
    // additional data
    foreach ($rows as $row) {
      // name
      $name_parts = array();
      if ($row->first_name != '') {
        $name_parts[] = $row->first_name;
      }
      if ($row->middle_name != '') {
        $name_parts[] = $row->middle_name;
      }
      if ($row->last_name != '') {
        $name_parts[] = $row->last_name;
      }
      $row->name = implode(' ', $name_parts);
      // country
      $term = get_term($row->country_id, 'wde_countries');
      $row->country_name = !is_wp_error($term) ? $term->name : '';
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

  public function get_edit_lists() {
    $lists = array();
    $lists['countries'] = WDFDb::get_list_countries();
    return $lists;
  }

  protected function init_rows_sort_data() {
    $this->rows_sort_data = array('sort_by' => 'first_name', 'sort_order' => 'asc');
    parent::init_rows_sort_data();
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

  protected function add_rows_query_select() {
    global $wpdb;
    $query = "";
    $query = parent::add_rows_query_select();
    $query .= ',CONCAT(' . $wpdb->prefix . 'ecommercewd_users.first_name, " ", ' . $wpdb->prefix . 'ecommercewd_users.middle_name, " ", ' . $wpdb->prefix . 'ecommercewd_users.last_name) AS name, ';
    return $query;
  }

  protected function add_rows_query_from() {
    global $wpdb;
    $query = "";
    $query = parent::add_rows_query_from();
    return $query;
  }

  protected function add_rows_query_where_filters() {
    global $wpdb;
    $search_name = WDFSession::get('search_name');

    return ' WHERE LOWER(CONCAT(' . $wpdb->prefix . 'ecommercewd_users.first_name, ' . $wpdb->prefix . 'ecommercewd_users.middle_name, ' . $wpdb->prefix . 'ecommercewd_users.last_name)) LIKE \'%' . WDFTextUtils::remove_spaces($search_name) . '%\'';
  }

  protected function add_rows_query_order() {
    $sort_data = parent::get_rows_sort_data();
    $query = ' ORDER BY ' . esc_sql($sort_data['sort_by']) . ' ' . esc_sql($sort_data['sort_order']);
    return $query;
  }
}