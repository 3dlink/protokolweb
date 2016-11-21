<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdViewOptions extends EcommercewdView {
  public function display($tpl = null) {
    ?>
    <div class="wrap">
      <?php
      flush_rewrite_rules();
      $this->create_toolbar();
      $model = $this->getModel();
      $this->_layout = 'default';
      $this->lists = $model->get_lists();
      $this->options = $model->get_options();
      $this->user_data_fields = $model->get_user_data_fields();
      $this->payment_systems = $model->get_additional_data('payments');

      parent::display($tpl);
      ?>
    </div>
    <?php
  }

  private function create_toolbar() {
    WDFToolbar::title(__('Options', 'wde'), 'spidershop_options.png');
    WDFToolbar::addButton('apply', __('Apply', 'wde'));
    WDFToolbar::addButton('cancel', __('Cancel', 'wde'));
    WDFToolbar::addToolbar();
  }
}