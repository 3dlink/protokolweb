<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewOrderProducts extends EcommercewdView {
  
  public function display($tpl = null) {
    ?>
    <div class="wrap">
      <?php
    $model = $this->getModel();
    $task = WDFInput::get_task();
    switch ($task) {
      case 'explore':
        $this->_layout = 'explore';
        $this->order_data = $model->get_order_data();
        $this->rows = $model->get_rows();
        break;
      default:
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
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}