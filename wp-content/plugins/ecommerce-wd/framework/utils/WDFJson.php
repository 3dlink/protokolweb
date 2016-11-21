<?php

defined('ABSPATH') || die('Access Denied');

function wdf_json_error_handler($severity, $message, $filename, $lineno) {
  if (strpos($message, ' json_') === 0) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
  }
  if (error_reporting() == 0) {
    return;
  }
  // if (error_reporting() & $severity) {
    // throw new ErrorException($message, 0, $severity, $filename, $lineno);
  // }
}

class WDFJson {
  /**
   * json_encode func.
   *
   * @param    mixed $obj object to be encoded.
   * @param    int $options options
   *
   * @return  string  json string.
   */
  public static function encode($obj, $options = null) {
    try {
      $json_str = json_encode($obj, $options);
    } catch (Exception $exception) {
      $json_str = json_encode($obj);
    }
    return self::decode_unicode_string($json_str);
  }

  /**
   * json_decode func.
   *
   * @param    string $json_str string to be decoded.
   * @param    int $options options
   * @param    boolean $assoc
   * @param    int $depth
   *
   * @return  mixed  decoded object.
   */
  public static function decode($json_str, $options = 0, $assoc = false, $depth = 512) {
    $json_str = html_entity_decode($json_str);
    try {
      $obj = json_decode($json_str, $assoc, $depth);
    } catch (Exception $exception) {
      $obj = json_decode($json_str);
    }
    return $obj;
  }

  public static function decode_unicode_string($chrs) {
    $delim       = substr($chrs, 0, 1);
    $utf8        = '';
    $strlen_chrs = strlen($chrs);
    for ($i = 0; $i < $strlen_chrs; $i++) {
      $substr_chrs_c_2 = substr($chrs, $i, 2);
      $ord_chrs_c = ord($chrs[$i]);
      switch (true) {
        case preg_match('/\\\u[0-9A-F]{4}/i', substr($chrs, $i, 6)):
          // single, escaped unicode character
          $utf16 = chr(hexdec(substr($chrs, ($i + 2), 2)))
                 . chr(hexdec(substr($chrs, ($i + 4), 2)));
          $utf8 .= self::utf162utf8($utf16);
          $i += 5;
          break;
        case ($ord_chrs_c >= 0x20) && ($ord_chrs_c <= 0x7F):
          $utf8 .= $chrs{$i};
          break;
        case ($ord_chrs_c & 0xE0) == 0xC0:
          // characters U-00000080 - U-000007FF, mask 110XXXXX
          $utf8 .= substr($chrs, $i, 2);
          ++$i;
          break;
        case ($ord_chrs_c & 0xF0) == 0xE0:
          // characters U-00000800 - U-0000FFFF, mask 1110XXXX
          $utf8 .= substr($chrs, $i, 3);
          $i += 2;
          break;
        case ($ord_chrs_c & 0xF8) == 0xF0:
          // characters U-00010000 - U-001FFFFF, mask 11110XXX
          $utf8 .= substr($chrs, $i, 4);
          $i += 3;
          break;
        case ($ord_chrs_c & 0xFC) == 0xF8:
          // characters U-00200000 - U-03FFFFFF, mask 111110XX
          $utf8 .= substr($chrs, $i, 5);
          $i += 4;
          break;
        case ($ord_chrs_c & 0xFE) == 0xFC:
          // characters U-04000000 - U-7FFFFFFF, mask 1111110X
          $utf8 .= substr($chrs, $i, 6);
          $i += 5;
          break;
      }
    }
    return $utf8;
  }

  protected static function utf162utf8($utf16) {
    // Check for mb extension otherwise do by hand.
    if (function_exists('mb_convert_encoding')) {
      return mb_convert_encoding($utf16, 'UTF-8', 'UTF-16');
    }
    $bytes = (ord($utf16{0}) << 8) | ord($utf16{1});
    switch (true) {
      case ((0x7F & $bytes) == $bytes):
        // this case should never be reached, because we are in ASCII range
        return chr(0x7F & $bytes);

      case (0x07FF & $bytes) == $bytes:
        // return a 2-byte UTF-8 character
        return chr(0xC0 | (($bytes >> 6) & 0x1F))
             . chr(0x80 | ($bytes & 0x3F));

      case (0xFFFF & $bytes) == $bytes:
        // return a 3-byte UTF-8 character
        return chr(0xE0 | (($bytes >> 12) & 0x0F))
             . chr(0x80 | (($bytes >> 6) & 0x3F))
             . chr(0x80 | ($bytes & 0x3F));
    }
    // ignoring UTF-32 for now, sorry
    return '';
  }
}