<?php


function wde_extra_user_profile_fields($user) {
  wd_ecommerce($user->ID);
}
add_action('show_user_profile', 'wde_extra_user_profile_fields');
add_action('edit_user_profile', 'wde_extra_user_profile_fields');

function wde_save_extra_user_profile_fields($user_id) {
  if (current_user_can('edit_user', $user_id)) {
    $user_meta_fields = WDFDb::get_user_meta_fields_list();
    foreach ($user_meta_fields as $data) {
      foreach ($data as $field) {
        if (isset($_POST[$field["id"]])) {
          update_user_meta($user_id, $field["id"], sanitize_text_field($_POST[$field["id"]]));
        }
      }
    }
  }
}
add_action('personal_options_update', 'wde_save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'wde_save_extra_user_profile_fields');