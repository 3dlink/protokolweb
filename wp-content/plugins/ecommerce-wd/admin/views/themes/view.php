<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdViewThemes extends EcommercewdView {
  public function display($tpl = null) {
  ?><div class="wrap"><?php
      echo WDFHTML::non_commercial();
      ?>
      <img class="wde_screenshot" src="<?php echo WD_E_URL . '/images/screenshots/1.png'; ?>" />
      <img class="wde_screenshot" src="<?php echo WD_E_URL . '/images/screenshots/2.png'; ?>" />
      <img class="wde_screenshot" src="<?php echo WD_E_URL . '/images/screenshots/3.png'; ?>" />
      <img class="wde_screenshot" src="<?php echo WD_E_URL . '/images/screenshots/4.png'; ?>" />
      <?php
      parent::display($tpl);
  ?></div><?php
  }
}