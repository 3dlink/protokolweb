<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerPages extends EcommercewdController {
  public function explore_articles() {
    WDFInput::set('tmpl', 'component');
    parent::display();
  }

  public function remove() {
    $this->remove_product_pages(WDFInput::get_checked_ids());
    parent::remove();
  }

  public function use_for_all_products() {
    WDFDb::set_checked_rows_data('pages', 'use_for_all_products', 1);
    WDFHelper::redirect('pages');
  }

  public function notuse_for_all_products() {
    WDFDb::set_checked_rows_data('pages', 'use_for_all_products', 0);
    WDFHelper::redirect('pages');
  }


  private function remove_product_pages($ids) {
    if (empty($ids) == true) {
      return false;
    }
    global $wpdb;
    $query = 'DELETE FROM ' . $wpdb->prefix . 'ecommercewd_productpages WHERE page_id IN (' . implode(',', $ids) . ')';
    $wpdb->query($query);
  }

  protected function store_input_in_row() {
    $is_article = WDFInput::get('is_article', 0, 'int');
    if ($is_article == 1) {
      global $wpdb;
      $article_id = WDFInput::get('article_id', 0, 'int');
      $query = 'SELECT post_title FROM ' . $wpdb->prefix . 'posts WHERE id=' . $article_id;
      $article_title = $wpdb->get_var($query);
      WDFInput::set('title', $article_title);
    }

    $row = parent::store_input_in_row();
    return $row;
  }
}