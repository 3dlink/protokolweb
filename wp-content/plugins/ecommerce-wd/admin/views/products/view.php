<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewProducts extends EcommercewdView {
  
  public function display($tpl = null) {
    global $post;
    ?>
    <div class="wrap">
      <?php
    $this->create_toolbar();

    $model = $this->getModel();

    $task = WDFInput::get_task();
    switch ($task) {
      case 'add':
      case 'add_refresh':
      case 'edit':
      case 'edit_refresh':
        $this->_layout = 'edit';
        $this->default_currency_row = WDFDb::get_row('currencies', '`default`= 1');
        $this->row = $model->get_row($post);
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
      case 'add':
      case 'add_refresh':
        WDFToolbar::title(__('Add product', 'wde'), 'spidershop_products.png');

        WDFToolbar::addButton('save', __('Save', 'wde'));
        WDFToolbar::addButton('apply', __('Apply', 'wde'));
        WDFToolbar::addButton('save2new', __('Save and new', 'wde'));
        WDFToolbar::addButton('cancel', __('Cancel', 'wde'));
        WDFToolbar::addToolbar();
        break;
      case 'edit':
      case 'edit_refresh':
        WDFToolbar::addButton('save', __('Save', 'wde'));
        WDFToolbar::addButton('apply', __('Apply', 'wde'));
        WDFToolbar::addButton('save2new', __('Save and new', 'wde'));
        WDFToolbar::addButton('cancel', __('Cancel', 'wde'));
        break;
      default:
        WDFToolbar::title(__('Products', 'wde'), 'spidershop_products.png');

        WDFToolbar::addNew();
        WDFToolbar::addButton('publish', __('Publish', 'wde'));
        WDFToolbar::addButton('unpublish', __('Unpublish', 'wde'));
        WDFToolbar::addButton('remove', __('Delete', 'wde'));
        WDFToolbar::addToolbar();
        break;
    }
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}