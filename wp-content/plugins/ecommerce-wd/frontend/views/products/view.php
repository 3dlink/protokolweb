<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdViewProducts extends EcommercewdView {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function display($params = null) {
    $model = $this->getModel();
    $this->row_default_currency = WDFDb::get_row('currencies', '`default`=1');
    $model_options = WDFHelper::get_model('options');
    $this->options = $model_options->get_options();

    $model_themes = WDFHelper::get_model('theme');
    $this->theme = $model_themes->get_theme_row();

    $model_usermanagement = WDFHelper::get_model('usermanagement');

    $this->row_user = $model_usermanagement->get_current_user_row();
    $task = WDFInput::get_task();
    $task = isset($task) ? $task : $params['layout'];
    switch ($task) {
      case 'displayproduct':          
        $this->active_menu_params = array('product_id');
        $this->_layout = 'displayproduct';
        $this->product_row = $model->get_product_view_product_row($params);
        break;
      case 'displayproducts':
        $this->_layout = 'displayproducts';
        $data = WDFProduct::get_products_view_data($params);

        $this->data = $data;
        $this->search_categories_list = $data['search_categories_list'];
        $this->search_data = $data['search_data'];
        $this->filter_manufacturer_rows = $data['filter_manufacturer_rows'];
        $this->filter_date_added_ranges = $data['filter_date_added_ranges'];
        $this->filter_products_min_price = $data['filter_products_min_price'];
        $this->filter_products_max_price = $data['filter_products_max_price'];
        $this->filters_data = $data['filters_data'];
        $this->arrangement_data = $data['arrangement_data'];
        $this->sortables_list = $data['sortables_list'];
        $this->sort_data = $data['sort_data'];
        $this->product_row = $model->get_product_view_product_row($params);
        $this->pagination = $data['pagination'];
        $this->product_rows = $data['product_rows'];
        break;
      case 'displaycompareproducts':
        $this->active_menu_params = array('product_id');

        $model_categories = WDFHelper::get_model('categories');

        $this->_layout = 'displaycompareproducts';
        $product_row = $model->get_compare_products_view_product_row();
        $this->row_product = $product_row;
        $this->lists = $model->get_compare_products_lists($this->row_product);
        $required_parameters = $model_categories->get_required_parameters($this->row_product);
        if ($required_parameters === false) {
          WDFHelper::show_error(2);
        }
        $this->required_parameters = $required_parameters;
        break;
      case 'displayproductreviews':
        $this->active_menu_params = array('product_id');

        $model_usermanagement = WDFHelper::get_model('usermanagement');

        $this->_layout = 'displayproductreviews';
        $this->user_row = $model_usermanagement->get_current_user_row();
        $this->product_row = $model->get_product_view_product_row();
        break;
    }

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