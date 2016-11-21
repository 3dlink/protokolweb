<?php

// Create custom post for products.
function wde_create_parameter() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'                            => _x( 'Parameters', 'post type general name', 'wde' ),
		'singular_name'                   => _x( 'Parameter', 'post type singular name', 'wde' ),
		'menu_name'                       => _x( 'Parameters', 'admin menu', 'wde' ),
		'all_items'                       => _x( 'All Parameters', 'admin menu', 'wde' ),
		'edit_item'                       => __( 'Edit Parameter', 'wde' ),
		'view_item'                       => __( 'View Parameter', 'wde' ),
		'update_item'                     => __( 'Update Parameter', 'wde' ),
		'add_new_item'                    => __( 'Add New Parameter', 'wde' ),
		'new_item_name'                   => __( 'New Parameter Name', 'wde' ),
		'parent_item  '                   => __( 'Parent Parameter', 'wde' ),
		'parent_item_colon'               => __( 'Parent Parameter:', 'wde' ),
		'search_items'                    => __( 'Search Parameters', 'wde' ),
		'popular_items'                   => __( 'Popular Parameters', 'wde' ),
		'separate_items_with_commas'      => __( 'Separate parameters with commas', 'wde' ),
		'add_or_remove_items'             => __( 'Add or remove parameters', 'wde' ),
		'choose_from_most_used'           => __( 'Choose from the most used parameters', 'wde' ),
		'not_found'                       => __( 'No parameters found.', 'wde' )
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
		'query_var'              => isset($options->option_parameter_base) ? $options->option_parameter_base : TRUE,
		'rewrite'                => isset($options->option_parameter_base) ? array('slug' => $options->option_parameter_base) : TRUE,
		'sort'                   => TRUE,
  );
  register_taxonomy('wde_parameters', 'wde_products', $args);
  
  $parameters = get_terms('wde_parameters', array( 'hide_empty' => 0 ));
  foreach ($parameters as $param) {
    $labels = array(
      'name'                            => _x( ucfirst($param->name) . 's', 'post type general name', 'wde' ),
      'singular_name'                   => _x( ucfirst($param->name), 'post type singular name', 'wde' ),
      'menu_name'                       => _x( ucfirst($param->name) . 's', 'admin menu', 'wde' ),
      'all_items'                       => _x( 'All ' . ucfirst($param->name) . 's', 'admin menu', 'wde' ),
      'edit_item'                       => __( 'Edit ' . ucfirst($param->name), 'wde' ),
      'view_item'                       => __( 'View ' . ucfirst($param->name), 'wde' ),
      'update_item'                     => __( 'Update ' . ucfirst($param->name), 'wde' ),
      'add_new_item'                    => __( 'Add New ' . ucfirst($param->name), 'wde' ),
      'new_item_name'                   => __( 'New ' . ucfirst($param->name) . ' Name', 'wde' ),
      'parent_item  '                   => __( 'Parent ' . ucfirst($param->name), 'wde' ),
      'parent_item_colon'               => __( 'Parent ' . ucfirst($param->name) . ':', 'wde' ),
      'search_items'                    => __( 'Search ' . ucfirst($param->name) . 's', 'wde' ),
      'popular_items'                   => __( 'Popular ' . ucfirst($param->name) . 's', 'wde' ),
      'separate_items_with_commas'      => __( 'Separate ' . $param->name . ' with commas', 'wde' ),
      'add_or_remove_items'             => __( 'Add or remove ' . $param->name . 's', 'wde' ),
      'choose_from_most_used'           => __( 'Choose from the most used ' . $param->name . 's', 'wde' ),
      'not_found'                       => __( 'No ' . $param->name . 's found.', 'wde' )
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
      'show_admin_column'      => FALSE,
      'hierarchical'           => FALSE,
      'update_count_callback'  => NULL,
      'query_var'              => isset($options->option_parameter_base) ? $options->option_parameter_base . '-' . $param->slug : TRUE,
      'rewrite'                => isset($options->option_parameter_base) ? array('slug' => $options->option_parameter_base . '/' . $param->slug) : TRUE,
      'sort'                   => TRUE,
    );
    register_taxonomy('wde_par_' . $param->slug, 'wde_products', $args);
    add_filter('manage_edit-wde_par_' . $param->slug . '_columns', 'wde_parameters_values_columns');
  }
}
add_action('init', 'wde_create_parameter');

// Remove parameter meta box from sidebar.
function wde_parameter_remove_meta() {
	remove_meta_box('tagsdiv-wde_parameters', 'wde_products', 'side');
  $parameters = get_terms('wde_parameters', array( 'hide_empty' => 0 ));
  foreach ($parameters as $param) {
    remove_meta_box('tagsdiv-wde_par_' . $param->slug, 'wde_products', 'side');
  }
}
add_action('admin_menu', 'wde_parameter_remove_meta');

// Add a box to the main column on the custom post edit screens.
function wde_add_parameter_meta_fields() {
  wd_ecommerce();
}
add_action('wde_parameters_add_form_fields', 'wde_add_parameter_meta_fields', 10, 2);

// Edit term page
function wde_parameters_edit_meta_field($term) {
	wd_ecommerce($term->term_id);
}
add_action('wde_parameters_edit_form_fields', 'wde_parameters_edit_meta_field', 10, 2);

// Save extra taxonomy fields callback function.
function save_wde_parameters_custom_meta($term_id) {
  $t_id = $term_id;
  $term_meta = get_option("wde_parameters_" . $t_id);
	if (isset($_POST['type_id'])) {
    $term_meta['type_id'] = $_POST['type_id'];
  }
	if (isset($_POST['default_values'])) {
    $term_meta['default_values'] = $_POST['default_values'];
  }
	if (isset($_POST['required'])) {
    $term_meta['required'] = $_POST['required'];
  }
  // Save the option array.
  update_option("wde_parameters_" . $t_id, $term_meta);
}  
add_action('edited_wde_parameters', 'save_wde_parameters_custom_meta', 10, 2);
add_action('create_wde_parameters', 'save_wde_parameters_custom_meta', 10, 2);

// Delete custom taxonomy extra fields options.
function wde_parameters_delete_term($term_id, $tt_id, $taxonomy) {
  delete_option("wde_parameters_" . $term_id);
  
  //Delete terms from default values.
  $parameters = get_terms('wde_par_' . $taxonomy->slug, array( 'hide_empty' => 0 ));
  foreach ($parameters as $param) {
    wp_delete_term($param->term_id, 'wde_par_' . $taxonomy->slug);
  }
}
add_action('delete_wde_parameters', 'wde_parameters_delete_term', 10, 3);

//change custom taxonomy columns to show in admin table
function wde_parameters_columns($columns) {
  $new_columns = array();
  $new_columns['values'] = __('Default values', 'wde');
  unset($columns['description']);
  unset($columns['posts']);
  return array_merge( $columns, $new_columns );
}
add_filter('manage_edit-wde_parameters_columns', 'wde_parameters_columns');

// Change custom taxonomy columns to show in admin table.
function wde_parameters_values_columns($columns) {
  unset($columns['posts']);
  return $columns;
}

// Change custom taxonomy column content in admin table.
function wde_parameters_column($columns, $column, $id) {
  if ($column == 'values') {
    $term = get_term($id, 'wde_parameters');
    $row_temp = get_option("wde_parameters_" . $id);
    $type_id = isset($row_temp['type_id']) ? $row_temp['type_id'] : 1;
    if ($type_id != 1) {
      $parameters = get_terms('wde_par_' . $term->slug, array('hide_empty' => 0));
      $params = array();
      if (!isset($parameters->errors)) {
        foreach ($parameters as $param) {
          array_push($params, $param->name);
        }
      }
      $href = add_query_arg(array('taxonomy' => 'wde_par_' . $term->slug, 'post_type' => 'wde_products'), admin_url('edit-tags.php'));
      $columns .= implode(', ', $params);
      $columns .= '<div class="row-actions">';
      $columns .= '<span class="edit"><a href="' . $href . '">' . __('Add/Edit', 'wde') . '</a></span>';
      $columns .= '</div>';
    }
  }
  return $columns;
}
add_filter('manage_wde_parameters_custom_column', 'wde_parameters_column', 10, 3 );