<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerTaxes extends EcommercewdController {
	public function import_taxes() {
    $id = WDFInput::get("tag_ID");
    if ($id) {
      if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'];
        die();
      }
      $upload = wp_upload_dir();
      $uplad_dir = (isset($upload['basedir']) ? $upload['basedir'] : WD_E_DIR) . DS;
      $base_name = basename($_FILES['file']["name"]);
      $file_path = $uplad_dir . $base_name;
      $uploaded = move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
      if ($uploaded) {
        $tax_rates = array();
        $imageFileType = pathinfo($file_path, PATHINFO_EXTENSION);
        if ($imageFileType == 'csv') {
          $handle = fopen($file_path, "r");
          while (($data = fgetcsv($handle, '', ",")) !== FALSE) {
            array_push($tax_rates, $data);
          }
          fclose($handle);
        }
        array_shift($tax_rates);
        if (!empty($tax_rates)) {
          global $wpdb;
          $max_ordering = $wpdb->get_var($wpdb->prepare('SELECT MAX(ordering) FROM ' . $wpdb->prefix . 'ecommercewd_tax_rates WHERE tax_id=%d', $id));
          if ($wpdb->last_error) {
            echo $wpdb->last_error;
            die();
          }
          foreach ($tax_rates as $key => $value) {
            $taxes = array(
              'country' => isset($value[0]) ? (int) $value[0] : 0,
              'state' => isset($value[2]) ? esc_html($value[2]) : '',
              'zipcode' => isset($value[3]) ? esc_html($value[3]) : '',
              'city' => isset($value[4]) ? esc_html($value[4]) : '', 
              'rate' => isset($value[5]) ? (float) $value[5] : 0,
              'tax_name' => isset($value[6]) ? esc_html($value[6]) : '',
              'priority' => isset($value[7]) ? (int) $value[7] : 1,
              'compound' => isset($value[8]) ? (int) $value[8] : 0,
              'shipping_rate' => isset($value[9]) ? (float) $value[9] : 0, 
              'ordering' => ++$max_ordering,
              'tax_id' => $id,
            );
            $wpdb->insert($wpdb->prefix . 'ecommercewd_tax_rates', $taxes);
            if ($wpdb->last_error) {
              echo $wpdb->last_error;
              die();
            }
          }
        }
      }
      echo add_query_arg(array('action' => 'edit', 'taxonomy' => 'wde_taxes', 'tag_ID' => $id, 'post_type' => 'post'), admin_url('edit-tags.php'));
    }
    die();
  }
}
