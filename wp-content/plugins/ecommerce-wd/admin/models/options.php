<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelOptions extends EcommercewdModel {
  private $options;

  public function get_options_row() {
    global $wpdb;
    $query = 'SELECT name, value';
    $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_options';
    $rows = $wpdb->get_results($query);
    
    if ($wpdb->last_error) {
      WDFHelper::show_error(2);
    }

    $options = new stdClass();
    foreach ($rows as $row) {
      $name = $row->name;
      $value = $row->value;
      $options->$name = $value;
    }
    return $options;
  }

  public function get_options() {
    if ($this->options == null) {
      global $wpdb;
      $query = 'SELECT * FROM ' . $wpdb->prefix . 'ecommercewd_options';
      $results = $wpdb->get_results($query);

      $initial_values = array();
      $default_values = array();
      
      foreach ($results as $res) {
        $initial_values[$res->name] = $res->value;
        $default_values[$res->name] = $res->default_value;
      }
      
      if ($wpdb->last_error) {
        echo $wpdb->last_error;
        die();
      }

      $this->options = array();
      $this->options['initial_values'] = $initial_values;
      $this->options['default_values'] = $default_values;
    }
    return $this->options;
  }

  public function get_lists() {
    // Dimensions units.
    $list_dimensions_units = array();
    $list_dimensions_units[] = array('value' => 'm', 'text' => 'm');
    $list_dimensions_units[] = array('value' => 'cm', 'text' => 'cm');
    $list_dimensions_units[] = array('value' => 'mm', 'text' => 'mm');
    $list_dimensions_units[] = array('value' => 'in', 'text' => 'in');
    $list_dimensions_units[] = array('value' => 'yd', 'text' => 'yd');

    // Weight units.
    $list_weight_units = array();
    $list_weight_units[] = array('value' => 'kg', 'text' => 'kg');
    $list_weight_units[] = array('value' => 'g', 'text' => 'g');
    $list_weight_units[] = array('value' => 'lbs', 'text' => 'lbs');
    $list_weight_units[] = array('value' => 'oz', 'text' => 'oz');

    // Captcha themes.
    $list_captcha_themes = array();
    $list_captcha_themes[] = array('value' => 'dark', 'text' => __('Dark', 'wde'));
    $list_captcha_themes[] = array('value' => 'light', 'text' => __('Light', 'wde'));

    // Date formats.
    $list_date_formats = array();
    $list_date_formats[] = array('value' => 'd/m/Y', 'text' => '20/01/2014');
    $list_date_formats[] = array('value' => 'd/m/y', 'text' => '20/01/14');
    $list_date_formats[] = array('value' => 'm/d/Y', 'text' => '01/20/2014');
    $list_date_formats[] = array('value' => 'm/d/y', 'text' => '01/20/14');

    // User data fields.
    $radio_list_user_data_field = array();
    $radio_list_user_data_field[] = (object)array('value' => '0', 'text' => __('Hide', 'wde'));
    $radio_list_user_data_field[] = (object)array('value' => '1', 'text' => __('Show', 'wde'));
    $radio_list_user_data_field[] = (object)array('value' => '2', 'text' => __('Show and require', 'wde'));

    // Paypal checkout mode.
    $radio_list_paypal_checkout_mode = array();
    $radio_list_paypal_checkout_mode[] = (object) array('value' => '0', 'text' => __('Sandbox', 'wde'));
    $radio_list_paypal_checkout_mode[] = (object) array('value' => '1', 'text' => __('Production', 'wde'));

    // Shipping rate type.
    $list_order_shipping_type = array();
    $list_order_shipping_type[] = (object)array('value' => 'per_order', 'text' => __('Per order', 'wde'));
    $list_order_shipping_type[] = (object)array('value' => 'per_item', 'text' => __('Per item', 'wde'));

    // Tax based on.
    $list_tax_based_on = array();
    $list_tax_based_on[] = array('value' => 'shipping_address', 'text' => __('Customer shipping address', 'wde'));
    $list_tax_based_on[] = array('value' => 'billing_address', 'text' => __('Customer billing address', 'wde'));
    $list_tax_based_on[] = array('value' => 'base_address', 'text' => __('Shop base address', 'wde'));

    // Tax total display.
		$list_tax_total_display = array();
    $list_tax_total_display[] = array('value' => 'single', 'text' => __('As a single total', 'wde'));
    $list_tax_total_display[] = array('value' => 'itemized', 'text' => __('Itemized', 'wde'));

    $lists = array();
    $lists['dimensions_units'] = $list_dimensions_units;
    $lists['weight_units'] = $list_weight_units;
    $lists['captcha_themes'] = $list_captcha_themes;
    $lists['date_formats'] = $list_date_formats;
    $lists['user_data_field'] = $radio_list_user_data_field;
    $lists['paypal_checkout_mode'] = $radio_list_paypal_checkout_mode;
    $lists['order_shipping_type'] = $list_order_shipping_type;
    $lists['tax_based_on'] = $list_tax_based_on;
    $lists['tax_total_display'] = $list_tax_total_display;
    $lists['base_location'] = WDFDb::get_list_countries();

    return $lists;
  }

  public function get_user_data_fields() {
    $datas = array();
    $datas[] = (object)array('label' => __('Middle name', 'wde'), 'name' => 'user_data_middle_name',);
    $datas[] = (object)array('label' => __('Last name', 'wde'), 'name' => 'user_data_last_name',);
    $datas[] = (object)array('label' => __('Company', 'wde'), 'name' => 'user_data_company',);
    $datas[] = (object)array('label' => __('Country', 'wde'), 'name' => 'user_data_country',);
    $datas[] = (object)array('label' => __('State', 'wde'), 'name' => 'user_data_state',);
    $datas[] = (object)array('label' => __('City', 'wde'), 'name' => 'user_data_city',);
    $datas[] = (object)array('label' => __('Address', 'wde'), 'name' => 'user_data_address',);
    $datas[] = (object)array('label' => __('Mobile', 'wde'), 'name' => 'user_data_mobile',);
    $datas[] = (object)array('label' => __('Phone', 'wde'), 'name' => 'user_data_phone',);
    $datas[] = (object)array('label' => __('Fax', 'wde'), 'name' => 'user_data_fax',);
    $datas[] = (object)array('label' => __('Zip code', 'wde'), 'name' => 'user_data_zip_code',);
    return $datas;
  }

  public function get_additional_data($table_name) {
    $rows = WDFDb::get_rows($table_name, NULL, '`ordering` ASC');
    foreach ($rows as $row) {
      if ($table_name == 'payments') {
        $row->edit_url = add_query_arg(array('page' => 'wde_' . $table_name, 'task' => 'edit', 'cid[]' => $row->id, 'type' => $row->short_name, 'from' => 'options'), admin_url('admin.php'));
      }
    }
    return $rows;
  }
}