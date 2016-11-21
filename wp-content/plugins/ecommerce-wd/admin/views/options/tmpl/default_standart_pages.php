<?php

defined('ABSPATH') || die('Access Denied');

$options = $this->options;
$initial_values = $options['initial_values'];

WDFHTMLTabs::startTabs('subtab3_group_options', WDFInput::get('subtab_index'), 'onsubTabActivated', FALSE);
WDFHTMLTabs::startTab('wde_permalink_settings', __('Permalink settings', 'wde'));
WDFHTMLTabs::startTab('wde_all_products_page', __('All products page', 'wde'));
WDFHTMLTabs::startTab('wde_orders_page', __('Orders page', 'wde'));
WDFHTMLTabs::startTab('wde_checkout_page', __('Checkout page', 'wde'));
WDFHTMLTabs::startTab('wde_user_management_page', __('User management page', 'wde'));
WDFHTMLTabs::startTab('wde_systempages', __('System pages', 'wde'));

if (is_array($custom_subtabs) && isset($custom_subtabs['options_standart_pages']) && is_array($custom_subtabs['options_standart_pages'])) {
  foreach ($custom_subtabs['options_standart_pages'] as $custom_subtab) {
    if (!version_compare($custom_subtab['version_required'], substr_replace(WD_E_VERSION, '2', 0, 1), '>')) {
      WDFHTMLTabs::startTab($custom_subtab['id'], $custom_subtab['title']);
    }
  }
}

WDFHTMLTabs::endTabs();

WDFHTMLTabs::startTabsContent('subtab3_group_options');

WDFHTMLTabs::startTabContent('wde_permalink_settings');
echo wde_permalink_settings($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_all_products_page');
echo wde_all_products_page($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_orders_page');
echo wde_orders_page($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_checkout_page');
echo wde_checkout_page($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_user_management_page');
echo wde_user_management_page($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_systempages');
echo wde_systempages($initial_values);
WDFHTMLTabs::endTabContent();

if (is_array($custom_subtabs) && isset($custom_subtabs['options_standart_pages']) && is_array($custom_subtabs['options_standart_pages'])) {
  foreach ($custom_subtabs['options_standart_pages'] as $custom_subtab) {
    if (!version_compare($custom_subtab['version_required'], substr_replace(WD_E_VERSION, '2', 0, 1), '>')) {
      WDFHTMLTabs::startTabContent($custom_subtab['id']);
      if (file_exists($custom_subtab['content'])) {
        require $custom_subtab['content'];
      }
      WDFHTMLTabs::endTabContent();
    }
  }
}

WDFHTMLTabs::endTabsContent();

WDFHTMLTabs::scripts('subtab3_group_options', FALSE, 'onsubTabActivated');
?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="btns_container" colspan="2">
        <?php
        echo WDFHTML::jfbutton(__('Reset', 'wde'), '', '', 'onclick="onBtnResetClick(event, this, \'standart_pages\');"');
        echo WDFHTML::jfbutton(__('Load default values', 'wde'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'standart_pages\');"');
        ?>
      </td>
    </tr>
    </tbody>
</table>
<?php

function standart_pages_options_template($options, $initial_values) {
  $permalink_structure = get_option('permalink_structure');
  $prefix = $blog_prefix = '';
  if (!got_url_rewrite()) {
    $prefix = '/index.php';
  }
  if (is_multisite() && ! is_subdomain_install() && is_main_site() && 0 === strpos($permalink_structure, '/blog/')) {
    $blog_prefix = '/blog';
  }
  $home_url = get_option('home') . $blog_prefix . $prefix . '/';
  ?>
  <div class="wde_description">
    <?php _e('Fill in the slug. Note that it should be unique. Use letters and dashes avoiding additional characters, symbols or numbers.', 'wde'); ?>
  </div>
  <?php
  foreach ($options as $key => $option) {
    $html = '<input type="text" class="wde_slug_rewrite" name="' . $key . '" id="' . $key . '" value="' . $initial_values[$key] . '" />';
    $link = str_replace('%input%', $html, $option['link']);
    ?>
  <div><label><?php echo $option['title']; ?></label></div>
  <div class="wde_permalink">
    <?php echo $home_url . $link; ?>
  </div>
    <?php
  }
}

function wde_permalink_settings($initial_values) {
  $options = array(
    'option_ecommerce_base' => array(
      'title' => __('Ecommerce slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/all-products/',
    ),
    'option_product_base' => array(
      'title' => __('Product slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/product-title/',
    ),
    'option_manufacturer_base' => array(
      'title' => __('Manufacturer slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/manufacturer-title/',
    ),
    'option_category_base' => array(
      'title' => __('Category slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/category-name/',
    ),
    'option_tag_base' => array(
      'title' => __('Tag slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/tag-name/',
    ),
    'option_parameter_base' => array(
      'title' => __('Parameter slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/parameter-name/',
    ),
    'option_discount_base' => array(
      'title' => __('Discount slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/discount-name/',
    ),
    'option_tax_base' => array(
      'title' => __('Tax slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/tax-name/',
    ),
    'option_label_base' => array(
      'title' => __('Label slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/label-name/',
    ),
    'option_shipping_method_base' => array(
      'title' => __('Shipping method slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/shipping-method-name/',
    ),
    'option_country_base' => array(
      'title' => __('Country slug', 'wde'),
      'description' => '',
      'link' => '%input%' . '/country-name/',
    ),
  );
  echo standart_pages_options_template($options, $initial_values);
}

function wde_all_products_page($initial_values) {
  $options = array(
    'option_endpoint_compare_products' => array(
      'title' => __('Products compare page', 'wde'),
      'description' => '',
      'link' => 'product/product-title/' . '%input%',
    ),
  );
  echo standart_pages_options_template($options, $initial_values);
}

function wde_orders_page($initial_values) {
  $options = array(
    'option_endpoint_orders_displayorder' => array(
      'title' => __('Display order page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/orders/' . '%input%',
    ),
    'option_endpoint_orders_printorder' => array(
      'title' => __('Print order page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/orders/' . '%input%',
    ),
  );
  echo standart_pages_options_template($options, $initial_values);
}

function wde_checkout_page($initial_values) {
  $options = array(
    'option_endpoint_checkout_shipping_data' => array(
      'title' => __('Shipping data page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/checkout/' . '%input%',
    ),
    'option_endpoint_checkout_products_data' => array(
      'title' => __('Products data page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/checkout/' . '%input%',
    ),
    'option_endpoint_checkout_license_pages' => array(
      'title' => __('License pages', 'wde'),
      'description' => '',
      'link' => 'ecommerce/checkout/' . '%input%',
    ),
    'option_endpoint_checkout_confirm_order' => array(
      'title' => __('Confirm order page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/checkout/' . '%input%',
    ),
    'option_endpoint_checkout_finished_success' => array(
      'title' => __('Checkout finished success page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/checkout/' . '%input%',
    ),
    'option_endpoint_checkout_finished_failure' => array(
      'title' => __('Checkout finished failure page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/checkout/' . '%input%',
    ),
    'option_endpoint_checkout_product' => array(
      'title' => __('Checkout product page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/checkout/' . '%input%',
    ),
    'option_endpoint_checkout_all_products' => array(
      'title' => __('Checkout all products page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/checkout/' . '%input%',
    ),
  );
  echo standart_pages_options_template($options, $initial_values);
}

function wde_user_management_page($initial_values) {
  $options = array(
    'option_endpoint_edit_user_account' => array(
      'title' => __('Edit user account page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/user-management/' . '%input%',
    ),
  );
  echo standart_pages_options_template($options, $initial_values);
}

function wde_systempages($initial_values) {
  $options = array(
    'option_endpoint_systempages_errnum' => array(
      'title' => __('System page', 'wde'),
      'description' => '',
      'link' => 'ecommerce/system-pages/' . '%input%',
    ),
  );
  echo standart_pages_options_template($options, $initial_values);
}