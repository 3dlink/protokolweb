<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);
// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);

$row = $this->row;
?>
<table class="adminlist table">
  <tbody>
    <!-- website -->
    <tr>
      <td class="col_key">
        <label for="site"><?php _e('Website', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="site" id="site" value="<?php echo $row->site; ?>" />
        <div class="spider_description">Use http:// and https:// for external links.</div>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Show info', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('show_info', $row->show_info, __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Show products', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('show_products', $row->show_products, __('Yes', 'wde'), __('No', 'wde')); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="products_count"><?php _e('Number of products', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="products_count" id="products_count" value="<?php echo $row->products_count; ?>" />
      </td>
    </tr>
    <!-- meta title-->
    <tr>
      <td class="col_key">
        <label for="meta_title"><?php _e('Meta title', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="meta_title" id="meta_title" value="<?php echo $row->meta_title; ?>" />
      </td>
    </tr>
    <!-- meta description-->
    <tr>
      <td class="col_key">
        <label for="meta_description"><?php _e('Meta description', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="meta_description" id="meta_description" value="<?php echo $row->meta_description; ?>" />
      </td>
    </tr>
    <!-- meta keyword-->
    <tr>
      <td class="col_key">
        <label for="meta_keyword"><?php _e('Meta keywords', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="meta_keyword" id="meta_keyword" value="<?php echo $row->meta_keyword; ?>" />
      </td>
    </tr>
  </tbody>
</table>