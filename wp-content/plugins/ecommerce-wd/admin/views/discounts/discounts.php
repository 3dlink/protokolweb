<?php


// Create custom taxonomy for discounts.
function wde_create_discount() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'                            => _x( 'Discounts', 'post type general name', 'wde' ),
		'singular_name'                   => _x( 'Discount', 'post type singular name', 'wde' ),
		'menu_name'                       => _x( 'Discounts', 'admin menu', 'wde' ),
		'all_items'                       => _x( 'All Discounts', 'admin menu', 'wde' ),
		'edit_item'                       => __( 'Edit Discount', 'wde' ),
		'view_item'                       => __( 'View Discount', 'wde' ),
		'update_item'                     => __( 'Update Discount', 'wde' ),
		'add_new_item'                    => __( 'Add New Discount', 'wde' ),
		'new_item_name'                   => __( 'New Discount Name', 'wde' ),
		'parent_item  '                   => __( 'Parent Discount', 'wde' ),
		'parent_item_colon'               => __( 'Parent Discount:', 'wde' ),
		'search_items'                    => __( 'Search Discounts', 'wde' ),
		'popular_items'                   => __( 'Popular Discounts', 'wde' ),
		'separate_items_with_commas'      => __( 'Separate Discounts with commas', 'wde' ),
		'add_or_remove_items'             => __( 'Add or remove discounts', 'wde' ),
		'choose_from_most_used'           => __( 'Choose from most used discounts', 'wde' ),
		'not_found'                       => __( 'No discounts found.', 'wde' )
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
		'query_var'              => isset($options->option_discount_base) ? $options->option_discount_base : TRUE,
		'rewrite'                => isset($options->option_discount_base) ? array('slug' => $options->option_discount_base) : TRUE,
		'sort'                   => TRUE,
  );
  register_taxonomy('wde_discounts', 'wde_products', $args);
}
add_action('init', 'wde_create_discount');

// Remove discounts meta box from sidebar.
function wde_discounts_remove_meta() {
	remove_meta_box('tagsdiv-wde_discounts', 'wde_products', 'side');
}
add_action('admin_menu', 'wde_discounts_remove_meta');

// Add extra taxonomy fields to the main column on the custom post edit screens.
function wde_add_discounts_meta_fields() {
  wd_ecommerce();
}
add_action('wde_discounts_add_form_fields', 'wde_add_discounts_meta_fields', 10, 2);

// Add extra taxonomy fields to the term edit page.
function wde_discounts_edit_meta_field($term) {
	wd_ecommerce($term->term_id);
}
add_action('wde_discounts_edit_form_fields', 'wde_discounts_edit_meta_field', 10, 2);

// Save extra taxonomy fields.
function save_wde_discounts_custom_meta($term_id) {
  $term_meta = get_option("wde_discounts_" . $term_id);
	if (isset($_POST['rate']) && $_POST['rate'] != '') {
    $term_meta['rate'] = sanitize_text_field($_POST['rate']);
  }
  if (isset($_POST['date_from'])) {
    $term_meta['date_from'] = sanitize_text_field($_POST['date_from']);
  }
  if (isset($_POST['date_to'])) {
    $term_meta['date_to'] = sanitize_text_field($_POST['date_to']);
  }
  // Save the option array.
  update_option("wde_discounts_" . $term_id, $term_meta);
}
add_action('edited_wde_discounts', 'save_wde_discounts_custom_meta', 10, 2);
add_action('create_wde_discounts', 'save_wde_discounts_custom_meta', 10, 2);

// Change custom taxonomy columns to show in administrator table.
function wde_discounts_columns($columns) {
  $new_columns = array();
  $new_columns['rate'] = __('Rate', 'wde');
  $new_columns['date_from_col'] = __('Date from', 'wde');
  $new_columns['date_to_col'] = __('Date to', 'wde');
  unset($columns['description']);
  unset($columns['slug']);
  unset($columns['posts']);
  return array_merge($columns, $new_columns);
}
add_filter('manage_edit-wde_discounts_columns', 'wde_discounts_columns');

// Change custom taxonomy column content in administrator table.
function wde_discounts_column($columns, $column, $term_id) {
  if ($column == 'rate') {
    $term_meta = get_option("wde_discounts_" . $term_id);
    $columns .= $term_meta['rate'] . '%';
  }
  elseif ($column == 'date_from_col') {
    $term_meta = get_option("wde_discounts_" . $term_id);
    $columns .= $term_meta['date_from'];
  }
   elseif ($column == 'date_to_col') {
    $term_meta = get_option("wde_discounts_" . $term_id);
    $columns .= $term_meta['date_to'];
  }
  return $columns;
}
add_filter('manage_wde_discounts_custom_column', 'wde_discounts_column', 10, 3);

// Delete custom taxonomy extra fields options.
function wde_discounts_delete_term($term_id, $tt_id, $taxonomy) {
  delete_option("wde_discounts_" . $term_id);
}
add_action('delete_wde_discounts', 'wde_discounts_delete_term', 10, 3);