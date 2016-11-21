<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerCategories extends EcommercewdController {
  public function show_tree() {
    WDFInput::set('tmpl', 'component');
    parent::display();
  }
}