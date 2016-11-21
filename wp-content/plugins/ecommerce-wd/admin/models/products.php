<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelProducts extends EcommercewdModel {
  public function get_row($id = 0) {
    global $post;
    $fields = array(
      'meta_title',
      'meta_description',
      'meta_keyword',
      'model',
      'price',
      'discount_id',
      'discount_rate',
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
      'page_ids',
      'parameters',
    );

    $row = new stdClass();
    foreach ($fields as $field) {
      $row->$field = esc_attr(get_post_meta($post->ID, 'wde_' . $field, TRUE));
    }

    // id
    $row->id = $post->ID;

    // tax data
    $tax = wp_get_object_terms($post->ID, 'wde_taxes');
    $row->tax_id = isset($tax[0]->term_id) ? $tax[0]->term_id : 0;
    $tax_name = isset($tax[0]->name) ? $tax[0]->name : '';
    $tax = get_option("wde_taxes_" . $row->tax_id);
    $row->tax_name = $row->tax_id != 0 ? $tax_name : '';
    $row->tax_rate = '';
    
    // discount data
    $discount = wp_get_object_terms($post->ID, 'wde_discounts');
    $row->discount_id = isset($discount[0]->term_id) ? $discount[0]->term_id : 0;
    $discount_name = isset($discount[0]->name) ? $discount[0]->name : '';
    $discount = get_option("wde_discounts_" . $row->discount_id);
    $row->discount_name = $row->discount_id != 0 ? $discount_name . ($discount['rate'] ? ' (' . $discount['rate'] . '%)' : '') : '';
    $row->discount_rate = $discount['rate'];

    $row->price = WDFText::wde_number_format($row->price ? $row->price : 0, 2);
    $row->market_price = WDFText::wde_number_format($row->market_price ? $row->market_price : 0, 2);


    $row->unlimited = $row->unlimited === '' ? 1 : $row->unlimited;
    $row->enable_shipping = $row->enable_shipping === '' ? 0 : $row->enable_shipping;

    // label
    $label = wp_get_object_terms($post->ID, 'wde_labels');
    $row->label_id = isset($label[0]->term_id) ? $label[0]->term_id : '';
    $row->label_name = isset($label[0]->name) ? $label[0]->name : '';

    // shipping method ids and names
    $shipping_methods = wp_get_object_terms($post->ID, 'wde_shippingmethods', array('orderby' => 'name', 'order' => 'ASC'));
    $shipping_method_ids = array();
    $shipping_method_names = array();
    // $shipping_method_ids = explode(',', $row->shipping_method_ids);
    foreach ($shipping_methods as $shipping_method) {
      if ($shipping_method) {
        $shipping_method_ids[] = $shipping_method->term_id;
        $shipping_method_names[] = $shipping_method->name;
      }
    }
    $row->shipping_method_ids = implode(',', $shipping_method_ids);
    $row->shipping_method_names = implode('&#13;', $shipping_method_names);

    // dimensions
		$dimensions = explode('x', $row->dimensions);
	
		$row->dimensions_length = isset($dimensions[0]) == true ? $dimensions[0] : "";
		$row->dimensions_width = isset($dimensions[1])== true ? $dimensions[1] : "";
		$row->dimensions_height = isset($dimensions[2])== true ? $dimensions[2] : "";
		// $row->_dimensions = $row_for_dimensions->dimensions;

    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();
    $initial_values = $options['initial_values'];

    $row->default_shipping = $initial_values['checkout_enable_shipping'];

    // page ids and titles
    $page_titles = array();
    $page_ids = explode(',', $row->page_ids);

    foreach ($page_ids as $page_id) {
      if ($page_id) {
        $page_titles[$page_id] = get_the_title($page_id);
      }
    }
    $row->page_titles = implode('&#13;', $page_titles);
    $row->parameters = $this->get_parameters($row->parameters);

    // categories
    $model_categories = WDFHelper::get_model('categories');
    $row->categories_parameters = $model_categories->get_categories_parameters();

    return $row;
  }

  public function get_parameters($parameters_str) {
    $parameters = WDFJson::decode($parameters_str);
    if (empty($parameters) == true) {
      return WDFJson::encode(array());
    }
    else {
      foreach ($parameters as $param) {
        $term = get_term($param->id, "wde_parameters");
        if (!is_wp_error($term)) {
          $param->name = $term->name;
        }
        $parameters_obj = get_terms('wde_par_' . $term->slug, array( 'hide_empty' => 0 ));
        $param->type_name = WDFDb::get_row_by_id('parametertypes', $param->type_id)->name;
        foreach ($param->values as $key => $value) {
          $parameter_value = WDFJson::decode($value);
          foreach ($parameters_obj as $parameter_obj) {
            if ($parameter_value->value_id == '') {
              // If parameter value inserted from product edit page, it has no value id.
              if (esc_html($parameter_value->value) == esc_html($parameter_obj->name)) {
                $parameter_value->value_id = $parameter_obj->term_id;
                break;
              }
            }
            else {
              if ($parameter_value->value_id == $parameter_obj->term_id) {
                $parameter_value->value = $parameter_obj->name;
                break;
              }
            }
          }
          $param->values[$key] = $parameter_value;
        }
      }
      return addslashes(WDFJson::encode($parameters, 256));
    }
  }

  public function get_lists() {
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();
    $initial_values = $options['initial_values'];
    $lists = array();
    // shipping data fields
    $radio_list_shipping_data_field = array();
    $radio_list_shipping_data_field[] = (object)array('value' => '0', 'text' => __('No', 'wde'));
    $radio_list_shipping_data_field[] = (object)array('value' => '1', 'text' => __('Yes', 'wde'));
    // $radio_list_shipping_data_field[] = (object)array('value' => '2', 'text' => __('USE_GLOBAL', 'wde'));
    
    $lists["list_shipping_data_field"] = $radio_list_shipping_data_field;
    return $lists;
  }

  public function get_rows() {
    $row_default_currency = WDFDb::get_row('currencies', '`default`= 1');
    $rows = parent::get_rows();
    // additional data
    foreach ($rows as $row) {
      // amount in stock
      if ($row->unlimited == 1) {
        $row->amount_in_stock = __('Unlimited', 'wde');
      }
      // price text
      $row->price_text = $row->price . ' ' . $row_default_currency->code;
    }

    return $rows;
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

  private function get_input_parameters($category_id) {
    $parameters = WDFJson::decode(WDFInput::get('parameters'));
		for ($i = 0; $i < count($parameters); $i++) {
      if (count($parameters[$i]->values) != 0) {
        for ($j = 0; $j < count($parameters[$i]->values); $j++) {
          $param_values = WDFJson::decode($parameters[$i]->values[$j]);
          $parameters[$i]->obj_values[] = $param_values;
        }
      } else {
        $parameters[$i]->obj_values[] = array();
      }
      $parameters[$i]->values = $parameters[$i]->obj_values;
      unset($parameters[$i]->obj_values);
    }

    $required_parameters = array();

    // insert category required parameters into new array
    $category_required_parameters = $this->get_category_required_parmeters($category_id);
    foreach ($category_required_parameters as $category_required_parameter) {
      $category_required_parameter->required = true;
      $category_required_parameter->values = array('');

      // get required parameter values from request (if their exists)
      for ($i = 0; $i < count($parameters); $i++) {
        $parameter_data = $parameters[$i];

        if ($parameter_data->id == $category_required_parameter->id) {
          $category_required_parameter->values = $parameter_data->values;
          unset($parameters[$i]);
          $parameters = array_values($parameters);
          break;
        }
      }

      $required_parameters[] = $category_required_parameter;
    }

    // update the rest of parameters(not required parameters) from request
    for ($i = 0; $i < count($parameters); $i++) {
        $parameter_data = $parameters[$i];

        $parameter_row = WDFDb::get_row_by_id('parameters', $parameter_data->id);
        $parameter_data->required = false;
        $parameter_data->name = $parameter_row->name;
    }
    // merge required and not required parameters
    $required_parameters = array_merge($required_parameters, $parameters);
    return addslashes(WDFJson::encode($required_parameters, 256));
  }

  private function get_input_tags() {
    if (empty($tag_ids) == true) {
      return WDFJson::encode(array());
    }

    $tag_ids = WDFJson::decode(WDFInput::get('tag_ids'));
    $tags = WDFDb::get_rows('tags', 'id IN (' . implode(',', $tag_ids) . ')');

    return WDFJson::encode($tags, 256);
  }
}