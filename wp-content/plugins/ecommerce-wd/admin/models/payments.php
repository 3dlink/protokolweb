<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelPayments extends EcommercewdModel {
  public function get_row($id = 0) {
    $row = parent::get_row($id);

    $row->field_types = array();	
    $row->fields = array();	
    if (WDFInput::get("type") != 'without_online_payment') {
      $class_name = 'WDF' . ucfirst($row->base_name);
      $field_types = $class_name::$field_types;

      // additional data
      $row_options = WDFJson::decode($row->options);

      if (isset($row_options->options) == true) {	
        $_cc_fields = array();
        foreach ($class_name::$cc_fields as $cc_field_name => $value) {
          if ($value == 1) {
            continue;
          }
          $_cc_fields[] = $cc_field_name;
        }
        $row_cc_fields = $row_options->options;				
        $row->cc_fields = $row_cc_fields;
        $row->json_cc_fields = WDFJson::encode($_cc_fields);
        unset($row_options->options);
      }
      $row->fields = $row_options;	
      $row->field_types = $field_types;	
      $row->class_name = $class_name;	
    }
    return $row;
  }

  public function get_rows() {
    $rows = parent::get_rows();
    // additional data
    foreach ($rows as $row) {
      $row->edit_url = add_query_arg(array('page' => 'wde_' . WDFInput::get_controller(), 'task' => 'edit', 'cid[]' => $row->id, 'type' => $row->short_name), admin_url('admin.php'));
    }
    return $rows;
  }

	public function get_lists() {
		$lists = array();
		if (WDFInput::get("type") != 'without_online_payment') {
			$row = $this->get_row();
			$class_name = $row->class_name ;
			$fields = $class_name::$field_types;
			// checkout mode
			$radio_list = array();
			foreach ($fields as $k => $field) {
				if ($field['type'] == 'radio') {
					$radio_list[$k] = array();
					foreach ($field['options'] as $key => $value) {
						$radio_list[$k][] = (object)array('value' => $key, 'text' => __($value, 'wde'));
          }
				}		
			}				
			$lists["radio"] = $radio_list;
		}
		return $lists;
	}

	public function get_selected_tool_ids($ids) {
		global $wpdb;
		$tool_ids = array();

		foreach ($ids as $id) {
      $tool_ids[] = $wpdb->get_var($wpdb->prepare('SELECT tool_id FROM ' . $wpdb->prefix . 'ecommercewd_payments WHERE id="%d"', $id));
		}
		return $tool_ids;
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
}