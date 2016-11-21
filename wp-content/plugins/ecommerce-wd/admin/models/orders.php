<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelOrders extends EcommercewdModel {
  public function get_row($id = 0) {
    $task = WDFInput::get_task();
    if (($id == 0) && ($task != 'add')) {
      $id = WDFInput::get_checked_id();
    }
    $row = WDFHelper::get_order($id);
    $row->print_url = add_query_arg(array('action' => 'wde_ajax', 'page' => 'wde_orders', 'task' => 'printorder', 'id' => $row->id), admin_url('admin-ajax.php'));

    $row->payment_data_status = $row->payment_data_status != '' ? $row->payment_data_status : '-';
    // User data.
    $row_user = get_userdata($row->j_user_id);
    if ($row_user) {
      $row->user_id = $row_user->ID;
      $row->user_name = $row_user->display_name;
      $row->user_view_url = get_edit_user_link($row_user->ID);
    } else {
      $name_parts = array();
      if ($row->shipping_data_first_name != '') {
        $name_parts[] = $row->shipping_data_first_name;
      }
      if ($row->shipping_data_middle_name != '') {
        $name_parts[] = $row->shipping_data_middle_name;
      }
      if ($row->shipping_data_last_name != '') {
        $name_parts[] = $row->shipping_data_last_name;
      }
      $row->user_name = implode(' ', $name_parts);
      $row->user_view_url = '';
    }
    
		$row->view_payment_data = WDFHelperFunctions::object_to_array(WDFJson::decode($row->payment_data));
    global $wpdb;
    $row->payment_method_name = $wpdb->get_var($wpdb->prepare('SELECT `name` FROM `' . $wpdb->prefix . 'ecommercewd_payments` WHERE `short_name`="%s"', $row->payment_method));
    $row->view_payment_data_url = add_query_arg(array('action' => 'wde_ajax', 'page' => 'wde_orders', 'task' => 'paymentdata', 'cid[]' => $row->id, 'TB_iframe' => 1), admin_url('admin-ajax.php'));
    return $row;
  }

  public function get_rows() {
    $orders = parent::get_rows();
    // products data and total
    $order_rows = array();
    foreach ($orders as $order) {
      $row = WDFHelper::get_order($order->id);
      
      $row->view_url = add_query_arg(array('page' => 'wde_orders', 'task' => 'view', 'cid[]' => $order->id), admin_url('admin.php'));
      $row->edit_url = add_query_arg(array('page' => 'wde_orders', 'task' => 'edit', 'cid[]' => $order->id), admin_url('admin.php'));
      $row->print_url = add_query_arg(array('action' => 'wde_ajax', 'page' => 'wde_orders', 'task' => 'printorder', 'id' => $order->id), admin_url('admin-ajax.php'));
      $row->order_products = $row->product_rows;
      $product_names = array();
      foreach ($row->order_products as $order_product) {
        $product_names[] = $order_product->product_name . ' x' . $order_product->product_count;
      }

      $row->product_names = implode('<br>', $product_names);
      // payment status
      $row->payment_data_status = $row->payment_data_status == '' ? '-' : $row->payment_data_status;

			// view payment data url
			$row->view_payment_data_url = add_query_arg(array('action' => 'wde_ajax', 'page' => 'wde_orders', 'task' => 'paymentdata', 'cid[]' => $row->id, 'TB_iframe' => 1), admin_url('admin-ajax.php'));
      // user data
      $wp_user = get_userdata($row->j_user_id);
      $j_user = new stdClass();
      $j_user->id = $row->j_user_id;
      $j_user->name = $wp_user ? $wp_user->display_name : '';
      $row_user = get_userdata($j_user->id);
      $row->user_id = $row_user->ID;
      if ($row_user->ID != 0) {
        $row->user_name = $row_user->display_name;
        $row->user_view_url = get_edit_user_link($row_user->ID);
        $row->user_email = $row_user->user_email;
      } else if ($j_user->id != 0) {
        $row->user_name = $j_user->name;
        $row->user_view_url = '';
        $row->user_email = '';
      } else {
        $name_parts = array();
        if ($row->shipping_data_first_name != '') {
          $name_parts[] = $row->shipping_data_first_name;
        }
        if ($row->shipping_data_middle_name != '') {
          $name_parts[] = $row->shipping_data_middle_name;
        }
        if ($row->shipping_data_last_name != '') {
          $name_parts[] = $row->shipping_data_last_name;
        }
        $row->user_name = implode(' ', $name_parts);
        $row->user_view_url = '';
        $row->user_email = '';
      }
      $order_rows[] = $row;
    }
    return $order_rows;
  }

  public function get_lists() {
    $lists = array();
    $lists['order_statuses'] = WDFDb::get_list('orderstatuses', 'id', 'name', array(" published = '1' "), 'ordering ASC');
		$lists['payment_methods'] = WDFDb::get_list('payments', 'short_name', 'name', array(), 'ordering ASC');
    return $lists;
  }

  protected function init_rows_filters() {
    $filter_items = array();

    // checkout date from
    $filter_item = new stdClass();
    $filter_item->type = 'string';
    $filter_item->name = 'checkout_date_from';
    $filter_item->default_value = null;
    $filter_item->operator = '>=';
    $filter_item->input_type = 'date';
    $filter_item->input_label = __('Date from', 'wde');
    $filter_item->input_name = 'search_checkout_date_from';
    $filter_items[$filter_item->name] = $filter_item;

    // checkout date to
    $filter_item = new stdClass();
    $filter_item->type = 'string';
    $filter_item->name = 'checkout_date_to';
    $filter_item->default_value = null;
    $filter_item->operator = '<=';
    $filter_item->input_type = 'date';
    $filter_item->input_label = __('Date to', 'wde');
    $filter_item->input_name = 'search_checkout_date_to';
    $filter_items[$filter_item->name] = $filter_item;
		// payment data
    $filter_item = new stdClass();
    $filter_item->type = 'string';
    $filter_item->name = 'payment_data';
    $filter_item->default_value = null;
    $filter_item->operator = 'LIKE';
    $filter_item->input_type = 'text';
    $filter_item->input_label = __('Payment data', 'wde');
    $filter_item->input_name = 'search_payment_data';
    $filter_items[$filter_item->name] = $filter_item;

    $this->rows_filter_items = $filter_items;

    parent::init_rows_filters();
  }

  protected function add_rows_query_select($query = '') {
    $query = 'SELECT ' . $this->current_table_name . '.*';
    $query .= ', T_USERS.display_name AS user_name';
    return $query;
  }

  protected function add_rows_query_from() {
    global $wpdb;
    $query = ' FROM ' . $this->current_table_name;
    $query .= ' LEFT JOIN ' . $wpdb->prefix . 'users AS T_USERS ON ' . $wpdb->prefix . 'ecommercewd_orders.j_user_id = T_USERS.ID';
    $query .= ' LEFT JOIN ' . $wpdb->prefix . 'ecommercewd_orderproducts AS T_ORDER_PRODUCTS ON T_ORDER_PRODUCTS.order_id = ' . $wpdb->prefix . 'ecommercewd_orders.id';
    return $query;
  }

  private function get_order_products($order_id) {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options_row();

    $decimals = $options->option_show_decimals == 1 ? 2 : 0;

    global $wpdb;
    $query = 'SELECT product_name, product_price, tax_price, shipping_method_price, product_count, currency_code';
    $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_orderproducts';
    $query .= ' WHERE order_id = ' . $order_id;
    $order_product_rows = $wpdb->get_results($query);

    // additional data
    foreach ($order_product_rows as $row) {
      // prices
      $row->product_price = doubleval($row->product_price);
      $row->tax_price = doubleval($row->tax_price);
      $row->shipping_method_price = doubleval($row->shipping_method_price);
      $row->product_count = intval($row->product_count);
      $row->subtotal = ($row->product_price + $row->tax_price) * $row->product_count + $row->shipping_method_price;

      //price texts
      $row->product_price_text = WDFText::wde_number_format($row->product_price, $decimals) . $row->currency_code;
      $row->tax_price_text = WDFText::wde_number_format($row->tax_price, $decimals) . $row->currency_code;
      $row->shipping_method_price_text = WDFText::wde_number_format($row->shipping_method_price, $decimals) . $row->currency_code;
      $row->subtotal_text = WDFText::wde_number_format($row->subtotal, $decimals) . $row->currency_code;
    }

    return $order_product_rows;
  }
}