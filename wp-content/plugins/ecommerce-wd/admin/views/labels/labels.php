<?php


// Create custom taxonomy for labels.
function wde_create_label() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'                            => _x( 'Labels', 'post type general name', 'wde' ),
		'singular_name'                   => _x( 'Label', 'post type singular name', 'wde' ),
		'menu_name'                       => _x( 'Labels', 'admin menu', 'wde' ),
		'all_items'                       => _x( 'All Labels', 'admin menu', 'wde' ),
		'edit_item'                       => __( 'Edit Label', 'wde' ),
		'view_item'                       => __( 'View Label', 'wde' ),
		'update_item'                     => __( 'Update Label', 'wde' ),
		'add_new_item'                    => __( 'Add New Label', 'wde' ),
		'new_item_name'                   => __( 'New Label Name', 'wde' ),
		'parent_item  '                   => __( 'Parent Label', 'wde' ),
		'parent_item_colon'               => __( 'Parent Label:', 'wde' ),
		'search_items'                    => __( 'Search Labels', 'wde' ),
		'popular_items'                   => __( 'Popular Labels', 'wde' ),
		'separate_items_with_commas'      => __( 'Separate Labels with commas', 'wde' ),
		'add_or_remove_items'             => __( 'Add or remove labels', 'wde' ),
		'choose_from_most_used'           => __( 'Choose from most used labels', 'wde' ),
		'not_found'                       => __( 'No labels found.', 'wde' )
	);
	$args = array(
		'labels'                 => $labels,
		'public'                 => TRUE,
		'show_ui'                => TRUE,
		'show_in_nav_menus'      => TRUE,
		'show_tagcloud'          => FALSE,
		'show_in_quick_edit'     => FALSE,
		'meta_box_cb'            => NULL,
		'show_admin_column'      => TRUE,
		'hierarchical'           => FALSE,
		'update_count_callback'  => NULL,
		'query_var'              => isset($options->option_label_base) ? $options->option_label_base : TRUE,
		'rewrite'                => isset($options->option_label_base) ? array('slug' => $options->option_label_base) : TRUE,
		'sort'                   => TRUE,
  );
  register_taxonomy('wde_labels', 'wde_products', $args);
}
add_action('init', 'wde_create_label');

// Remove labels meta box from siderbar.
function wde_labels_remove_meta() {
	remove_meta_box('tagsdiv-wde_labels', 'wde_products', 'side');
}
add_action('admin_menu' , 'wde_labels_remove_meta');

// Add extra taxonomy fields to the main column on the custom post edit screens.
function wde_add_labels_meta_fields() {
  wd_ecommerce();
}
add_action('wde_labels_add_form_fields', 'wde_add_labels_meta_fields', 10, 2);

// Add extra taxonomy fields to the term edit page.
function wde_labels_edit_meta_field($term) {
	wd_ecommerce($term->term_id);
}
add_action('wde_labels_edit_form_fields', 'wde_labels_edit_meta_field', 10, 2);

// Save extra taxonomy fields.
function save_wde_labels_custom_meta($term_id) {
  $term_meta = get_option("wde_labels_" . $term_id);
	if (isset($_POST['thumb'])) {
    $term_meta['thumb'] = sanitize_text_field($_POST['thumb']);
  }
  if (isset($_POST['thumb_position'])) {
    $term_meta['thumb_position'] = sanitize_text_field($_POST['thumb_position']);
  }
  // Save the option array.
  update_option("wde_labels_" . $term_id, $term_meta);
}
add_action('edited_wde_labels', 'save_wde_labels_custom_meta', 10, 2);
add_action('create_wde_labels', 'save_wde_labels_custom_meta', 10, 2);

// Change custom taxonomy columns to show in administrator table.
function wde_labels_columns($columns) {
  unset($columns['description']);
  unset($columns['slug']);
  unset($columns['posts']);
  return array_merge($columns, 
          array('thumbs' => __('Thumbnail', 'wde')));
}
add_filter('manage_edit-wde_labels_columns', 'wde_labels_columns');

// Change custom taxonomy column content in administrator table.
function wde_labels_column($columns, $column, $term_id) {
  if ($column == 'thumbs') {
    $term_meta = get_option("wde_labels_" . $term_id);
    $columns .= WDFHTML::jf_show_image_wp(wp_get_attachment_thumb_url($term_meta['thumb']));
  }
  return $columns;
}
add_filter('manage_wde_labels_custom_column', 'wde_labels_column', 10, 3);

// Delete custom taxonomy extra fields options.
function wde_labels_delete_term($term_id, $tt_id, $taxonomy) {
  delete_option("wde_labels_" . $term_id);
}
add_action('delete_wde_labels', 'wde_labels_delete_term', 10, 3);