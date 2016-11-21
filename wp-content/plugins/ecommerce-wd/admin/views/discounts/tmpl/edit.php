<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);

$row = $this->row;
if (!$row) {
  ?>
  <div class="form-field form-required">
    <label for="rate"><?php _e('Rate', 'wde'); ?></label>
    <input type="text" name="rate" id="rate" class="wde_input" value="" />
    <span>%</span>
    <p class="description"></p>
  </div>
  <div class="form-field">
    <label for="date_from"><?php _e('Date from', 'wde'); ?></label>
    <?php
    echo WDFHTML::wd_date('date_from', '', '%Y-%m-%d', 'class="wde_input"');
    ?>
    <p class="description"></p>
  </div>
  <div class="form-field">
    <label for="date_to"><?php _e('Date to', 'wde'); ?></label>
    <?php
    echo WDFHTML::wd_date('date_to', '', '%Y-%m-%d', 'class="wde_input"');
    ?>
    <p class="description"></p>
  </div>
  <?php
}
else {
  $row = get_option("wde_discounts_" . $row);
  ?>
  <tr class="form-field form-required">
    <th scope="row" valign="top"><label for="rate"><?php _e('Rate', 'wde'); ?></label></th>
    <td>
      <input type="text" name="rate" id="rate" aria-required="true" class="wde_input" value="<?php echo $row['rate']; ?>" />
      <span>%</span>
      <p class="description"></p>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="date_from"><?php _e('Date from', 'wde'); ?></label></th>
    <td>
      <?php
      echo WDFHTML::wd_date('date_from', $row['date_from'], '%Y-%m-%d', 'class="wde_input"');
      ?>
      <p class="description"></p>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="date_to"><?php _e('Date to', 'wde'); ?></label></th>
    <td>
      <?php
      echo WDFHTML::wd_date('date_to', $row['date_to'], '%Y-%m-%d', 'class="wde_input"');
      ?>
      <p class="description"></p>
    </td>
  </tr>
  <?php
}