<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerRatings extends EcommercewdController {
  public function update_rating() {
    $id = (int) WDFInput::get_checked_id();
    global $wpdb;
    $rating = $wpdb->get_row($wpdb->prepare('SELECT `product_id`,`rating` FROM ' . $wpdb->prefix . 'ecommercewd_ratings WHERE id=%d', $id));
    $new_rate = WDFInput::get('rating_' . $id);
    if ($rating->rating != $new_rate) {
      $saved = $wpdb->update($wpdb->prefix . 'ecommercewd_ratings', array('rating' => $new_rate), array('id' => $id));
      if ($saved !== FALSE) {
        $message_id = 23;
        $average_rating = $wpdb->get_var($wpdb->prepare('SELECT FORMAT(AVG(rating), 1) FROM ' . $wpdb->prefix . 'ecommercewd_ratings WHERE product_id=%d', $rating->product_id));
        update_post_meta($product_id, 'wde_rating', $average_rating);
      }
      else {
        $message_id = 22;
      }
    }
    else {
      $message_id = 24;
    }
    WDFHelper::redirect('', '', '', '', $message_id);
  }
}