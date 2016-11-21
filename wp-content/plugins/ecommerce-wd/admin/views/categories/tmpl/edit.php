<?php
 
defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_enqueue_script('jquery-ui-sortable');
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

$row = $this->row;
if (!$row->id) {
  ?>
  <div class="form-field">
    <label for="meta_title"><?php _e('Meta title', 'wde'); ?></label>
    <input name="meta_title" id="meta_title" type="text" value="">
    <p class="description"></p>
  </div>
  <div class="form-field">
    <label for="meta_description"><?php _e('Meta description', 'wde'); ?></label>
    <input name="meta_description" id="meta_description" type="text" value="">
    <p class="description"></p>
  </div>
  <div class="form-field">
    <label for="meta_keyword"><?php _e('Meta keywords', 'wde'); ?></label>
    <input name="meta_keyword" id="meta_keyword" type="text" value="">
    <p class="description"></p>
  </div>
  <div class="form-field">
    <label><?php _e('Images', 'wde'); ?></label>
    <?php
    echo WDFHTML::jf_thumb_box('thumb_box', FALSE, 'images');
    ?>
    <input type="hidden" name="images" id="images" />
    <p class="description"></p>
  </div>
  <div class="form-field">
    <label><?php _e('Parameters', 'wde'); ?></label>
    <fieldset>
      <table class="adminlist table">
          <tbody id="parameters_container">
          <tr class="template parameter_container" parameter_id="" parameter_name="">
            <td class="col-ordering"><i class="hasTooltip icon-drag" title="" data-original-title=""></i></td>
            <td class="col_parameter_key">
                <span class="parameter_name"></span>
                <span class="required_sign">*</span>
            </td>
            <td>
                <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', 'btn_remove_parameter', 'onclick="onBtnRemoveParameterClick(event, this);"'); ?>
            </td>
          </tr>
          </tbody>

          <tbody>
          <tr>
              <td colspan="3">
              <span>
                  <?php echo '* - ' . __('Required parameters', 'wde'); ?>
              </span>
              <span id="parameter_buttons_container">
                  <?php echo WDFHTML::jfbutton(__('Add parameter', 'wde'), '', 'thickbox', 'onclick="onBtnAddParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
                  <?php echo WDFHTML::jfbutton(__('Remove all', 'wde'), '', '', 'onclick="onBtnRemoveAllParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
                  <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_parameters', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
              </span>
              </td>
          </tr>

          <tr>
              <input type="hidden" name="parameters"/>
          </tr>
          </tbody>
      </table>
    </fieldset>
    <p class="description"></p>
  </div>
  <div class="form-field">
    <label><?php _e('Tags', 'wde'); ?></label>
    <!-- tags -->
    <fieldset>
        <table class="adminlist table">
            <tbody>
            <tr>
                <td class="col_value">
                    <?php echo WDFHTML::jf_tag_box('tag_box', ''); ?>
                </td>
            </tr>

            <tr>
                <td class="col_value">
                <span id="tag_buttons_container">
                    <?php echo WDFHTML::jfbutton(__('Add tags', 'wde'), '', 'thickbox', 'onclick="onBtnAddTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
                    <?php echo WDFHTML::jfbutton(__('Remove all', 'wde'), '', '', 'onclick="onBtnRemoveAllTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
                    <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_tag', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
                </span>
                </td>
            </tr>

            <tr>
                <input type="hidden" name="tags"/>
            </tr>
            </tbody>
        </table>
    </fieldset>
    <p class="description"></p>
  </div>
  <div class="wde-form-field">
    <label><?php _e('Show info', 'wde'); ?>:</label>
    <?php echo WDFHTML::wd_radio('cshow_info', $row->cshow_info, __('Yes', 'wde'), __('No', 'wde')); ?>
    <p class="description"></p>
  </div>
  <div class="wde-form-field">
    <label><?php _e('Show products', 'wde'); ?>:</label>
    <?php echo WDFHTML::wd_radio('cshow_products', $row->cshow_products, __('Yes', 'wde'), __('No', 'wde')); ?>
    <p class="description"></p>
  </div>
  <div class="wde-form-field">
    <label for="meta_title"><?php _e('Number of products', 'wde'); ?>:</label>
    <input type="text" name="products_count" id="products_count" value="<?php echo $row->products_count; ?>" />
    <p class="description"></p>
  </div>
  <div class="wde-form-field">
    <label><?php _e('Show subcategories', 'wde'); ?>:</label>
    <?php echo WDFHTML::wd_radio('show_subcategories', $row->show_subcategories, __('Yes', 'wde'), __('No', 'wde')); ?>
    <p class="description"></p>
  </div>
  <div class="wde-form-field">
    <label><?php _e('Show hierarchy', 'wde'); ?>:</label>
    <?php echo WDFHTML::wd_radio('show_tree', $row->show_tree, __('Yes', 'wde'), __('No', 'wde')); ?>
    <p class="description"></p>
  </div>
  <div class="wde-form-field">
    <label><?php _e('Number of columns', 'wde'); ?>:</label>
    <?php 
    $options = array(
      (object) array('value' => 1, 'text' => '4-3-1'),
      (object) array('value' => 2, 'text' => '3-2-1'),
      (object) array('value' => 3, 'text' => '2-1-1')
    );
    echo WDFHTML::wd_radio_list('subcategories_cols', $options, 'value', 'text', $row->subcategories_cols); ?>
    <p class="description"></p>
  </div>
  <script>
    var _parentId = "";

    var _imageUrls = JSON.parse("[]");

    var _parameters = JSON.parse("[]");
    var _parentParameters = JSON.parse("[]");

    var _tags = JSON.parse("[]");
    var _parentTags = JSON.parse("[]");
    var _url_root = "";
    var _wde_admin_url = "<?php echo admin_url(); ?>";
  </script>
  <?php 
}
else {
  ?>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="meta_title"><?php _e('Meta title', 'wde'); ?></label></th>
    <td>
      <input type="text" name="meta_title" id="meta_title" value="<?php echo $row->meta_title; ?>">
      <p class="description"></p>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="meta_description"><?php _e('Meta description', 'wde'); ?></label></th>
    <td>
      <input type="text" name="meta_description" id="meta_description" value="<?php echo $row->meta_description; ?>">
      <p class="description"></p>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="meta_keyword"><?php _e('Meta keywords', 'wde'); ?></label></th>
    <td>
      <input type="text" name="meta_keyword" id="meta_keyword" value="<?php echo $row->meta_keyword; ?>">
      <p class="description"></p>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="meta_keyword"><?php _e('Images', 'wde'); ?></label></th>
    <td>
      <?php 
      echo WDFHTML::jf_thumb_box('thumb_box', FALSE, 'images');
      ?>
      <input type="hidden" name="images" id="images" value="<?php echo $row->images; ?>" />
      <p class="description"></p>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label><?php _e('Parameters', 'wde'); ?></label></th>
    <td>
      <fieldset>
        <table class="adminlist table">
            <tbody id="parameters_container">
            <tr class="template parameter_container" parameter_id="" parameter_name="">
              <td class="col-ordering"><i class="hasTooltip icon-drag" title="" data-original-title=""></i></td>
              <td class="col_parameter_key">
                  <span class="parameter_name"></span>
                  <span class="required_sign">*</span>
              </td>
              <td>
                  <?php echo WDFHTML::jfbutton_inline('', WDFHTML::BUTTON_INLINE_TYPE_REMOVE, '', 'btn_remove_parameter', 'onclick="onBtnRemoveParameterClick(event, this);"'); ?>
              </td>
            </tr>
            </tbody>

            <tbody>
            <tr>
                <td colspan="3">
                <span>
                    <?php echo '* - ' . __('Required parameters', 'wde'); ?>
                </span>
                <span id="parameter_buttons_container">
                    <?php echo WDFHTML::jfbutton(__('Add parameter', 'wde'), '', 'thickbox', 'onclick="onBtnAddParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
                    <?php echo WDFHTML::jfbutton(__('Remove all', 'wde'), '', '', 'onclick="onBtnRemoveAllParametersClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
                    <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_parameters', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
                </span>
                </td>
            </tr>

            <tr>
                <input type="hidden" name="parameters"/>
            </tr>
            </tbody>
        </table>
    </fieldset>
      <p class="description"></p>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label><?php _e('Tags', 'wde'); ?></label></th>
    <td>
      <!-- tags -->
      <fieldset>
          <table class="adminlist table">
              <tbody>
              <tr>
                  <td class="col_value">
                      <?php echo WDFHTML::jf_tag_box('tag_box', ''); ?>
                  </td>
              </tr>

              <tr>
                  <td class="col_value">
                  <span id="tag_buttons_container">
                      <?php echo WDFHTML::jfbutton(__('Add tags', 'wde'), '', 'thickbox', 'onclick="onBtnAddTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
                      <?php echo WDFHTML::jfbutton(__('Remove all', 'wde'), '', '', 'onclick="onBtnRemoveAllTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
                      <?php echo WDFHTML::jfbutton(__('Manage', 'wde'), '', '', 'href="' . add_query_arg(array('taxonomy' => 'wde_tag', 'post_type' => 'wde_products'), admin_url('edit-tags.php')) . '" target="_blank"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL); ?>
                  </span>
                  </td>
              </tr>

              <tr>
                  <input type="hidden" name="tags" value=""/>
              </tr>
              </tbody>
          </table>
      </fieldset>
      <p class="description"></p>
    </td>
  </tr>
  <tr class="wde-form-field">
    <th scope="row" valign="top"><label><?php _e('Show info', 'wde'); ?>:</label></th>
    <td>
      <?php echo WDFHTML::wd_radio('cshow_info', $row->cshow_info, __('Yes', 'wde'), __('No', 'wde')); ?>
      <p class="description"></p>
    </td>
  </tr>
  <tr class="wde-form-field">
    <th scope="row" valign="top"><label><?php _e('Show products', 'wde'); ?>:</label></th>
    <td>
      <?php echo WDFHTML::wd_radio('cshow_products', $row->cshow_products, __('Yes', 'wde'), __('No', 'wde')); ?>
      <p class="description"></p>
    </td>
  </tr>
  <tr class="wde-form-field">
    <th scope="row" valign="top"><label for="meta_title"><?php _e('Number of products', 'wde'); ?>:</label></th>
    <td>
      <input type="text" name="products_count" id="products_count" value="<?php echo $row->products_count; ?>" />
      <p class="description"></p>
    </td>
  </tr>
  <tr class="wde-form-field">
    <th scope="row" valign="top"><label><?php _e('Show subcategories', 'wde'); ?>:</label></th>
    <td>
      <?php echo WDFHTML::wd_radio('show_subcategories', $row->show_subcategories, __('Yes', 'wde'), __('No', 'wde')); ?>
      <p class="description"></p>
    </td>
  </tr>
  <tr class="wde-form-field">
    <th scope="row" valign="top"><label><?php _e('Show hierarchy', 'wde'); ?>:</label></th>
    <td>
      <?php echo WDFHTML::wd_radio('show_tree', $row->show_tree, __('Yes', 'wde'), __('No', 'wde')); ?>
      <p class="description"></p>
    </td>
  </tr>
  <tr class="wde-form-field">
    <th scope="row" valign="top"><label><?php _e('Number of columns', 'wde'); ?>:</label></th>
    <td>
      <?php 
      $options = array(
        (object) array('value' => 1, 'text' => '4-3-1'),
        (object) array('value' => 2, 'text' => '3-2-1'),
        (object) array('value' => 3, 'text' => '2-1-1')
      );
      echo WDFHTML::wd_radio_list('subcategories_cols', $options, 'value', 'text', $row->subcategories_cols); ?>
      <p class="description"></p>
    </td>
  </tr>
  <script>
    var _imageUrls = JSON.parse("[\"<?php echo addslashes(stripslashes(wp_get_attachment_url($row->images))); ?>\"]");
    var _tags = JSON.parse("<?php echo addslashes(stripslashes(html_entity_decode($row->tags))); ?>");
    var _wde_admin_url = "<?php echo admin_url(); ?>";
    var _parameters = JSON.parse("<?php echo addslashes(stripslashes(html_entity_decode($row->parameters))); ?>");
  </script>
  <?php
}
?>
<input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
<input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="id" value="<?php //echo $row->id; ?>"/>
