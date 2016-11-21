<?php

defined('ABSPATH') || die('Access Denied');


class WDFTextUtils {
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
     * Add chars(spaces) from beginning of the string
     *
     * @param    $str    string    string to modify
     * @param    $count    int    chars count to add
     * @param    $char    string    chars to add
     *
     * @return    string    result string
     */
    public static function indent_string($str, $count = 1, $char = ' ') {
        while ($count-- > 0) {
            $str = $char . $str;
        }
        return $str;
    }

    /**
     * Remove spaces
     *
     * @param    $str    string    string to modify
     *
     * @return    string    result string
     */
    public static function remove_spaces($str) {
        return str_replace(' ', '', $str);
    }

    /**
     * Remove new line chars from string
     *
     * @param    $str    string    string to modify
     *
     * @return    string    result string
     */
    public static function remove_new_line_chars($str) {
        $str = str_replace('\r', '', $str);
        $str = str_replace('\n', '', $str);
        return $str;
    }

    /**
     * Remove space chars between html tags
     *
     * @param    $html    string    html string to modify
     *
     * @return    string    result string
     */
    public static function remove_html_spaces($html) {
        return preg_replace('~>\s+<~', '><', $html);
    }

    /**
     * Truncate string.
     *
     * @param string $string string to truncate
     * @param int $max_length maximum length of result string
     *
     * @return string truncated string
     */
    public static function truncate($string, $max_length) {
        if (strlen($string) > $max_length) {
            $string = substr($string, 0, $max_length - 3) . '...';
        }
        return $string;
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