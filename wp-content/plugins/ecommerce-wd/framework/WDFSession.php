<?php

defined('ABSPATH') || die('Access Denied');

class WDFSession {
  
  public static function get($key, $default = null, $type = 'none', $use_input = true, $use_controller = true, $use_task = true) {        
    $key_parts = array();
    $key_parts[] = 'com_' . WDFHelper::get_com_name();
    $controller = WDFInput::get_controller();
    if (($use_controller == true) && ($controller != '')) {
      $key_parts[] = $controller;
    }
    $task = WDFInput::get_task();
    if (($use_task == true) && ($task != '')) {
      $key_parts[] = $task;
    }
    $key_parts[] = $key;
    $full_key = implode('.', $key_parts);
    if ($use_input == true) {            
      return self::getUserStateFromRequest($full_key, $key, $default, $type);
    }
    else {
      return self::getUserState($full_key, $default);
    }
  }

  public static function getUserState($full_key, $default) {
    if (isset($_SESSION[$full_key])) {
      return $_SESSION[$full_key];
    }
    return $default;
  }

  public static function getUserStateFromRequest($full_key, $key, $default, $type) {
    $old_state = self::getUserState($full_key, $default);
    $cur_state = (!is_null($old_state)) ? $old_state : $default;
    $new_state = WDFInput::get($key, null, $type);
    // Save the new value only if it was set in this request.
    if ($new_state !== null) {
      self::setUserState($full_key, $new_state);
    }
    else {
      $new_state = $cur_state;
    }
    return $new_state;
  }

  public static function setUserState($key, $value) {
    $_SESSION[$key] = $value;
  }

  public static function clear($key, $use_controller = true, $use_task = true) {
    // self::set($key, null, $use_controller, $use_task);
    if (isset($_SESSION[$key])) {
      $_SESSION[$key] = NULL;
    }
    $key_parts = array();
    $key_parts[] = 'com_' . WDFHelper::get_com_name();
    $controller = WDFInput::get_controller();
    if (($use_controller == true) && ($controller != '')) {
      $key_parts[] = $controller;
    }
    $task = WDFInput::get_task();
    if (($use_task == true) && ($task != '')) {
      $key_parts[] = $task;
    }
    $key_parts[] = $key;
    $full_key = implode('.', $key_parts);
    if (isset($_SESSION[$full_key])) {
      $_SESSION[$full_key] = NULL;
    }
  }

  /**
   * Gets the limit of pagination.
   *
   * @return    int    Pagination limit.
   */
  public static function get_pagination_limit() {
      return 20;
  }

  /**
   * Gets the start of pagination.
   *
   * @return    int    Pagination start.
   */
  public static function get_pagination_start() {
      return self::get('page_number', 1, 'int');
  }
}