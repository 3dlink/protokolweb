<?php


// Create custom taxonomy for countries.
function wde_create_country() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'                            => _x( 'Countries', 'post type general name', 'wde' ),
		'singular_name'                   => _x( 'Country', 'post type singular name', 'wde' ),
		'menu_name'                       => _x( 'Countries', 'admin menu', 'wde' ),
		'all_items'                       => _x( 'All Countries', 'admin menu', 'wde' ),
		'edit_item'                       => __( 'Edit Country', 'wde' ),
		'view_item'                       => __( 'View Country', 'wde' ),
		'update_item'                     => __( 'Update Country', 'wde' ),
		'add_new_item'                    => __( 'Add New Country', 'wde' ),
		'new_item_name'                   => __( 'New Country Name', 'wde' ),
		'parent_item  '                   => __( 'Parent Country', 'wde' ),
		'parent_item_colon'               => __( 'Parent Country:', 'wde' ),
		'search_items'                    => __( 'Search Countries', 'wde' ),
		'popular_items'                   => __( 'Popular Countries', 'wde' ),
		'separate_items_with_commas'      => __( 'Separate Countries with commas', 'wde' ),
		'add_or_remove_items'             => __( 'Add or remove countries', 'wde' ),
		'choose_from_most_used'           => __( 'Choose from most used countries', 'wde' ),
		'not_found'                       => __( 'No countries found.', 'wde' )
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
		'query_var'              => isset($options->option_country_base) ? $options->option_country_base : TRUE,
		'rewrite'                => isset($options->option_country_base) ? array('slug' => $options->option_country_base) : TRUE,
		'sort'                   => TRUE,
  );
  register_taxonomy('wde_countries', 'wde_products', $args);
}
add_action('init', 'wde_create_country');

// Remove countries meta box from siderbar.
function wde_countries_remove_meta() {
	remove_meta_box('tagsdiv-wde_countries', 'wde_products', 'side');
}
add_action('admin_menu' , 'wde_countries_remove_meta');

// Add extra taxonomy fields to the main column on the custom post edit screens.
function wde_add_countries_meta_fields() {
  wd_ecommerce();
}
add_action('wde_countries_add_form_fields', 'wde_add_countries_meta_fields', 10, 2);

// Add extra taxonomy fields to the term edit page.
function wde_countries_edit_meta_field($term) {
	wd_ecommerce($term->term_id);
}
add_action('wde_countries_edit_form_fields', 'wde_countries_edit_meta_field', 10, 2);

// Save extra taxonomy fields.
function save_wde_countries_custom_meta($term_id) {
  $term_meta = get_option("wde_countries_" . $term_id);
	if (isset($_POST['code']) && $_POST['code'] != '') {
    $term_meta['code'] = sanitize_text_field($_POST['code']);
  }
  // Save the option array.
  update_option("wde_countries_" . $term_id, $term_meta);
}
add_action('edited_wde_countries', 'save_wde_countries_custom_meta', 10, 2);
add_action('create_wde_countries', 'save_wde_countries_custom_meta', 10, 2);

// Change custom taxonomy columns to show in administrator table.
function wde_countries_columns($columns) {
  unset($columns['description']);
  unset($columns['slug']);
  unset($columns['posts']);
  return array_merge($columns, 
          array('code' => __('Country code', 'wde')));
}
add_filter('manage_edit-wde_countries_columns', 'wde_countries_columns');

// Change custom taxonomy column content in administrator table.
function wde_countries_column($columns, $column, $term_id) {
  if ($column == 'code') {
    $term_meta = get_option("wde_countries_" . $term_id);
    $columns .= $term_meta['code'];
  }
  return $columns;
}
add_filter('manage_wde_countries_custom_column', 'wde_countries_column', 10, 3);

// Delete custom taxonomy extra fields options.
function wde_countries_delete_term($term_id, $tt_id, $taxonomy) {
  delete_option("wde_countries_" . $term_id);
}
add_action('delete_wde_countries', 'wde_countries_delete_term', 10, 3);