<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdModelManufacturers extends EcommercewdModel {
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
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();
    $search_data = $this->get_search_data($params);
    $args = array(
      'post_type' => 'wde_manufacturers',
      'post_status' => array('publish'),
    );
    if (($options->search_enable_search == 1) && ($search_data['name'] != '')) {
      $args['s'] = $search_data['name'];
    }
    $args['orderby'] = 'name';
    $args['order'] = isset($params['morder_dir']) && $params['morder_dir'] == 'asc' ? 'ASC' : 'DESC';
    $args['nopaging'] = $use_pagination;
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
    $rows_data = array();
    if ($query->have_posts()) {
      foreach ($query->posts as $index => $row) {
        if (!$use_pagination || ($index >= $pagination->limitstart && $index < $pagination->limitstart + $pagination->limit)) {
          $row->id = $row->ID;
          $name_max_length = 30;
          $description_max_length = 500;
          $row->name = $row->post_title;
          $row->description = wpautop($row->post_content);
          if (strlen(strip_tags($row->description)) > $description_max_length) {
            $row->description = WDFText::truncate_html($row->description, $description_max_length - 3);
          }
          $row->url = get_permalink($row->id);
          $row->image = '';
          if (has_post_thumbnail($row->id)) {
            $attachment_id = get_post_thumbnail_id($row->id);
            $row->image = wp_get_attachment_url($attachment_id);
          }
          $row->show_info = isset($params['mshow_info']) && $params['mshow_info'] ? 1 : 0;
          $rows_data[] = $row;
        }
      }
    }
    return $use_pagination ? array($rows_data, $pagination) : $rows_data;
  }

  public function get_manufacturers_view_data($params) {
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
    $data['pagination'] = $pagination;
    $data['rows'] = $rows;
    return $data;
  }

  private function get_search_data($params) {
    if ($this->search_data == NULL) {
      $search_data = array();
      $search_data['name'] = WDFInput::get('search_name', '');
      $this->search_data = $search_data;
    }
    return $this->search_data;
  }

  public function get_row($params) {
    $id = $params['manufacturer_id'];
    $fields = array(
      'site',
      'show_info',
      'show_products',
      'products_count',
    );
    $row = get_post($id);
    foreach ($fields as $field) {
      $row->$field = esc_attr(get_post_meta($id, 'wde_' . $field, TRUE));
    }
    $row->id = $id;
    $row->name = $row->post_title;
    $row->description = wpautop($row->post_content);
    
    if ($row->id == 0) {
      WDFHelper::show_error(1);
    }

    $row->logo = wp_get_attachment_url(get_post_thumbnail_id($id));

    $row->products = array();
    if ($row->show_products == 1) {
      $products = $this->get_manufacturer_products($row->id, $row->products_count);
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


  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  private function get_manufacturer_products($manufacturer_id, $count) {
    $args = array(
      'post_parent' => $manufacturer_id,
      'post_type'   => 'wde_products', 
      'numberposts' => $count,
      'post_status' => 'publish' 
    ); 
    $rows = get_children($args);

    // additional data
    foreach ($rows as $row) {
      // id
      $row->id = $row->ID;
      $row->name = $row->post_title;
      $row->image = wp_get_attachment_url(get_post_thumbnail_id($row->id));
      if (!$row->image) {
        $image_ids = explode(',', esc_attr(get_post_meta($row->id, 'wde_images', TRUE)));
        $row->image = wp_get_attachment_url($image_ids[0]);
      }

      $row->url = get_permalink($row->id);
    }

    return $rows;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}