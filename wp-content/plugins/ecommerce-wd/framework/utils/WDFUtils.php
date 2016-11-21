<?php
 
defined('ABSPATH') || die('Access Denied');


class WDFUtils {
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
    /**
     * get client ip address
     *
     * @return    string    ip address
     */
    public static function get_client_ip_address() {
        $ip_address = 'unknown';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ip_address = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
		
        return $ip_address;
    }


    /**
     * get bytes from notations like 2M
     *
     * @return    int    bytes
     */
    public static function get_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
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