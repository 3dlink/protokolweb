<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelUninstall extends EcommercewdModel {
  private $options;

  public function delete_db_tables() {
    global $wpdb;
    $this->remove_standart_pages();
    $this->remove_user_meta();
    $this->remove_taxonomy("wde_categories");
    $this->remove_taxonomy("wde_countries");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_currencies");
    $this->remove_taxonomy("wde_discounts");
    $this->remove_taxonomy("wde_labels");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_options");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_orderproducts");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_orders");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_orderstatuses");
    $this->remove_taxonomy("wde_parameters");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_parametertypes");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_productparameters");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_payments");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_ratings");
    $this->remove_taxonomy("wde_shippingmethods");
    $this->remove_taxonomy("wde_tag");
    $this->remove_taxonomy("wde_taxes");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_themes");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_tools");
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ecommercewd_tax_rates");
    delete_option("wde_version");
    delete_option("wde_sample_data");

    // Delete templates external folder if exist.
    $templates_external_folder = str_replace(array('/', '\\'), DS, WP_PLUGIN_DIR . DS . WD_E_PLUGIN_NAME . '-templates');
    if (is_dir($templates_external_folder)) {
      function delfiles($del_file) {
        if (is_dir($del_file)) {
          $del_folder = scandir($del_file);
          foreach ($del_folder as $file) {
            if ($file != '.' and $file != '..') {
              delfiles($del_file . '/' . $file);
            }
          }
          if (!rmdir($del_file)) {
            $flag = FALSE;
          }
        }
        else {
          if (!unlink($del_file)) {
            $flag = FALSE;
          }
        }
      }
      delfiles($templates_external_folder);
    }
  }

  public function remove_sample_data() {
    $wde_sample_data = get_option("wde_sample_data");
    foreach ($wde_sample_data['wde_images'] as $wde_image_id) {
      wp_delete_attachment($wde_image_id, true);
    }
    foreach ($wde_sample_data['wde_tag'] as $wde_term_id) {
      wp_delete_term($wde_term_id, 'wde_tag');
    }
    foreach ($wde_sample_data['wde_categories'] as $wde_term_id) {
      wp_delete_term($wde_term_id, 'wde_categories');
    }
    foreach ($wde_sample_data['wde_labels'] as $wde_term_id) {
      wp_delete_term($wde_term_id, 'wde_labels');
    }
    foreach ($wde_sample_data['wde_parameters'] as $wde_term_id) {
      wp_delete_term($wde_term_id, 'wde_parameters');
    }
    foreach ($wde_sample_data['wde_countries'] as $wde_term_id) {
      wp_delete_term($wde_term_id, 'wde_countries');
    }
    foreach ($wde_sample_data['wde_manufacturers'] as $wde_post_id) {
      wp_delete_post($wde_post_id, true);
    }
    foreach ($wde_sample_data['wde_products'] as $wde_post_id) {
      wp_delete_post($wde_post_id, true);
    }
    delete_option("wde_sample_data");
  }

  private function remove_taxonomy($taxonomy) {
    $terms = get_terms($taxonomy, array( 'hide_empty' => 0 ));
    foreach ($terms as $term) {
      wp_delete_term($term->term_id, $taxonomy);
    }
  }

  private function remove_user_meta() {
    $fields = WDFDb::get_user_meta_fields_list();
    $users = get_users();
    foreach ($users as $user) {
      foreach ($fields as $data) {
        foreach ($data as $field) {
          delete_user_meta($user->ID, $field["id"]);
        }
      }
    }
  }

  private function remove_standart_pages() {
    $pages = get_posts(array('posts_per_page' => -1, 'post_type' => 'wde_page'));
    if ($pages) {
      foreach($pages as $page) {
        wp_delete_post($page->ID, TRUE);
      }
    }

    $manufacturers = get_posts(array('posts_per_page' => -1, 'post_type' => 'wde_manufacturers'));
    if ($manufacturers) {
      foreach($manufacturers as $manufacturer) {
        wp_delete_post($manufacturer->ID, TRUE);
      }
    }

    $products = get_posts(array('posts_per_page' => -1, 'post_type' => 'wde_products'));
    if ($products) {
      foreach($products as $product) {
        wp_delete_post($product->ID, TRUE);
      }
    }
  }
}