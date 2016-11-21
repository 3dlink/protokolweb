<?php

defined('ABSPATH') || die('Access Denied');

class WDFMail {
  
  /**
   * Gets component translated text.
   *
   * @param    string $mail_from sender mail.
   * @param    string $mail_to recipient mail.
   * @param    string $subject mail subject.
   * @param    string $mail_body mail body.
   *
   * @return  boolean  is mail sent.
   */

  public static function send_mail($mail_from, $mail_to, $subject, $mail_body, $isHTML = FALSE, $from_name = '', $mailer) {
    $content_type = $isHTML ? "text/html" : "text/plain";
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $from_name = $from_name == '' ? $mail_from : $from_name;
    $headers .= $mail_from != '' ? "From: '" . $from_name . "' <" . $mail_from . ">" . "\r\n" : '';
    $headers .= 'Content-type: ' . $content_type . '; charset="' . get_option('blog_charset') . '"' . "\r\n";
    $mail_body = str_replace(array("\r\n"), "<br>", stripslashes($mail_body));
    $mail_body = str_replace('</div><br>', '</div>', stripslashes($mail_body));

    if ($mailer) {
      $is_mail_sent = wp_mail($mail_to, $subject, $mail_body, $headers);
    }
    else {
      $is_mail_sent = mail($mail_to, $subject, $mail_body, $headers);
    }

    return $is_mail_sent;
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