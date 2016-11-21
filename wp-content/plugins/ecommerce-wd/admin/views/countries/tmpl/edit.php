<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);
// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);

$row = $this->row;

if ($row === 0) {
  ?>
  <div class="form-field form-required">
    <label for="code"><?php _e('Code', 'wde'); ?></label>
    <input type="text" name="code" id="code" style="width: 100px;" value="" aria-required="true" />
    <p class="description"></p>
  </div>
  <?php
}
else {
  ?>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="code"><?php _e('Code', 'wde'); ?></label></th>
    <td>
      <input type="text" name="code" id="code" style="width: 100px;" value="<?php echo $row['code']; ?>" />
      <p class="description"></p>
    </td>
  </tr>
  <?php
}