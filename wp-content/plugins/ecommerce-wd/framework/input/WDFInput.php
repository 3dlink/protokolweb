<?php

class WDFInput {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private static $input;

  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  /**
   * Gets a value from the input data.
   *
   * @param    string $name Name of the value to get.
   * @param    mixed $default Default value to return if variable does not exist.
   * @param    string $filter Filter to apply to the value.
   *
   * @return    mixed   The filtered input value.
   */
  public static function get($name, $default = null, $filter = 'string') {
    $ret_val = isset($_REQUEST[$name]) ? $_REQUEST[$name] : FALSE;
    // $ret_val = 'edit';
    if ($ret_val !== FALSE) {
      if (is_array($ret_val)) {
        foreach ($ret_val as $key => $ret) {
          // $ret_val[$key] = htmlentities(stripslashes($ret));
          $ret_val[$key] = esc_attr(stripslashes($ret));
        }
      }
      else {
        // $ret_val = htmlentities(stripslashes($ret_val));
        $ret_val = esc_attr(stripslashes($ret_val));
      }
      return $ret_val;
    }
    else {
      return $default;
    }
    // return self::get_input()->get($name, $default, $filter);
  }

  /**
   * Sets a value in the input data.
   *
   * @param    string $name Name of the value to set.
   * @param    mixed $value Value to assign to the input.
   *
   * @return    void
   */
  public static function set($name, $value) {
      $_REQUEST[$name] = $value;
      // self::get_input()->set($name, $value);
  }

  /**
   * Gets input data as String Object, explodes it by delimiter and returns it.
   *
   * @param    string $name Name of the value to get.
   * @param    string $delimiter Delimiter by which string must be splited.
   *
   * @return    array
   */
  public static function get_array($name, $delimiter = ',', $default = array(), $trim = false, $exclude_empty = false) {
    $input_string = self::get($name, '', 'string');
    if ($input_string == '') {
      $input_array = $default;
    }
    else {
      $input_array = explode($delimiter, $input_string);
      if ($trim == true) {
        for ($i = 0; $i < count($input_array); $i++) {
            $input_array[$i] = trim($input_array[$i]);
        }
      }
      if ($exclude_empty == true) {
        for ($i = count($input_array) - 1; $i >= 0; $i--) {
          if ($input_array[$i] == '') {
            unset($input_array[$i]);
            $input_array = array_values($input_array);
          }
        }
      }
    }
    return $input_array;
  }

  /**
   * Gets input data as json string, parses it and return object.
   *
   * @param    string $name Name of the value to get.
   * @param    mixed $default Default value to return if variable does not exist.
   *
   * @return    stdClass
   */
  public static function get_parsed_json($name, $default = null) {
    $input_str = self::get($name, $default, 'string');
    if (is_string($input_str)) {
      try {
        return WDFJson::decode(self::get($name, $default, 'string'));
      } catch (Exception $exception) {
        return null;
      }
    }
    return null;
  }

  /**
   * Gets the value of controller input.
   *
   * @param    mixed $default Default value to return if variable does not exist.
   *
   * @return    string   The controller string.
   */
  public static function get_controller($default = null) {
    $cur_page = '';
    if (is_admin()) {
      $cur_page = get_current_screen();
    }
    $page = self::get('page');
    if ($cur_page) {
      if ($cur_page->taxonomy) {
        $page = $cur_page->taxonomy;
      }
      elseif ($cur_page->post_type) {
        $page = $cur_page->post_type;
      }
      elseif ($cur_page->base == "profile" || $cur_page->base == "user-edit") {
        $page = "wde_users";
      }
    }
    $controller = substr($page, 4);
    return $controller;
  }

  /**
   * Gets the value of task input.
   *
   * @return    string   The task string.
   */
  public static function get_task($task_name = 'task') {
    $page = '';
    if (is_admin()) {
      $page = get_current_screen();
    }
    if (!$page || (!$page->post_type && !$page->taxonomy)) {
      $task = self::get($task_name);
    }
    else {
      $task = 'edit';
    }
    return $task;
  }

  /**
   * return if selected all items.
   *
   * @return boolean(true or false).
   */

  public static function isset_request( $name ) {
    return isset( $_REQUEST[$name] ) && $_REQUEST[$name] == 1 ? true : false;
  }

  /**
   * Gets all orders ids.
   *
   * @return   array of db.
   */

  public static function get_all_id( $table_name ) {
    global $wpdb;
    $table = $wpdb->prefix . $table_name;
    $ids_query = $wpdb->get_results( "SELECT `id` FROM $table", ARRAY_A );
    if ( !empty( $ids_query ) ) {
      $return_arr = array();
      foreach ( $ids_query as $key => $value ) {
        if ( !empty( $value['id'] ) ) {
          array_push( $return_arr, $value['id'] );
        }
      }
    }
    else {
      $return_arr = array();
    }
    return $return_arr;
  }

  /**
   * Gets the array of checked fields ids.
   *
   * @return    array   Array of checked ids.
   */
  public static function get_checked_ids() {
    if ( self::isset_request( 'select_all_orders' ) === true ) {
      $cids = self::get_all_id( 'ecommercewd_orders' );   
    }
    else {
      $cids = self::get('cid', array(), 'array');
    }   
    return $cids;
  }
  /**
   * Gets the value of the first checked field id.
   *
   * @return    string   Checked field id.
   */
  public static function get_checked_id() {
    $cids = self::get_checked_ids();
    return count($cids) > 0 ? $cids[0] : null;
  }

  /**
   * Gets the array of row orders.
   *
   * @return    array   Array of row orders.
   */
  public static function get_orders() {
    $orders = self::get('order', array(), 'array');
    $orders = WDFArrayUtils::to_integer($orders);
    return $orders;
  }

  /**
   * Set cookie.
   *
   * @param mixed $key key.
   * @param mixed $value value.
   * @param mixed $expire expire time.
   * @param boolean $add_prefix add component name as prefix to get unique key.
   */
  public static function cookie_set($key, $value, $expire = null, $use_prefix = true) {
    if ($use_prefix == true) {
      $key = WDFHelper::get_com_name() . '_' . $key;
    }
    self::cookie_unset($key);
    setcookie($key, $value, $expire, '/');
    $_COOKIE[$key] = $value;
  }

  /**
   * Get cookie.
   *
   * @param mixed $key key.
   * @param mixed $default default value if cookie isn't set.
   * @param boolean $add_prefix add component name as prefix to get unique key.
   */
  public static function cookie_get($key, $default = null, $use_prefix = true) {
    if ($use_prefix == true) {
      $key = WDFHelper::get_com_name() . '_' . $key;
    }
    return (isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default);
  }

  /**
   * Unset cookie.
   *
   * @param mixed $key key.
   * @param boolean $add_prefix add component name as prefix to get unique key.
   */
  public static function cookie_unset($key, $use_prefix = true) {
    if ($use_prefix == true) {
      $key = WDFHelper::get_com_name() . '_' . $key;
    }
    setcookie($key, '', time() - 1, '/');
    unset($_COOKIE[$key]);
  }
  /**
   * Store array in cookies.
   *
   * @param mixed $key key.
   * @param mixed $value value.
   * @param mixed $expire expire time.
   * @param boolean $add_prefix add component name as prefix to get unique key.
   */
  public static function cookie_set_array($key, $value, $expire = null, $use_prefix = true) {
    $value = WDFJson::encode($value, 256);
    self::cookie_set($key, $value, $expire, $use_prefix);
  }

  /**
   * Get stored array from cookies.
   *
   * @param mixed $key key.
   * @param array $default default value if cookie isn't set.
   * @param boolean $add_prefix add component name as prefix to get unique key.
   */
  public static function cookie_get_array($key, $default = array(), $use_prefix = true) {
    $default = WDFJson::encode($default);
    $array_json = self::cookie_get($key, $default, $use_prefix);
    $array_json = stripslashes($array_json);
    return WDFJson::decode($array_json);
  }
}