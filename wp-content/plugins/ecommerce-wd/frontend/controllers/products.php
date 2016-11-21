<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerProducts extends EcommercewdController {
  
  public function displayproducts($params) {
    parent::display($params);
  }

  public function displayproduct($params) {
    parent::display($params);
  }

  public function displayproductreviews() {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();

    if ($options->feedback_enable_product_reviews == 0) {
      $product_id = WDFInput::get('product_id', 0, 'int');

      wp_redirect(get_permalink($product_id));
      exit;
    }
    parent::display();
  }

  public function displaycompareproducts($params) {
    parent::display($params);
  }

  public function ajax_getquickviewproductrow() {
    WDFInput::set('tmpl', 'component');

    $model = WDFHelper::get_model('products', true);
    $product_row = $model->get_quick_view_product_row();
    if ($product_row === false) {
        $product_row = null;
    }

    echo WDFJson::encode($product_row);
    die();
  }

  public function ajax_rate_product() {
    global $wpdb;
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();

    $j_user_id = get_current_user_id();
    $product_id = get_the_ID();

    $rating_data = WDFJson::decode(stripslashes(WDFInput::get('rating_data_json')));
    $rating = (float) $rating_data->rating;
    $user_ip_address = WDFUtils::get_client_ip_address();
    $msg = '';

    // check privileges
    $can_rate = true;
    if (/*($options->feedback_enable_guest_feedback == 0) && */(!is_user_logged_in())) {
      $can_rate = false;
      $msg = __('Login to rate', 'wde');
    }
    else {
      $query = 'SELECT id FROM ' . $wpdb->prefix . 'ecommercewd_ratings';
      if (is_user_logged_in()) {
        $query .= ' WHERE j_user_id = ' . $j_user_id;
      }
      else {
        $query .= ' WHERE user_ip_addressj_user_id = "' . $user_ip_address . '"';
      }
      $query .= ' AND product_id = ' . $product_id;
      $rating_rows = $wpdb->get_results($query);

      if ($wpdb->last_error) {
        $can_rate = false;
        $msg = __('Failed to rate', 'wde');
      }

      if (($rating_rows != null) && (count($rating_rows) > 0)) {
        $can_rate = false;
        $msg =  __('You have already rated this product', 'wde') ;
      }
    }
    if ($can_rate == true) {
        // save rating
        $save = $wpdb->insert($wpdb->prefix . 'ecommercewd_ratings', array(			
          'j_user_id' => $j_user_id,
          'user_ip_address' => $user_ip_address,
          'product_id' => $product_id,
          'rating' => $rating,
          'date' => date('Y-m-d H:i:s')
        ));

        if ($save === FALSE) {
          $msg = __('Failed to rate', 'wde');
        }
        else {
          $msg = __('Successfully rated', 'wde') ;
        }
    }
    // get average rating
    $query = 'SELECT FORMAT(AVG(rating), 1) FROM ' . $wpdb->prefix . 'ecommercewd_ratings WHERE product_id = ' . $product_id;
    $average_rating = $wpdb->get_var($query);
    update_post_meta($product_id, 'wde_rating', $average_rating);

    // return data
    $data = array();
    $data['msg'] = $msg;
    $data['rating'] = $average_rating;
    echo WDFJson::encode($data);
    die();
  }

  public function ajax_getcompareproductrow($params) {
    // WDFInput::set('tmpl', 'component');
    $model = WDFHelper::get_model('products');
    $product_row = $model->get_product_view_product_row($params);
    echo WDFJson::encode($product_row);
    die();
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