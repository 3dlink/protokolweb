<?php

defined('ABSPATH') || die('Access Denied');

class WDFCookie {
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
    if (isset($_COOKIE[$full_key])) {
      return $_COOKIE[$full_key];
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
    $_COOKIE[$key] = $value;
  }

  public static function clear($key, $use_controller = true, $use_task = true) {
    if (isset($_COOKIE[$key])) {
      $_COOKIE[$key] = NULL;
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
    if (isset($_COOKIE[$full_key])) {
      $_COOKIE[$full_key] = NULL;
    }
  }
}