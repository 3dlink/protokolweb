<?php

// Create custom post for products.
function wde_create_tag() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'                            => _x( 'Tags', 'post type general name', 'wde' ),
		'singular_name'                   => _x( 'Tag', 'post type singular name', 'wde' ),
		'menu_name'                       => _x( 'Tags', 'admin menu', 'wde' ),
		'all_items'                       => _x( 'All Tags', 'admin menu', 'wde' ),
		'edit_item'                       => __( 'Edit Tag', 'wde' ),
		'view_item'                       => __( 'View Tag', 'wde' ),
		'update_item'                     => __( 'Update Tag', 'wde' ),
		'add_new_item'                    => __( 'Add New Tag', 'wde' ),
		'new_item_name'                   => __( 'New Tag Name', 'wde' ),
		'parent_item  '                   => __( 'Parent Tag', 'wde' ),
		'parent_item_colon'               => __( 'Parent Tag:', 'wde' ),
		'search_items'                    => __( 'Search Tags', 'wde' ),
		'popular_items'                   => __( 'Popular Tags', 'wde' ),
		'separate_items_with_commas'      => __( 'Separate Tags with commas', 'wde' ),
		'add_or_remove_items'             => __( 'Add or remove tags', 'wde' ),
		'choose_from_most_used'           => __( 'Choose from most used', 'wde' ),
		'not_found'                       => __( 'No tags found.', 'wde' )
	);
	$args = array(
		'labels'                 => $labels,
		'public'                 => TRUE,
		'show_ui'                => TRUE,
		'show_in_nav_menus'      => TRUE,
		'show_tagcloud'          => TRUE,
		'meta_box_cb'            => NULL,
		'show_admin_column'      => TRUE,
		'hierarchical'           => FALSE,
		'update_count_callback'  => NULL,
		'query_var'              => isset($options->option_tag_base) ? $options->option_tag_base : TRUE,
		'rewrite'                => isset($options->option_tag_base) ? array('slug' => $options->option_tag_base) : TRUE,
		'sort'                   => TRUE,
  );
  register_taxonomy('wde_tag', 'wde_products', $args);  
}
add_action('init', 'wde_create_tag');

function wde_tag_columns($columns) {
  wp_enqueue_style('wde_tags_edit');
  return $columns;
}
add_filter('manage_edit-wde_tag_columns', 'wde_tag_columns');

