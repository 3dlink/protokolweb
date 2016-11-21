<?php

defined('ABSPATH') || die('Access Denied');

$row = $this->row;
?>
<table class="adminlist table">
  <tbody>
    <!-- rating-->
    <tr>
      <td class="col_key">
        <label ><?php _e('Ratings', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <a href="<?php echo add_query_arg(array('page' => 'wde_ratings', 'search_product_id' => $row->id), admin_url('admin.php')); ?>" target="_blank" class="jfbutton jfbutton_color_white jfbutton_size_small ">
        <span><?php _e('Ratings', 'wde'); ?></span>
      </a>
      </td>
    </tr>
  </tbody>
</table>
