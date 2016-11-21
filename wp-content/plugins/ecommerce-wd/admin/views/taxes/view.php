<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewTaxes extends EcommercewdView {
  
  public function display($tpl = null, $attrs = null) {
    ?>
    <div class="wrap">
      <?php
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
      case 'edit':
        $this->_layout = 'edit';
        $this->row = $attrs;
        $this->tax_rates = WDFDb::get_tax_rates_by('id', $attrs, FALSE);
        $this->tax_rates_defaults = $model->get_tax_rates_defaults();
        break;
    }
    parent::display($tpl);
      ?>
    </div>
    <?php
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}