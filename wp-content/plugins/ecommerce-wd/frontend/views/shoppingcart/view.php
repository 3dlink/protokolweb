<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdViewShoppingcart extends EcommercewdView {
  public function display($params = NULL) {
    $model = $this->getModel();

    $model_options = WDFHelper::get_model('options', TRUE);
    $this->options = $model_options->get_options();

    $model_usermanagement = WDFHelper::get_model('usermanagement', TRUE);
    $this->row_user = $model_usermanagement->get_current_user_row();

    $task = $params['layout'];
    switch ($task) {
      case 'displayshoppingcart':
        $this->_layout = 'displayshoppingcart';
        $this->order = WDFHelper::get_order_for_shopping_cart();
        break;
    }
    parent::display($params);
  }
}