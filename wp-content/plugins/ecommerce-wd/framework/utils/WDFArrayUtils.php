<?php

defined('ABSPATH') || die('Access Denied');


class WDFArrayUtils {
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
     * Convert array elements to integer.
     *
     * @param Array $array array to convert
     * @param Array $default default value
     *
     * @return array of converted elements
     */
    public static function to_integer($array, $default = null) {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = (int)$value;
            }
        } else {
            if ($default === null) {
                $array = array();
            } elseif (is_array($default)) {
                $default = WDFArrayUtils::to_integer($default, null);
                $array = $default;
            } else {
                $array = array((int)$default);
            }
        }

        return $array;
    }

    /**
     * Convert array keys to integer.
     *
     * @param Array $array array to convert
     * @param Array $default default value
     *
     * @return array with converted keys
     */
    public static function keys_to_integer($array, $default = null) {
        $converted_array = array();

        if ((is_array($array)) || is_object($array)) {
            foreach ($array as $key => $value) {
                $converted_array[intval($key)] = $value;
            }
        } else {
            if ($default !== null) {
                if (is_array($default)) {
                    $default = WDFArrayUtils::keys_to_integer($default, null);
                    $converted_array = $default;
                } else {
                    $converted_array[] = $default;
                }
            }
        }

        return $converted_array;
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