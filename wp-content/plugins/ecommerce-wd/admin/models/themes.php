<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelThemes extends EcommercewdModel {
  public function get_row($id = 0) {
    global $wpdb;
    $task = WDFInput::get_task();
    // get base theme
    switch ($task) {
      case 'add':
        $row = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . WDFHelper::get_com_name() . '_' . WDFInput::get_controller() . ' WHERE `basic` = 1');
        if ($wpdb->last_error) {
          echo $wpdb->last_error;
          die();
        }
        $row->id = '';
        $row->name = '';
        $row->basic = 0;
        $row->default = 0;
        $row = (object) array_merge((array) $row, (array) json_decode($row->data));
        break;
      case 'edit_basic':
        $row = WDFDb::get_checked_row();

        $row->id = '';
        $row->name = '';
        $row->basic = 0;
        $row->default = 0;
        $row = (object) array_merge((array) $row, (array) json_decode($row->data));
        break;
      case 'edit':
        $row = WDFDb::get_checked_row();
        $row = (object) array_merge((array) $row, (array) json_decode($row->data));
        break;
    }
    return $row;
  }

  public function get_rows() {
    $rows = parent::get_rows();
    foreach ($rows as $row) {
      $row->icon_basic = $row->basic == 1 ? '<img src="templates/hathor/images/admin/icon-16-protected.png">' : '';
      $row->icon_default = $row->default == 1 ? '<img src="templates/hathor/images/header/icon-48-default.png">' : '';
    }
    return $rows;
  }
  
  protected function add_rows_query_where() {
    $query = $this->add_rows_query_where_filters();
    if ($query) {
      $query .= " AND `basic` = 0 ";
    }
    else {
      $query = " WHERE `basic` = 0 ";          
    }
    return $query;
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