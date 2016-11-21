<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewSystempages extends EcommercewdView {
  
  public function display($tpl = null) {
    $model = $this->getModel();

    $task = WDFInput::get_task();

    $model_options = WDFHelper::get_model('options');
    $this->options = $model_options->get_options();

    $model_usermanagement = WDFHelper::get_model('usermanagement');
    $this->row_user = $model_usermanagement->get_current_user_row();

    switch ($task) {
      case 'displayerror':
        $this->_layout = 'displayerror';
        $this->error = $model->get_error();
        break;
    }

    parent::display($tpl);
  }
}