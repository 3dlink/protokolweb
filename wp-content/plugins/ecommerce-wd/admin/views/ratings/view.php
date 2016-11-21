<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewRatings extends EcommercewdView {
  
  public function display($tpl = null) {
    ?>
    <div class="wrap">
      <?php
    $this->create_toolbar();

    $model = $this->getModel();

    $task = WDFInput::get_task();
    switch ($task) {
      default:
        $this->_layout = 'default';
        $this->filter_items = $model->get_rows_filter_items();
        $this->sort_data = $model->get_rows_sort_data();
        $this->lists = $model->get_lists();
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
      default:
        WDFToolbar::title(__('Ratings', 'wde'), 'spidershop_ratings.png');
        WDFToolbar::addButton('remove', __('Delete', 'wde'));
        WDFToolbar::addToolbar();
        break;
    }
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}