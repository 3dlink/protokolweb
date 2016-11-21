<?php

// Create custom post for manufacturers.
function wde_create_manufacturers_posttype() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'               => _x( 'Manufacturers', 'post type general name', 'wde' ),
		'singular_name'      => _x( 'Manufacturer', 'post type singular name', 'wde' ),
		'menu_name'          => _x( 'Manufacturers', 'admin menu', 'wde' ),
		'name_admin_bar'     => _x( 'Manufacturer', 'add new on admin bar', 'wde' ),
		'add_new'            => _x( 'Add New', 'book', 'wde' ),
		'add_new_item'       => __( 'Add New Manufacturer', 'wde' ),
		'new_item'           => __( 'New Manufacturer', 'wde' ),
		'edit_item'          => __( 'Edit Manufacturer', 'wde' ),
		'view_item'          => __( 'View Manufacturer', 'wde' ),
		'all_items'          => __( 'Manufacturers', 'wde' ),
		'search_items'       => __( 'Search Manufacturers', 'wde' ),
		'parent_item_colon'  => __( 'Parent Manufacturers:', 'wde' ),
		'not_found'          => __( 'No manufacturers found.', 'wde' ),
		'not_found_in_trash' => __( 'No manufacturers found in Trash.', 'wde' )
	);
	$args = array(
		'labels'             => $labels,
    'menu_icon'          => WD_E_URL . '/images/toolbar_icons/manufacturers_20.png',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => 'edit.php?post_type=wde_products',
		'query_var'          => isset($options->option_manufacturer_base) ? $options->option_manufacturer_base : TRUE,
		'rewrite'            => isset($options->option_manufacturer_base) ? array('slug' => $options->option_manufacturer_base) : TRUE,
		// 'rewrite'            => array('slug' => 'wde_manufacturers', "with_front" => true),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => TRUE,
		'supports'           => array('title', 'editor', 'author', 'thumbnail')
  );
  register_post_type('wde_manufacturers', $args);
}
add_action('init', 'wde_create_manufacturers_posttype');

// Add a box to the main column on the custom post edit screens.
function wde_manufacturers_add_meta_box() {
  add_meta_box(
    'wde_manufacturers_section',
    __('Manufacturer data', 'wde'),
    'wde_manufacturers_meta_box_callback',
    'wde_manufacturers',
    'advanced',
    'high'
  );
}
add_action('add_meta_boxes', 'wde_manufacturers_add_meta_box');

// Add custom field label header to custom post table.
function wde_manufacturers_add_custom_columns($columns) {
  unset($columns['author']);
  unset($columns['date']);
  return array_merge($columns, 
          array('logo' => __('Logo', 'wde'),
                'site' => __('Website', 'wde'),
          ));
}
add_filter('manage_wde_manufacturers_posts_columns' , 'wde_manufacturers_add_custom_columns');

// Add custom field value to custom post table.
function wde_manufacturers_action_custom_columns_content($column_id, $post_id) {
  switch ($column_id) { 
    case 'logo': {
      $title = trim(strip_tags(get_the_title($post_id)));
      $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'post-thumbnail');
      // echo get_the_post_thumbnail($post_id, array(50, 50), array('alt' => $title, 'title' => $title));
      echo ($title == '' && $thumbnail == '') ? __('No Image', 'wde') : '<img class="attachment-post-thumbnail wp-post-image" title="' . $title . '" alt="' . $title . '" src="' . $thumbnail[0] . '" />';
      break;
    }
    case 'site': {
      echo (($value = get_post_meta($post_id, 'wde_site', TRUE)) ? $value : '');
      break;
    }
  }
}
add_action('manage_wde_manufacturers_posts_custom_column', 'wde_manufacturers_action_custom_columns_content', 10, 2);

// Make columns sortable.
function wde_manufacturers_sortable_cake_column($columns) {
  wp_enqueue_style('wde_' . WDFInput::get_controller() . '_edit');
  return $columns;
}
add_filter('manage_edit-wde_manufacturers_sortable_columns', 'wde_manufacturers_sortable_cake_column');

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function wde_manufacturers_meta_box_callback($post) {
  wp_nonce_field('wde_meta_box', 'nonce_wde');
  wd_ecommerce();
}

/**
 * Save custom data on post save.
 *
 * @param int $post_id The ID of the post being saved.
 */
function wde_manufacturers_save_meta_box_data($post_id, $post) {
	if (!wde_manufacturers_verify($post_id, $post)) {
    return;
  }

  $fields = array(
    'site',
    'show_info',
    'show_products',
    'products_count',
    'meta_title',
    'meta_description',
    'meta_keyword',
  );
  foreach ($fields as $field) {
    // Make sure that it is set.
    if (isset($_POST[$field])) {
      // Sanitize user input.
      $data = sanitize_text_field($_POST[$field]);
    }
    else {
      $data = 0;
    }
    // Update the meta field in the database.
    update_post_meta($post_id, 'wde_' . $field, $data);
  }
}
add_action('save_post', 'wde_manufacturers_save_meta_box_data', 10, 2);

function wde_manufacturers_verify($post_id, $post) {
  // Check post type
  if ($post->post_type != 'wde_manufacturers') {
    return FALSE;
  }
  
  // Check if our nonce is set.
	if (!isset($_POST['nonce_wde'])) {
		return FALSE;
	}

	// Verify that the nonce is valid.
	if (!wp_verify_nonce($_POST['nonce_wde'], 'wde_meta_box')) {
		return FALSE;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return FALSE;
	}

	// Check the user's permissions.
	if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return FALSE;
		}
	} else {
		if (!current_user_can('edit_post', $post_id)) {
			return FALSE;
		}
	}
  return TRUE;
}