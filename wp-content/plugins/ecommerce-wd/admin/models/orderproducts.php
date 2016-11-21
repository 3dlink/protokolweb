<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelOrderProducts extends EcommercewdModel {
  public function get_order_data() {
    global $wpdb;

    $order_id = WDFInput::get('order_id');
    $query = 'SELECT GROUP_CONCAT(
        CONCAT(
            "<strong>", T_ORDER_PRODUCTS.product_name, "</strong>",
            " (",
            T_ORDER_PRODUCTS.product_price,
            " + ' . __('Tax', 'wde') . ': ", T_ORDER_PRODUCTS.tax_price,
            ") x", T_ORDER_PRODUCTS.product_count,
            " + ' . __('Shipping', 'wde') . ': ", T_ORDER_PRODUCTS.shipping_method_price,
            " = ",
            "<strong>", (T_ORDER_PRODUCTS.product_price + T_ORDER_PRODUCTS.tax_price) * T_ORDER_PRODUCTS.product_count + T_ORDER_PRODUCTS.shipping_method_price, "</strong>"
        )
    SEPARATOR "<hr>") AS product_names';
    $query .= ', SUM((T_ORDER_PRODUCTS.product_price + T_ORDER_PRODUCTS.tax_price) * T_ORDER_PRODUCTS.product_count + T_ORDER_PRODUCTS.shipping_method_price) AS total_price';
    $query .= ', CONCAT(SUM((T_ORDER_PRODUCTS.product_price + T_ORDER_PRODUCTS.tax_price + T_ORDER_PRODUCTS.shipping_method_price) * T_ORDER_PRODUCTS.product_count), " ", T_ORDER_PRODUCTS.currency_code) AS total_price_text';
    $query .= ', T_ORDER_PRODUCTS.currency_code';
    $query .= ', T_ORDER.shipping_type';
    $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_orderproducts AS T_ORDER_PRODUCTS';
    $query .= ' INNER JOIN ' . $wpdb->prefix . 'ecommercewd_orders AS T_ORDER';
    $query .= ' WHERE T_ORDER_PRODUCTS.order_id = ' . $order_id;
    $order_data = $wpdb->get_results($query);
    return $order_data;
  }

  protected function add_rows_query_select() {
    $query = parent::add_rows_query_select();

    $query .= ', (product_price + tax_price) * product_count + shipping_method_price AS subtotal';
    return $query;
  }

  protected function add_rows_query_where() {
    $order_id = WDFInput::get('order_id');
    $query = ' WHERE order_id = ' . $order_id;
    return $query;
  }
}