<?php


// Create custom taxonomy for taxes.
function wde_create_taxes() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'                            => _x( 'Tax classes', 'post type general name', 'wde' ),
		'singular_name'                   => _x( 'Tax class', 'post type singular name', 'wde' ),
		'menu_name'                       => _x( 'Taxe classes', 'admin menu', 'wde' ),
		'all_items'                       => _x( 'All Tax classes', 'admin menu', 'wde' ),
		'edit_item'                       => __( 'Edit Tax class', 'wde' ),
		'view_item'                       => __( 'View Tax class', 'wde' ),
		'update_item'                     => __( 'Update Tax class', 'wde' ),
		'add_new_item'                    => __( 'Add New Tax class', 'wde' ),
		'new_item_name'                   => __( 'New Tax class name', 'wde' ),
		'parent_item  '                   => __( 'Parent Tax class', 'wde' ),
		'parent_item_colon'               => __( 'Parent Tax class:', 'wde' ),
		'search_items'                    => __( 'Search Tax classes', 'wde' ),
		'popular_items'                   => __( 'Popular Tax classes', 'wde' ),
		'separate_items_with_commas'      => __( 'Separate Tax classes with commas', 'wde' ),
		'add_or_remove_items'             => __( 'Add or remove Tax classes', 'wde' ),
		'choose_from_most_used'           => __( 'Choose from most used Tax classes', 'wde' ),
		'not_found'                       => __( 'No Tax classes found.', 'wde' )
	);
	$args = array(
		'labels'                 => $labels,
		'public'                 => TRUE,
		'show_ui'                => TRUE,
		'show_in_menu'           => FALSE,
		'show_in_nav_menus'      => FALSE,
		'show_tagcloud'          => FALSE,
		'show_in_quick_edit'     => FALSE,
		'meta_box_cb'            => NULL,
		'show_admin_column'      => TRUE,
		'hierarchical'           => FALSE,
		'update_count_callback'  => NULL,
		'query_var'              => isset($options->option_tax_base) ? $options->option_tax_base : TRUE,
		'rewrite'                => isset($options->option_tax_base) ? array('slug' => $options->option_tax_base) : TRUE,
		'sort'                   => TRUE,
  );
  register_taxonomy('wde_taxes', 'wde_products', $args);
}
add_action('init', 'wde_create_taxes');

// Remove taxes meta box from siderbar.
function wde_taxes_remove_meta() {
	remove_meta_box('tagsdiv-wde_taxes', 'wde_products', 'side');
}
add_action('admin_menu' , 'wde_taxes_remove_meta');

// Add extra taxonomy fields to the main column on the custom post edit screens.
function wde_add_taxes_meta_fields() {
  wd_ecommerce();
}
add_action('wde_taxes_add_form_fields', 'wde_add_taxes_meta_fields', 10, 2);

// Add extra taxonomy fields to the term edit page.
function wde_taxes_edit_meta_field($term) {
	wd_ecommerce($term->term_id);
}
add_action('wde_taxes_edit_form_fields', 'wde_taxes_edit_meta_field', 10, 2);

// Save extra taxonomy fields.
function save_wde_taxes_custom_meta($term_id) {
  wde_save_tax_rates($term_id);
}

function wde_save_tax_rates($term_id) {
  $countries = WDFInput::get('countries', array(), 'array');
  $states = WDFInput::get('states', array(), 'array');
  $zipcodes = WDFInput::get('zipcodes', array(), 'array');
  $cities = WDFInput::get('cities', array(), 'array');
  $rates = WDFInput::get('rates', array(), 'array');
  $tax_names = WDFInput::get('tax_names', array(), 'array');
  $priorities = WDFInput::get('priorities', array(), 'array');
  $compounds = WDFInput::get('compounds', array(), 'array');
  $shipping_rates = WDFInput::get('shipping_rates', array(), 'array');
  $orders = WDFInput::get('orders', array(), 'array');
  $removed = WDFInput::get('removed', array(), 'array');
  global $wpdb;
  if ($removed) {
    $wpdb->query('DELETE FROM `' . $wpdb->prefix . 'ecommercewd_tax_rates` WHERE `id` IN (' . $removed . ')');
  }
  foreach ($countries as $key => $country) {
    if ($key != 'default') {
      $data = array(
        'country' => (int) $country,
        'state' => isset($states[$key]) ? $states[$key] : '',
        'zipcode' => isset($zipcodes[$key]) ? $zipcodes[$key] : '',
        'city' => isset($cities[$key]) ? $cities[$key] : '',
        'rate' => isset($rates[$key]) ? $rates[$key] : '',
        'tax_name' => isset($tax_names[$key]) ? $tax_names[$key] : '',
        'priority' => isset($priorities[$key]) ? (int) $priorities[$key] : 0,
        'compound' => isset($compounds[$key]) ? 1 : 0,
        'shipping_rate' => isset($shipping_rates[$key]) ? $shipping_rates[$key] : '',
        'ordering' => isset($orders[$key]) ? (int) $orders[$key] : 0,
        'tax_id' => $term_id,
      );
      if (strpos($key, 'default') === FALSE) {
        $wpdb->update($wpdb->prefix . 'ecommercewd_tax_rates', $data, array('id' => $key));
      }
      else {
        $wpdb->insert($wpdb->prefix . 'ecommercewd_tax_rates', $data);
      }
    }
  }
}

add_action('edited_wde_taxes', 'wde_save_tax_rates', 10, 2);
add_action('create_wde_taxes', 'save_wde_taxes_custom_meta', 10, 2);

// Change custom taxonomy columns to show in administrator table.
function wde_taxes_columns($columns) {
  unset($columns['description']);
  unset($columns['slug']);
  unset($columns['posts']);
  return $columns;
}
add_filter('manage_edit-wde_taxes_columns', 'wde_taxes_columns');

// Delete custom taxonomy extra fields options.
function wde_taxes_delete_term($term_id, $tt_id, $taxonomy) {
  delete_option("wde_taxes_" . $term_id);
  global $wpdb;
  $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'ecommercewd_tax_rates WHERE tax_id=%d', $term_id));
}
add_action('delete_wde_taxes', 'wde_taxes_delete_term', 10, 3);