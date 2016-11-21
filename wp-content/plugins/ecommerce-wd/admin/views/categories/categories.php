<?php

// Create custom post for products.
function wde_create_category() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'                            => _x( 'Categories', 'post type general name', 'wde' ),
		'singular_name'                   => _x( 'Category', 'post type singular name', 'wde' ),
		'menu_name'                       => _x( 'Categories', 'admin menu', 'wde' ),
		'all_items'                       => _x( 'All Categories', 'admin menu', 'wde' ),
		'edit_item'                       => __( 'Edit Category', 'wde' ),
		'view_item'                       => __( 'View Category', 'wde' ),
		'update_item'                     => __( 'Update Category', 'wde' ),
		'add_new_item'                    => __( 'Add New Category', 'wde' ),
		'new_item_name'                   => __( 'New Category Name', 'wde' ),
		'parent_item  '                   => __( 'Parent Category', 'wde' ),
		'parent_item_colon'               => __( 'Parent Category:', 'wde' ),
		'search_items'                    => __( 'Search Categories', 'wde' ),
		'popular_items'                   => __( 'Popular Categories', 'wde' ),
		'separate_items_with_commas'      => __( 'Separate categories with commas', 'wde' ),
		'add_or_remove_items'             => __( 'Add or remove categories', 'wde' ),
		'choose_from_most_used'           => __( 'Choose from the most used categories', 'wde' ),
		'not_found'                       => __( 'No categories found.', 'wde' )
	);
	$args = array(
		'labels'                 => $labels,
		'public'                 => TRUE,
		'show_ui'                => TRUE,
		'show_in_nav_menus'      => TRUE,
		'show_tagcloud'          => TRUE,
		'meta_box_cb'            => NULL,
		'show_admin_column'      => TRUE,
		'hierarchical'           => TRUE,
		'update_count_callback'  => NULL,
		'query_var'              => isset($options->option_category_base) ? $options->option_category_base : TRUE,
		'rewrite'                => isset($options->option_category_base) ? array('slug' => $options->option_category_base) : TRUE,
		'sort'                   => TRUE,
  );
  register_taxonomy('wde_categories', 'wde_products', $args);  
}
add_action('init', 'wde_create_category');

// Add a box to the main column on the custom post edit screens.
function wde_add_category_meta_fields() {
  wd_ecommerce();
}
add_action('wde_categories_add_form_fields', 'wde_add_category_meta_fields', 10, 2);

// Edit term page
function wde_categories_edit_meta_field($term) {
	wd_ecommerce($term->term_id);
}
add_action('wde_categories_edit_form_fields', 'wde_categories_edit_meta_field', 10, 2);

// Save extra taxonomy fields callback function.
function save_wde_categories_custom_meta($term_id) {
  $t_id = $term_id;
  $term_meta = get_option("wde_categories_" . $t_id);
	if (isset($_POST['meta_title'])) {
    $term_meta['meta_title'] = $_POST['meta_title'];
  }
	if (isset($_POST['meta_description'])) {
    $term_meta['meta_description'] = $_POST['meta_description'];
  }
	if (isset($_POST['meta_keyword'])) {
    $term_meta['meta_keyword'] = $_POST['meta_keyword'];
  }
	if (isset($_POST['images'])) {
    $term_meta['images'] = $_POST['images'];
  }
	if (isset($_POST['tags'])) {
    $term_meta['tags'] = $_POST['tags'];
  }
	if (isset($_POST['parameters'])) {
    $term_meta['parameters'] = $_POST['parameters'];
  }
	if (isset($_POST['cshow_info'])) {
    $term_meta['cshow_info'] = $_POST['cshow_info'];
  }
	if (isset($_POST['cshow_products'])) {
    $term_meta['cshow_products'] = $_POST['cshow_products'];
  }
	if (isset($_POST['products_count'])) {
    $term_meta['products_count'] = $_POST['products_count'];
  }
	if (isset($_POST['show_subcategories'])) {
    $term_meta['show_subcategories'] = $_POST['show_subcategories'];
  }
	if (isset($_POST['show_tree'])) {
    $term_meta['show_tree'] = $_POST['show_tree'];
  }
	if (isset($_POST['subcategories_cols'])) {
    $term_meta['subcategories_cols'] = $_POST['subcategories_cols'];
  }
  // Save the option array.
  update_option("wde_categories_" . $t_id, $term_meta);  
}  
add_action('edited_wde_categories', 'save_wde_categories_custom_meta', 10, 2);
add_action('create_wde_categories', 'save_wde_categories_custom_meta', 10, 2);

// Delete custom taxonomy extra fields options.
function wde_categories_delete_term($term_id, $tt_id, $taxonomy) {
  delete_option("wde_categories_" . $term_id);
}
add_action('delete_wde_categories', 'wde_categories_delete_term', 10, 3);

//change custom taxonomy columns to show in admin table
function wde_categories_columns($columns) {
  $new_columns = array();
  $new_columns['cb'] = $columns['cb'];
  $new_columns['thumb'] = __('Thumbnail', 'wde');
  unset($columns['cb']);
  unset($columns['description']);
  return array_merge( $new_columns, $columns );
}
add_filter('manage_edit-wde_categories_columns', 'wde_categories_columns');

//change custom taxonomy column content in admin table
function wde_categories_column($columns, $column, $id) {
  wp_enqueue_style('wde_categories_edit');
  if ($column == 'thumb') {
    $term_meta = get_option("wde_categories_" . $id);
    $image = isset($term_meta['images']) ? $term_meta['images'] : '';
    $image = wp_get_attachment_thumb_url($image);
    // $image = str_replace(' ', '%20', $image );
    $columns .= WDFHTML::jf_show_image_wp($image);
  }
  return $columns;
}
add_filter('manage_wde_categories_custom_column', 'wde_categories_column', 10, 3 );