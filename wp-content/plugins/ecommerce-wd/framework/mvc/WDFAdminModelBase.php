<?php

defined('ABSPATH') || die('Access Denied');

class WDFAdminModelBase {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  protected $current_table_name;
  protected $rows_sort_data;
  protected $rows_default_sort_by;
  protected $rows_default_sort_order;
  protected $rows_filter_items;
  protected $rows_filter_conditions;
  protected $rows_pagination;

  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
    global $wpdb;
    $this->current_table_name = $wpdb->prefix . WDFHelper::get_com_name() . '_' . WDFInput::get_controller();
    $this->init_rows_sort_data();
    $this->init_rows_filters();
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function get_row($id = 0) {
    $task = WDFInput::get_task();
    if (($id == 0) && ($task != 'add')) {
      $id = WDFInput::get_checked_id();
    }

    $row = WDFDb::get_row_by_id('', $id);
    return $row;
  }

  public function get_rows() {
    $query = $this->add_rows_query_select();
    $query .= $this->add_rows_query_from();
    
    $query .= $this->add_rows_query_where();
    $query .= $this->add_rows_query_group();
    $query .= $this->add_rows_query_order();
    $query .= $this->get_rows_pagination_limit();

    global $wpdb;
    $rows = $wpdb->get_results($query);

    $controller = WDFInput::get_controller();
    foreach ($rows as $row) {
      $row->view_url = WDFUrl::get_admin_url() . 'admin.php?page=wde_' . $controller . '&task=view' . '&cid[]=' . $row->id;
      $row->edit_url = WDFUrl::get_admin_url() . 'admin.php?page=wde_' . $controller . '&task=edit' . '&cid[]=' . $row->id;
    }
    return $rows;
  }

  public function get_rows_filter_items() {
    return $this->rows_filter_items;
  }

  public function get_rows_sort_data() {
    return $this->rows_sort_data;
  }

  public function get_rows_pagination_limit() {
    $pagination = $this->get_rows_pagination();
    if ($pagination->_count == 0) return "";
    $limit = $pagination->limit;
    $limitstart = $pagination->limitstart;
    return " LIMIT " . (($limitstart - 1) * $limit) . ", " . $limit;
  }
  
  public function get_rows_pagination() {
    $query = "SELECT COUNT(" . $this->current_table_name . ".id)";
    $query .= " FROM " . $this->current_table_name;
    $query .= $this->add_rows_query_where();

    global $wpdb;
    $count = $wpdb->get_var($query);
    $pagination = new stdClass;
    $pagination->_count = $count;
    $limit = WDFSession::get_pagination_limit();
    $limitstart = WDFSession::get_pagination_start();
    $pagination->limit = $limit;
    $pagination->limitstart = $limitstart;
    $pagination->_offset = (($limitstart - 1) * $limit) + 1;
    return $pagination;
  }


  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  protected function init_rows_sort_data() {
    if ($this->rows_sort_data === null) {
      switch(WDFInput::get_controller()) {
        case "orderstatuses":
        case "payments":
          $sort_by = 'ordering';
          $sort_order = 'asc';
          break;
        case "ratings":
        case "orders":
        case "orderproducts":
          $sort_by = 'id';
          $sort_order = 'desc';
          break;
        default:	
          $sort_by = 'name';
          $sort_order = 'asc';
          break;	
      }
      $this->rows_sort_data = array('sort_by' => $sort_by, 'sort_order' => $sort_order);
    }
    $this->rows_sort_data['sort_by'] = WDFSession::get('sort_by', $this->rows_sort_data['sort_by']);
    $this->rows_sort_data['sort_order'] = WDFSession::get('sort_order', $this->rows_sort_data['sort_order']);
  }

  protected function init_rows_filters() {
    if ($this->rows_filter_items === null) {
      $this->rows_filter_items = array();
    }
    // reset filter values if needed
    if (WDFInput::get('reset_filters', 0, 'int') == 1) {
      foreach ($this->rows_filter_items as $filter_item) {
        WDFSession::set('search_' . $filter_item->name, $filter_item->default_value);
      }
    }
    // init values
    foreach ($this->rows_filter_items as $filter_item) {
      switch ($filter_item->type) {
        case 'uint':
          $value = WDFSession::get('search_' . $filter_item->name, $filter_item->default_value, 'int');
          $filter_item->value = $value >= 0 ? $value : null;
          break;
        case 'string':
          $value = WDFSession::get('search_' . $filter_item->name, $filter_item->default_value, 'string');
          $filter_item->value = $value != '' ? $value : null;
          break;
        default:
          $filter_item->value = WDFSession::get('search_' . $filter_item->name, $filter_item->default_value, $filter_item->type);
          break;
      }
    }
  }

  protected function add_rows_query_select() {
    $query = "SELECT " . $this->current_table_name . ".* ";
    return $query;
  }

  protected function add_rows_query_from() {
    $query = " FROM " . $this->current_table_name;
    return $query;
  }

  protected function add_rows_query_where() {
      $query = $this->add_rows_query_where_filters();
      return $query;
  }

  protected function add_rows_query_where_filters() {
    $query = '';
    if ($this->rows_filter_conditions === null) {
      $filter_conditions = array();
      foreach ($this->rows_filter_items as $filter_item) {
        if ($filter_item->value !== null) {
          $operator = strtolower($filter_item->operator);
          switch ($operator) {
            case 'like':
              $filter_condition = 'LOWER(' . $this->current_table_name . '.' . $filter_item->name . ') LIKE \'%' . $filter_item->value . '%\'';
              break;
            default:
              $filter_name = $filter_item->name;
              $filter_value = $filter_item->value;

              if ($filter_item->input_type == 'date') {
                if ($operator == '>=') {
                  if (substr($filter_name, -5) == '_from') {
                    $filter_name = substr($filter_name, 0, -5);
                  }
                  $filter_value .= ' 00:00:00';
                }
                elseif ($operator == '<=') {
                  if (substr($filter_name, -3) == '_to') {
                    $filter_name = substr($filter_name, 0, -3);
                  }
                  $filter_value .= ' 23:59:59';
                }
              }
              $filter_condition = $this->current_table_name . '.' . $filter_name . ' ' . $operator . ' \'' . $filter_value . '\'';
              break;
          }
          $filter_conditions[] = $filter_condition;
        }
      }

      $this->rows_filter_conditions = $filter_conditions;
    }
    // foreach ($this->rows_filter_conditions as $filter_condition) {
      $query .= implode(' AND ', $this->rows_filter_conditions);
    // }
    if ($query != '') {
      $query = ' WHERE ' . $query;
    }
    return $query;
  }

  protected function add_rows_query_group() {
    $query = ' GROUP BY ' . $this->current_table_name . '.id';
    return $query;
  }

  protected function add_rows_query_order() {
    $sort_data = $this->get_rows_sort_data();
    $query = ' ORDER BY ' . $this->current_table_name . '.' . esc_sql($sort_data['sort_by']) . ' ' . esc_sql($sort_data['sort_order']);
    return $query;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}