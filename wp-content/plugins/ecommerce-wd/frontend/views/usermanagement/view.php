<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewUsermanagement extends EcommercewdView {
  
  public function display($params = null) {
    $model = $this->getModel();

    $options_model = WDFHelper::get_model('options');
    $this->options = $options_model->get_options();
    
    $this->row_user = $model->get_current_user_row();

    $task = WDFInput::get_task();
    switch ($task) {
      case 'displaylogin':
        if (is_user_logged_in()) {
          $this->_layout = 'displayuseraccount';
          $params['layout'] = 'displayuseraccount';
          $this->user_data = $model->get_user_data_view();
          WDFInput::set('task', 'displayuseraccount');
        }
        else {
          $this->_layout = 'displaylogin';
        }
        break;
      case 'displayupdateuserdata':
        $this->_layout = 'displayupdateuserdata';
        $this->form_fields = $model->get_user_data_form_fields();
        $this->user_data = $model->get_user_data();
        break;
    }
    $_SESSION['wde_return_key_values'] = NULL;
    $_SESSION['wde_invalid_fields'] = NULL;
    parent::display($params);
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