<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerOrderProducts extends EcommercewdController {
  public function remove() {
    WDFDb::remove_rows('', WDFInput::get('id'));
    WDFHelper::redirect('', 'explore', '', 'order_id=' . WDFInput::get('order_id') . '&callback=' . WDFInput::get('callback'), __('Item removed.', 'wde'), 'message', TRUE);
  }

  public function update() {
    WDFDb::store_input_in_row();
    WDFHelper::redirect('', 'explore', '', 'order_id=' . WDFInput::get('order_id') . '&callback=' . WDFInput::get('callback'), __('Item saved.', 'wde'), 'message', TRUE);
  }
}