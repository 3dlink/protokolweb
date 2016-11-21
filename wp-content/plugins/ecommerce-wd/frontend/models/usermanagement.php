<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdModelUsermanagement extends EcommercewdModel {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  public function get_user_data() {
    // if user entered wrong data, return user entered data, else return data from db
    $has_errors = isset($_SESSION['wde_invalid_fields']) && $_SESSION['wde_invalid_fields'] ? true : false;
    $j_user = wp_get_current_user();
    $user_data = array();
    if ($has_errors == true) {
      $user_data = isset($_SESSION['wde_return_key_values']) ? $_SESSION['wde_return_key_values'] : array();
    } else {
      $user_data = WDFDb::get_user_meta_fields_list($j_user->ID);
    }
    return $user_data;
  }
  
  public function get_user_data_view() {
    $j_user = wp_get_current_user();
    $user_data = WDFDb::get_user_meta_fields_list($j_user->ID, true);
    
    return $user_data;
  }

  public function get_user_data_form_fields() {
    $invalid_fields = isset($_SESSION['wde_invalid_fields']) ? $_SESSION['wde_invalid_fields'] : array();

    $form_fields = WDFDb::get_user_meta_fields_list();
    
    foreach ($form_fields["billing_fields_list"] as $i => $form_field) {
      $form_fields["billing_fields_list"][$i]['has_error'] = in_array($form_field["id"], $invalid_fields);
    }
    
    foreach ($form_fields["shipping_fields_list"] as $i => $form_field) {
      $form_fields["shipping_fields_list"][$i]['has_error'] = in_array($form_field["id"], $invalid_fields);
    }

    return $form_fields;
  }

  public function get_current_user_row() {
    global $wpdb;

    $row_user = new stdClass();
    $row_user->name = '';
    $row_user->email = '';
    $row_user->j_user_id = 0;
    
    if (is_user_logged_in()) {
      $j_user = wp_get_current_user();
      $row_user->name = $j_user->display_name;
      $row_user->j_user_id = $j_user->ID;
      $row_user->email = $j_user->user_email;
    }

    // additional data
    // products in cart
    
    
    $query = 'SELECT COUNT(*)';
    $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_orderproducts';
    $query .= ' WHERE order_id = 0';
    
    if (is_user_logged_in()) {
      $query .= ' AND j_user_id = ' . $j_user->ID;
    } else {
      $user_order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids');
      if (empty($user_order_product_rand_ids) == false) {
        $query .= ' AND j_user_id = 0';
        $query .= ' AND rand_id IN (' . implode(',', $user_order_product_rand_ids) . ')';
      } else {
        $query .= ' AND 0';
      }
    }

    $row_user->products_in_cart = $wpdb->get_var($query);

    if ($wpdb->last_error) {
        echo $wpdb->last_error;
        die();
    }

    return $row_user;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}