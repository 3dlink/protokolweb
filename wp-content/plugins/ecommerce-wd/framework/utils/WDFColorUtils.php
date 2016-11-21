<?php

defined('ABSPATH') || die('Access Denied');


class WDFColorUtils {
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
     * Convert various color format to RGBA array.
     *
     * @param mixed $color Color value (array, string or integer)
     *
     * @return array RGBA array or FALSE on failure
     */
    public static function color_to_rgba($color, $return_string = false) {
        $color_rgba = null;
        if (is_array($color)) {
            if (isset($color['r']) && isset($color['g']) && isset($color['b'])) {
                $color['a'] = isset($color['a']) ? $color['a'] : 1;
                $color_rgba = $color;
            } elseif (isset($color['h']) && isset($color['s']) && isset($color['b'])) {
                return self::hsb_to_rgba($color);
            } elseif (isset($color[0]) && isset($color[1]) && isset($color[2])) {
                $color[3] = isset($color[3]) ? $color[3] : 1;
                $color_rgba = array('r' => $color[0], 'g' => $color[1], 'b' => $color[2], 'a' => $color[3]);
            }
        } else if (is_string($color)) {
            $regex = '/^[#|]?([a-f0-9]{2})?([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/i';
            if (preg_match($regex, $color, $matches)) {
                $color_rgba = array('r' => hexdec($matches[2]), 'g' => hexdec($matches[3]), 'b' => hexdec($matches[4]), 'a' => !empty($matches[1]) ? hexdec($matches[1]) : 1);
            }
        } elseif (is_int($color)) {
            $color_rgba = array('r' => ($color >> 16) & 0xff, 'g' => ($color >> 8) & 0xff, 'b' => ($color >> 0) & 0xff, 'a' => ($color >> 24) & 0xff);
        }

        if ($color_rgba != null) {
            return $return_string == false ? $color_rgba : 'rgba(' . $color_rgba['r'] . ', ' . $color_rgba['g'] . ', ' . $color_rgba['b'] . ', ' . $color_rgba['a'] . ')';
        }

        return false;
    }

    /**
     * Convert various color format to hex string.
     *
     * @param mixed $color Color value (array, string or integer)
     * @param boolean $ignore_alpha ignore alpha part
     *
     * @return string hex string or FALSE on failure
     */
    public static function color_to_hex($color, $ignore_alpha = true) {
        $color_rgba = self::color_to_rgba($color);
        if ($color_rgba == false) {
            return false;
        }

        $color_hex = '#' . str_pad(dechex($color_rgba['r']), 2, '0', STR_PAD_LEFT) . str_pad(dechex($color_rgba['g']), 2, '0', STR_PAD_LEFT) . str_pad(dechex($color_rgba['b']), 2, '0', STR_PAD_LEFT);
        if ($ignore_alpha == false) {
            $color_hex .= dechex($color_rgba['a']);
        }

        return $color_hex;
    }

    /**
     * Convert various color format to hsb string.
     *
     * @param mixed $color Color value (array, string or integer)
     *
     * @return array hex string or FALSE on failure
     */
    public static function color_to_hsba($color) {
        $color_rgba = self::color_to_rgba($color);
        if ($color_rgba == false) {
            return false;
        }

        $min = min($color_rgba['r'], $color_rgba['g'], $color_rgba['b']);
        $max = max($color_rgba['r'], $color_rgba['g'], $color_rgba['b']);
        $delta = $max - $min;

        $color_hsb = array('h' => 0, 's' => 0, 'b' => 0);
        $color_hsb['b'] = $max;
        $color_hsb['s'] = $max != 0 ? 255 * $delta / $max : 0;
        if ($color_hsb['s'] != 0) {
            if ($color_rgba['r'] == $max) {
                $color_hsb['h'] = ($color_rgba['g'] - $color_rgba['b']) / $delta;
            } elseif ($color_rgba['g'] == $max) {
                $color_hsb['h'] = 2 + ($color_rgba['b'] - $color_rgba['r']) / $delta;
            } else {
                $color_hsb['h'] = 4 + ($color_rgba['r'] - $color_rgba['g']) / $delta;
            }
        } else {
            $color_hsb['h'] = 0;
        }
        $color_hsb['h'] *= 60;
        if ($color_hsb['h'] < 0) {
            $color_hsb['h'] += 360;
        }
        $color_hsb['h'] = round($color_hsb['h']);
        $color_hsb['s'] = round($color_hsb['s'] * 100 / 255);
        $color_hsb['b'] = round($color_hsb['b'] * 100 / 255);
        $color_hsb['a'] = $color_rgba['a'];
        return $color_hsb;
    }

    /**
     * Increase color brightness.
     *
     * @param mixed $color Color value (array, string or integer)
     * @param mixed $percent percent to adjust brightness (-100 to 100)
     *
     * @return string hex string or FALSE on failure
     */
    public static function adjust_brightness($color, $percent) {
        $color_hsba = self::color_to_hsba($color);
        if ($color_hsba == false) {
            return false;
        }

        $color_hsba['b'] = max(0, min(100, $color_hsba['b'] + $percent));

        $color_hex = self::color_to_hex($color_hsba, true);
        return $color_hex;
    }

    /**
     * Increase color saturation.
     *
     * @param mixed $color Color value (array, string or integer)
     * @param mixed $percent percent to adjust saturation (-100 to 100)
     *
     * @return string hex string or FALSE on failure
     */
    public static function adjust_saturation($color, $percent) {
        $color_hsba = self::color_to_hsba($color);
        if ($color_hsba == false) {
            return false;
        }

        $color_hsba['s'] = max(0, min(100, $color_hsba['s'] + $percent));

        $color_hex = self::color_to_hex($color_hsba, false);
        return $color_hex;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private static function hsb_to_rgba($color_hsb) {
        $color_rgb = array();

        $h = round($color_hsb['h']);
        $s = round($color_hsb['s'] * 255 / 100);
        $v = round($color_hsb['b'] * 255 / 100);
        if ($s == 0) {
            $color_rgb['r'] = $color_rgb['g'] = $color_rgb['b'] = $v;
        } else {
            $t1 = $v;
            $t2 = (255 - $s) * $v / 255;
            $t3 = ($t1 - $t2) * ($h % 60) / 60;
            if ($h == 360) {
                $h = 0;
            }
            if ($h < 60) {
                $color_rgb['r'] = $t1;
                $color_rgb['g'] = $t2 + $t3;
                $color_rgb['b'] = $t2;
            } elseif ($h < 120) {
                $color_rgb['r'] = $t1 - $t3;
                $color_rgb['g'] = $t1;
                $color_rgb['b'] = $t2;
            } elseif ($h < 180) {
                $color_rgb['r'] = $t2;
                $color_rgb['g'] = $t1;
                $color_rgb['b'] = $t2 + $t3;
            } elseif ($h < 240) {
                $color_rgb['r'] = $t2;
                $color_rgb['g'] = $t1 - $t3;
                $color_rgb['b'] = $t1;
            } elseif ($h < 300) {
                $color_rgb['r'] = $t2 + $t3;
                $color_rgb['g'] = $t2;
                $color_rgb['b'] = $t1;
            } elseif ($h < 360) {
                $color_rgb['r'] = $t1;
                $color_rgb['g'] = $t2;
                $color_rgb['b'] = $t1 - $t3;
            } else {
                $color_rgb['r'] = 0;
                $color_rgb['g'] = 0;
                $color_rgb['b'] = 0;
            }
        }

        $color_rgb['r'] = round($color_rgb['r']);
        $color_rgb['g'] = round($color_rgb['g']);
        $color_rgb['b'] = round($color_rgb['b']);
        if (isset($color_hsb['a'])) {
            $color_rgb['a'] = $color_hsb['a'];
        }

        return $color_rgb;
    }

    private static function hue_to_rgb($p, $q, $t) {
        if ($t < 0) {
            $t += 1;
        }
        if ($t > 1) {
            $t -= 1;
        }
        if ($t < 1 / 6) {
            return $p + ($q - $p) * 6 * $t;
        }
        if ($t < 1 / 2) {
            return $q;
        }
        if ($t < 2 / 3) {
            return $p + ($q - $p) * (2 / 3 - $t) * 6;
        }
        return $p;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}