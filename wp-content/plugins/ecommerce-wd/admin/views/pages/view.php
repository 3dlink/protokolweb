<?php

defined('ABSPATH') || die('Access Denied');


class EcommercewdViewPages extends EcommercewdView {
  
  public function display($tpl = null) {
     ?>
    <div class="wrap">
      <?php
    $this->create_toolbar();

    $model = $this->getModel();

    $task = WDFInput::get_task();
    switch ($task) {
      case 'explore1':
        $this->_layout = 'explore';
        $this->filter_items = $model->get_rows_filter_items();
        $this->sort_data = $model->get_rows_sort_data();
        $this->pagination = $model->get_rows_pagination();
        $this->rows = $model->get_rows();
        break;
      case 'add':
      case 'edit':
        $this->_layout = 'edit';
        $this->row = $model->get_row();
        break;
      case 'explore':
        $this->_layout = 'explore';
        $table_data = $model->get_articles_table_data();
        $this->filter_items = $table_data['filter_items'];
        $this->sort_data = $table_data['sort_data'];
        $this->pagination = $table_data['pagination'];
        $this->rows = $table_data['rows'];
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
  // Private Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  private function create_toolbar() {
    switch (WDFInput::get_task()) {
      case 'explore':
        break;
      case 'add':
        WDFToolbar::title(__('Add page', 'wde'), 'spidershop_pages.png');

        WDFToolbar::addButton('save', __('Save', 'wde'));
        WDFToolbar::addButton('apply', __('Apply', 'wde'));
        WDFToolbar::addButton('save2new', __('Save and new', 'wde'));
        WDFToolbar::addButton('cancel', __('Cancel', 'wde'));
        WDFToolbar::addToolbar();
        break;
      case 'edit':
        WDFToolbar::title(__('Edit page', 'wde'), 'spidershop_pages.png');

        WDFToolbar::addButton('save', __('Save', 'wde'));
        WDFToolbar::addButton('apply', __('Apply', 'wde'));
        WDFToolbar::addButton('save2new', __('Save and new', 'wde'));
        WDFToolbar::addButton('cancel', __('Cancel', 'wde'));
        WDFToolbar::addToolbar();
        break;
      case 'explore_articles':
        break;
      default:
        WDFToolbar::title(__('Licensing', 'wde'), 'spidershop_pages.png');

        WDFToolbar::addNew();
        WDFToolbar::addButton('publish', __('Publish', 'wde'));
        WDFToolbar::addButton('unpublish', __('Unpublish', 'wde'));
        WDFToolbar::addButton('remove', __('Delete', 'wde'));
        WDFToolbar::addToolbar();
        break;
    }
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}