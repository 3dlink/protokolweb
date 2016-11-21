<?php

// Create custom post for products.
function wde_create_product_posttype() {
  $options = WDFDb::get_options();
  $labels = array(
		'name'               => _x( 'Products', 'post type general name', 'wde' ),
		'singular_name'      => _x( 'Product', 'post type singular name', 'wde' ),
		'menu_name'          => _x( 'Products', 'admin menu', 'wde' ),
		'name_admin_bar'     => _x( 'Product', 'add new on admin bar', 'wde' ),
		'add_new'            => _x( 'Add New', 'book', 'wde' ),
		'add_new_item'       => __( 'Add New Product', 'wde' ),
		'new_item'           => __( 'New Product', 'wde' ),
		'edit_item'          => __( 'Edit Product', 'wde' ),
		'view_item'          => __( 'View Product', 'wde' ),
		'all_items'          => __( 'All Products', 'wde' ),
		'search_items'       => __( 'Search Products', 'wde' ),
		'parent_item_colon'  => '',
		'not_found'          => __( 'No products found.', 'wde' ),
		'not_found_in_trash' => __( 'No products found in Trash.', 'wde' )
	);
	$args = array(
		'labels'             => $labels,
    'menu_icon'          => WD_E_URL . '/images/toolbar_icons/products_20.png',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => isset($options->option_product_base) ? $options->option_product_base : TRUE,
		'rewrite'            => isset($options->option_product_base) ? array('slug' => $options->option_product_base) : TRUE,
    // "rewrite" => array( "slug" => "manufacturer/%series_name%", "with_front" => true ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array('title', 'editor', 'author', 'thumbnail', 'page-attributes', 'comments')
  );
  register_post_type('wde_products', $args);
  // add_rewrite_rule('^manufacturer/(.*)/([^/]+)/?$', 'index.php?wde_products=$matches[2]', 'top');
  // add_rewrite_rule('^product/([^/]+)/?$', 'index.php?wde_products=$matches[1]', 'top');
}
add_action('init', 'wde_create_product_posttype');

// function my_custom_bulk_actions($actions){
        // return array_merge($actions, array('aa' => 'bb'));
    // }
    // add_filter('bulk_actions-edit-wde_products','my_custom_bulk_actions');

function wde_products_post_type_link($link, $post) {
  if (get_post_type($post) == 'wde_products') {
    // Get the parent manufacturer name.
    if ($post->post_parent) {
      $parent = get_post($post->post_parent);
      if (!empty($parent->post_name)) {
        return str_replace('%series_name%', $parent->post_name, $link);
      }
    }
    else {
      // When product has not parent.
      return str_replace('manufacturer/%series_name%', 'product', $link);
    }
  }
  return $link;
}
// add_filter('post_type_link', 'wde_products_post_type_link', 10, 2);

// Add a box to the main column on the custom post edit screens.
function wde_add_meta_box() {
  // Product special parameters.
  add_meta_box('wde_short_desc_section', __('Short description', 'wde'), 'wde_meta_box_short_desc', 'wde_products', 'advanced', 'high');
  // Product special parameters.
  add_meta_box('wde_products_section', __('Product data', 'wde'), 'wde_meta_box_callback', 'wde_products', 'advanced', 'high');
  // Manufacturer select box.
  add_meta_box('wde_manufacturers_section', __('Select manufacturer', 'wde'), 'wde_select_manufacturer', 'wde_products', 'side', 'core');
}
add_action('add_meta_boxes', 'wde_add_meta_box');

// Add custom field label header to custom post table.
function wde_add_custom_columns($columns) {
  unset($columns['author']);
  unset($columns['date']);
  unset($columns['taxonomy-wde_tag']);
  unset($columns['taxonomy-wde_parameters']);
  unset($columns['taxonomy-wde_discounts']);
  unset($columns['taxonomy-wde_taxes']);
  unset($columns['taxonomy-wde_labels']);
  unset($columns['taxonomy-wde_shippingmethods']);
  unset($columns['taxonomy-wde_countries']);
  return array_merge($columns, 
          array('taxonomy-wde_categories' => __('Category', 'wde'),
                'manufacturer' => __('Manufacturer', 'wde'),
                'price' => __('Price', 'wde'),
                'amount_in_stock' => __('Amount in stock', 'wde'),
                'label' => __('Label', 'wde'),
                'thumbnail' => __('Thumbnail', 'wde'),
          ));
}
add_filter('manage_wde_products_posts_columns' , 'wde_add_custom_columns');

// Add custom field value to custom post table.
function wde_action_custom_columns_content($column_id, $post_id) {
  switch ($column_id) {
    case 'manufacturer': {
      $pp_id = get_post($post_id)->post_parent;
      if (!empty($pp_id)) {
        $get_post = get_post($pp_id);
        $pp_title = $get_post->post_title;
        echo $pp_title;
      }
      break;
    }
    case 'price': {
      $row_default_currency = WDFDb::get_row('currencies', '`default`= 1');
      echo (($value = get_post_meta($post_id, 'wde_price', TRUE)) ? WDFText::wde_number_format($value, 2) : '0.00') . ' ' . $row_default_currency->code;
      break;
    }
    case 'amount_in_stock': {
      $unlimited = get_post_meta($post_id, 'wde_unlimited', TRUE);
      if ($unlimited) {
        $amount_in_stock = __('Unlimited', 'wde');
      }
      else {
        $amount_in_stock = get_post_meta($post_id, 'wde_amount_in_stock', TRUE);
      }
      echo $amount_in_stock;
      break;
    }
    case 'label': {
      $label = wp_get_object_terms($post_id, 'wde_labels');
      $image = __('No label', 'wde');
      if (isset($label[0])) {
        $term = $label[0];
        if (isset($term->term_id)) {
          $term_meta = get_option("wde_labels_" . $term->term_id);
          if (isset($term_meta['thumb']) && $term_meta['thumb']) {
            $image = WDFHTML::jf_show_image_wp(wp_get_attachment_thumb_url($term_meta['thumb']));
          }
          elseif (isset($term->name) && $term->name) {
            $image = $term->name;
          }
        }
      }
      echo $image;
      break;
    }
    case 'thumbnail': {
      $func_name = '';
      if (!has_post_thumbnail($post_id)) {
        $image_ids_string = get_post_meta($post_id, 'wde_images', TRUE);
        $image_ids = explode(',', $image_ids_string);
        if (isset($image_ids[0]) && is_numeric($image_ids[0]) && $image_ids[0] != 0) {
          $image_id = (int) $image_ids[0];
          $func_name = 'wp_get_attachment_image';
        }
      }
      else {
        $image_id = $post_id;
        $func_name = 'get_the_post_thumbnail';
      }
      $title = trim(strip_tags(get_the_title($post_id)));
      if ($func_name) {
        $image = $func_name($image_id, array(50, 50), array('alt' => $title,	'title'	=> $title));
      }
      else {
        $image = __('No image', 'wde');
      }
      echo $image;
      break;
    }
  }
}
add_action('manage_wde_products_posts_custom_column', 'wde_action_custom_columns_content', 10, 2);

// Make columns sortable.
function wde_sortable_custom_column($columns) {
  wp_enqueue_style('wde_' . WDFInput::get_controller() . '_edit');
  $columns['price'] = 'wde_price';
  $columns['amount_in_stock'] = 'wde_amount_in_stock';

  return $columns;
}
add_filter('manage_edit-wde_products_sortable_columns', 'wde_sortable_custom_column');

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function wde_meta_box_callback($post) {
  wp_nonce_field('wde_meta_box', 'nonce_wde');
  wd_ecommerce();
}

/**
 * Prints the editor for short description.
 */
function wde_meta_box_short_desc($post) {
  $short_description = get_post_meta($post->ID, 'wde_short_description', TRUE);
  if (user_can_richedit()) {
    wp_editor($short_description, 'short_description', array('teeny' => FALSE, 'textarea_name' => 'short_description', 'media_buttons' => FALSE, 'textarea_rows' => 5));
  }
  else {
    ?>
  <textarea class="wde_short_description" rows="5" id="short_description" name="short_description">
    <?php echo $short_description; ?>
  </textarea>
    <?php
  }
  ?>
  <p class="howto"><?php _e('Show short description of product on all progucts page and single product pages.', 'wde'); ?></p>
  <?php
}

/**
 * Save custom data on post save.
 *
 * @param int $post_id The ID of the post being saved.
 */
function wde_save_meta_box_data($post_id, $post) {
	if (!wde_verify($post_id, $post)) {
    return;
  }

  $fields = array(
    'short_description',
    'meta_title',
    'meta_description',
    'meta_keyword',
    'model',
    'price',
    // 'tax_id',
    // 'tax_rate',
    // 'discount_id',
    // 'discount_rate',
    'market_price',
    'unlimited',
    'amount_in_stock',
    'sku',
    'upc',
    'ean',
    'jan',
    'isbn',
    'mpn',
    'enable_shipping',
    'weight',
    'dimensions',
    'images',
    'videos',
    // 'label_id',
    'page_ids',
    // 'shipping_method_ids',
    'parameters',
    'rating',
  );
  foreach ($fields as $field) {
    // Make sure that it is set.
    if ($field == 'dimensions') {
      $dim_arr = array();
      $dim_arr['dimensions_length'] = isset($_POST['dimensions_length']) ? sanitize_text_field($_POST['dimensions_length']) : "";
      $dim_arr['dimensions_width'] = isset($_POST['dimensions_width']) ? sanitize_text_field($_POST['dimensions_width']) : "";
      $dim_arr['dimensions_height'] = isset($_POST['dimensions_height']) ? sanitize_text_field($_POST['dimensions_height']) : "";
      $dim_arr = array_diff($dim_arr, array(''));
      $data = implode('x', $dim_arr);
    }
    elseif ($field == 'price') {
      $data = WDFText::float_val(sanitize_text_field($_POST[$field]), 2);
    }
    elseif ($field == 'rating') {
      // If product is not rated.
      add_post_meta($post_id, 'wde_' . $field, 0, TRUE);
      continue;
    }
    elseif ($field == 'short_description') {
      $data = stripslashes($_POST[$field]);
    }
    elseif (isset($_POST[$field])) {
      // Sanitize user input.
      $data = sanitize_text_field($_POST[$field]);
    }
    else {
      $data = 0;
    }
    // Update the meta field in the database.
    update_post_meta($post_id, 'wde_' . $field, $data);
  }
  if (isset($_POST['parameters']) && sanitize_text_field($_POST['parameters'])) {
    $parameters = WDFJson::decode(stripslashes(sanitize_text_field($_POST['parameters'])));
    wp_delete_object_term_relationships($post_id, 'wde_parameters');
    foreach ($parameters as $parameter) {
      $param_slug = get_term($parameter->id, 'wde_parameters');
      wp_set_object_terms($post_id, $param_slug->slug, 'wde_parameters', TRUE);
      wp_delete_object_term_relationships($post_id, 'wde_par_' . $param_slug->slug);
      foreach ($parameter->values as $value) {
        $val = WDFJson::decode($value);
        wp_set_object_terms($post_id, $val->value, 'wde_par_' . $param_slug->slug, TRUE);
        if (isset($val->value_id)) {
          wp_update_term( $val->value_id, 'wde_par_' . $param_slug->slug, array( 'name' => $val->value ) );
        }
      }
    }
  }
  else {
    wp_delete_object_term_relationships($post_id, 'wde_parameters');
  }
  if (isset($_POST['shipping_method_ids']) && sanitize_text_field($_POST['shipping_method_ids'])) {
    $shipping_method_ids = explode(',', sanitize_text_field($_POST['shipping_method_ids']));
    $shipping_method_ids = array_map('intval', $shipping_method_ids);
    wp_set_object_terms($post_id, $shipping_method_ids, 'wde_shippingmethods', FALSE);
  }
  else {
    wp_delete_object_term_relationships($post_id, 'wde_shippingmethods');
  }
  if (isset($_POST['label_id']) && sanitize_text_field($_POST['label_id'])) {
    $label_id = (int) sanitize_text_field($_POST['label_id']);
    wp_set_object_terms($post_id, $label_id, 'wde_labels', FALSE);
  }
  else {
    wp_delete_object_term_relationships($post_id, 'wde_labels');
  }
  if (isset($_POST['tax_id']) && sanitize_text_field($_POST['tax_id'])) {
    $tax_id = (int) sanitize_text_field($_POST['tax_id']);
    wp_set_object_terms($post_id, $tax_id, 'wde_taxes', FALSE);
  }
  else {
    wp_delete_object_term_relationships($post_id, 'wde_taxes');
  }
  if (isset($_POST['discount_id']) && sanitize_text_field($_POST['discount_id'])) {
    $discount_id = (int) sanitize_text_field($_POST['discount_id']);
    wp_set_object_terms($post_id, $discount_id, 'wde_discounts', FALSE);
  }
  else {
    wp_delete_object_term_relationships($post_id, 'wde_discounts');
  }
  flush_rewrite_rules();
}
add_action('save_post', 'wde_save_meta_box_data', 10, 2);

function wde_verify($post_id, $post) {
  // Check post type
  if ($post->post_type != 'wde_products') {
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

// Display category and manufacturer dropdown in admin.
function wde_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'wde_products';

	if ($typenow == $post_type) {
    $taxonomy  = 'wde_categories';
    $parent  = 'wde_manufacturers_filter';
    // Display a category dropdown.
		wp_dropdown_categories(array(
			'show_option_all' => __('Show all categories', 'wde'),
			'taxonomy' => $taxonomy,
			'name' => $taxonomy,
			'orderby' => 'name',
			'selected' => isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '',
			'show_count' => TRUE,
			'hide_empty' => FALSE,
			'hierarchical' => TRUE,
		));
    // Display a manufacturer dropdown.
    wp_dropdown_pages(array(
			'show_option_none' => __('Show all manufacturers', 'wde'),
			'post_type' => 'wde_manufacturers',
			'name' => $parent,
			'sort_order'   => 'ASC',
      'sort_column'  => 'post_title',
			'selected' => isset($_REQUEST[$parent]) ? esc_html($_REQUEST[$parent]) : '',
		));
	}
}
add_action('restrict_manage_posts', 'wde_filter_post_type_by_taxonomy');

// Custom filter for posts by category and manufacturer in admin.
function wde_convert_id_to_term_in_query($query) {
  global $pagenow;
	$post_type = 'wde_products';

	$q_vars = &$query->query_vars;
	if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type) {
    $taxonomy  = 'wde_categories';
    $parent  = 'wde_manufacturers_filter';
    // Filter posts by category.
    if (isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
      $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
      $q_vars[$taxonomy] = $term->slug;
    }
    // Filter posts by parent.
    if (isset($_REQUEST[$parent]) && is_numeric($_REQUEST[$parent]) && $_REQUEST[$parent] != 0) {
      $q_vars['post_parent'] = esc_html($_REQUEST[$parent]);
      $q_vars['name'] = '';
    }
	}
  
}
add_filter('parse_query', 'wde_convert_id_to_term_in_query');

// Change parent dropdown arguments.
// function wde_products_parent_args($dropdown_args, $post = null) {
  // if ($dropdown_args['post_type'] == 'wde_products') {
    // $dropdown_args['post_type'] = 'wde_manufacturers';
    // $dropdown_args['show_option_none'] = __('No manufacturer selected', 'wde');
  // }
  // return $dropdown_args;
// }
// add_filter('page_attributes_dropdown_pages_args', 'wde_products_parent_args', 10, 2);

function wde_select_manufacturer($post) {
  $pages = wp_dropdown_pages(array(
    'post_type' => 'wde_manufacturers',
    'selected' => $post->post_parent,
    'name' => 'parent_id',
    'show_option_none' => __('No manufacturer selected', 'wde'),
    'sort_order'   => 'ASC',
    'sort_column'  => 'post_title',
    'echo' => 0));
  ?>
  <p><strong><?php echo __('Manufacturer:', 'wde'); ?></strong></p>
  <label class="screen-reader-text" for="parent_id"><?php echo __('Manufacturer:', 'wde'); ?></label>
  <?php
  echo !empty($pages) ? $pages : '';
}

/**
 * Save custom data on post save.
 */
function wde_products_query($query) {
  // Run this code only when we are on the public archive.
  if ((isset($query->query_vars['post_type']) && 'wde_products' != $query->query_vars['post_type']) || ! $query->is_main_query() || is_admin()) {
    return;
  }
  // Fix query for hierarchical study permalinks.
  if (isset($query->query_vars['name']) && isset($query->query_vars['wde_products'])) {
    // Remove the parent name.
    $query->set('name', basename(untrailingslashit($query->query_vars['name'])));
    // Unset this.
    // $query->set('wde_products', null);
  }
}
add_filter('pre_get_posts', 'wde_products_query');

function wde_products_query_action($query) {
  // In the main WP query, if an orderby query variable is designated.
  if ($query->is_main_query() && ($orderby = $query->get('orderby'))) {
    if ($orderby == 'wde_amount_in_stock' || $orderby == 'wde_price') {
      // Ordering by 'meta_key'. Set query's meta_key, which is used for custom fields.
      $query->set('meta_key', $orderby);
      // Tell the query to order by our custom field/meta_key's value.
      // If your meta value are numbers, change 'meta_value'to 'meta_value_num'.
      $query->set('orderby', 'meta_value_num');
    }
  }
}
add_action('pre_get_posts', 'wde_products_query_action', 1);

/*
 * Add the duplicate link to action list for wde_products.
 */
function wde_products_duplicate_link($actions, $post) {
	if (current_user_can('edit_posts')) {
    global $typenow;
    if ($typenow == 'wde_products') {
      $view = $actions['view'];
      unset($actions['view']);
      $actions['duplicate'] = '<a href="' . add_query_arg(array('action' => 'wde_products_duplicate', 'post' => $post->ID), admin_url()) . '" title="' . __('Duplicate this item', 'wde') . '" rel="permalink">' . __('Duplicate', 'wde') . '</a>';
      $actions['view'] = $view;
    }
	}
	return $actions;
}
add_filter('post_row_actions', 'wde_products_duplicate_link', 10, 2);

/*
 * Duplicate post.
 */
function wde_products_duplicate() {
	$post_id = (isset($_GET['post']) ? esc_html($_GET['post']) : esc_html($_POST['post']));
	$post = get_post($post_id);
	if (isset($post) && $post != NULL && isset($_REQUEST['action']) && 'wde_products_duplicate' == $_REQUEST['action']) {
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => $post->post_status,
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
		$new_post_id = wp_insert_post($args);
		// Get all current post terms and set them.
		$taxonomies = get_object_taxonomies($post->post_type);
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
		// Duplicate all post meta just in two SQL queries.
    global $wpdb;
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos) != 0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query .= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}

		wp_redirect(add_query_arg(array('post_type' => 'wde_products'), admin_url('edit.php')));
		exit;
	}
  else {
		wp_die(__('Product creation failed, could not find original product.', 'wde'));
	}
}
add_action('admin_action_wde_products_duplicate', 'wde_products_duplicate');

/*
add_action('admin_head', 'custom_bulk_admin_footer');
function custom_bulk_admin_footer() {
  global $post_type;
  if ($post_type == 'wde_products') {
    $discounts = get_terms('wde_discounts', array('hide_empty' => FALSE));
    ?>
    <script type="text/javascript">
      jQuery(document).ready(function() {
        jQuery('<option>').val('discount').attr("disabled", "disabled").text('<?php _e('Choose Discount', 'wde')?>').appendTo("select[name='action']");
        jQuery('<option>').val('discount').attr("disabled", "disabled").text('<?php _e('Choose Discount', 'wde')?>').appendTo("select[name='action2']");
        <?php
        foreach ($discounts as $discount) {
          $term_meta = get_option("wde_discounts_" . $discount->term_id);
          $rate = $term_meta['rate'];
          $rate_text = (isset($term_meta['rate']) && $term_meta['rate']) ? ' (' . $term_meta['rate'] . '%) ' : '';
          $discount_details = $discount->name . $rate_text;
          ?>
          jQuery('<option>').val('discount<?php echo $discount->term_id ?>').html('&nbsp;&nbsp;<?php echo $discount_details; ?>').appendTo("select[name='action']");
          jQuery('<option>').val('discount<?php echo $discount->term_id ?>').html('&nbsp;&nbsp;<?php echo $discount_details; ?>').appendTo("select[name='action2']");
          <?php
        }
        ?>
      });
    </script>
    <?php
  }
}

add_action('load-edit.php', 'custom_bulk_action');
 
function custom_bulk_action() {
  // 1. get the action
  $wp_list_table = _get_list_table('WP_Posts_List_Table');
  $action = $wp_list_table->current_action();

  // 2. security check
  // check_admin_referer('bulk-posts');

  if (strpos($action, 'discount') !== FALSE) {
    if (isset($_REQUEST['post'])) {
      $post_ids = array_map('intval', $_REQUEST['post']);
    }
    else {
      return;
    }
    $discount_id = (int) str_replace('discount', '', $action);
    foreach ($post_ids as $post_id) {
      // wp_delete_object_term_relationships($post_id, 'wde_discounts');
      wp_set_object_terms($post_id, $discount_id, 'wde_discounts', FALSE);
    }
    $sendback = add_query_arg(array('discount' => 1), wp_get_referer());
    wp_redirect($sendback);
    exit();
  }
}

add_action('admin_notices', 'custom_bulk_admin_notices');
 
function custom_bulk_admin_notices() {
  global $post_type, $pagenow;
  if ($pagenow == 'edit.php' && $post_type == 'wde_products' && isset($_REQUEST['discount']) && (int) $_REQUEST['discount']) {
    echo "<div class='updated'><p>aaaa</p></div>";
  }
}*/


function wde_products_bulk_edit($column_name, $post_type) {
  if ($post_type != 'wde_products' || $column_name != 'price') {
    return;
  }
  ?>
  <fieldset class="inline-edit-col-right">
    <div class="inline-edit-group">
      <label class="inline-edit-wde_discounts alignleft">
        <span class="title"><?php _e('Discount', 'wde'); ?></span>
        <select class="wde_discounts" name="wde_discounts">
          <option value="-1"><?php _e('&mdash; No change &mdash;', 'wde'); ?></option>
          <option value="0"><?php _e('&mdash; Remove discount &mdash;', 'wde'); ?></option>
          <?php
          $discounts = get_terms('wde_discounts', array('hide_empty' => FALSE));
          foreach ($discounts as $discount) {
            $term_meta = get_option("wde_discounts_" . $discount->term_id);
            $rate = $term_meta['rate'];
            $rate_text = (isset($term_meta['rate']) && $term_meta['rate']) ? ' (' . $term_meta['rate'] . '%) ' : '';
            $discount_details = $discount->name . $rate_text;
            ?>
          <option value="<?php echo esc_attr($discount->term_id); ?>"><?php echo $discount_details; ?></option>
            <?php
          }
					?>
        </select>
      </label>
    </div>
    <div class="inline-edit-group">
      <label class="inline-edit-wde_taxes alignleft">
        <span class="title"><?php _e('Tax', 'wde'); ?></span>
        <select class="wde_taxes" name="wde_taxes">
          <option value="-1"><?php _e('&mdash; No change &mdash;', 'wde'); ?></option>
          <option value="0"><?php _e('&mdash; Remove tax &mdash;', 'wde'); ?></option>
          <?php
          $taxes = get_terms('wde_taxes', array('hide_empty' => FALSE));
          foreach ($taxes as $tax) {
            $term_meta = get_option("wde_taxes_" . $tax->term_id);
            $rate = $term_meta['rate'];
            $rate_text = (isset($term_meta['rate']) && $term_meta['rate']) ? ' (' . $term_meta['rate'] . '%) ' : '';
            $tax_details = $tax->name . $rate_text;
            ?>
          <option value="<?php echo esc_attr($tax->term_id); ?>"><?php echo $tax_details; ?></option>
            <?php
          }
					?>
        </select>
      </label>
    </div>
    <div class="inline-edit-group">
      <label class="inline-edit-wde_shippingmethods alignleft">
        <span class="title"><?php _e('Shipping method', 'wde'); ?></span>
        <ul class="shipping-checklist">
          <li>
              <label class="selectit">
              <input type="checkbox" name="wde_shippingmethods_remove" value="-1" /><?php _e('Remove shipping methods', 'wde'); ?>
            </label>
          </li>
          <?php
          $shippingmethods = get_terms('wde_shippingmethods', array('hide_empty' => FALSE));
          foreach ($shippingmethods as $shippingmethod) {
            $term_meta = get_option("wde_shippingmethods_" . $shippingmethod->term_id);
            $row_default_currency = WDFDb::get_row('currencies', '`default` = 1');
            if ($term_meta['free_shipping'] == 1) {
              $price = __('free shipping', 'wde');
            }
            else {
              $price = WDFText::wde_number_format($term_meta['price'], 2) . ' ' . $row_default_currency->code;
            }
            $details = $shippingmethod->name . ' (' . $price . ')';
            ?>
          <li>
            <label class="selectit">
              <input type="checkbox" name="wde_shippingmethods" value="<?php echo esc_attr($shippingmethod->term_id); ?>" /><?php echo $details; ?>
            </label>
          </li>
            <?php
          }
					?>
        </ul>
      </label>
    </div>
    <?php wp_nonce_field('nonce_wde', 'nonce_wde'); ?>
  </fieldset>
  <?php
}
add_action('bulk_edit_custom_box', 'wde_products_bulk_edit', 10, 2);

function wde_products_bulk_edit_scripts() {
  global $pagenow;
  if ($pagenow == 'edit.php' && (isset($_GET['post_type']) && $_GET['post_type'] == 'wde_products')) {
    wp_register_script('wde_products_bulk_edit', WD_E_URL . '/js/products/bulk_edit.js', array('jquery'));
    wp_enqueue_script('wde_products_bulk_edit');
    wp_register_style('wde_products_bulk_edit', WD_E_URL . '/css/products/bulk_edit.css');
    wp_enqueue_style('wde_products_bulk_edit');
  }
}
add_action('admin_enqueue_scripts', 'wde_products_bulk_edit_scripts', 10, 1);

function save_bulk_edit_wde_products() {
  check_admin_referer('nonce_wde', 'nonce_wde');
	$post_ids = (!empty($_POST['post_ids'])) ? $_POST['post_ids'] : array();
  // Add data to bulk_edit.js.
	$discount_id = (!empty($_POST['wde_discounts'])) ? (int) $_POST['wde_discounts'] : 0;
  if (!empty($post_ids) && is_array($post_ids) && $discount_id != -1) {
    if ($discount_id === 0) {
      foreach ($post_ids as $post_id) {
        wp_delete_object_term_relationships($post_id, 'wde_discounts');
      }
    }
    else {
      foreach ($post_ids as $post_id) {
        wp_set_object_terms($post_id, $discount_id, 'wde_discounts', FALSE);
      }
    }
  }
  $tax_id = (!empty($_POST['wde_taxes'])) ? (int) $_POST['wde_taxes'] : 0;
  if (!empty($post_ids) && is_array($post_ids) && $tax_id != -1) {
    if ($tax_id === 0) {
      foreach ($post_ids as $post_id) {
        wp_delete_object_term_relationships($post_id, 'wde_taxes');
      }
    }
    else {
      foreach ($post_ids as $post_id) {
        wp_set_object_terms($post_id, $tax_id, 'wde_taxes', FALSE);
      }
    }
  }
  if (!empty($post_ids) && is_array($post_ids)) {
    $wde_shippingmethods_remove = (!empty($_POST['wde_shippingmethods_remove'])) ? $_POST['wde_shippingmethods_remove'] : 0;
    if ($wde_shippingmethods_remove == -1) {
      foreach ($post_ids as $post_id) {
        wp_delete_object_term_relationships($post_id, 'wde_shippingmethods');
        update_post_meta($post_id, 'wde_enable_shipping', 0);
      }
    }
    elseif (sanitize_text_field($_POST['wde_shippingmethods'])) {
      $wde_shippingmethods = explode(',', sanitize_text_field($_POST['wde_shippingmethods']));
      $shipping_method_ids = array_map('intval', $wde_shippingmethods);
      foreach ($post_ids as $post_id) {
        wp_set_object_terms($post_id, $shipping_method_ids, 'wde_shippingmethods', FALSE);
        update_post_meta($post_id, 'wde_enable_shipping', 1);
      }
    }
  }
	die();
}
add_action('wp_ajax_save_bulk_edit_wde_products', 'save_bulk_edit_wde_products');