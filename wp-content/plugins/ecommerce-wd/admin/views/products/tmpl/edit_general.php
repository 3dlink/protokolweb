<?php
defined('ABSPATH') || die('Access Denied');

$row = $this->row;

?>
<table class="adminlist table">
  <tbody>
    <!-- meta title-->
    <tr>
      <td class="col_key">
        <label for="meta_title"><?php _e('Meta title', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text"
               name="meta_title"
               id="meta_title"
               value="<?php echo $row->meta_title; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
    <!-- meta description-->
    <tr>
      <td class="col_key">
        <label for="meta_description"><?php _e('Meta description', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text"
               name="meta_description"
               id="meta_description"
               value="<?php echo $row->meta_description; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
    <!-- meta keyword-->
    <tr>
      <td class="col_key">
        <label for="meta_keyword"><?php _e('Meta keywords', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text"
               name="meta_keyword"
               id="meta_keyword"
               value="<?php echo $row->meta_keyword; ?>"
               onKeyPress="return disableEnterKey(event);"/>
      </td>
    </tr>
  </tbody>
</table>