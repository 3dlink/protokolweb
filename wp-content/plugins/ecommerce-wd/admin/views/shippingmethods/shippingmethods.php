<?php


// Create custom taxonomy for shippingmethods.
function wde_create_shippingmethod() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'                            => _x( 'Shipping methods', 'post type general name', 'wde' ),
		'singular_name'                   => _x( 'Shipping method', 'post type singular name', 'wde' ),
		'menu_name'                       => _x( 'Shipping methods', 'admin menu', 'wde' ),
		'all_items'                       => _x( 'All Shipping methods', 'admin menu', 'wde' ),
		'edit_item'                       => __( 'Edit Shipping method', 'wde' ),
		'view_item'                       => __( 'View Shipping method', 'wde' ),
		'update_item'                     => __( 'Update Shipping method', 'wde' ),
		'add_new_item'                    => __( 'Add New Shipping method', 'wde' ),
		'new_item_name'                   => __( 'New Shipping method Name', 'wde' ),
		'parent_item  '                   => __( 'Parent Shipping method', 'wde' ),
		'parent_item_colon'               => __( 'Parent Shipping method:', 'wde' ),
		'search_items'                    => __( 'Search Shipping methods', 'wde' ),
		'popular_items'                   => __( 'Popular Shipping methods', 'wde' ),
		'separate_items_with_commas'      => __( 'Separate Shipping methods with commas', 'wde' ),
		'add_or_remove_items'             => __( 'Add or remove shipping methods', 'wde' ),
		'choose_from_most_used'           => __( 'Choose from most used shipping methods', 'wde' ),
		'not_found'                       => __( 'No shipping methods found.', 'wde' )
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
		'query_var'              => isset($options->option_shipping_method_base) ? $options->option_shipping_method_base : TRUE,
		'rewrite'                => isset($options->option_shipping_method_base) ? array('slug' => $options->option_shipping_method_base) : TRUE,
		'sort'                   => TRUE,
  );
  register_taxonomy('wde_shippingmethods', 'wde_products', $args);
}
add_action('init', 'wde_create_shippingmethod');

// Remove shippingmethods meta box from siderbar.
function wde_shippingmethods_remove_meta() {
	remove_meta_box('tagsdiv-wde_shippingmethods', 'wde_products', 'side');
}
add_action('admin_menu' , 'wde_shippingmethods_remove_meta');

// Add extra taxonomy fields to the main column on the custom post edit screens.
function wde_add_shippingmethods_meta_fields() {
  wd_ecommerce();
}
add_action('wde_shippingmethods_add_form_fields', 'wde_add_shippingmethods_meta_fields', 10, 2);

// Add extra taxonomy fields to the term edit page.
function wde_shippingmethods_edit_meta_field($term) {
	wd_ecommerce($term->term_id);
}
add_action('wde_shippingmethods_edit_form_fields', 'wde_shippingmethods_edit_meta_field', 10, 2);

// Save extra taxonomy fields.
function save_wde_shippingmethods_custom_meta($term_id) {
  $term_meta = get_option("wde_shippingmethods_" . $term_id);
	if (isset($_POST['price'])) {
    $term_meta['price'] = sanitize_text_field($_POST['price']);
  }
  $term_meta['price'] = $term_meta['price'] ? $term_meta['price'] : '0.00';
  if (isset($_POST['free_shipping'])) {
    if ((WDFInput::get('free_shipping', 0, 'int') == 0) && (WDFInput::get('free_shipping_after_certain_price', 0, 'int') == 1)) {
      $term_meta['free_shipping'] = 2;
    }
    else {
      $term_meta['free_shipping'] = sanitize_text_field($_POST['free_shipping']);
    }
  }
  if (isset($_POST['free_shipping_start_price'])) {
    $term_meta['free_shipping_start_price'] = sanitize_text_field($_POST['free_shipping_start_price']);
  }
  if (isset($_POST['tax_id'])) {
    $term_meta['tax_id'] = sanitize_text_field($_POST['tax_id']);
  }
  if (isset($_POST['shipping_type'])) {
    $term_meta['shipping_type'] = sanitize_text_field($_POST['shipping_type']);
  }
  if (isset($_POST['country_ids'])) {
    $term_meta['country_ids'] = sanitize_text_field($_POST['country_ids']);
  }
  // Save the option array.
  update_option("wde_shippingmethods_" . $term_id, $term_meta);
}
add_action('edited_wde_shippingmethods', 'save_wde_shippingmethods_custom_meta', 10, 2);
add_action('create_wde_shippingmethods', 'save_wde_shippingmethods_custom_meta', 10, 2);

// Change custom taxonomy columns to show in administrator table.
function wde_shippingmethods_columns($columns) {
  unset($columns['description']);
  unset($columns['slug']);
  unset($columns['posts']);
  return array_merge($columns, 
          array('price' => __('Price', 'wde')));
}
add_filter('manage_edit-wde_shippingmethods_columns', 'wde_shippingmethods_columns');

// Change custom taxonomy column content in administrator table.
function wde_shippingmethods_column($columns, $column, $term_id) {
  if ($column == 'price') {
    $term_meta = get_option("wde_shippingmethods_" . $term_id);
    $row_default_currency = WDFDb::get_row('currencies', '`default` = 1');
    if ($term_meta['free_shipping'] == 1) {
      $columns .= __('Free shipping', 'wde');
    }
    else {
      $columns .= WDFText::wde_number_format($term_meta['price'], 2) . ' ' . $row_default_currency->code;
    }
  }
  return $columns;
}
add_filter('manage_wde_shippingmethods_custom_column', 'wde_shippingmethods_column', 10, 3);

// Delete custom taxonomy extra fields options.
function wde_shippingmethods_delete_term($term_id, $tt_id, $taxonomy) {
  delete_option("wde_shippingmethods_" . $term_id);
}
add_action('delete_wde_shippingmethods', 'wde_shippingmethods_delete_term', 10, 3);