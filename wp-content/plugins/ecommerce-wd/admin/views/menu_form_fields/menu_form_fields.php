<?php

// WD js
wp_print_scripts('jquery');
wp_print_scripts('thickbox');
wp_print_styles('thickbox');

// WD css
wp_print_styles('dashicons');
wp_print_styles('wp-admin');
wp_print_styles('buttons');
wp_print_styles('wp-auth-check');
wp_print_styles('nav-menus');

$controller = 'menu_form_fields';
wde_register_ajax_scripts($controller);
wp_print_scripts('wde_tiny_mce_popup');
wp_print_scripts('wde_view');
wp_print_styles('wde_' . $controller);
wp_print_scripts('wde_' . $controller);
?>
<form name="adminForm" id="adminForm" action="" method="post">
  <?php
  WDFHTMLTabs::startTabs('tab_group_shortcode', 'products', 'onTabActivated', FALSE, TRUE);
  WDFHTMLTabs::startTab('categories', __('Categories page', 'wde'));
  WDFHTMLTabs::startTab('manufacturers', __('Manufacturers page', 'wde'));
  WDFHTMLTabs::startTab('products', __('All Products', 'wde'));
  ?>
  <table class="btn_cont">
    <tbody>
      <tr>
        <td class="btns_container">
          <?php echo WDFHTML::jfbutton(__('Update', 'wde'), '', 'wde_shortcode_btn', 'onclick="onBtnInsertClick(event, this);"'); ?>
        </td>
      </tr>
    </tbody>
  </table>
  <?php

  WDFHTMLTabs::endTabs();

  WDFHTMLTabs::startTabsContent();

  WDFHTMLTabs::startTabContent('categories');
  require WD_E_DIR . '/admin/views/menu_form_fields/displaycategory.php';
  WDFHTMLTabs::endTabContent();

  WDFHTMLTabs::startTabContent('manufacturers');
  require WD_E_DIR . '/admin/views/menu_form_fields/displaymanufacturers.php';
  WDFHTMLTabs::endTabContent();

  WDFHTMLTabs::startTabContent('products');
  require WD_E_DIR . '/admin/views/menu_form_fields/displayproducts.php';
  WDFHTMLTabs::endTabContent();

  WDFHTMLTabs::endTabsContent();
  WDFHTMLTabs::scripts(FALSE);

  ?>
  <input type="hidden" name="tab_index" value="products" />
  <input type="hidden" name="layout" value="displayproducts" />
</form>
<script>
  var _wde_admin_url = "<?php echo admin_url(); ?>";
  var wde_btn_insert = "<?php _e('Insert', 'wde'); ?>";
</script>
<?php
die();