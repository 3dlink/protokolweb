<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelPages extends EcommercewdModel {
  public function get_row($id = 0) {
    $row = parent::get_row($id);

    $row->article_title = $this->get_article_title($row->article_id);
    return $row;
  }

  public function get_articles_table_data() {
    // session data
    $search_title = WDFSession::get('search_title', '');
    $sort_by = WDFSession::get('sort_by', 'id');
    $sort_order = WDFSession::get('sort_order', 'asc');
    $limit = WDFSession::get_pagination_limit();
    $limitstart = WDFSession::get_pagination_start();
    
    $pagination = new stdClass;
    $total = new WP_Query(array('post_type' => 'post', 's' => $search_title, 'nopaging' => TRUE));
    $pagination->_count = count($total->posts);
    $pagination->_offset = (($limitstart - 1) * $limit) + 1;
    $args = array(
      'post_type' => 'post',
      's' => $search_title,
      'nopaging' => FALSE,
      'posts_per_page' => 10,
      'offset' => $pagination->_offset - 1,
    );
    $query = new WP_Query($args);
    $rows = array();
    function get_cat_titles($category) {
      return $category->name;
    }

    if ($query->have_posts()) {
      foreach ($query->posts as $index => $post) {
        $row = new stdClass();
        $row->id = $post->ID;
        $row->title = $post->post_title;
        $row->category_title = get_the_category($post->ID);
        $row->category_title = array_map('get_cat_titles', $row->category_title);
        $row->category_title = implode(', ', $row->category_title);
        $row->published = ($post->post_status == 'publish') ? 1 : 0;
        $rows[] = $row;
      }
    }
    $data = array();
    $data['rows'] = $rows;
    $data['filter_items'] = $this->get_rows_filter_items();
    $data['sort_data'] = array('sort_by' => $sort_by, 'sort_order' => $sort_order);
    $data['pagination'] = $pagination;
    return $data;
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

    // title
    $filter_item = new stdClass();
    $filter_item->type = 'string';
    $filter_item->name = 'title';
    $filter_item->default_value = null;
    $filter_item->operator = 'like';
    $filter_item->input_type = 'text';
    $filter_item->input_label = __('Title', 'wde');
    $filter_item->input_name = 'search_title';
    $filter_items[$filter_item->name] = $filter_item;

    $this->rows_filter_items = $filter_items;

    parent::init_rows_filters();
  }

  private function get_article_title($id) {
    global $wpdb;
    $query = 'SELECT post_title FROM ' . $wpdb->prefix . 'posts WHERE id=' . $id . ' AND post_type="post"';
    $title = $wpdb->get_var($query);
    return $title;
  }
}