<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewManufacturers extends EcommercewdView {
  
  public function display($params = null) {
    $model = $this->getModel();

    $model_options = WDFHelper::get_model('options');
    $this->options = $model_options->get_options();

    $model_usermanagement = WDFHelper::get_model('usermanagement');
    $this->row_user = $model_usermanagement->get_current_user_row();

    $task = $params['layout'];
    switch ($task) {
      case 'displaymanufacturer':
        $this->active_menu_params = array('manufacturer_id');

        $this->_layout = 'displaymanufacturer';
        $this->row = $model->get_row($params);
        break;
      case 'displaymanufacturers':
        $this->active_menu_params = array('manufacturer_id');

        $this->_layout = 'displaymanufacturers';
        $this->_folder = 'manufacturers';
        $data = $model->get_manufacturers_view_data($params);

        $this->search_data = $data['search_data'];
        $this->pagination = $data['pagination'];
        $this->row = $data['rows'];
        break;
    }

    parent::display($params);
  }
}