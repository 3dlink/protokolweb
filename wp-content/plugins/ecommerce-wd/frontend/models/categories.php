<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdModelCategories extends EcommercewdModel {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $search_data;
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function get_rows($use_pagination, $params) {
    $search_data = $this->get_search_data($params);
    $terms_to_include = array();
    if ($search_data['category_id']) {
      $terms_to_include = get_term_children($search_data['category_id'], 'wde_categories');
      $terms_to_include[] = $search_data['category_id'];
    }
    $args = array(
      'orderby'                => 'name',
      'order'                  => isset($params['corder_dir']) && $params['corder_dir'] == 'asc' ? 'ASC' : 'DESC',
      'hide_empty'             => FALSE,
      'include'                => $terms_to_include,
      'exclude'                => array(),
      'exclude_tree'           => array(),
      'number'                 => '',
      'offset'                 => '',
      'fields'                 => 'all',
      'name'                   => '',
      'slug'                   => '',
      'hierarchical'           => TRUE,
      'search'                 => '',
      'name__like'             => $search_data['name'],
      'description__like'      => '',
      'pad_counts'             => FALSE,
      'get'                    => 'all',
      'childless'              => 1,
      'cache_domain'           => 'core',
      'update_term_meta_cache' => TRUE,
      'meta_query'             => ''
    );
    $rows = get_terms('wde_categories', $args);
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
      $pagination->stop = ceil(count($rows) / $limit);
      $pagination->total = $pagination->stop;
    }
    else {
      $pagination = new stdClass();
      $pagination->limitstart = 0;
      $pagination->limit = 1;
    }
    $rows_data = array();
    foreach ($rows as $index => $row) {
      if (!$use_pagination || ($index >= $pagination->limitstart && $index < $pagination->limitstart + $pagination->limit)) {
        $row->id = $row->term_id;
        $name_max_length = 30;
        $description_max_length = 500;
        if (strlen(strip_tags($row->description)) > $description_max_length) {
          $row->description = WDFText::truncate_html($row->description, $description_max_length - 3);
        }
        $row->url = get_term_link($row);
        $term = get_term($row->id, 'wde_categories');
        $term_meta = get_option('wde_categories_' . $row->id);
        $image_id = isset($term_meta['images']) ? $term_meta['images'] : '';
        $image = isset($term_meta['images']) ? wp_get_attachment_thumb_url($term_meta['images']) : '';
        $row->image = $image ? $image : '';
        $row->path_categories = $this->get_category_path_categories($row->id);
        $row->show_info = isset($params['cshow_info']) && $params['cshow_info'] ? 1 : 0;
        $rows_data[] = $row;
      }
    }
    return $use_pagination ? array($rows_data, $pagination) : $rows_data;
  }

  public function get_categories_view_data($params) {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();
    $rows_data = $this->get_rows(TRUE, $params);
    if ($rows_data === FALSE) {
      WDFHelper::show_error(2);
    }
    $rows = $rows_data[0];
    $pagination = $rows_data[1];

    $data = array();
    $data['search_data'] = $this->get_search_data($params);
    $search_categories_list = array(
      'show_option_all'    => __('All categories', 'wde'),
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
      'hide_if_empty'      => FALSE,
      'value_field'	       => 'term_id',	
    );
    $data['search_categories_list'] = $search_categories_list;
    $data['pagination'] = $pagination;
    $data['rows'] = $rows;
    return $data;
  }

  private function get_search_data($params) {
    if ($this->search_data == null) {
      $search_data = array();
      $search_data['category_id'] = (int) WDFInput::get('search_category_id', isset($params['ccategory_id']) ? $params['ccategory_id'] : 0);
      $search_data['name'] = WDFInput::get('search_name', '');
      $this->search_data = $search_data;
    }
    return $this->search_data;
  }

  public function get_row($params) {
    $cur_page = get_queried_object();
    if (isset($cur_page) && isset($cur_page->taxonomy) && $cur_page->taxonomy == 'wde_categories') {
      $id = $cur_page->term_id;
    }
    else {
      return null;
    }
    
    $term_meta = get_option("wde_categories_" . $id);
    $params['cshow_info'] = isset($term_meta['cshow_info']) ? $term_meta['cshow_info'] : 1;    
    $params['cshow_products'] = isset($term_meta['cshow_products']) ? $term_meta['cshow_products'] : 1;    
    $params['products_count'] = isset($term_meta['products_count']) ? $term_meta['products_count'] : 12;    
    $params['show_subcategories'] = isset($term_meta['show_subcategories']) ? $term_meta['show_subcategories'] : 1;    
    $params['show_tree'] = isset($term_meta['show_tree']) ? $term_meta['show_tree'] : 1;    
    $params['subcategories_cols'] = isset($term_meta['subcategories_cols']) ? $term_meta['subcategories_cols'] : 2;    
    
    $term = get_term($id, "wde_categories");
    $row = new stdClass();
    if (is_wp_error($term)) {
        $row->id = 0;
        $row->name = 'root';
    }
    else {
      $row->id = $term->term_id;
      $row->name = $term->name;
      $row->description = $term->description;
      $row->images = isset($term_meta['images']) ? $term_meta['images'] : '';
    }

    // additional data
    // path categories
    $row->path_categories = $this->get_category_path_categories($row->id);

    // info
    $row->show_info = $params['cshow_info'];

    // image
    if ($row->images != null) {
        $images = wp_get_attachment_thumb_url($row->images);
        $row->image = $images != false ? $images : '';
    }
    else {
        $row->image = '';
    }

    // subcategories
    $row->show_subcategories = $params['show_subcategories'];
    $row->subcategories_cols = $params['subcategories_cols'];
    
    $subcategories = $this->get_category_subcategories($row->id);
    if ($subcategories === false) {
      WDFHelper::show_error(2);
    }
    $row->subcategories = $subcategories;
    if (empty($row->subcategories) == true) {
      $row->show_subcategories = 0;
    }

    // category tree
    $row->show_tree = $params['show_tree'];

    // products and count
    $row->show_products = $params['cshow_products'];
    $row->products_count = $params['products_count'];
    
    $row->products = array();
    if ($row->show_products == 1) {
      $products = $this->get_category_products($row->id, $row->products_count);
      if ($products === false) {
        WDFHelper::show_error(2);
      }
      $row->products = $products;
    }
    if (empty($row->products) == true) {
      $row->show_products = 0;
    }

    // url view products
    $row->url_view_products = '';

    return $row;
  }

  public function get_required_parameters($product_row) {
    // $parameter_rows = get_the_terms($product_row->id, 'wde_parameters');
    $parameter_rows = $product_row->parameters;
    // $parameter_rows = WDFJson::decode($product_row->parameters);
    $required_parameters = array();
    if ($parameter_rows) {
      // foreach ($parameter_rows as $key => $parameter) {
        // $required_parameter = new stdClass();
        // $required_parameter->id = $parameter->term_id;
        // $required_parameter->name = $parameter->name;
        // $required_parameters[$i++] = $required_parameter;
      // }
      $parameters = array();
      foreach ($parameter_rows as $parameter_row) {
        if (isset($parameters[$parameter_row->id]) == FALSE) {
          $parameter = new stdClass();
          if (!isset($parameter_row->name) || $parameter_row->name == '') {
            $term = get_term($parameter_row->id, 'wde_parameters');
            $parameter_row->name = !is_wp_error($term) ? $term->name : '';
          }
          $parameter->name = $parameter_row->name;
          $parameter->id = $parameter_row->id;
          $parameter->type_id = $parameter_row->type_id;
          $parameter->values = array();
          $parameter->prices = array();
        }
        else {
          $parameter = $parameters[$parameter_row->id];
        }
        if (is_array($parameter_row->values)) {
          foreach ($parameter_row->values as $key => $parameter_values) {
            $parameter_prices = $parameter_row->prices;
            $parameter->values[] = $parameter_values;
            $parameter->prices[] = $parameter_prices[$key];
          }
        }
        $parameters[$parameter_row->id] = $parameter;
      }
      $required_parameters = $parameters;
    }
    return $required_parameters;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  private function get_category_path_categories($category_id) {
    $path_categories = array();
    $root_path = '';
    while ($category_id != 0) {
      $term = get_term($category_id, "wde_categories");
      $term_meta = get_option("wde_categories_" . $category_id);
      $category_row = new stdClass();
      $category_row->id = !is_wp_error($term) ? $term->term_id : 0;
      $category_row->name = !is_wp_error($term) ? $term->name : '';
      $category_row->image = !is_wp_error($term) ? $term_meta['images'] : '';

      // additional data
      $category_row->is_active = true;

      // url
      $category_row->url = get_term_link((int) $category_id, "wde_categories");
      $root_path = $category_row->url;

      array_unshift($path_categories, $category_row);

      $category_id = $term->parent;
    }
    $category_row = new stdClass();
    $category_row->id = 0;
    $category_row->is_active = false; //true;
    $category_row->url = ''; //$root_path;
    $category_row->name = __('Main', 'wde');
    $category_row->image = '';
    array_unshift($path_categories, $category_row);

    return $path_categories;
  }

  private function get_category_subcategories($category_id) {
    $args = array(
      'hide_empty'        => FALSE,
      'parent'            => $category_id
    ); 
    $terms = get_terms("wde_categories", $args);
    $rows = array();
    if (!is_wp_error($terms)) {
      foreach($terms as $term) {
        $term_meta = get_option("wde_categories_" . $term->term_id);
        $row = new stdClass();
        $row->id = $term->term_id;
        $row->name = $term->name;
        $row->images = isset($term_meta['images']) ? $term_meta['images'] : '';
        $row->images = wp_get_attachment_thumb_url($row->images);
        $row->images = $row->images != false ? $row->images : '';
        $row->url = get_term_link($term, "wde_categories");
        array_push($rows, $row);
      }
    }

    return $rows;
  }

  private function get_category_products($category_id, $count) {
    $args = array(
      'post_type' => 'wde_products',
      'posts_per_page' => $count,
      'post_status' => array('publish'),
      'tax_query' => array(
        array(
          'taxonomy' => 'wde_categories',
          'terms' => $category_id,
          'include_children' => FALSE
        ),
      ),
    );
    $query = new WP_Query($args);
    $rows = array();
    if ($query->have_posts()) {
      foreach ($query->posts as $post) {
        $row = new stdClass();
        $row->id = $post->ID;
        $row->name = $post->post_title;
        $row->image = '';
        if (!has_post_thumbnail($post->ID)) {
          $image_ids_string = get_post_meta($post->ID, 'wde_images', TRUE);
          $image_ids = explode(',', $image_ids_string);
          if (isset($image_ids[0]) && is_numeric($image_ids[0]) && $image_ids[0] != 0) {
            $image_id = (int) $image_ids[0];
            $row->image = wp_get_attachment_url($image_id);
          }
        }
        else {
          $row->image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        }
        $row->url = get_permalink($post->ID);
        array_push($rows, $row);
      }
    }

    return $rows;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}