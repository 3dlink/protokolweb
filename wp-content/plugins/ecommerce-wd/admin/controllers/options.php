<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerOptions extends EcommercewdController {
  public function apply() {
    $message_id = '';
    $failed = false;
    $this->prepare_checkboxes_for_save();
    global $wpdb;
    $table_name = $wpdb->prefix . WDFHelper::get_com_name() . '_' . WDFInput::get_controller();
    // Get option names.
    $names = $wpdb->get_col('SELECT name FROM ' . $table_name);
    if ($wpdb->last_error) {
      $message_id = 4;
      $failed = true;
    }

    // update options
    if ($failed == false) {
      for ($i = 0; $i < count($names); $i++) {
        $name = $names[$i];
        if ($name == 'admin_email_body'
          || $name == 'user_email_body'
          || $name == 'user_email_status_body'
          // || $name == "canceled_body"
          || $name == 'failed_body'
          || $name == 'pending_body'
          || $name == 'completed_body'
          || $name == 'refunded_body'
          || $name == 'invoice_body') {
          $value = isset($_POST[$name]) ? stripslashes($_POST[$name]) : '';
        }
        else {
          $value = WDFInput::get($name, NULL);
        }
        if ($value !== NULL) {
          $wpdb->update($table_name, array('value' => $value), array('name' => $name));

          if ($wpdb->last_error) {
            $failed = true;
            $message_id = 4;
            break;
          }
        }
      }
    }
    if ($failed == false) {
      $message_id = 1;
    }
    WDFHelper::redirect('', '', '', 'tab_index=' . WDFInput::get('tab_index') . (WDFInput::get('subtab_index') ? '&subtab_index=' . WDFInput::get('subtab_index') : ''), $message_id);
  }

  public function save_order() {
    global $wpdb;
    WDFDb::save_ordering($wpdb->prefix . 'ecommercewd_payments');
  }

  private function prepare_checkboxes_for_save() {
    $checkboxes = array('social_media_integration_enable_fb_like_btn', 'social_media_integration_enable_twitter_tweet_btn', 'social_media_integration_enable_g_plus_btn');
    foreach ($checkboxes as $checkbox) {
      WDFInput::set($checkbox, WDFInput::get($checkbox, 0, 'int'));
    }
  }
}