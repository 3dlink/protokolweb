<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerUsermanagement extends EcommercewdController {
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
    public function updateuserdata() {
      global $wpdb;
      $model = WDFHelper::get_model('usermanagement', true);
      $options = WDFHelper::get_model('options', true)->get_options();
      
      if (!is_user_logged_in()) {
        wp_redirect(get_permalink($options->option_usermanagement_page));
        exit;
      }

      // get validated user data from request
      $user_data = $this->get_user_data_from_post();
      // update joomla user data
      $j_user = wp_get_current_user();
      
      $update_user = wp_update_user(array('ID' => $j_user->ID/* , 'user_email' => $user_data['email'] */));
      if (is_wp_error($update_user)) {
        $model->enqueue_message(__('Failed to update user data', 'wde') . ' :: ' . $update_user, 'danger');
      } else {
        foreach ($user_data as $i => $data) {
          update_user_meta($j_user->ID, $i, sanitize_text_field($data));
        }
        
        /* if ($wpdb->replace($wpdb->prefix . 'ecommercewd_users', $user_data_update)) { */
          $model->enqueue_message(__('User data updated', 'wde'), 'success');
        /* } else {
          $model->enqueue_message(__('Failed to update user data', 'wde') . ' :: ' . $wpdb->last_error, 'danger');
        } */
      }

      // goto update data page(with message)
      wp_redirect(WDFPath::add_pretty_query_args(get_permalink($options->option_usermanagement_page), $options->option_endpoint_edit_user_account, '1', FALSE));
      exit;
    }

    public function displaylogin($params) {
        /* if (is_user_logged_in()) {
          $options = WDFHelper::get_model('options', true)->get_options();
          wp_redirect(get_permalink($options->option_usermanagement_page));
          exit;
        }
 */
        parent::display($params);
    }

    public function displayupdateuserdata($params) {
      if (!is_user_logged_in()) {
        $options = WDFHelper::get_model('options', true)->get_options();
        wp_redirect(get_permalink($options->option_usermanagement_page));
        exit;
      }
      parent::display($params);
    }

    public function displayuseraccount($params) {          
      /* if (!is_user_logged_in()) {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();
        $model_options->enqueue_message(__('Please login ', 'wde'), 'warning');
        wp_redirect(get_permalink($options->option_usermanagement_page));
        exit;
      } */
      parent::display($params);
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function get_user_data_from_post() {
      global $wpdb;
      $model = WDFHelper::get_model('usermanagement', true);
      $options = WDFHelper::get_model('options', true)->get_options();

      // key_values to return if there are invalid fields
      $return_key_values = array();
      $invalid_fields = array();
      $data = array();
      $form_fields = WDFDb::get_user_meta_fields_list();
        
      foreach ($form_fields["billing_fields_list"] as $i => $form_field) {
        $field = WDFInput::get($form_field['id']);
        if (($form_field['id'] == 2) && (trim($field) == '')) {
          $invalid_fields[] = $form_field['label'];
        } else {
          $data[$form_field['id']] = $field;
          $return_key_values[$form_field['id']] = $field;
          $data[$form_field['id']] = $data[$form_field['id']];
        }
      }
      
      foreach ($form_fields["shipping_fields_list"] as $i => $form_field) {
        $field = WDFInput::get($form_field['id']);
        if (($form_field['id'] == 2) && (trim($field) == '')) {
          $invalid_fields[] = $form_field['label'];
        } else {
          $data[$form_field['id']] = $field;
          $return_key_values[$form_field['id']] = $field;
          $data[$form_field['id']] = $data[$form_field['id']];
        }
      }

      if (count($invalid_fields) > 0) {
        $msg = __('This field is required', 'wde');
        $task = 'displayupdateuserdata';
        $_SESSION['wde_return_key_values'] = $return_key_values;
        $_SESSION['wde_invalid_fields'] = $invalid_fields;
        wp_redirect(WDFPath::add_pretty_query_args(get_permalink($options->option_usermanagement_page), $options->option_endpoint_edit_user_account, '1', FALSE));
        exit;
      }

      return $data;
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}