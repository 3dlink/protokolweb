<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdViewTemplates extends EcommercewdView {
  public function display($tpl = NULL) {
  ?><div class="wrap"><?php
    parent::display($tpl);
  ?></div><?php
  }
}