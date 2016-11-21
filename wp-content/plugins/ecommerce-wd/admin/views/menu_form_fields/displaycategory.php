<?php

$category_name = WDFText::get('ROOT_CATEGORY');
?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="col_key">
        <label><?php _e('Filter by category', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <div class="wd_listcategory_wrapper">
          <?php
            wp_dropdown_categories(array(
              'show_option_all' => __('Show all categories', 'wde'),
              'taxonomy' => 'wde_categories',
              'name' => 'ccategory_id',
              'orderby' => 'name',
              'show_count' => TRUE,
              'hide_empty' => FALSE,
              'hierarchical' => TRUE,
            ));
          ?>
        </div>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Order direction', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php
        $options = array(
          (object) array('value' => 'asc', 'text' => __('Asc', 'wde')),
          (object) array('value' => 'desc', 'text' => __('Desc', 'wde'))
        );
        echo WDFHTML::wd_radio_list('corder_dir', $options, 'value', 'text', 'asc'); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php echo WDFText::get('SHOW_INFO'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('cshow_info', 1, WDFText::get('YES'), WDFText::get('NO')); ?>
      </td>
    </tr>
  </tbody>
</table>