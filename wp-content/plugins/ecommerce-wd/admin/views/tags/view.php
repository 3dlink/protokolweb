<?php

defined('ABSPATH') || die('Access Denied');


class EcommercewdViewTags extends EcommercewdView {
  
  public function display($tpl = null) {
    ?>
    <div class="wrap">
      <?php
    $this->create_toolbar();

    $model = $this->getModel();

    $task = WDFInput::get_task();
    switch ($task) {
      case 'explore':
        $this->_layout = 'explore';
        $this->filter_items = $model->get_rows_filter_items();
        $this->sort_data = $model->get_rows_sort_data();
        // $this->pagination = $model->get_rows_pagination();
        $this->rows = $model->get_rows();
        break;
      case 'add':
      case 'edit':
        $this->_layout = 'edit';
        $this->row = $model->get_row();
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
      case 'explore':
        break;
      case 'add':
        WDFToolbar::title(__('Add tag', 'wde'), 'spidershop_tags.png');

        WDFToolbar::addButton('save', __('Save', 'wde'));
        WDFToolbar::addButton('apply', __('Apply', 'wde'));
        WDFToolbar::addButton('save2new', __('Save and new', 'wde'));
        WDFToolbar::addButton('cancel', __('Cancel', 'wde'));

        WDFToolbar::addToolbar();
        break;
      case 'edit':
        WDFToolbar::title(__('Edit tag', 'wde'), 'spidershop_tags.png');

        WDFToolbar::addButton('save', __('Save', 'wde'));
        WDFToolbar::addButton('apply', __('Apply', 'wde'));
        WDFToolbar::addButton('save2new', __('Save and new', 'wde'));
        WDFToolbar::addButton('cancel', __('Cancel', 'wde'));

        WDFToolbar::addToolbar();
        break;
      default:
        WDFToolbar::title(__('Tags', 'wde'), 'spidershop_tags.png');

        WDFToolbar::addNew();
        WDFToolbar::addButton('remove', __('Delete', 'wde'));

        WDFToolbar::addToolbar();
        break;
    }
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}