<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerPayments extends EcommercewdController {
	public function apply() {
    $row = $this->store_input_in_row();
    $model = WDFHelper::get_model();	
    $selected_tools = $model->get_selected_tool_ids(WDFInput::get_checked_ids()); 
    WDFDb::set_rows_data('tools', $selected_tools, 'published', WDFInput::get("published") );
    WDFHelper::redirect('', 'edit', $row->id, 'type=' . WDFInput::get("type") . (WDFInput::get('from') == 'options' ? '&from=options' : ''), __('Changes saved.', 'wde'));
  }

  public function save() {
    $this->store_input_in_row();
    if (WDFInput::get('from') == 'options') {
      WDFHelper::redirect('options', '', '', 'tab_index=options_checkout');
    }
    WDFHelper::redirect('', '', '', '', 2);
  }  

  public function cancel() {
    if (WDFInput::get('from') == 'options') {
      WDFHelper::redirect('options', '', '', 'tab_index=options_checkout');
    }
    WDFHelper::redirect();
  }

	public function publish() {
		WDFDb::set_checked_rows_data('payments', 'published', 1);
		$model = WDFHelper::get_model();	
		$selected_tools = $model->get_selected_tool_ids(WDFInput::get_checked_ids()); 

		WDFDb::set_checked_rows_data('tools', 'published', 1, $selected_tools);
		WDFHelper::redirect();
	}

	public function unpublish() {
		WDFDb::set_checked_rows_data('payments', 'published', 0);
		$model = WDFHelper::get_model();	
		$selected_tools = $model->get_selected_tool_ids(WDFInput::get_checked_ids()); 
		WDFDb::set_checked_rows_data('tools', 'published', 0, $selected_tools);
		WDFHelper::redirect();
	}
}