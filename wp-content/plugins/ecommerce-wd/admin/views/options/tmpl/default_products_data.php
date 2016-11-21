<?php

defined('ABSPATH') || die('Access Denied');

$lists = $this->lists;

$options = $this->options;

$initial_values = $options['initial_values'];
?>
<?php
WDFHTMLTabs::startTabs('subtab1_group_options', WDFInput::get('subtab_index'), 'onsubTabActivated', FALSE);
WDFHTMLTabs::startTab('wde_products_data', __('Products data', 'wde'));
WDFHTMLTabs::startTab('wde_feedback', __('Feedback', 'wde'));
WDFHTMLTabs::startTab('wde_social', __('Social media integration', 'wde'));

if (is_array($custom_subtabs) && isset($custom_subtabs['products_data']) && is_array($custom_subtabs['products_data'])) {
  foreach ($custom_subtabs['products_data'] as $custom_subtab) {
    if (!version_compare($custom_subtab['version_required'], substr_replace(WD_E_VERSION, '2', 0, 1), '>')) {
      WDFHTMLTabs::startTab($custom_subtab['id'], $custom_subtab['title']);
    }
  }
}

WDFHTMLTabs::endTabs();

WDFHTMLTabs::startTabsContent('subtab1_group_options');

WDFHTMLTabs::startTabContent('wde_products_data');
echo wde_products_data($initial_values, $lists);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_feedback');
echo wde_feedback($initial_values);
WDFHTMLTabs::endTabContent();

WDFHTMLTabs::startTabContent('wde_social');
echo wde_social($initial_values);
WDFHTMLTabs::endTabContent();

if (is_array($custom_subtabs) && isset($custom_subtabs['products_data']) && is_array($custom_subtabs['products_data'])) {
  foreach ($custom_subtabs['products_data'] as $custom_subtab) {
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

WDFHTMLTabs::scripts('subtab1_group_options', FALSE, 'onsubTabActivated');
?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="btns_container">
        <?php
        echo WDFHTML::jfbutton(__('Reset', 'wde'), '', '', 'onclick="onBtnResetClick(event, this, \'products_data\');"');
        echo WDFHTML::jfbutton(__('Load default values', 'wde'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'products_data\');"');
        ?>
      </td>
    </tr>
  </tbody>
</table>
<?php

function wde_products_data($initial_values, $lists) {
  $list_dimensions_units = $lists['dimensions_units'];
  $list_weight_units = $lists['weight_units'];
  ?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="col_key">
        <label for="weight_unit"><?php _e('Weight unit', 'wde'); ?>:</label>
      </td>
      <td class="col_value">   
        <?php echo WDFHTML::wd_select('weight_unit', $list_weight_units, 'value', 'text', $initial_values['weight_unit']); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="dimensions_unit"><?php _e('Dimensions unit', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_select('dimensions_unit', $list_dimensions_units, 'value', 'text', $initial_values['dimensions_unit']); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="enable_sku"><?php _e('SKU', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('enable_sku', $initial_values['enable_sku'], __('Yes', 'wde'), __('No', 'wde')); ?>    
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="enable_upc"><?php _e('UPC', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('enable_upc', $initial_values['enable_upc'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="enable_ean"><?php _e('EAN', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('enable_ean', $initial_values['enable_ean'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="enable_jan"><?php _e('JAN', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('enable_jan', $initial_values['enable_jan'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="enable_isbn"><?php _e('ISBN', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('enable_isbn', $initial_values['enable_isbn'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="enable_mpn"><?php _e('MPN', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('enable_mpn', $initial_values['enable_mpn'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>	
  </tbody>
</table>
  <?php
}

function wde_feedback($initial_values) {
  ?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="col_key">
        <label for="feedback_enable_product_rating"><?php _e('Enable product rating', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('feedback_enable_product_rating', $initial_values['feedback_enable_product_rating'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="feedback_enable_product_reviews"><?php _e('Enable product reviews', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('feedback_enable_product_reviews', $initial_values['feedback_enable_product_reviews'], __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
  </tbody>
</table>
  <?php
}

function wde_social($initial_values) {
  $enable_fb_like_btn_checked = $initial_values['social_media_integration_enable_fb_like_btn'] == 1 ? 'checked="checked"' : '';
  $enable_twitter_tweet_btn_checked = $initial_values['social_media_integration_enable_twitter_tweet_btn'] == 1 ? 'checked="checked"' : '';
  $enable_g_plus_btn_checked = $initial_values['social_media_integration_enable_g_plus_btn'] == 1 ? 'checked="checked"' : '';
  $list_fb_color_scheme = array();
  $list_fb_color_scheme[] = (object)array('value' => 'light', 'text' => __('Light', 'wde'));
  $list_fb_color_scheme[] = (object)array('value' => 'dark', 'text' => __('Dark', 'wde'));
  ?>
<fieldset>
  <legend><?php _e('Share buttons', 'wde'); ?></legend>
  <table class="adminlist table">
    <tbody>
      <tr>
        <td class="col_key">
          <label><?php _e('Enable buttons', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <label class="wd_clear">
            <input type="checkbox" name="social_media_integration_enable_fb_like_btn"
                   value="1" <?php echo $enable_fb_like_btn_checked; ?>>
            <img class="img_social_btn"
                 src="<?php echo WDFUrl::get_com_admin_url() . '/images/options/fb_like.png' ?>">
          </label>
          <label class="wd_clear">
            <input type="checkbox" name="social_media_integration_enable_twitter_tweet_btn"
                   value="1" <?php echo $enable_twitter_tweet_btn_checked; ?>>
            <img class="img_social_btn"
                 src="<?php echo WDFUrl::get_com_admin_url() . '/images/options/twitter_tweet.png' ?>">
          </label>
          <label class="wd_clear">
            <input type="checkbox" name="social_media_integration_enable_g_plus_btn"
                   value="1" <?php echo $enable_g_plus_btn_checked; ?>>
            <img class="img_social_btn"
                 src="<?php echo WDFUrl::get_com_admin_url() . '/images/options/g_plus.png' ?>">
          </label>
        </td>
      </tr>
    </tbody>
  </table>
</fieldset>
<fieldset>
  <legend><?php _e('Facebook comments', 'wde'); ?></legend>
  <table class="adminlist table">
    <tbody>
      <tr>
        <td class="col_key">
          <label for="social_media_integration_use_fb_comments"><?php _e('Use Facebook comments instead of reviews', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <?php echo WDFHTML::wd_radio('social_media_integration_use_fb_comments', $initial_values['social_media_integration_use_fb_comments'], __('Yes', 'wde'), __('No', 'wde')); ?>
        </td>
      </tr>
      <tr>
        <td class="col_key">
          <label for="social_media_integration_fb_color_scheme"><?php _e('Color scheme', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <?php echo WDFHTML::wd_radio_list('social_media_integration_fb_color_scheme', $list_fb_color_scheme, 'value', 'text', $initial_values['social_media_integration_fb_color_scheme']); ?>
        </td>
      </tr>
    </tbody>
  </table>
</fieldset>
  <?php
}