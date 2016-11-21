<?php
defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_edit');
wp_enqueue_style('wde_layout_default');
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);
// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_edit');
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

$options = $this->options;
$initial_values = $options['initial_values'];
$default_values = $options['default_values'];
?><form name="adminForm" id="adminForm" action="" method="post">
  <?php echo $this->generate_message();

  /*
  * Add custom tabs to options page.
  * Since version 2.0.14
  */
  $custom_tabs = array();
  $custom_tabs = apply_filters('wde_options_custom_tabs', $custom_tabs);

  /*
  * Add custom subtabs to options page tabs.
  * Since version 2.0.14
  */
  $custom_subtabs = array();
  $custom_subtabs = apply_filters('wde_options_custom_subtabs', $custom_subtabs);

  WDFHTMLTabs::startTabs('tab_group_options', WDFInput::get('tab_index'), 'onTabActivated');
  WDFHTMLTabs::startTab('options_global', __('Global', 'wde'));
  WDFHTMLTabs::startTab('products_data', __('Products', 'wde'));
  WDFHTMLTabs::startTab('options_checkout', __('Checkout', 'wde'));
  WDFHTMLTabs::startTab('options_tax', __('Tax, discount and shipping', 'wde'));
  WDFHTMLTabs::startTab('options_user_data', __('Users', 'wde'));
  WDFHTMLTabs::startTab('options_email', __('Email options', 'wde'));
  WDFHTMLTabs::startTab('options_standart_pages', __('Standard pages', 'wde'));

  if (is_array($custom_tabs)) {
    foreach ($custom_tabs as $custom_tab) {
      if (!version_compare($custom_tab['version_required'], substr_replace(WD_E_VERSION, '2', 0, 1), '>')) {
        WDFHTMLTabs::startTab($custom_tab['id'], $custom_tab['title']);
      }
    }
  }

  WDFHTMLTabs::endTabs();

  $controller = WDFInput::get_controller('ecommercewd');    

  WDFHTMLTabs::startTabsContent('tab_group_options');

  WDFHTMLTabs::startTabContent('options_global');
  require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/default_global.php';
  WDFHTMLTabs::endTabContent();

  WDFHTMLTabs::startTabContent('products_data');
  require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/default_products_data.php';
  WDFHTMLTabs::endTabContent();

  WDFHTMLTabs::startTabContent('options_email');
  require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/default_email.php';
  WDFHTMLTabs::endTabContent();

  WDFHTMLTabs::startTabContent('options_user_data');
  require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/default_user_data.php';
  WDFHTMLTabs::endTabContent();

  WDFHTMLTabs::startTabContent('options_checkout');
  require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/default_checkout.php';
  WDFHTMLTabs::endTabContent();

  WDFHTMLTabs::startTabContent('options_tax');
  require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/default_tax.php';
  WDFHTMLTabs::endTabContent();

  WDFHTMLTabs::startTabContent('options_standart_pages');
  require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/default_standart_pages.php';
  WDFHTMLTabs::endTabContent();

  if (is_array($custom_tabs)) {
    foreach ($custom_tabs as $custom_tab) {
      if (!version_compare($custom_tab['version_required'], substr_replace(WD_E_VERSION, '2', 0, 1), '>')) {
        WDFHTMLTabs::startTabContent($custom_tab['id']);
        if (file_exists($custom_tab['content'])) {
          require $custom_tab['content'];
        }
        WDFHTMLTabs::endTabContent();
      }
    }
  }

  WDFHTMLTabs::endTabsContent();

  WDFHTMLTabs::scripts('tab_group_options', TRUE, 'onTabActivated');
  ?>
  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>" />
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="tab_index" id="tab_index" value="<?php echo WDFInput::get('tab_index'); ?>" />
  <input type="hidden" name="subtab_index" id="subtab_index" value="<?php echo WDFInput::get('subtab_index'); ?>" />
</form><?php
foreach ($initial_values as $key => $initial_value) {
  $initial_values[$key] = htmlentities($initial_value, ENT_QUOTES);
  $default_values[$key] = htmlentities($default_values[$key], ENT_QUOTES);
}
?>
<script>
  var _optionsInitialValues = JSON.parse("<?php echo addslashes((WDFJson::encode($initial_values, 256))); ?>");
  var _optionsDefaultValues = JSON.parse("<?php echo addslashes((WDFJson::encode($default_values, 256))); ?>");
</script>