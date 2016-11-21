<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewCategories extends EcommercewdView {
  
  public function display($params) {
    $model = $this->getModel();

    $model_options = WDFHelper::get_model('options');
    $this->options = $model_options->get_options();

    $model_themes = WDFHelper::get_model('theme');
    $this->theme = $model_themes->get_theme_row();

    $model_usermanagement = WDFHelper::get_model('usermanagement');
    $this->row_user = $model_usermanagement->get_current_user_row();

    $task = $params['layout'];
    switch ($task) {
      case 'displaycategory':
        $this->active_menu_params = array('category_id');

        $this->_layout = 'displaycategory';
        $this->row = $model->get_row($params);
        break;
      case 'displaycategories':
        $this->active_menu_params = array('category_id');

        $this->_layout = 'displaycategories';
        $data = $model->get_categories_view_data($params);

        $this->search_categories_list = $data['search_categories_list'];
        $this->search_data = $data['search_data'];
        $this->pagination = $data['pagination'];
        $this->row = $data['rows'];
        break;
    }

    parent::display($params);
  }
}