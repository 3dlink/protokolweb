<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

$row = $this->row;
if (!$row) {
  ?>
  <div class="form-field">
    <label><?php _e('Thumbnail', 'wde'); ?>:</label>
    <?php echo WDFHTML::jf_thumb_box('thumb_box'); ?>
    <input type="hidden" name="thumb" id="thumb" value="" />
    <p class="description"></p>
  </div>
  <div class="form-field">
    <label><?php _e('Position', 'wde'); ?>:</label>
    <table>
      <tbody>
        <tr>
          <td>
            <label for="thumb_position_0"><?php _e('Top left', 'wde'); ?></label>
          </td>
          <td>
            <input type="radio" name="thumb_position" id="thumb_position_0" value="0" checked="checked" />
          </td>
          <td>
            <input type="radio" name="thumb_position" id="thumb_position_1" value="1" />
          </td>
          <td>
            <label for="thumb_position_1"><?php _e('Top right', 'wde'); ?></label>
          </td>
        </tr>
        <tr>
          <td>
            <label for="thumb_position_2"><?php _e('Bottom left', 'wde'); ?></label>
          </td>
          <td>
            <input type="radio" name="thumb_position" id="thumb_position_2" value="2" />
          </td>
          <td>
            <input type="radio" name="thumb_position" id="thumb_position_3" value="3" />
          </td>
          <td>
            <label for="thumb_position_3"><?php _e('Bottom right', 'wde'); ?></label>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="description"></p>
  </div>
  <script>
    var _thumbUrls = JSON.parse("[]");
    var _url_root = "";
  </script>
  <?php
}
else {
  $row = get_option("wde_labels_" . $row);
  $position_0_checked = $row['thumb_position'] == 0 ? 'checked="checked"' : '';
  $position_1_checked = $row['thumb_position'] == 1 ? 'checked="checked"' : '';
  $position_2_checked = $row['thumb_position'] == 2 ? 'checked="checked"' : '';
  $position_3_checked = $row['thumb_position'] == 3 ? 'checked="checked"' : '';
  ?>
  <tr class="form-field">
    <th scope="row" valign="top"><label><?php _e('Thumbnail', 'wde'); ?></label></th>
    <td>
      <?php echo WDFHTML::jf_thumb_box('thumb_box'); ?>
      <input type="hidden" name="thumb" id="thumb" value="<?php echo $row['thumb']; ?>" />
      <p class="description"></p>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label><?php _e('Position', 'wde'); ?>:</label></th>
    <td>
      <table>
        <tbody>
          <tr>
            <td>
              <label for="thumb_position_0"><?php _e('Top left', 'wde'); ?></label>
            </td>
            <td>
              <input type="radio" name="thumb_position" id="thumb_position_0" value="0" <?php echo $position_0_checked; ?> />
            </td>
            <td>
              <input type="radio" name="thumb_position" id="thumb_position_1" value="1" <?php echo $position_1_checked; ?> />
            </td>
            <td>
              <label for="thumb_position_1"><?php _e('Top right', 'wde'); ?></label>
            </td>
          </tr>
          <tr>
            <td>
              <label for="thumb_position_2"><?php _e('Bottom left', 'wde'); ?></label>
            </td>
            <td>
              <input type="radio" name="thumb_position" id="thumb_position_2" value="2" <?php echo $position_2_checked; ?> />
            </td>
            <td>
              <input type="radio" name="thumb_position" id="thumb_position_3" value="3" <?php echo $position_3_checked; ?> />
            </td>
            <td>
              <label for="thumb_position_3"><?php _e('Bottom right', 'wde'); ?></label>
            </td>
          </tr>
        </tbody>
      </table>
      <p class="description"></p>
    </td>
  </tr>
  <script>
    var _thumbUrls = JSON.parse('["<?php echo addslashes(stripslashes(html_entity_decode(wp_get_attachment_thumb_url($row['thumb'])))); ?>"]');
    var _url_root = "";
  </script>
  <?php
}
?>