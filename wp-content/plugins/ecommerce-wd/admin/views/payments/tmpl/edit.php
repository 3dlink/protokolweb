<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

$row = $this->row;
?>
<form name="adminForm" id="adminForm" action="" method="post">
  <?php echo $this->generate_message(); ?>
  <?php
	switch (WDFInput::get("type")) {
		case 'stripe':
		case 'authorizenetaim':
		case 'authorizenetdpm':
			$_cc_fields = $row->json_cc_fields;
      WDFHTMLTabs::startTabs('payment_options', WDFInput::get('tab_index'), 'onTabActivated');
			WDFHTMLTabs::startTab('options_api', __('API options', 'wde'));
      WDFHTMLTabs::startTab('options_gneral', __('Credit card fields', 'wde'));
			WDFHTMLTabs::endTabs();

      WDFHTMLTabs::startTabsContent();
      WDFHTMLTabs::startTabContent('options_api');
      require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_apioptions.php';
      WDFHTMLTabs::endTabContent();
      WDFHTMLTabs::startTabContent('options_gneral');
      require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_generaloptions.php';
      WDFHTMLTabs::endTabContent();
      WDFHTMLTabs::endTabsContent();

      WDFHTMLTabs::scripts();
      break;
		case 'without_online_payment':
		case 'paypalstandard':
		case 'paypalexpress':
		case 'authorizenetsim':
			$_cc_fields= '{}';
      require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_apioptions.php';
      break;	
	}
  ?>
  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>" />
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
  <input type="hidden" name="short_name" value="<?php echo WDFInput::get("type"); ?>" />
  <input type="hidden" name="name" value="<?php echo $row->name; ?>" />
  <input type="hidden" name="options" value=""/>
  <input type="hidden" name="tab_index" value="<?php echo WDFInput::get('tab_index'); ?>" />
</form>
<script> 
	var _fields = '<?php echo addslashes(stripslashes(html_entity_decode($row->options))); ?>';
	var _cc_fields = '<?php echo $_cc_fields; ?>';
	var payment_method = '<?php echo WDFInput::get("type"); ?>';
</script>