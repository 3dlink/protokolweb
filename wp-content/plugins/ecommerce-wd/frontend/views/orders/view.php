<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewOrders extends EcommercewdView {
  
  public function display($params = null) {
    $model = $this->getModel();

    $model_options = WDFHelper::get_model('options');
    $this->options = $model_options->get_options();

    $model_usermanagement = WDFHelper::get_model('usermanagement');
    $this->row_user = $model_usermanagement->get_current_user_row();

    $task = WDFInput::get_task();
    switch ($task) {
      case 'displayorder':
        $this->active_menu_params = array('order_id');
        $this->_layout = 'displayorder';
        $this->order_row = $model->get_order_row();
        break;

      case 'printorder':	
        $this->order_row = $model->get_print_order();
        $this->_layout = 'printorder';
        break;

      case 'displayorders':
        $this->_layout = 'displayorders';
        $data = $model->get_orders_data();
        $this->pagination = $data['pagination'];
        $this->order_rows = $data['order_rows'];
        break;            
    }
    parent::display($params);
  }
}