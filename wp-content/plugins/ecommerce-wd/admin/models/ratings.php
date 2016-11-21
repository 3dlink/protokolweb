<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelRatings extends EcommercewdModel {
  public function get_rows() {
    $rows = parent::get_rows();

    // additional data
    foreach ($rows as $row) {
      $row->user_view_url = get_edit_user_link($row->user_id);
      $row->product_name = get_the_title($row->product_id);
    }
    return $rows;
  }

  public function get_lists() {
    $list_ratings = array(array('value' => 1, 'text' => 1), array('value' => 2, 'text' => 2), array('value' => 3, 'text' => 3), array('value' => 4, 'text' => 4), array('value' => 5, 'text' => 5));

    $lists = array();
    $lists['ratings'] = $list_ratings;
    return $lists;
  }

  protected function init_rows_filters() {
    $filter_items = array();

    // product id
    $filter_item = new stdClass();
    $filter_item->type = 'uint';
    $filter_item->name = 'product_id';
    $filter_item->values_list = WDFDb::get_list_custom_post_type('wde_products', array('id' => -1, 'name' => '-' . __('Any product', 'wde') . '-'));
    $filter_item->values_list_prop_value = 'id';
    $filter_item->values_list_prop_text = 'name';
    $filter_item->default_value = -1;
    $filter_item->operator = '=';
    $filter_item->input_type = 'select';
    $filter_item->input_label = __('Product', 'wde');
    $filter_item->input_name = 'search_product_id';
    $filter_items[$filter_item->name] = $filter_item;
    $this->rows_filter_items = $filter_items;
    parent::init_rows_filters();
  }

  protected function add_rows_query_select() {
    $query = 'SELECT ' . $this->current_table_name . '.*';
    $query .= ', T_USERS.ID AS user_id';
    $query .= ', T_USERS.display_name AS user_name';
    return $query;
  }

  protected function add_rows_query_from() {
    $query = parent::add_rows_query_from();
    global $wpdb;
    $query .= ' LEFT JOIN ' . $wpdb->prefix . 'users AS T_USERS ON ' . $wpdb->prefix . 'ecommercewd_ratings.j_user_id = T_USERS.ID';
    return $query;
  }

  protected function add_rows_query_order() {
    $sort_data = $this->get_rows_sort_data();
    $query = ' ORDER BY ' . $sort_data['sort_by'] . ' ' . $sort_data['sort_order'];
    return $query;
  }
}