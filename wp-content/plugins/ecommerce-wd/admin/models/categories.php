<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelCategories extends EcommercewdModel {
  const MAX_DESCRIPTION_LENGTH = 150;

  public function get_row($id = 0) {
    $row = new stdClass();
    if ($id) {
      $row_temp = get_option("wde_categories_" . $id);
      $row->id = $id;
      $row->meta_title = isset($row_temp['meta_title']) ? $row_temp['meta_title'] : '';
      $row->meta_description = isset($row_temp['meta_description']) ? $row_temp['meta_description'] : '';
      $row->meta_keyword = isset($row_temp['meta_keyword']) ? $row_temp['meta_keyword'] : '';
      $row->images = isset($row_temp['images']) ? $row_temp['images'] : '';
      $row->tags = $this->get_tags(isset($row_temp['tags']) ? stripslashes($row_temp['tags']) : '');
      $row->parameters = $this->get_parameters(isset($row_temp['parameters']) ? stripslashes($row_temp['parameters']) : '');
      $row->cshow_info = isset($row_temp['cshow_info']) ? $row_temp['cshow_info'] : 1;
      $row->cshow_products = isset($row_temp['cshow_products']) ? $row_temp['cshow_products'] : 1;
      $row->products_count = isset($row_temp['products_count']) ? $row_temp['products_count'] : 12;
      $row->show_subcategories = isset($row_temp['show_subcategories']) ? $row_temp['show_subcategories'] : 1;
      $row->show_tree = isset($row_temp['show_tree']) ? $row_temp['show_tree'] : 0;
      $row->subcategories_cols = isset($row_temp['subcategories_cols']) ? $row_temp['subcategories_cols'] : 3;
    }
    else {
      $row->id = 0;
      $row->meta_title = "";
      $row->meta_description = "";
      $row->meta_keyword = "";
      $row->images = "";
      $row->tags = $this->get_tags("");
      $row->parameters = $this->get_parameters("");
      $row->cshow_info = 1;
      $row->cshow_products = 1;
      $row->products_count = 12;
      $row->show_subcategories = 1;
      $row->show_tree = 0;
      $row->subcategories_cols = 3;
    }
    return $row;
  }

  private function get_parameters($parameters_ids) {
    $parameters_ids = WDFJson::decode($parameters_ids);
    if (empty($parameters_ids) == true) {
      return WDFJson::encode(array());
    }
    else {
      $parameters= array();
      foreach ($parameters_ids as $parameter_ids) {
        $term = get_term($parameter_ids->id, "wde_parameters");
        if (!is_wp_error($term)) {
          $term->id = $parameter_ids->id;
          $term_meta = get_option("wde_parameters_" . $term->id);
          if ($term_meta) {
            $term->type_id = isset($term_meta['type_id']) ? $term_meta['type_id'] : 1;
            $term->type_name =  WDFDb::get_row_by_id('parametertypes', $term->type_id)->name;
            
            $parameters_temp = get_terms('wde_par_' . $term->slug, array( 'hide_empty' => 0 ));
            $params = array();
            foreach ($parameters_temp as $param) {
              array_push($params, $param->name);
            }
            $term->default_values = WDFJson::encode($params, 256);
            $term->default_values = addslashes($term->default_values);
            $term->required = isset($term_meta['required']) ? $term_meta['required'] : 0;
            $term->add_parameter = true;
          }
          array_push($parameters, $term);
        }
      }
      return WDFJson::encode($parameters, 256);
    }
  }

  private function get_tags($tag_ids) {
    $tag_ids = WDFJson::decode($tag_ids);
    if (empty($tag_ids) == true) {
      return WDFJson::encode(array());
    }
    else {
      $tags= array();
      foreach ($tag_ids as $tag_id) {
        $term = get_term($tag_id, "wde_tag");
        if (!is_wp_error($term)) {
          array_push($tags, $term);
        }
      }
      return WDFJson::encode($tags, 256);
    }
  }

  public function get_categories_parameters() {
    $args = array(
      // 'orderby'           => WDFSession::get('sort_by', 'name'),
      // 'order'             => WDFSession::get('sort_order', 'ASC'),
      'hide_empty'        => FALSE,
      'exclude'           => array(),
      'exclude_tree'      => array(),
      'include'           => array(),
      // 'number'            => $limit,
      'fields'            => 'all',
      'slug'              => '',
      'parent'            => '',
      'hierarchical'      => TRUE,
      'child_of'          => 0,
      'childless'         => FALSE,
      'get'               => '',
      // 'name__like'        => WDFSession::get('search_name', ''),
      'description__like' => '',
      'pad_counts'        => FALSE,
      // 'offset'            => $offset,
      'search'            => '',
      'cache_domain'      => 'core'
    );
    $rows = get_terms('wde_categories', $args);
    
    $rows_to_return = array();
    
    foreach ($rows as $row) {
      $row_temp = new stdClass();
      $row_temp->id = $row->term_id;
      $row_meta = get_option("wde_categories_" . $row->term_id);
      $parameters = isset($row_meta['parameters']) ? stripslashes($row_meta['parameters']) : '';
      $row_temp->parameters = $this->get_parameters($parameters);
      // array_push($rows_to_return, $row_temp);
      $rows_to_return[$row_temp->id] = $row_temp->parameters;
    }

    return addslashes(WDFJson::encode($rows_to_return, 256));
  }

  public function get_popup_rows() {
    $rows = $this->get_rows();
    $main_category_array = array();
    $main_category = new stdClass();
    $main_category->id = 0;
    $main_category->name = __('Main', 'wde');;
    $main_category->level = 1;
    $main_category_array[0] =  $main_category;

    $rows_ = array_merge($main_category_array,$rows);
    foreach ($rows_ as $row) {
      $row->tree = $this->find_parents($row->id);
    }
    return 	$rows_;
  }

  protected function init_rows_filters() {
    $filter_items = array();

    // name
    $filter_item = new stdClass();
    $filter_item->type = 'string';
    $filter_item->name = 'name';
    $filter_item->default_value = null;
    $filter_item->operator = 'like';
    $filter_item->input_type = 'text';
    $filter_item->input_label = __('Name', 'wde');
    $filter_item->input_name = 'search_name';
    $filter_items[$filter_item->name] = $filter_item;

    $this->rows_filter_items = $filter_items;

    parent::init_rows_filters();
  }

  private function get_input_parameters() {
    $parameters = WDFJson::decode(WDFInput::get('parameters'));
    for ($i = 0; $i < count($parameters); $i++) {
      $parameter = $parameters[$i];

      $parameter_row = WDFDb::get_row_by_id('parameters', $parameter->id);
      $parameter->name = $parameter_row->name;
    }
    return addslashes(WDFJson::encode($parameters, 256));
  }

  private function get_input_tags() {
    $tag_ids = WDFJson::decode(WDFInput::get('tag_ids'));
    if (empty($tag_ids) == true) {
      return WDFJson::encode(array());
    }
    $tags = WDFDb::get_rows('tags', 'id IN (' . implode(',', $tag_ids) . ')');
    return WDFJson::encode($tags, 256);
  }
}