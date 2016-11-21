<?php
class WDFProduct {
  const PRODUCTS_ARRANGEMENT_THUMBS = 'thumbs';
  const PRODUCTS_ARRANGEMENT_LIST = 'list';
  const PRODUCTS_ARRANGEMENT_BLOG_STYLE = 'blog_style';

  const MAX_LENGTH_NAME_THUMBS_VIEW = 35;
  const MAX_LENGTH_DESCRIPTION_THUMBS_VIEW = 100;
  const MAX_LENGTH_NAME_LIST_VIEW = 30;
  const MAX_LENGTH_DESCRIPTION_LIST_VIEW = 30;
  const MAX_LENGTH_NAME_BLOG_STYLE_VIEW = 35;
  const MAX_LENGTH_DESCRIPTION_BLOG_STYLE_VIEW = 800;

  const MAX_REVIEWS_PRODUCT_VIEW = 5;

  const REVIEWS_COUNT_TO_LOAD = 5;
  const MAX_LENGTH_DESCRIPTION_WRITE_REVIEW = 240;

  /**
   * Get list of manufacturers for checkbox list
   *
   * @since 2.0.14
   *
   * @return array List of manufacturers.
  */
  public static function get_filter_manufacturer_rows() {
    $args = array(
      'posts_per_page'   => 0,
      'offset'           => 0,
      'category'         => '',
      'category_name'    => '',
      'orderby'          => 'title',
      'order'            => 'ASC',
      'include'          => '',
      'exclude'          => '',
      'meta_key'         => '',
      'meta_value'       => '',
      'post_type'        => 'wde_manufacturers',
      'post_mime_type'   => '',
      'post_parent'      => '',
      'author'	         => '',
      'post_status'      => 'publish',
      'suppress_filters' => true 
    );
    $posts_array = get_posts($args);
    
    $manufacturer_rows = array();
    foreach ($posts_array as $post) {
      $manufacturer = new stdClass();
      $manufacturer->id = $post->ID;
      $manufacturer->name = $post->post_title;
      array_push($manufacturer_rows, $manufacturer);
    }
    return $manufacturer_rows;
  }

  /**
   * Get list of date ranges for filters
   *
   * @since 2.0.14
   *
   * @return array List of date ranges.
  */
  public static function get_filter_date_added_ranges() {
    $date_added_ranges = array();

    $date_added_ranges[1] = __('Today', 'wde');
    $date_added_ranges[2] = __('Last week', 'wde');
    $date_added_ranges[3] = __('Last two weeks', 'wde');
    $date_added_ranges[4] = __('Last month', 'wde');
    $date_added_ranges[0] = __('Any date', 'wde');

    return $date_added_ranges;
  }

  /**
   * Get list of fields to sort by
   *
   * @since 2.0.14
   *
   * @return array List of value/name pairs of fields.
  */
  public static function get_sortables_list() {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();

    $sortables_list = array();
    $sortables_list['ordering'] = array('value' => 'ordering', 'text' => __('Relevance', 'wde'));
    if ($options->sort_by_name == 1) {
      $sortables_list['name'] = array('value' => 'name', 'text' => __('Name', 'wde'));
    }
    if ($options->sort_by_manufacturer == 1) {
      $sortables_list['manufacturer'] = array('value' => 'manufacturer', 'text' => __('Manufacturer', 'wde'));
    }
    if ($options->sort_by_price == 1) {
      $sortables_list['price'] = array('value' => 'price', 'text' => __('Price', 'wde'));
    }
    if (($options->feedback_enable_product_reviews) && ($options->sort_by_count_of_reviews == 1)) {
      $sortables_list['reviews_count'] = array('value' => 'reviews_count', 'text' => __('Number of reviews', 'wde'));
    }
    if (($options->feedback_enable_product_rating == 1) && ($options->sort_by_rating)) {
      $sortables_list['rating'] = array('value' => 'rating', 'text' => __('Rating', 'wde'));
    }

    return $sortables_list;
  }

  /**
   * Get arrangement data
   *
   * @since 2.0.14
   *
   * @param array $params.
   * @return array.
  */
  public static function get_arrangement_data($params) {
    $arrangement_data = array();
    $arrangement_data['arrangement'] = WDFCookie::get('arrangement', WDFInput::get('arrangement', WDFParams::get($params, 'arrangement', 'thumbs')));
    return $arrangement_data;
  }

  /**
   * Get ordering information
   *
   * @since 2.0.14
   *
   * @param array $params.
   * @return array List of sort_by and sort_order information.
  */
  public static function get_sort_data($params) {
    $sort_data = array();
    if(WDFInput::get('type')) {
      $sort_data['sort_by'] = WDFInput::get('order');
      $sort_data['sort_order'] = WDFInput::get('direction');
    }
    else {
      $sort_data['sort_by'] = WDFCookie::get('sort_by', WDFInput::get('sort_by', WDFParams::get($params, 'ordering')));
      $sort_data['sort_order'] = WDFCookie::get('sort_order', WDFInput::get('sort_order', WDFParams::get($params, 'order_dir')));
    }
    return $sort_data;
  }
  
  /**
   * Get search parameters
   *
   * @since 2.0.14
   *
   * @param array $params.
   * @return array List of search parameters.
  */
  public static function get_search_data($params = null) {
    $search_data = array();

    $search_data['category_id'] = (int) WDFInput::get('search_category_id', WDFParams::get($params, 'category_id'));
    $search_data['name'] = WDFInput::get('search_name', '');

    return $search_data;
  }

  /**
   * Get filter parameters
   *
   * @since 2.0.14
   *
   * @param array $params.
   * @return array List of filter parameters.
  */
  public static function get_filters_data($params) {
    $filters_data = array();

    $filters_data['filters_opened'] = WDFInput::get('filter_filters_opened', 0, 'int');
    if (WDFInput::get('filter_manufacturer_ids') !== NULL) {
      $manufacturer_ids = WDFInput::get_array('filter_manufacturer_ids', ',', array());
    }
    else {
      $manufacturer_ids = (isset($params['manufacturer_id']) && $params['manufacturer_id']) ? explode(',', $params['manufacturer_id']): array();
    }
    array_walk($manufacturer_ids, create_function('&$value', '$value = (int)$value;'));
    $filters_data['manufacturer_ids'] = $manufacturer_ids;

    $filters_data['price_from'] = max(0, WDFInput::get('filter_price_from', isset($params['min_price']) ? $params['min_price'] : 0, 'double'));
    $filters_data['price_from'] = $filters_data['price_from'] == 0 ? '' : $filters_data['price_from'];
    $filters_data['price_to'] = max(0, WDFInput::get('filter_price_to', isset($params['max_price']) ? $params['max_price'] : 0, 'double'));
    $filters_data['price_to'] = $filters_data['price_to'] == 0 ? '' : $filters_data['price_to'];
    $filters_data['date_added_range'] = (int) WDFInput::get('filter_date_added_range', isset($params['date_added']) ? $params['date_added'] : 0);
    $filters_data['minimum_rating'] = (int) WDFInput::get('filter_minimum_rating', isset($params['min_rating']) ? $params['min_rating'] : 0);
    $selected_tags = array();
    if (WDFInput::get('filter_tags') !== NULL) {
      $selected_tags = WDFInput::get_array('filter_tags', ',', array(), true, true);
    }
    elseif (isset($params['tags']) && $params['tags']) {
      $tag_ids = explode(',', $params['tags']);
      $selected_tags = array();
      foreach ($tag_ids as $tag_id) {
        if ($tag_id != 0) {
          $term = get_term((int) $tag_id, 'wde_tag');
          $selected_tags[]= $term->name;
        }
      }
    }
    $filters_data['tags'] = $selected_tags;
    return $filters_data;
  }
  
  /**
   * Get product rating.
   *
   * @since 2.0.14
   *
   * @param int $product_id Product ID.
   * @return object rating, can_rate, ratings_count.
  */
  public static function get_product_rating($product_id) {
    global $wpdb;
    $query = 'SELECT FORMAT(T_RATINGS.rating, 1) AS rating';
    $query .= ', CASE
            WHEN T_USER_RATINGS.ratings_count > 0 THEN 0
            WHEN T_USER_RATINGS.ratings_count = 0 THEN 1
            WHEN T_USER_RATINGS.ratings_count IS NULL THEN 1
            END AS can_rate';
    $query .= ', T_USER_RATINGS.ratings_count AS ratings_count';
    $query .= ' FROM (SELECT product_id, AVG(rating) AS rating FROM ' . $wpdb->prefix . 'ecommercewd_ratings GROUP BY product_id) AS T_RATINGS';
    if (is_user_logged_in()) {
      $user_identification = 'j_user_id = ' . get_current_user_id();
    }
    else {
      $user_ip_address = WDFUtils::get_client_ip_address();
      $user_identification = 'user_ip_address = "' . $user_ip_address . '"';
    }
    $query .= ' LEFT JOIN (
              SELECT
                  product_id,
                  COUNT(rating) AS ratings_count
              FROM
                  ' . $wpdb->prefix . 'ecommercewd_ratings
              WHERE ' . $user_identification . '
              GROUP BY product_id
          ) AS T_USER_RATINGS ON T_USER_RATINGS.product_id = T_RATINGS.product_id';
    $query .= ' WHERE T_RATINGS.product_id=' . $product_id;
    return $wpdb->get_row($query);
  }

  /**
   * Add tags to products in product list.
   *
   * @since 2.0.14
   *
   * @param array $product_rows Products list.
  */
  public static function add_product_tags($product_rows) {
    for ($i = 0; $i < count($product_rows); $i++) {
      $product_row = $product_rows[$i];
      $tag_rows = wp_get_post_terms($product_row->id, 'wde_tag', array('orderby' => 'name', 'order' => 'ASC'));
      if (!isset($tag_rows->error)) {
        $product_row->tags = $tag_rows;
      }
      else {
        $product_row->tags = array();
      }
    }
  }

  /**
   * Add shipping methods to products in product list.
   *
   * @since 2.0.14
   *
   * @param array $product_rows Products list.
  */
  public static function add_product_shipping_methods($product_rows) {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();

    $decimals = $options->option_show_decimals == 1 ? 2 : 0;

    $row_default_currency = WDFDb::get_row('currencies', '`default`=1');

    for ($i = 0; $i < count($product_rows); $i++) {
      $product_row = $product_rows[$i];
      $shipping_methods_rows = wp_get_post_terms($product_row->id, 'wde_shippingmethods', array('orderby' => 'name', 'order' => 'ASC'));
      if (!isset($shipping_methods_rows->error)) {
        foreach ($shipping_methods_rows as $shipping_method) {
          $term_meta = get_option("wde_shippingmethods_" . $shipping_method->term_id);
          $shipping_method->price = isset($term_meta['price']) ? $term_meta['price'] : '0.00';
          $shipping_method->free_shipping = isset($term_meta['free_shipping']) ? $term_meta['free_shipping'] : 0;
          $shipping_method->free_shipping_start_price = isset($term_meta['free_shipping_start_price']) ? $term_meta['free_shipping_start_price'] : '0.00';
          // prices
          $shipping_method->price = $shipping_method->free_shipping == 1 ? 0 : $shipping_method->price;
          // number format and currency signs
          if ($shipping_method->price != 0) {
            $shipping_method->price_text = WDFText::wde_number_format(WDFText::float_val($shipping_method->price, $decimals), $decimals);
            if ($row_default_currency->sign_position == 0) {
              $shipping_method->price_text = $row_default_currency->sign . $shipping_method->price_text;
            }
            else {
              $shipping_method->price_text = $shipping_method->price_text . $row_default_currency->sign;
            }
          }
          else {
            $shipping_method->price_text = __('Free shipping', 'wde');
          }
        }
        $product_row->shipping_methods = $shipping_methods_rows;
      }
      else {
        $product_row->shipping_methods = array();
      }
    }
  }

  /**
   * Add related products list to products in product list.
   *
   * @since 2.0.14
   *
   * @param array $product_rows Products list.
  */
  public static function add_product_related_products($product_rows) {
    for ($i = 0; $i < count($product_rows); $i++) {
      $product_row = $product_rows[$i];
      $categories_rows = wp_get_post_terms($product_row->id, 'wde_categories', array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'names'));
      $args = array(
        'posts_per_page'   => 15,
        'offset'           => 0,
        'category'         => '',
        'category_name'    => '',
        'orderby'          => 'rand',
        'order'            => 'DESC',
        'include'          => '',
        'exclude'          => $product_row->id,
        'meta_key'         => '',
        'meta_value'       => '',
        'post_type'        => 'wde_products',
        'post_mime_type'   => '',
        'post_parent'      => '',
        'post_status'      => 'publish',
        'tax_query' => array(
          array(
            'taxonomy' => 'wde_categories',
            'field' => 'slug',
            'terms' => $categories_rows ? $categories_rows : 0
          )
        )
      );
      $related_product_rows = get_posts($args);
      // add data
      if (is_array($related_product_rows)) {
        foreach ($related_product_rows as $related_product_row) {
          $related_product_row->id =  $related_product_row->ID;
          $related_product_row->name =  $related_product_row->post_title;
          // link
          $related_product_row->link = get_permalink($related_product_row->id);

          // image
          $url = '';
          if (!has_post_thumbnail($related_product_row->id)) {
            $image_ids_string = get_post_meta($related_product_row->id, 'wde_images', TRUE);
            $image_ids = explode(',', $image_ids_string);
            if (isset($image_ids[0]) && is_numeric($image_ids[0]) && $image_ids[0] != 0) {
              $image_id = (int) $image_ids[0];
              $url = wp_get_attachment_url($image_id);
            }
          }
          else {
            $url = wp_get_attachment_url(get_post_thumbnail_id($related_product_row->id));
          }
          $related_product_row->image = $url;
        }
      }
      $product_row->related_products = $related_product_rows;
    }
  }

  /**
   * Add parameters to products in product list.
   *
   * @since 2.0.14
   *
   * @param array $product_rows Products list.
  */
  public static function add_product_parameters($product_rows) {
    for ($i = 0; $i < count($product_rows); $i++) {
      $product_row = $product_rows[$i];
      $parameter_rows = WDFJson::decode($product_row->parameters);
      $parameters = array();
      if (is_array($parameter_rows)) {
        foreach ($parameter_rows as $parameter_row) {
          if (isset($parameters[$parameter_row->id]) == FALSE) {
            $parameter = new stdClass();
            $term = get_term($parameter_row->id, 'wde_parameters');
            $parameter->name = !is_wp_error($term) ? $term->name : '';
            $parameter->id = $parameter_row->id;
            $parameter->type_id = $parameter_row->type_id;
            $parameter->values = array();
            $parameter->prices = array();
          }
          else {
            $parameter = $parameters[$parameter_row->id];
          }
          if (is_array($parameter_row->values)) {
            foreach ($parameter_row->values as $parameter_values) {
              $parameter_value = WDFJson::decode($parameter_values);
              $parameter->values[] = $parameter_value->value;
              $parameter->prices[] = $parameter_value->price;
            }
          }
          $parameters[$parameter_row->id] = $parameter;
        }
      }
      $product_row->parameters = $parameters;
    }
  }

  /**
   * Get product selectable parameters.
   *
   * @since 2.0.14
   *
   * @param int $product_id Product ID.
   * @param int $product_row NULL Product.
   * @return array Product selectable parameters.
  */
  public static function get_product_selectable_parameters($product_id, $product_row = NULL) {
    if (!$product_row) {
      return;
    }
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();
    $decimals = $options->option_show_decimals == 1 ? 2 : 0;

    // get values
    $product_selectable_parameters_data = $product_row->parameters;
    foreach ($product_selectable_parameters_data as $key => $product_selectable_parameter_data) {
      $values_list = array();
      $product_selectable_parameter_data_values_list = $product_selectable_parameter_data->values;
      $product_selectable_parameter_data_prices_list = $product_selectable_parameter_data->prices;
      if ($product_selectable_parameter_data->type_id == 2) {
        unset($product_selectable_parameters_data[$key]);
      }
      foreach ($product_selectable_parameter_data_values_list as $key => $value) {
        $values_list[$key]['value'] = $value;
        $values_list[$key]['parameter_price'] = $product_selectable_parameter_data_prices_list[$key];
        $price = substr($values_list[$key]['parameter_price'], 1);
        $price_sign = substr($values_list[$key]['parameter_price'], 0, 1);
        $values_list[$key]['parameter_price'] = '';
        if (WDFText::wde_number_format($price, $decimals) != WDFText::wde_number_format(0, $decimals)) {
          $values_list[$key]['parameter_price'] = $price_sign . WDFText::wde_number_format(WDFText::float_val($price, $decimals), $decimals);
        }
      }
      $product_selectable_parameter_data->values_list = $values_list;
    }
    return $product_selectable_parameters_data;
  }

  /**
   * Add selectable parameters to products in product list.
   *
   * @since 2.0.14
   *
   * @param array $product_rows Products list.
  */
  public static function add_product_selectable_parameters($product_rows) {
    for ($i = 0; $i < count($product_rows); $i++) {
      $product_row = $product_rows[$i];
      $selectable_parameters = self::get_product_selectable_parameters($product_row->id, $product_row);
      if ($selectable_parameters === false) {
        return false;
      }
      $product_row->selectable_parameters = $selectable_parameters;
    }
  }

  /*
  
  */
  public static function get_selectable_params_empty_row($product_id, $product_row = NULL) {
    $product_selectable_params = self::get_product_selectable_parameters($product_id, $product_row);
    return $product_selectable_params;
  }

  /**
   * Get products.
   *
   * @since 2.0.14
   *
   * @param array $ids Product IDs to get.
   * @param bool $use_search_and_filters FALSE Whether to use search and filters.
   * @param bool $use_pagination FALSE Whether to use pagination.
   * @param bool $use_menu_params FALSE Whether to use menu parameters NOT IN USE.
   * @param array $params NULL.
   * @param bool $is_frontend_ajax FALSE Is frontend ajax call.
   * @return array of products array and pagination if using pagination otherwise products array
  */
  public static function get_product_rows($ids, $use_search_and_filters = false, $use_pagination = false, $use_menu_params = false, $params = null, $is_frontend_ajax = false) {
    if (($ids != null) && (is_array($ids) == false)) {
      $ids = array($ids);
    }
    $model_options = WDFHelper::get_model('options', $is_frontend_ajax);
    $options = $model_options->get_options();

    $decimals = $options->option_show_decimals == 1 ? 2 : 0;

    $row_default_currency = WDFDb::get_row('currencies', '`default`=1');

    $args = array(
      'post_type' => 'wde_products',
      'post_status' => array('publish'),
    );
    if ($ids != null) {
      $args['post__in'] = $ids;
    }

    if ($use_search_and_filters == true) {
      $search_data = self::get_search_data($params);

      if (($options->search_enable_search == 1) && ($search_data['name'] != '')) {
        $args['s'] = $search_data['name'];
      }

      $tax_query = array();
      if (($options->search_enable_search == 1) && ($options->search_by_category) && ($search_data['category_id'] != '')) {
        $category_ids = array($search_data['category_id']);
        $categories_query = array(
          'taxonomy' => 'wde_categories',
          'terms'    => $category_ids,
          'include_children' => $options->search_include_subcategories
        );
        array_push($tax_query, $categories_query);
      }

      $filters_data = self::get_filters_data($params);

      if (($options->search_enable_search == 1) && ($options->filter_manufacturers) && (count($filters_data['manufacturer_ids']) > 0)) {
        $args['post_parent__in'] = $filters_data['manufacturer_ids'];
      }

      $meta_query = array();

      if (($options->search_enable_search == 1) && ($options->filter_price)) {
        if ($filters_data['price_from'] != '') {
          $price_query = array(
            'key'     => 'wde_price',
            'value'   => WDFText::float_val($filters_data['price_from'], $decimals),
            'type'    => 'numeric',
            'compare' => '>=',
          );
          array_push($meta_query, $price_query);
        }
        if ($filters_data['price_to'] != '') {
          $price_query = array(
            'key'     => 'wde_price',
            'value'   => WDFText::float_val($filters_data['price_to'], $decimals),
            'type'    => 'numeric',
            'compare' => '<=',
          );
          array_push($meta_query, $price_query);
        }
      }
      
      if (($options->search_enable_search == 1) && ($options->filter_minimum_rating) && ($options->feedback_enable_product_rating) && ($filters_data['minimum_rating'] != 0)) {
        $rating_query = array(
          'key'     => 'wde_rating',
          'value'   => $filters_data['minimum_rating'],
          'type'    => 'numeric',
          'compare' => '>=',
        );
        array_push($meta_query, $rating_query);
      }
      
      if (($options->search_enable_search == 1) && ($options->filter_date_added == 1)) {
        $interval = '';
        switch ($filters_data['date_added_range']) {
          case 1:
            $interval = '-1 day';
            break;
          case 2:
            $interval = '-1 week';
            break;
          case 3:
            $interval = '-2 week';
            break;
          case 4:
            $interval = '-1 month';
            break;
        }
        $date_query = array();
        $date_after = getdate(strtotime($interval));
        $date_query['after']['year'] = $date_after['year'];
        $date_query['after']['month'] = $date_after['mon'];
        $date_query['after']['day'] = $date_after['mday'];
        $date_query['inclusive'] = true;

        $args['date_query'] = array($date_query);
      }
      
      if (($options->search_enable_search == 1) && ($options->filter_tags == 1)) {
        foreach ($filters_data['tags'] as $tag_name) {
          $tag_query = array(
            'taxonomy' => 'wde_tag',
            'field'    => 'name',
            'terms'    => $tag_name
          );
          array_push($tax_query, $tag_query);
        }
      }
      
      $sort_data = self::get_sort_data($params);
      $sort_by = '';
      $meta_key = '';
      $sort_order = ($sort_data['sort_order'] == "asc" || $sort_data['sort_order'] == "desc" || $sort_data['sort_order'] == "") ? strtoupper($sort_data['sort_order']) : "ASC";

      switch ($sort_data['sort_by']) {
        case 'ordering':
          $sort_by = 'menu_order';
          break;
        case 'name':
          $sort_by = 'name';
          break;
        case 'manufacturer':
          $sort_by = 'parent';
          break;
        case 'price':
          $sort_by = 'meta_value_num';
          $meta_key = 'wde_price';
          break;
        case 'reviews_count':
          $sort_by = 'comment_count';
          break;
        case 'rating':
          $sort_by = 'meta_value_num';
          $meta_key = 'wde_rating';
          break;
      }
      $args['orderby'] = $sort_by;
      $args['order'] = $sort_order;
      $args['meta_key'] = $meta_key;
      
      $args['tax_query'] = $tax_query;
      $args['meta_query'] = $meta_query;

      $args['nopaging'] = $use_pagination;
    }
    else if ($use_menu_params == true){
      // Not in use. Not implemented.
    }
    $query = new WP_Query($args);
    if ($use_pagination) {
      $theme = WDFHelper::get_model('theme')->get_theme_row();
      $limit_start = WDFInput::get('pagination_limit_start', 0, 'int');
      $limit = WDFInput::get('pagination_limit', $theme->products_count_in_page, 'int');
      $limit = $limit ? $limit : $theme->products_count_in_page;

      $pagination = new stdClass();
      $pagination->limitstart = $limit_start;
      $pagination->limit = $limit;
      $pagination->current = $limit_start / $limit + 1;
      $pagination->start = 1;
      $pagination->stop = ceil(count($query->posts) / $limit);
      $pagination->total = $pagination->stop;
    }
    else {
      $pagination = new stdClass();
      $pagination->limitstart = 0;
      $pagination->limit = 1;
    }

    $fields = array(
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
    );
    $product_rows = array();
    if ($query->have_posts()) {
      foreach ($query->posts as $index => $product_row) {
        if (!$use_pagination || ($index >= $pagination->limitstart && $index < $pagination->limitstart + $pagination->limit)) {
          // $product_row = get_post($id);
          $product_row->id = $product_row->ID;
          $rating = self::get_product_rating($product_row->id);
          if ($rating) {
            $product_row->rating = $rating->rating;
            $product_row->can_rate = $rating->can_rate;
            $product_row->ratings_count = $rating->ratings_count;
          }
          foreach ($fields as $field) {
            $product_row->$field = esc_attr(get_post_meta($product_row->id, 'wde_' . $field, TRUE));
          }
          $product_row->name = $product_row->post_title;
          $product_row->description = wpautop($product_row->post_content);
          $product_row->short_description = wpautop(get_post_meta($product_row->id, 'wde_short_description', TRUE));

          // url
          $product_row->url = get_permalink($product_row->id);
          $product_row->url_absolute = $product_row->url;

          // image
          $url = '';
          if (!has_post_thumbnail($product_row->id)) {
            $image_ids_string = get_post_meta($product_row->id, 'wde_images', TRUE);
            $image_ids = explode(',', $image_ids_string);
            if (isset($image_ids[0]) && is_numeric($image_ids[0]) && $image_ids[0] != 0) {
              $image_id = (int) $image_ids[0];
              $url = wp_get_attachment_url($image_id);
            }
          }
          else {
            $attachment_id = get_post_thumbnail_id($product_row->id);
            $product_row->images  = $attachment_id . ',' . $product_row->images;
            $url = wp_get_attachment_url($attachment_id);
          }
          $product_row->image = $url;
          //videos
          $product_row->videos = explode(',', $product_row->videos);
          $product_row->videos = array_map('wp_get_attachment_url', $product_row->videos);

          // label
          $label = wp_get_object_terms($product_row->id, 'wde_labels');
          $product_row->label_id = isset($label[0]->term_id) ? $label[0]->term_id : '';
          $product_row->label_name = isset($label[0]->name) ? $label[0]->name : '';
          $term_meta = get_option("wde_labels_" . $product_row->label_id);
          $product_row->label_thumb = isset($term_meta['thumb']) ? wp_get_attachment_url($term_meta['thumb']) : '';
          $product_row->label_thumb_position = isset($term_meta['thumb_position']) ? $term_meta['thumb_position'] : '';
          
          // discount data
          $discount = wp_get_object_terms($product_row->ID, 'wde_discounts');
          $product_row->discount_id = isset($discount[0]->term_id) ? $discount[0]->term_id : 0;
          $discount = get_option("wde_discounts_" . $product_row->discount_id);
          $product_row->discount_rate = $discount['rate'];
          if (($discount['date_from'] != '' && $discount['date_from'] > date('Y-m-d')) || ($discount['date_to'] != '' && $discount['date_to'] < date('Y-m-d'))) {
            $product_row->discount_rate = '';
          }

          // rating
          $product_row->rating_url = '';
          $product_row->rating_msg = '';
          if ($product_row->ratings_count > 0) {
            $product_row->can_rate = 0;
          }
          else {
             $product_row->can_rate = 1;
          }

          if (/*($options->feedback_enable_guest_feedback == 0) && */(!is_user_logged_in())) {
            $product_row->can_rate = 0;
            $product_row->rating_msg = __('Login to rate', 'wde');
          }
          elseif ($product_row->can_rate === 0) {
            $product_row->rating_msg = __('You have already rated this product', 'wde');
          }
          else {
            $product_row->rating_url = add_query_arg(array('task' => 'ajax_rate_product'), $product_row->url_absolute);
          }

          // category
          $categories_rows = wp_get_post_terms($product_row->id, 'wde_categories', array('orderby' => 'name', 'order' => 'ASC'));
          $product_row->category_url = $categories_rows;

          // manufacturer
          $product_row->manufacturer_url = '';
          $product_row->manufacturer_logo = '';
          $product_row->manufacturer_name = '';
          if ($product_row->post_parent != 0) {
            $product_row->manufacturer_url = get_permalink($product_row->post_parent);
            $product_row->manufacturer_name = get_the_title($product_row->post_parent);
            $product_row->manufacturer_logo = wp_get_attachment_url(get_post_thumbnail_id($product_row->post_parent));
          }

          // prices
          $price = WDFText::float_val($product_row->price, $decimals);

          $product_row->price_without_t_d = $price;
          $product_row->price_without_t_d_text = WDFHelper::price_text($price, $decimals, $row_default_currency);
          if (isset($_POST['parameters_price'])) {
            $price += (float) $_POST['parameters_price'];
          }

          if ($options->option_include_discount_in_price && $product_row->discount_rate) {
            $price -= ($product_row->discount_rate * $price / 100);
          }

          $product_row->price_without_t = $price;
          $product_row->price_without_t_text = WDFHelper::price_text($price, $decimals, $row_default_currency);

          $calculated_tax_rates = WDFHelper::calculate_tax_rates($price, $product_row->ID);
          if ($calculated_tax_rates) {
            $price = $options->option_include_tax_in_price ? $calculated_tax_rates['tax_price'] : $calculated_tax_rates['price'];
          }

          $product_row->market_price_text = WDFHelper::price_text($product_row->market_price, $decimals, $row_default_currency);
          $product_row->price_text = WDFHelper::price_text($price, $decimals, $row_default_currency);

          $product_row->price_suffix = '';
          if ($options->price_display_suffix) {
            $product_row->price_suffix = str_replace(array('{price_including_tax}', '{price_excluding_tax}'), array($product_row->price_text, $product_row->price_without_t_text), $options->price_display_suffix);
          }

          $product_row->currency_sign = $row_default_currency->sign;
          // availability
          if ($product_row->unlimited == 1) {
            $product_row->is_available = TRUE;
            $product_row->available_msg = __('In stock', 'wde');
            $product_row->stock_class = 'class="wd_in_stock"';
          }
          elseif ($product_row->amount_in_stock > 0) {
            $product_row->is_available = TRUE;
            $product_row->available_msg = __('In stock', 'wde') . ': ' . $product_row->amount_in_stock;
            $product_row->stock_class = 'class="wd_in_stock"';
          }
          else {
            $product_row->is_available = FALSE;
            $product_row->available_msg = __('Out of stock', 'wde');
            $product_row->stock_class = 'class="wd_out_of_stock"';
          }

          // checkout privileges
          $products_in_stock = ($product_row->amount_in_stock > 0) || ($product_row->unlimited == 1) ? true : false;
          $product_row->can_checkout = $products_in_stock == true ? true : false;

          // compare url
          $product_row->compare_url = WDFPath::add_pretty_query_args(get_permalink($product_row->id), $options->option_endpoint_compare_products, '1', FALSE);;

          // review urls
          $product_row->reviews_url = "";
          $product_row->write_review_url = "";
          $product_rows[] = $product_row;
        }
      }
    }
    return $use_pagination ? array($product_rows, $pagination) : $product_rows;
  }
  
  /**
   * Get products view data.
   *
   * @since 2.0.14
   *
   * @param array $params.
   * @return array products view data.
  */
  public static function get_products_view_data($params) {
    $pagination = true;
    $product_rows_data = self::get_product_rows(null, true, $pagination, true, $params);

    if ($product_rows_data === false) {
      WDFHelper::show_error(2);
    }

    $product_rows = $product_rows_data[0];
    $pagination = $product_rows_data[1];
    // prepare data
    if (WDFInput::get('type')) {
      $arrangement_data = WDFInput::get('arrangement');
      
      $arrangement['arrangement'] = $arrangement_data;
      switch ($arrangement) {
        case self::PRODUCTS_ARRANGEMENT_THUMBS:
          $name_max_length = self::MAX_LENGTH_NAME_THUMBS_VIEW;
          $description_max_length = self::MAX_LENGTH_DESCRIPTION_THUMBS_VIEW;
          break;
        case self::PRODUCTS_ARRANGEMENT_LIST:
          $name_max_length = self::MAX_LENGTH_NAME_LIST_VIEW;
          $description_max_length = self::MAX_LENGTH_DESCRIPTION_LIST_VIEW;
          break;
        default:
          $name_max_length = self::MAX_LENGTH_NAME_THUMBS_VIEW;
          $description_max_length = self::MAX_LENGTH_DESCRIPTION_THUMBS_VIEW;
          break;
      }
    }
    else {
      $arrangement_data = self::get_arrangement_data($params);
      $arrangement = $arrangement_data['arrangement'];
      switch ($arrangement) {
        case self::PRODUCTS_ARRANGEMENT_THUMBS:
          $name_max_length = self::MAX_LENGTH_NAME_THUMBS_VIEW;
          $description_max_length = self::MAX_LENGTH_DESCRIPTION_THUMBS_VIEW;
          break;
        case self::PRODUCTS_ARRANGEMENT_LIST:
          $name_max_length = self::MAX_LENGTH_NAME_LIST_VIEW;
          $description_max_length = self::MAX_LENGTH_DESCRIPTION_LIST_VIEW;
          break;
        case self::PRODUCTS_ARRANGEMENT_BLOG_STYLE:
          $name_max_length = self::MAX_LENGTH_NAME_BLOG_STYLE_VIEW;
          $description_max_length = self::MAX_LENGTH_DESCRIPTION_BLOG_STYLE_VIEW;
          break;
        default:
          $name_max_length = self::MAX_LENGTH_NAME_THUMBS_VIEW;
          $description_max_length = self::MAX_LENGTH_DESCRIPTION_THUMBS_VIEW;
          break;
      }
    }
    $min_price = -1;
    $max_price = -1;
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();
    $decimals = $options->option_show_decimals == 1 ? 2 : 0;
    //get 
    self::add_product_parameters($product_rows);
    for ($i = 0; $i < count($product_rows); $i++) {
      $product_row = $product_rows[$i];

      // shorten name
      if (strlen($product_row->name) > $name_max_length) {
         // $product_row->name = substr($product_row->name, 0, $name_max_length - 3) . '...';
        $product_row->name = join("", array_slice( preg_split("//u", $product_row->name, -1, PREG_SPLIT_NO_EMPTY), 0, $name_max_length - 3)). '...';		
      }

      // shorten description
      if ($product_row->short_description) {
        $product_row->description = $product_row->short_description;
      }
      if (strlen(strip_tags($product_row->description)) > $description_max_length) {
        $product_row->description = WDFText::truncate_html($product_row->description, $description_max_length - 3);
      }

      //empty parameters
      $product_row->parameters = self::get_selectable_params_empty_row($product_row->id, $product_row);
      
      // get products min and max price
      if (WDFText::float_val($product_row->price, $decimals) > $max_price || $max_price === -1) {
        $max_price = WDFText::float_val($product_row->price, $decimals);
      }
      if (WDFText::float_val($product_row->price, $decimals) < $min_price || $min_price === -1) {
        $min_price = WDFText::float_val($product_row->price, $decimals);
      }
    }
    if ($max_price === -1) {
      $max_price = 0;
    }
    if ($min_price === -1) {
      $min_price = 0;
    }

    // get products min and max price
    $products_min_and_max_price_data = array();
    $products_min_and_max_price_data['min_price'] = WDFText::wde_number_format($min_price, $decimals);
    $products_min_and_max_price_data['max_price'] = WDFText::wde_number_format($max_price, $decimals);

    $data = array();
    $data['search_data'] = self::get_search_data();
    
    $search_categories_list = array(
      'show_option_all'    => __('Any category', 'wde'),
      'show_option_none'   => '',
      'option_none_value'  => '-1',
      'orderby'            => 'NAME',
      'order'              => 'ASC',
      'show_count'         => 0,
      'hide_empty'         => 0,
      'child_of'           => 0,
      'exclude'            => '',
      'echo'               => 0,
      'selected'           => $data['search_data']['category_id'],
      'hierarchical'       => $options->search_include_subcategories == true ? 1 : 0,
      'name'               => 'search_category_id',
      'id'                 => 'search_category_id',
      'class'              => 'form-control',
      'depth'              => 0,
      'tab_index'          => 0,
      'taxonomy'           => 'wde_categories',
      'hide_if_empty'      => false,
      'value_field'	     => 'term_id',	
    );
    $data['search_categories_list'] = $search_categories_list;
    
    $data['all_products_page_url'] = get_permalink($options->option_all_products_page);
    $data['filter_manufacturer_rows'] = self::get_filter_manufacturer_rows();
    $data['filter_products_min_price'] = $products_min_and_max_price_data['min_price'];
    $data['filter_products_max_price'] = $products_min_and_max_price_data['max_price'];
    $data['filter_date_added_ranges'] = self::get_filter_date_added_ranges();
    $data['filters_data'] = self::get_filters_data($params);
    $data['arrangement_data'] = self::get_arrangement_data($params);
    $data['sortables_list'] = self::get_sortables_list();
    $data['sort_data'] = self::get_sort_data($params);
    $data['pagination'] = $pagination;
    $data['product_rows'] = $product_rows;
    return $data;
  }
}