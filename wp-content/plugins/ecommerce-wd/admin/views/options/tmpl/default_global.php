<?php

defined('ABSPATH') || die('Access Denied');

$options = $this->options;
$lists = $this->lists;
$initial_values = $options['initial_values'];

WDFHTMLTabs::startTabs('subtab2_group_options', WDFInput::get('subtab_index'), 'onsubTabActivated', FALSE);
WDFHTMLTabs::startTab('wde_general', __('General', 'wde'));
WDFHTMLTabs::startTab('wde_search', __('Search and Sort', 'wde'));

if (is_array($custom_subtabs) && isset($custom_subtabs['options_global']) && is_array($custom_subtabs['options_global'])) {
  foreach ($custom_subtabs['options_global'] as $custom_subtab) {
    if (!version_compare($custom_subtab['version_required'], substr_replace(WD_E_VERSION, '2', 0, 1), '>')) {
      WDFHTMLTabs::startTab($custom_subtab['id'], $custom_subtab['title']);
    }
  }
}

WDFHTMLTabs::endTabs();

WDFHTMLTabs::startTabsContent('subtab2_group_options');

WDFHTMLTabs::startTabContent('wde_general');
echo wde_general($initial_values, $lists);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_search');
echo wde_search($initial_values);
WDFHTMLTabs::endTabContent();

if (is_array($custom_subtabs) && isset($custom_subtabs['options_global']) && is_array($custom_subtabs['options_global'])) {
  foreach ($custom_subtabs['options_global'] as $custom_subtab) {
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

WDFHTMLTabs::scripts('subtab2_group_options', FALSE, 'onsubTabActivated');

?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="btns_container">
        <?php
        echo WDFHTML::jfbutton(__('Reset', 'wde'), '', '', 'onclick="onBtnResetClick(event, this, \'global\');"');
            echo WDFHTML::jfbutton(__('Load default values', 'wde'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'global\');"');
        ?>
      </td>
    </tr>
  </tbody>
</table>
<?php

function wde_general($initial_values, $lists) {
  $list_base_location = $lists['base_location'];
  ?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="col_key">
        <label for="base_location"><?php _e('Base location', 'wde'); ?>:</label>
      </td>
      <td class="col_value">   
        <?php echo WDFHTML::wd_select('base_location', $list_base_location, 'id', 'name', $initial_values['base_location']); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="option_date_format"><?php _e('Date format', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="option_date_format" id="option_date_format" value="<?php echo $initial_values['option_date_format']; ?>" />
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="option_show_decimals"><?php _e('Display price with decimals', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('option_show_decimals', $initial_values['option_show_decimals'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Add/Edit countries', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <a class="jfbutton jfbutton_color_blue jfbutton_size_medium"
           target="_blank"
           href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=wde_countries')); ?>"
           title="<?php _e('To add a new country or edit the existing one, please click on the button.', 'wde'); ?>"><?php _e('Country', 'wde'); ?></a>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Add/Edit currencies', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <a class="jfbutton jfbutton_color_blue jfbutton_size_medium"
           target="_blank"
           href="<?php echo esc_url(admin_url('admin.php?page=wde_currencies')); ?>"
           title="<?php _e('To add a new currency or edit the existing one, please click on the button.', 'wde'); ?>"><?php _e('Currency', 'wde'); ?></a>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Add/Edit order statuses', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <a class="jfbutton jfbutton_color_blue jfbutton_size_medium"
           target="_blank"
           href="<?php echo esc_url(admin_url('admin.php?page=wde_orderstatuses')); ?>"
           title="<?php _e('To add a new order status or edit the existing one, please click on the button.', 'wde'); ?>"><?php _e('Order status', 'wde'); ?></a>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Access the wizard again', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <a class="jfbutton jfbutton_color_blue jfbutton_size_medium"
           target="_blank"
           href="<?php echo esc_url(admin_url('admin.php?page=wde_setup')); ?>"
           title="<?php _e('If you need to access the setup wizard again, please click on the button.', 'wde'); ?>"><?php _e('Setup wizard', 'wde'); ?></a>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Manage Product/Category/Manufacturer templates', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::jfbutton(__('Manage templates', 'wde'), '', '', 'href="' . esc_url(admin_url('admin.php?page=wde_templates')) . '" target="_blank"'); ?>
      </td>
    </tr>
  </tbody>
</table>
  <?php
}

function wde_search($initial_values) {
  ?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="col_key">
        <label for="search_enable_search"><?php _e('Enable search', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('search_enable_search', $initial_values['search_enable_search'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="search_by_category"><?php _e('Search by category', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('search_by_category', $initial_values['search_by_category'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="search_include_subcategories"><?php _e('Hierarchical categories ', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('search_include_subcategories', $initial_values['search_include_subcategories'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="filter_manufacturers"><?php _e('Filter by manufacturers', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('filter_manufacturers', $initial_values['filter_manufacturers'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="filter_price"><?php _e('Filter by price', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('filter_price', $initial_values['filter_price'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="filter_date_added"><?php _e('Filter by date added', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('filter_date_added', $initial_values['filter_date_added'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="filter_minimum_rating"><?php _e('Filter by minimum rating', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('filter_minimum_rating', $initial_values['filter_minimum_rating'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="filter_tags"><?php _e('Filter by tags', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('filter_tags', $initial_values['filter_tags'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="sort_by_name"><?php _e('Sort by name', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('sort_by_name', $initial_values['sort_by_name'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="sort_by_manufacturer"><?php _e('Sort by manufacturer', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('sort_by_manufacturer', $initial_values['sort_by_manufacturer'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="sort_by_price"><?php _e('Sort by price', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('sort_by_price', $initial_values['sort_by_price'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="sort_by_count_of_reviews"><?php _e('Sort by number of reviews', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('sort_by_count_of_reviews', $initial_values['sort_by_count_of_reviews'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="sort_by_rating"><?php _e('Sort by rating', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('sort_by_rating', $initial_values['sort_by_rating'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
  </tbody>
</table>
  <?php
}