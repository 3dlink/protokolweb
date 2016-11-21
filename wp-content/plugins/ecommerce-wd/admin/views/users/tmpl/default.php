<?php
 
defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);
// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);

$lists = $this->lists;
$list_countries = $lists['countries'];
$row = $this->row;
?>
<h2><?php _e('E-Commerce Billing Information', 'wde'); ?></h2>
<table class="form-table">
  <tbody>
    <?php
    foreach ($row["billing_fields_list"] as $field) {
      if ($field["required"] > 0) {
        ?>
        <tr>
          <th>
            <label for="<?php echo $field["id"]; ?>"><?php echo $field["label"]; ?>
              <?php if ($field["required"] == 2) {
                ?>
                <span class="description"><?php _e("(required)", 'wde'); ?></span>
                <?php
              } ?>
            </label>
          </th>
          <td>
          <?php
          if ($field["type"] == "input") {
          ?>
            <input type="text" name="<?php echo $field["id"]; ?>" id="<?php echo $field["id"]; ?>" value="<?php echo $field["value"]; ?>" class="regular-text<?php echo ($field["required"] == 2 ? ' required_field' : ''); ?>"/>
          <?php
          }
          elseif($field["type"] == "select") {
          ?>
            <?php echo WDFHTML::wd_select($field["id"], $list_countries, 'id', 'name', $field["value"], ($field["required"] == 2 ? 'class="required_field"' : '')); ?>
          <?php
          }
          ?>
          </td>
        </tr>
        <?php
      }
    }
    ?>
  </tbody>
</table>
<h2><?php _e('E-Commerce Shipping Information', 'wde'); ?></h2>
<table class="form-table">
  <tbody>
    <?php
    foreach ($row["shipping_fields_list"] as $field) {
      if ($field["required"] > 0) {
        ?>
        <tr>
          <th>
            <label for="<?php echo $field["id"]; ?>"><?php echo $field["label"]; ?>
              <?php if ($field["required"] == 2) {
                ?>
                <span class="description"><?php _e("(required)", 'wde'); ?></span>
                <?php
              } ?>
            </label>
          </th>
          <td>
          <?php
          if ($field["type"] == "input") {
          ?>
            <input type="text" name="<?php echo $field["id"]; ?>" id="<?php echo $field["id"]; ?>" value="<?php echo $field["value"]; ?>" class="regular-text<?php echo ($field["required"] == 2 ? ' required_field' : ''); ?>"/>
          <?php
          }
          elseif($field["type"] == "select") {
          ?>
            <?php echo WDFHTML::wd_select($field["id"], $list_countries, 'id', 'name', $field["value"], ($field["required"] == 2 ? 'class="required_field"' : '')); ?>
          <?php
          }
          ?>
          </td>
        </tr>
        <?php
      }
    }
    ?>
  </tbody>
</table>
