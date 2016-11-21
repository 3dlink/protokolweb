<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerCurrencies extends EcommercewdController {
  public function explore_paypal_currencies() {
    WDFInput::set('tmpl', 'component');
    parent::display();
  }

  public function explore_currencies() {
    WDFInput::set('tmpl', 'component');
    parent::display();
  }
}