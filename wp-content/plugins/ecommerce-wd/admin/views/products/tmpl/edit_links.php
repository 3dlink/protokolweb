<?php
 
defined('ABSPATH') || die('Access Denied');

$row = $this->row;

?>
<table class="adminlist table">
  <tbody>
    <!-- category -->
    <!--<tr>
      <td class="col_key">
        <label><?php _e('CATEGORY', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" id="category_name" disabled="disabled" value="<?php //echo $row->category_name; ?>"/>
        <?php //echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveCategoryClick(event, this);"'); ?>
        <?php //echo WDFHTML::jfbutton(__('BTN_SELECT', 'wde'), '', 'thickbox', 'onclick="onBtnSelectCategoryClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php //echo WDFHTML::jfbutton(__('BTN_MANAGE', 'wde'), '', '', 'href="' . add_query_arg(array('page' => 'wde_categories'), admin_url('admin.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden"
               name="category_id"
               id="category_id"
               value="<?php //echo $row->category_id; ?>"/>
      </td>
    </tr>-->
    <!-- manufacturer -->
    <!--<tr>
      <td class="col_key">
        <label for="manufacturer_id"><?php //_e('MANUFACTURER', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="manufacturer_name" value="<?php //echo $row->manufacturer_name; ?>"
               disabled="disabled">
        <?php //echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveManufacturerClick(event, this);"'); ?>
        <?php //echo WDFHTML::jfbutton(__('BTN_SELECT', 'wde'), '', 'thickbox', 'onclick="onBtnSelectManufacturerClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php //echo WDFHTML::jfbutton(__('BTN_MANAGE', 'wde'), '', '', 'href="' . add_query_arg(array('page' => 'wde_manufacturers'), admin_url('admin.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="manufacturer_id" id="manufacturer_id"
               value="<?php //echo $row->manufacturer_id; ?>">
      </td>
    </tr>-->
    <!-- label -->
    <tr>
      <td class="col_key">
        <label for="label_id"><?php _e('Label', 'wde') ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="label_name" value="<?php echo $row->label_name; ?>" disabled="disabled">
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemoveLabelClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', 'thickbox', 'onclick="onBtnSelectLabelClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_labels', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden" name="label_id" id="label_id" value="<?php echo $row->label_id; ?>">
      </td>
    </tr>
    <!-- pages -->
    <tr>
      <td class="col_key">
        <label><?php _e('License pages', 'wde') ?>:</label>
      </td>
      <td class="col_value">
        <textarea type="text"
                  name="page_titles"
                  id="page_titles"
                  class="names_list"
                  disabled="disabled"><?php echo $row->page_titles; ?></textarea>
        <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', '', 'onclick="onBtnRemovePagesClick(event, this);"'); ?>
        <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', 'thickbox', 'onclick="onBtnSelectPagesClick(event, this);"', WDFHTML::BUTTON_COLOR_GREEN, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . admin_url('edit.php') . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
        <input type="hidden"
               name="page_ids"
               id="page_ids"
               value="<?php echo $row->page_ids; ?>" />
      </td>
    </tr>
  </tbody>
</table>
