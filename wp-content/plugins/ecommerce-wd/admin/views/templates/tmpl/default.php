<?php
if (function_exists('current_user_can')) {
  if (!current_user_can('manage_options')) {
    die('Access Denied');
  }
}
else {
  die('Access Denied');
}

defined('ABSPATH') || die('Access Denied');

wp_enqueue_style('wde_layout_default');
wp_enqueue_style('wde_options_default');
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_default');
?><form name="adminForm" id="adminForm" action="" method="post">
  <?php echo $this->generate_message(); ?><?php
$tab_index = WDFInput::get('tab_index', 'products');
WDFHTMLTabs::startTabs('tab_group_options', $tab_index, 'onTabActivated');
WDFHTMLTabs::startTab('products', __('Product template', 'wde'));
WDFHTMLTabs::startTab('manufacturers', __('Manufacturer template', 'wde'));
WDFHTMLTabs::startTab('categories', __('Category template', 'wde'));
WDFHTMLTabs::endTabs();

WDFHTMLTabs::startTabsContent('tab_group_options');

WDFHTMLTabs::startTabContent('products');
echo wde_product_template();
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('manufacturers');
echo wde_manufacturer_template();
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('categories');
echo wde_category_template();
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::endTabsContent();

WDFHTMLTabs::scripts('tab_group_options', FALSE, 'onTabActivated');
?><input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>" />
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="tab_index" id="tab_index" value="<?php echo $tab_index; ?>" />
</form>
<?php

function template_html($options) {
  $type = $options['type'];
  $description = $options['description'];
  $path = wde_get_template($type);
  $vew_path = str_replace(str_replace(array('/', '\\'), DS, ABSPATH), '', $path);
  $flag = FALSE;
  if (file_exists($path)) {
    $content = file_get_contents($path);
    if ($content === FALSE) {
      $flag = TRUE;
    }
    $content = trim($content);
  }
  else {
    $flag = TRUE;
  }
  if ($flag) {
    echo WDFHTML::wd_message(30);
    return;
  }
?><table class="adminlist table">
  <tbody>
    <tr>
      <td class="btns_container" colspan="2">
        <?php
        echo WDFHTML::jfbutton(__('Save', 'wde'), '', '', 'onclick="submitform(\'save\'); return false;"');
        echo WDFHTML::jfbutton(__('Custom template', 'wde'), '', '', 'onclick="submitform(\'reset\'); return false;"');
        echo WDFHTML::jfbutton(__('Import from theme template', 'wde'), '', '', 'onclick="submitform(\'copy\'); return false;"');
        echo WDFHTML::jfbutton(__('Generate template', 'wde'), '', '', 'onclick="submitform(\'generate_templates\'); return false;" style="float: right;"');
        ?>
      </td>
    </tr>
    </tbody>
</table>
<div id="template">
  <div class="wde_template template_html">
    <h4><?php _e('HTML template', 'wde'); ?>&nbsp;<code><?php echo $vew_path; ?></code></h4>
    <p><?php echo $options['description']; ?></p>
    <p><code><?php echo $options['code']; ?></code></p>
    <div class="editor">
      <textarea class="code" name="<?php echo $type; ?>_code" rows="30"><?php
      echo $content;
      ?></textarea>
    </div>
  </div>
</div><?php
}

function wde_product_template() {
  $options = array(
    'type' => 'products',
    'description' => __('Insert the code to display product in custom area:', 'wde'),
    'code' => esc_html("<?php wde_front_end(array('product_id' => get_the_ID(), 'type' => 'products', 'layout' => 'displayproduct'), TRUE); ?>"),
  );
  template_html($options);
}

function wde_manufacturer_template() {
  $options = array(
    'type' => 'manufacturers',
    'description' => __('Insert the code to display manufacturer in custom area:', 'wde'),
    'code' => esc_html("<?php wde_front_end(array('manufacturer_id' => get_the_ID(), 'type' => 'manufacturers', 'layout' => 'displaymanufacturer')); ?>"),
  );
  template_html($options);
}

function wde_category_template() {
  $options = array(
    'type' => 'categories',
    'description' => __('Insert the code to display category in custom area:', 'wde'),
    'code' => esc_html("<?php wde_front_end(array('type' => 'categories', 'layout' => 'displaycategory')); ?>"),
  );
  template_html($options);
}