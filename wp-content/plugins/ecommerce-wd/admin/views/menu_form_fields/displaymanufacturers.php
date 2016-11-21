<?php

?>
<table class="adminlist table">
  <tbody>
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
        echo WDFHTML::wd_radio_list('morder_dir', $options, 'value', 'text', 'asc'); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php echo WDFText::get('SHOW_INFO'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::wd_radio('mshow_info', 1, WDFText::get('YES'), WDFText::get('NO')); ?>
      </td>
    </tr>
  </tbody>
</table>