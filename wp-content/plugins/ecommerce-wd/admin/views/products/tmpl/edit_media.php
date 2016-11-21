<?php

defined('ABSPATH') || die('Access Denied');

$row = $this->row;

?>

<table class="adminlist table">
  <tbody>
    <!-- images -->
    <tr>
      <td class="col_key">
        <label><?php _e('Images', 'wde'); ?>:</label>
      </td>
      <td class="col_value wd_shop_product_images">
        <?php echo WDFHTML::jf_thumb_box('thumb_box_images', true, 'images', 'images'); ?>
        <input type="hidden" name="images" id="images" value="<?php echo $row->images; ?>" />		
      </td>
    </tr>
    <!-- videos -->
    <tr>
      <td class="col_key">
        <label><?php _e('Videos', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php echo WDFHTML::jf_thumb_box('thumb_box_videos', true, 'videos', 'videos'); ?>
        <input type="hidden" name="videos" id="videos" value="<?php echo $row->videos; ?>" />		
      </td>
  </tr>
  </tbody>
</table>
