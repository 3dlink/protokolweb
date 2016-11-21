<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelOrders extends EcommercewdModel {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  const MAX_PRODUCT_NAME_LENGTH = 20;
  const MAX_PRODUCT_NAMES_LENGTH = 30;

  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function get_order_row($order_id = 0) {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();
    if ($order_id == 0) {
      $order_id = get_query_var($options->option_endpoint_orders_displayorder);
      if (!$order_id) {
        $order_id = get_query_var($options->option_endpoint_orders_printorder);
        if (!$order_id) {
          $order_id = WDFInput::get('order_id', 0, 'int');
        }
      }
    }
    $row_order = WDFHelper::get_order($order_id);
    if (!$row_order) {
      WDFHelper::show_error(2);
    }

    // check if user can access this order
    $can_user_access = false;
    $j_user = wp_get_current_user();
    if (is_user_logged_in()) {
      if ($row_order->j_user_id == $j_user->ID) {
        $can_user_access = true;
      }
    }
    else {
      $order_rand_ids = WDFInput::cookie_get_array('order_rand_ids');
      if ((empty($order_rand_ids) == false) && (in_array($row_order->rand_id, $order_rand_ids))) {
        $can_user_access = true;
      }
    }
    if ($can_user_access == false) {
      $model_options->enqueue_message(__('Wrong request', 'wde'), 'danger');
      wp_redirect(get_permalink($options->option_orders_page));
      exit;
    }
    return $row_order;
  }

  /*
  
  
  public function add_order_products_data($row_order, $max_product_name_length = false ) {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();

    $decimals = $options->option_show_decimals == 1 ? 2 : 0;
    $row_default_currency = WDFDb::get_row('currencies', '`default`=1');

    global $wpdb;
    // order products
    $query = 'SELECT T_ORDERP_RODUCTS.product_id AS id';
    $query .= ', T_ORDERP_RODUCTS.product_name AS name';
    $query .= ', T_ORDERP_RODUCTS.product_image AS image';
    $query .= ', T_ORDERP_RODUCTS.currency_code';
    $query .= ', T_ORDERP_RODUCTS.product_price AS price';
    $query .= ', T_ORDERP_RODUCTS.discount_rate';
    $query .= ', T_ORDERP_RODUCTS.discount';
    $query .= ', T_ORDERP_RODUCTS.tax_price';
    $query .= ', T_ORDERP_RODUCTS.shipping_method_id';
    $query .= ', T_ORDERP_RODUCTS.shipping_method_name';
    $query .= ', T_ORDERP_RODUCTS.shipping_method_price';
    $query .= ', T_ORDERP_RODUCTS.product_count AS count';
    $query .= ', T_ORDERP_RODUCTS.product_parameters AS parameters';
    $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_orderproducts AS T_ORDERP_RODUCTS';
    $query .= ' WHERE T_ORDERP_RODUCTS.order_id = ' . $row_order->id;
    $row_order->product_rows = $wpdb->get_results($query);

    if ($wpdb->last_error) {
      return false;
    }

    $total_price = 0;
    if (is_array($row_order->product_rows)) {
      foreach ($row_order->product_rows as $product_row) {
        $product_row->enable_shipping = esc_attr(get_post_meta($product_row->id, 'wde_enable_shipping', TRUE));
        if ($max_product_name_length == false) {
          if (strlen($product_row->name) > self::MAX_PRODUCT_NAME_LENGTH) {
            $product_row->name = WDFTextUtils::truncate($product_row->name, self::MAX_PRODUCT_NAME_LENGTH);
          }
        }
        $product_row->price_text = WDFHelper::price_text($product_row->price, $decimals, $row_default_currency);
        $product_row->tax_price_text = WDFHelper::price_text($product_row->tax_price, $decimals, $row_default_currency);
        if ($row_order->shipping_type != 'per_order') {
          $product_row->shipping_method_price_text = WDFHelper::price_text($product_row->shipping_method_price, $decimals, $row_default_currency);
        }
        else {
          $product_row->shipping_method_price_text = '';
        }
        $product_row->discount_rate = $product_row->discount_rate ? $product_row->discount_rate . '%' : '';
        $product_row->subtotal_price = 0;
        $product_row->subtotal_text = WDFHelper::price_text($product_row->subtotal_price, $decimals, $row_default_currency);

        $total_price += $product_row->subtotal_price;
      }
    }

    $row_order->total_price = $total_price + ($row_order->shipping_type == 'per_order' ? $row_order->shipping_method_price : 0);
    $row_order->total_price_text = WDFHelper::price_text($row_order->total_price, $decimals, $row_default_currency);

    return $row_order;
  }*/

  public function get_orders_data() {
      $pagination = $this->get_orders_pagination();
      $order_rows = $this->get_order_rows($pagination);

      $data = array();
      $data['pagination'] = $pagination;
      $data['order_rows'] = $order_rows;
      return $data;
  }

  public function get_order_rand_id() {
    global $wpdb;
    $query = 'SELECT rand_id FROM ' . $wpdb->prefix . 'ecommercewd_orders';
    $existing_rand_ids = $wpdb->get_col($query);

    if ($wpdb->last_error) {
      return FALSE;
    }

    do {
      $rand_id = rand(10000000, 99999999);
    } while (in_array($rand_id, $existing_rand_ids) == true);
    return $rand_id;
  }

  public function get_print_order() {
    $order_row = $this->get_order_row();
    return $order_row;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  private function get_orders_pagination() {
    global $wpdb;

    $theme = WDFHelper::get_model('theme')->get_theme_row();

    // get orders count
    $query = 'SELECT COUNT(*)';
    $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_orders';
    if (is_user_logged_in()) {
      $j_user = wp_get_current_user();
      $query .= ' WHERE j_user_id = ' . $j_user->ID;
    } else {
      $order_rand_ids = WDFInput::cookie_get_array('order_rand_ids', array());
      if (empty($order_rand_ids) == false) {
        $query .= ' WHERE j_user_id = 0';
        $query .= ' AND rand_id IN (' . implode(',', $order_rand_ids) . ')';
      } else {
        $query .= ' WHERE 0';
      }
    }
    $orders_count = $wpdb->get_var($query);

    if ($wpdb->last_error) {
      WDFHelper::show_error(2);
    }

    $limit_start = WDFInput::get('pagination_limit_start', 0, 'int');
    $limit = WDFInput::get('pagination_limit', $theme->products_count_in_page, 'int');
    $limit = $limit ? $limit : $theme->products_count_in_page;

    $pagination = new stdClass();
    $pagination->limitstart = $limit_start;
    $pagination->limit = $limit;
    $pagination->current = $limit_start / $limit + 1;
    $pagination->start = 1;
    $pagination->stop = ceil($orders_count / $limit);
    $pagination->total = $pagination->stop;
    return $pagination;
  }

  private function get_order_rows($pagination) {
    global $wpdb;
    $query = 'SELECT id';
    $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_orders';
    if (is_user_logged_in()) {
      $j_user = wp_get_current_user();
      $query .= ' WHERE j_user_id = ' . $j_user->ID;
    }
    else {
      $order_rand_ids = WDFInput::cookie_get_array('order_rand_ids', array());
      if (empty($order_rand_ids) == false) {
        $query .= ' WHERE j_user_id = 0';
        $query .= ' AND rand_id IN (' . implode(',', $order_rand_ids) . ')';
      }
      else {
        $query .= ' WHERE 0';
      }
    }
    $query .= ' ORDER BY checkout_date DESC';
    $query .= ' LIMIT ' . $pagination->limitstart . ', ' . $pagination->limit;
    $order_ids = $wpdb->get_col($query);
    if ($wpdb->last_error) {
      WDFHelper::show_error(2);
    }

    $order_rows = array();
    foreach ($order_ids as $order_id) {
      $order_rows[] = WDFHelper::get_order($order_id);
    }
    if (!empty($order_rows)) {
      $model_options = WDFHelper::get_model('options');
      $options = $model_options->get_options();
      foreach ($order_rows as $order_row) {
        $order_row->order_link = WDFPath::add_pretty_query_args(get_permalink($options->option_orders_page), $options->option_endpoint_orders_displayorder, $order_row->id, TRUE); 
        $order_row->print_orders_link = WDFPath::add_pretty_query_args(get_permalink($options->option_orders_page), $options->option_endpoint_orders_printorder, $order_row->id, TRUE); 
        if (strlen($order_row->product_names) > self::MAX_PRODUCT_NAMES_LENGTH) {
          $order_row->product_names = WDFTextUtils::truncate($order_row->product_names, self::MAX_PRODUCT_NAMES_LENGTH);
        }
      }
    }

    return $order_rows;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}