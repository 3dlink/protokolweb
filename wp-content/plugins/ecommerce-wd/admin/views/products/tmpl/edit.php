<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_enqueue_script('jquery-ui-sortable');
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

$row = $this->row;

WDFHTMLTabs::startTabs('tab_group_products', WDFInput::get('tab_index'), 'onTabActivated');

WDFHTMLTabs::startTab('data', __('Data', 'wde'));
WDFHTMLTabs::startTab('links', __('Links', 'wde'));
WDFHTMLTabs::startTab('parameters', __('Parameters', 'wde'));	
WDFHTMLTabs::startTab('shipping', __('Shipping', 'wde'));	
WDFHTMLTabs::startTab('media', __('Media', 'wde'));	
WDFHTMLTabs::startTab('general', __('Meta tags', 'wde'));
if (WDFInput::get('action') == "edit") {
  WDFHTMLTabs::startTab('feedback', __('Ratings', 'wde'));
}

WDFHTMLTabs::endTabs();

$controller = WDFInput::get_controller('ecommercewd');

WDFHTMLTabs::startTabsContent();

WDFHTMLTabs::startTabContent('data');
require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_data.php';
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('links');
require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_links.php';
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('parameters');
require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_parameters.php';
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('shipping');
require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_shipping.php';
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('media');
require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_media.php';
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('general');
require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_general.php';
WDFHTMLTabs::endTabContent();

if (WDFInput::get('action') == "edit") {
  WDFHTMLTabs::startTabContent('feedback');
  require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/edit_feedback.php';
  WDFHTMLTabs::endTabContent();
}

WDFHTMLTabs::endTabsContent();
  
WDFHTMLTabs::scripts();
?>
<input type="hidden" name="tab_index" value="<?php echo WDFInput::get('tab_index'); ?>" />

<script>
  var _imageUrls = [];
  var _imageIDs = [];
  var _videoUrls = [];
  var _videoIDs = [];
  
  <?php
  $images_id = explode(',', $row->images);
  foreach ($images_id as $key => $image_id) {
    if ($image_id) {
      ?>
  _imageUrls[<?php echo $key; ?>] = "<?php echo addslashes(stripslashes(html_entity_decode(wp_get_attachment_url($image_id)))); ?>";
  _imageIDs[<?php echo $key; ?>] = <?php echo addslashes(stripslashes(html_entity_decode($image_id))); ?>;
      <?php
    }
  }
  $videos_id = explode(',', $row->videos);
  foreach ($videos_id as $key => $videos_id) {
    if ($videos_id) {
      ?>
  _videoUrls[<?php echo $key; ?>] = "<?php echo addslashes(stripslashes(html_entity_decode(wp_get_attachment_url($videos_id)))); ?>";
  _videoIDs[<?php echo $key; ?>] = <?php echo addslashes(stripslashes(html_entity_decode($videos_id))); ?>;
      <?php
    }
  }
  ?>
  var _parameters = JSON.parse("<?php echo addslashes(stripslashes(html_entity_decode($row->parameters))); ?>");

  var _default_shipping = "<?php echo $row->default_shipping; ?>";

  var _url_root = "";
  var _wde_admin_url = "<?php echo admin_url(); ?>";
  var _categories_parameters = JSON.parse("<?php echo addslashes(stripslashes(html_entity_decode($row->categories_parameters))); ?>");
</script>