<?php

class WDFUrl {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  /**
   * Administrator url.
   *
   * @var    string
   */
  private static $admin_url;

  /**
   * Site url.
   *
   * @var    string
   */
  private static $site_url;

  /**
   * The component administrator url.
   *
   * @var    string
   */
  private static $com_admin_relative_url;

  /**
   * The component site url.
   *
   * @var    string
   */
  private static $com_site_relative_url;


  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  /**
   * Normaize url (Replace \ with /).
   *
   * @return    string    normalized path
   */
  public static function normalize_url($url) {
      $url = str_replace('\\', '/', $url);
      return $url;
  }


  /**
   * Get admin part url.
   *
   * @return    string    admin part url
   */
  public static function get_admin_url($relative = false) {
    return admin_url();
  }

  /**
   * Get site part url.
   *
   * @return    string    site part url
   */
  public static function get_site_url($relative = false) {
      // if (isset(self::$site_url) == false) {
          // self::$site_url = self::normalize_url(site_url()/*JURI::root($relative)*/);
      // }
      // return self::$site_url;
      return home_url();
  }

  /**
   * Get component admin part url.
   *
   * @return    string    component admin part url
   */
  public static function get_com_admin_url($relative = false) {
      if (isset(self::$com_admin_relative_url) == false) {
          self::$com_admin_relative_url = self::normalize_url(str_replace(site_url(), '', WD_E_URL /*plugins_url(plugin_basename(dirname(__FILE__)))*/));
      }
      return $relative == true ? self::$com_admin_relative_url : WD_E_URL;
  }

  /**
   * Get component site part url.
   *
   * @return    string    component site part url
   */
  public static function get_com_site_url($relative = false) {
      if (isset(self::$com_site_relative_url) == false) {
          self::$com_site_relative_url = self::normalize_url('components/com_' . WDFHelper::get_com_name());
      }
      return $relative == true ? self::$com_site_relative_url : self::get_site_url() . '/' . self::$com_site_relative_url;
  }

  /**
   * Get component admin part url if user is in admin part or site part if user is in site part.
   *
   * @return    string    component url
   */
  public static function get_com_url($relative = false) {
      return is_admin() ? self::get_com_admin_url() : self::get_com_site_url();
  }

  /**
   * Get referer page url.
   *
   * @return    string    referer page url
   */
  public static function get_referer_url() {
      if (isset($_SERVER['HTTP_REFERER'])) {
          return ($_SERVER['HTTP_REFERER']);
      }
      return '';
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