<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewPayments extends EcommercewdView {
  
  public function display($tpl = null) {
    ?>
    <div class="wrap">
      <?php
    $this->create_toolbar();

    $model = $this->getModel();

    $task = WDFInput::get_task();
    switch ($task) {		
      case 'edit':
        $this->_layout = 'edit';
        $this->row = $model->get_row();
        $this->lists = $model->get_lists();
        break;
      default:
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
    switch (WDFInput::get_task()) {
      case 'edit':
        WDFToolbar::title(__('Edit payment system', 'wde'), 'spidershop_payments.png');

        WDFToolbar::addButton('save', __('Save', 'wde'));
        WDFToolbar::addButton('apply', __('Apply', 'wde'));
        WDFToolbar::addButton('cancel', __('Cancel', 'wde'));
        WDFToolbar::addToolbar();
        break;
      default:
        WDFToolbar::title(__('Payments', 'wde'), 'spidershop_payments.png');

        WDFToolbar::addButton('publish', __('Publish', 'wde'));
        WDFToolbar::addButton('unpublish', __('Unpublish', 'wde'));
        WDFToolbar::addToolbar();
        break;
    }
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}