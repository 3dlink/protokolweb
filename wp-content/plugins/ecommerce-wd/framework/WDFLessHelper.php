<?php

 

 //defined('ABSPATH') || die('Access Denied');

class WDFLessHelper {
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
     * Create new css file with prefix added to selectors.
     *
     * @param    string $file_name file full path.
     * @param    string $new_file_name new file full path.
     * @param    string $prefixes string to prefix selectors with.
     * @param    boolean $is_class is prefix class or id.
     */
    public static function add_selector_prefix($file_name, $new_file_name, $prefixes, $is_class = false) {
        if (strrpos($file_name, '.css') == (strlen($file_name) - 4)) {
            $file_name_parts = str_split($file_name, strlen($file_name) - 4);
            $file_name_less = $file_name_parts[0] . '.less';
        } else {
            $file_name_less = $file_name . '.less';
        }

        $str_start = '';
        $str_end = '';
        $prefix_symbol = $is_class == false ? '#' : '.';
        if (is_array($prefixes)) {
            for ($i = 0; $i < count($prefixes); $i++) {
                $str_start .= $prefix_symbol . $prefixes[$i] . ' {';
                $str_end .= '}';
            }
        } else {
            $str_start = $prefix_symbol . $prefixes . ' {';
            $str_end = '}';
        }

        $file_content = file_get_contents($file_name);
        $file_content_less = $str_start . $file_content . $str_end;
        file_put_contents($file_name_less, $file_content_less);

        $less = new lessc();
        $less->checkedCompile($file_name_less, $new_file_name);
        unlink($file_name_less);
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