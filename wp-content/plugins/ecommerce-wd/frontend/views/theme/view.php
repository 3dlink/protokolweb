<?php

defined('ABSPATH') || die('Access Denied');

// jimport('joomla.application.component.view');

class EcommercewdViewTheme extends EcommercewdView {
  
  public function display($tpl = null) {
    $model = $this->getModel();

    $this->prefix = '#wd_shop_container_1 #wd_shop_container_2 #wd_shop_container_3 #wd_shop_container_4 #wd_shop_container_5 #wd_shop_container_6 #wd_shop_container_7 #wd_shop_container_8 #wd_shop_container_9 #wd_shop_container_10 #wd_shop_container_11 #wd_shop_container_12 #wd_shop_container';
    $this->theme = $model->get_theme_row();
    parent::display($tpl);
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