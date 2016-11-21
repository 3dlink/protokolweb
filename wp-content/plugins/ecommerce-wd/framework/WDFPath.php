<?php
 
//defined('ABSPATH') || die('Access Denied');


class WDFPath {
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
     * The component administrator path.
     *
     * @var    string
     */
    private static $com_admin_path;

    /**
     * The component site path.
     *
     * @var    string
     */
    private static $com_site_path;

    /**
     * Framework path.
     *
     * @var    string
     */
    private static $framework_path;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Normaize path (Replace / and \ with DS, removes multiple separators).
     *
     * @return    string    normalized path
     */
    public static function normalize_path($path) {
        $path = str_replace('/', DS, $path);
        $path = str_replace('\\', DS, $path);
        while (strpos($path, DS . DS) !== false) {
            $path = str_replace(DS . DS, DS, $path);
        }

        return $path;
    }

    /**
     * Get component admin part path.
     *
     * @return    string    component admin part path
     */
    public static function get_com_admin_path($relative_path) {
        if (isset(self::$com_admin_path) == false) {
            self::$com_admin_path = WD_E_DIR;
        }
        return self::$com_admin_path . ($relative_path ? DS . $relative_path : '');
    }

    /**
     * Get component site part path.
     *
     * @return    string    component site part path
     */
    public static function get_com_site_path() {
        if (isset(self::$com_site_path) == false) {
            self::$com_site_path = WD_E_DIR . '/frontend';
        }
        return self::$com_site_path;
    }

    /**
     * Get component admin path if user is in admin part and site path if user is in site part.
     *
     * @return    string    component path
     */
    public static function get_com_path($relative_path = '', $is_frontend_ajax = false) {
        return is_admin() && !$is_frontend_ajax ? self::get_com_admin_path($relative_path) : self::get_com_site_path();
    }

    /**
     * Get framework folder path
     *
     * @return    string    path of framework folder
     */
    public static function get_framework_path() {
        if (isset(self::$framework_path) == false) {
            self::$framework_path = self::normalize_path(self::$com_admin_path . DS . 'framework');
        }
        return self::$framework_path;
    }
    
    /**
     * Get pretty url
     *
     * @return    string    pretty url with arguments
     */
    public static function add_pretty_query_args($url, $argument, $value, $include_value = FALSE) {
      if (strpos($url, '?') !== FALSE) {
        return add_query_arg($argument, $value, $url);
      }
      else {
        return trailingslashit($url) . $argument . ($include_value ? '/' . $value : '');
      }
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