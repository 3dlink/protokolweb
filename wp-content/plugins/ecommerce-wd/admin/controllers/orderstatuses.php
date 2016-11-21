<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerOrderstatuses extends EcommercewdController {
  public function remove_keep_default() {
    $this->clear_order_statuses(WDFInput::get_checked_ids());
    parent::remove_keep_default();
  }

  private function clear_order_statuses($ids) {
    if (empty($ids) == true) {
      return false;
    }
    global $wpdb;
    $query = 'UPDATE ' . $wpdb->prefix . 'ecommercewd_orders SET status_id = 0 WHERE status_id IN (' . implode(',', $ids) . ')';
    $wpdb->query($query);
  }
}