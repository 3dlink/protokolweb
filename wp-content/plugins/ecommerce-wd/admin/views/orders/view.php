<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewOrders extends EcommercewdView {
  
  public function display($tpl = null) {
    ?>
    <div class="wrap">
      <?php

    $model = $this->getModel();

    $this->lists = $model->get_lists();

    $task = WDFInput::get_task();
    switch ($task) {
      case 'view':
        $this->create_toolbar();
        $this->_layout = 'view';
        $this->row = $model->get_row();
        break;
      case 'edit':
        $this->create_toolbar();
        $this->_layout = 'edit';
        $this->row = $model->get_row();
        break;
      case 'paymentdata':
        $this->_layout = 'paymentdata';
        $this->row = $model->get_row();
        break;				
			case 'printorder':
        $id = WDFInput::get('id');
				$this->row  = $model->get_row($id);
				$this->_layout= 'printorder';
				break;
      default:
        $this->create_toolbar();
        $this->_layout = 'default';
        $this->filter_items = $model->get_rows_filter_items();
        $this->sort_data = $model->get_rows_sort_data();
        $this->pagination = $model->get_rows_pagination();
        $this->rows = $model->get_rows();
        break;
    }
    parent::display($tpl);
      ?>
    </div>
    <?php
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  private function create_toolbar() {
    $task = WDFInput::get_task();
    switch ($task) {
      case 'view':
        WDFToolbar::title(__('View order', 'wde'), 'spidershop_orders.png');
        WDFToolbar::addButton('cancel', __('Cancel', 'wde'));
        WDFToolbar::addToolbar();
        break;
      case 'edit':
        WDFToolbar::title(__('Edit order', 'wde'), 'spidershop_orders.png');
        WDFToolbar::addButton('save', __('Save', 'wde'));
        WDFToolbar::addButton('apply', __('Apply', 'wde'));
        WDFToolbar::addButton('cancel', __('Cancel', 'wde'));
        WDFToolbar::addToolbar();
        break;
      case 'printorder':
        break;
      case 'paymentdata':
        WDFToolbar::title(__('Orders', 'wde'), 'spidershop_orders.png');
				break;
      default:
        WDFToolbar::title(__('Orders', 'wde'), 'spidershop_orders.png');
        WDFToolbar::addButton('select_all', __('Select all', 'wde'));
        WDFToolbar::addButton('export', __('Export as CSV', 'wde'));
        WDFToolbar::addButton('remove', __('Delete', 'wde'));
        WDFToolbar::addToolbar();
        break;
    }
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}