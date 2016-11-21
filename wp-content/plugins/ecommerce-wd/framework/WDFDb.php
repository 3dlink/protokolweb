<?php
class WDFDb {
  public static function get_table_instance($table_name = '') {
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }
    $table_prefix = ucfirst(WDFHelper::get_com_name()) . 'Table';
    $table_name = ucfirst($table_name);
    $class = $table_prefix . $table_name;
    $instance = new $class();
    return $instance;
  }

  public static function get_row($table_name = '', $where_queries = array()) {
    $rows = self::get_rows($table_name, $where_queries);
    return empty($rows) == false ? $rows[0] : self::get_table_instance($table_name);
  }

  public static function get_rows($table_name = '', $where_queries = array(), $order = '') {
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }

    if (is_string($where_queries) == true) {
      $where_queries = array($where_queries);
    }

    global $wpdb;
    $query = "SELECT * FROM " . $wpdb->prefix . 'ecommercewd' . '_' . $table_name;
    if (!empty($where_queries)) {
      $query .= " WHERE ";
    }
    foreach ($where_queries as $key => $where_query) {
      $query .= $where_query . ($key == count($where_queries) - 1 ? " " : " AND ");
    }
    if ($order) {
      $query .= ' ORDER BY ' . $order;
    }
    $rows = $wpdb->get_results($query);
    if (!$rows) {
      return false;
    }
    return $rows;
  }

  public static function get_row_by_id($table_name = '', $id = 0) {
    global $wpdb;
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }
    if ($id) {
      $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . WDFHelper::get_com_name() . '_' . $table_name . ' WHERE id="%d"', $id));
    }
    else {
      $row = FALSE;
    }
    if (!$row) {
      $row = self::get_table_instance($table_name);
    }
    return $row;
  }

  public static function get_row_from_input($table_name) {
    if ($table_name == '') {
        $table_name = WDFInput::get_controller();
    }
    $row = self::get_table_instance($table_name);

    foreach ($row as $key => $value) {
        $value_input = WDFInput::get($key, null);
        if ($value_input != null) {
            $row->$key = $value_input;
        }
    }
    return $row;
  }

  public static function remove_rows($table_name, $ids) {
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }
    if (is_array($ids) == true) {
      $ids = implode(',', $ids);
    }
    if (!$ids) return;
    global $wpdb;
    $query = 'DELETE FROM ' . $wpdb->prefix . WDFHelper::get_com_name() . '_' . $table_name . ' WHERE id IN (' . esc_sql($ids) . ')';
    return $wpdb->query($query);
  }

  public static function get_checked_row($table_name = '') {
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }
    return self::get_row_by_id($table_name, WDFInput::get_checked_id());
  }

  public static function remove_checked_rows($table_name = '') {
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }
    return self::remove_rows($table_name, WDFInput::get_checked_ids());
  }

  public static function store_input_in_row($table_name = '') {
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }
    $id = WDFInput::get('id', 0, 'int');
    $row = self::get_row_by_id($table_name, $id);
    $data = array();
    foreach ($row as $key => $value) {
      $new_value = WDFInput::get($key, $value);
      $data[$key] = $new_value;
    }
    global $wpdb;
    $full_table_name = $wpdb->prefix . WDFHelper::get_com_name() . '_' . $table_name;

    $wpdb->replace($full_table_name, $data);
    $new_row = self::get_row_by_id($table_name, $wpdb->insert_id);

    return $new_row;
  }

  public static function set_rows_data($table_name, $ids, $keys, $values) {
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }
    if (is_array($ids) == true) {
      $ids = implode(',', $ids);
    }
    if (!$ids) {
      return;
    }
    $table_name = WDFHelper::get_com_name() . '_' . $table_name;
    $query_set = '';
    if (is_array($keys)) {
      if (count($keys) > 0) {
        $query_set = 'SET';
        for ($i = 0; $i < count($keys); $i++) {
          $query_set .= (' ' . esc_sql($keys[$i]) . ' = ' . esc_sql($values[$i]) . (($i == count($keys) - 1) ? '' : ','));
        }
      }
    }
    else {
      $query_set = 'SET ' . esc_sql($keys) . ' = ' . esc_sql($values);
    }
    $query_where = $ids == '' ? '' : 'WHERE id IN ( ' . esc_sql($ids) . ' )';
    global $wpdb;
    $query = 'UPDATE ' . $wpdb->prefix . $table_name . ' ' . $query_set . ' ' . $query_where;
    return $wpdb->query($query);
  }

  public static function save_ordering($table_name = '') {
    global $wpdb;
    $cids = WDFJson::decode(WDFInput::get('cid'));
    if ($table_name == '') {
      $table_name = $wpdb->prefix . 'ecommercewd_' . WDFInput::get_controller();
    }
    for ($i = 0; $i < count($cids); $i++) {
      $id = $cids[$i];
      $wpdb->update($table_name, array('ordering' => $i + 1), array('id' => $id));
    }
  }

  public static function set_checked_row_data($table_name, $keys, $values) {
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }
    $cids = array(WDFInput::get_checked_id());
    return self::set_rows_data($table_name, $cids, $keys, $values);
  }

  public static function set_checked_rows_data($table_name, $keys, $values, $cids = '') {
    if ($table_name == '') {
      $table_name = WDFInput::get_controller();
    }
    if ($cids == '') {
      $cids = WDFInput::get_checked_ids();
    }
    return self::set_rows_data($table_name, $cids, $keys, $values);
  }

  public static function get_list($table_name, $key, $value, $where_conditions = array(), $order = '', $key_value_first = null, $key_value_last = null) {
    if (is_array($where_conditions) == false) {
      $where_conditions = empty($where_conditions) == true ? array() : array($where_conditions);
    }
    global $wpdb;
    $table_name = WDFHelper::get_com_name() . '_' . $table_name;
    $query = 'SELECT ' . $key . ',' . $value . ' FROM ' . $wpdb->prefix . $table_name;
    if (!empty($where_conditions)) {
      $query .= ' WHERE ';
      foreach ($where_conditions as $where_condition) {
        $query .= $where_condition;
      }
    }
    if ($order != '') {
      $query .= ' ORDER BY ' . $order;
    }
    $rows = $wpdb->get_results($query);
    $value_parts = explode(' ', $value);
    $value = end($value_parts);

    $list = array();
    for ($i = 0; $i < count($rows); $i++) {
      $row = $rows[$i];
      $row_key = $row->$key;
      $row_value = $row->$value;
      $list[$row_key] = array($key => $row_key, $value => $row_value);
    }

    if ($key_value_first != null) {
      $list = array_merge($key_value_first, $list);
    }

    if ($key_value_last != null) {
      $list = array_merge($list, $key_value_last);
    }
    return $list;
  }

  /**
	 * Get list of countries.
	 *
	 * @since 1.2.0
	 *
	 * @param boolean    $echo     Return html select tag or return array of countries
	 * @param string     $value    Checked value
	 * @param string     $attr     An array of key -> value arguments of attributes for select tag.
	 * @return Html select tag or return array of countries depend on first parameter.
	 */
  public static function get_list_countries($echo = FALSE, $checked_value = 0, $attr = array()) {
    if (!isset($attr['empty_value'])) {
      $attr['empty_value'] = __('Select country', 'wde');
    }
    if (!isset($attr['name'])) {
      $attr['name'] = 'wde_countries';
    }
    $attr['class'] = isset($attr['class']) ? 'class="' . $attr['class'] . '"' : '';
    $args = array(
      'orderby'           => 'name', 
      'order'             => 'ASC',
      'hide_empty'        => FALSE,
    ); 
    $countries_taxanomy = get_terms('wde_countries', $args);
    $countries = array();
    $countries[0] = array('id' => '', 'name' => $attr['empty_value']);
    $html = '<select name="' . $attr['name'] . '" ' . $attr['class'] . '>';
    $html .= '<option value="0" ' . selected($checked_value, 0, FALSE) . '>' . $attr['empty_value'] . '</option>';
    foreach ($countries_taxanomy as $country_taxanomy) {
      $countries[$country_taxanomy->term_id] = array('id' => $country_taxanomy->term_id, 'name' => $country_taxanomy->name);
      $html .= '<option value="' . $country_taxanomy->term_id . '" ' . selected($checked_value, $country_taxanomy->term_id, FALSE) . '>' . $country_taxanomy->name . '</option>';
    }
    $html .= '</select>';
    return $echo ? $html : $countries;
  }

  public static function get_list_discounts() {
    $args = array(
      'orderby'           => 'name', 
      'order'             => 'ASC',
      'hide_empty'        => FALSE,
    ); 
    $discounts_taxanomy = get_terms('wde_discounts', $args);
    $discounts = array();
    $discounts[0] = array('id' => '', 'name' => '-' . __('Select discount', 'wde') . '-');
    foreach ($discounts_taxanomy as $discount_taxanomy) {
      $discount = get_option("wde_discounts_" . $discount_taxanomy->term_id);
      $discounts[$discount_taxanomy->term_id] = array('id' => $discount_taxanomy->term_id, 'name' => $discount_taxanomy->name . '(' . $discount['rate'] . '%)');
    }
    return $discounts;
  }

  public static function get_list_custom_post_type($type, $key_value_first = null) {
    $products = array();
    if ($key_value_first != null) {
      $products[] = $key_value_first;
    }
    
    $args = array(
      'post_type' => $type,
      'nopaging' => TRUE
    );
    $loop = new WP_Query($args);
    $i = 1;
    while ($loop->have_posts()) {
      $loop->the_post();
      $products[] = array('id' => get_the_ID(), 'name' => get_the_title());
    }
    return $products;
  }
  
  public static function get_options() {
    global $wpdb;
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "ecommercewd_options'");
    if (!$table_exists) {
      return FALSE;
    }

    $rows = $wpdb->get_results('SELECT name, value FROM ' . $wpdb->prefix . 'ecommercewd_options');

    if ($wpdb->last_error) {
      return FALSE;
    }

    $options = new stdClass();
    foreach ($rows as $row) {
      $name = $row->name;
      $value = $row->value;
      $options->$name = $value;
    }
    return $options;
  }

  public static function get_user_meta_fields_list($id = 0, $view = false, $include_user_data = false) {
    $options = self::get_options();
    $billing_fields_list = array();
    array_push($billing_fields_list, array("id" => "wde_billing_first_name", "label" => (($options->user_data_middle_name > 0) || ($options->user_data_last_name > 0)) ? __("First name", "wde") : __("Name", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_first_name", true), "required" => 2));
    array_push($billing_fields_list, array("id" => "wde_billing_middle_name", "label" => __("Middle name", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_middle_name", true), "required" => $options->user_data_middle_name));
    array_push($billing_fields_list, array("id" => "wde_billing_last_name", "label" => __("Last name", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_last_name", true), "required" => $options->user_data_last_name));
    $user_email = FALSE;
    if ($include_user_data) {
      if ($id) {
        $user_data = get_userdata($id);
        if ($user_data) {
          $user_email = $user_data->user_email;
        }
      }
    }
    array_push($billing_fields_list, array("id" => "wde_billing_email", "label" => __("Email", "wde"), "type" => "input", "value" => $user_email, "required" => 2));
    array_push($billing_fields_list, array("id" => "wde_billing_company", "label" => __("Company", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_company", true), "required" => $options->user_data_company));
    array_push($billing_fields_list, array("id" => "wde_billing_country_id", "label" => __("Country", "wde"), "type" => "select", "value" => get_user_meta($id, "wde_billing_country_id", true), "required" => $options->user_data_country));
    if ($view) {
      $term = get_term($billing_fields_list[count($billing_fields_list) - 1]["value"], 'wde_countries');
      $billing_fields_list[count($billing_fields_list) - 1]["value"] = !is_wp_error($term) ? $term->name : '';
    }
    else {
      $billing_fields_list[count($billing_fields_list) - 1]["options"] = WDFDb::get_list_countries();
    }
    array_push($billing_fields_list, array("id" => "wde_billing_state", "label" => __("State", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_state", true), "required" => $options->user_data_state));
    array_push($billing_fields_list, array("id" => "wde_billing_city", "label" => __("City", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_city", true), "required" => $options->user_data_city));
    array_push($billing_fields_list, array("id" => "wde_billing_address", "label" => __("Address", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_address", true), "required" => $options->user_data_address));
    array_push($billing_fields_list, array("id" => "wde_billing_mobile", "label" => __("Mobile", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_mobile", true), "required" => $options->user_data_mobile));
    array_push($billing_fields_list, array("id" => "wde_billing_phone", "label" => __("Phone", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_phone", true), "required" => $options->user_data_phone));
    array_push($billing_fields_list, array("id" => "wde_billing_fax", "label" => __("Fax", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_fax", true), "required" => $options->user_data_fax));
    array_push($billing_fields_list, array("id" => "wde_billing_zip_code", "label" => __("Zip code", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_billing_zip_code", true), "required" => $options->user_data_zip_code));
    
    $shipping_fields_list = array();
    array_push($shipping_fields_list, array("id" => "wde_shipping_first_name", "label" => (($options->user_data_middle_name > 0) || ($options->user_data_last_name > 0)) ? __("First name", "wde") : __("Name", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_shipping_first_name", true), "required" => 2));
    array_push($shipping_fields_list, array("id" => "wde_shipping_middle_name", "label" => __("Middle name", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_shipping_middle_name", true), "required" => $options->user_data_middle_name));
    array_push($shipping_fields_list, array("id" => "wde_shipping_last_name", "label" => __("Last name", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_shipping_last_name", true), "required" => $options->user_data_last_name));
    array_push($shipping_fields_list, array("id" => "wde_shipping_company", "label" => __("Company", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_shipping_company", true), "required" => $options->user_data_company));
    array_push($shipping_fields_list, array("id" => "wde_shipping_country_id", "label" => __("Country", "wde"), "type" => "select", "value" => get_user_meta($id, "wde_shipping_country_id", true), "required" => $options->user_data_country));
    if ($view) {
      $term = get_term($shipping_fields_list[count($shipping_fields_list) - 1]["value"], 'wde_countries');
      $shipping_fields_list[count($shipping_fields_list) - 1]["value"] = !is_wp_error($term) ? $term->name : '-';
    }      
    else {
      $shipping_fields_list[count($shipping_fields_list) - 1]["options"] = WDFDb::get_list_countries();
    }
    array_push($shipping_fields_list, array("id" => "wde_shipping_state", "label" => __("State", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_shipping_state", true), "required" => $options->user_data_state));
    array_push($shipping_fields_list, array("id" => "wde_shipping_city", "label" => __("City", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_shipping_city", true), "required" => $options->user_data_city));
    array_push($shipping_fields_list, array("id" => "wde_shipping_address", "label" => __("Address", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_shipping_address", true), "required" => $options->user_data_address));
    array_push($shipping_fields_list, array("id" => "wde_shipping_zip_code", "label" => __("Zip code", "wde"), "type" => "input", "value" => get_user_meta($id, "wde_shipping_zip_code", true), "required" => $options->user_data_zip_code));
    return array("billing_fields_list" => $billing_fields_list, "shipping_fields_list" => $shipping_fields_list);
  }

  /**
	 * Get tax rates data by tax taxonomy term id or slug.
	 *
	 * @since 1.2.0
	 *
	 * @param string     $field    Either 'slug' or 'id' (term_id)
	 * @param string|int $value    Search for this term value
	 * @return Tax rates object on success otherwise return false.
	 */
  public static function get_tax_rates_by($field, $value, $group = TRUE) {
    if ( 'slug' == $field ) {
      $value = sanitize_title($value);
      if ( empty($value) ) {
        return FALSE;
      }
      $term = get_term_by( 'slug', $value, 'wde_taxes' );
      $term_id = $term->term_id;
    }
    elseif ( 'id' == $field ) {
      $term_id = (int) $value;
      if ( !$value ) {
        return FALSE;
      }
    }
    else {
      return FALSE;
    }
    global $wpdb;
    $group_by = $group ? ' INNER JOIN (SELECT priority, MIN(ordering) as min_order FROM `' . $wpdb->prefix . 'ecommercewd_tax_rates` GROUP BY `priority`) AS tax2 ON tax1.priority = tax2.priority AND tax1.ordering = tax2.min_order AND ' : ' WHERE';
    $tax_rates = $wpdb->get_results($wpdb->prepare('SELECT tax1.* FROM `' . $wpdb->prefix . 'ecommercewd_tax_rates` AS tax1' . $group_by . ' tax1.tax_id="%d" ORDER BY tax1.`priority` ASC, tax1.`ordering` ASC', $term_id));
    if ( !$tax_rates ) {
      return FALSE;
    }
    return $tax_rates;
  }
}