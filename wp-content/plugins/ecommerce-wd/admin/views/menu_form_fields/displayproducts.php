<?php

// css and js
wp_print_scripts('wde_view');

WDFCookie::clear('displayproducts.sort_by', TRUE, FALSE);
WDFCookie::clear('displayproducts.sort_order', TRUE, FALSE);
WDFCookie::clear('displayproducts.arrangement', TRUE, FALSE);
?>
<table class="adminlist table">
  <tbody>
    <tr>
      <td class="col_key">
        <label><?php _e('Arrangement', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php 
        $options = array(
          (object) array('value' => 'thumbs', 'text' => __('Thumbnails', 'wde')),
          (object) array('value' => 'masonry', 'text' => __('Masonry', 'wde')),
          (object) array('value' => 'list', 'text' => __('List', 'wde')),
          (object) array('value' => 'blog_style', 'text' => __('Blog style', 'wde')),
          (object) array('value' => 'cheese', 'text' => __('Chess', 'wde')),
        );
        $disable_options = array(
          'masonry',
          'blog_style',
          'cheese',
        );
        echo WDFHTML::wd_radio_list('arrangement', $options, 'value', 'text', 'thumbs', '', '', $disable_options); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Filter by category', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <div class="wd_listcategory_wrapper">
          <?php
            $taxonomy = 'wde_categories';
            // Display a category dropdown.
            wp_dropdown_categories(array(
              'show_option_all' => __('Show all categories', 'wde'),
              'taxonomy' => $taxonomy,
              'name' => 'category_id',
              'orderby' => 'name',
              'show_count' => TRUE,
              'hide_empty' => FALSE,
              'hierarchical' => TRUE,
            ));
          ?>
        </div>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Filter by manufacturer', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php
        $manufacturers = WDFDb::get_list_custom_post_type('wde_manufacturers');
        foreach ($manufacturers as $manufacturer) {
          ?>
          <label for="<?php echo $manufacturer['id']; ?>" class="wd_manufacturer_label">
            <input type="checkbox" name="manufacturers[]" value="<?php echo $manufacturer['id']; ?>" onchange="wd_shop_fillInputmanufacturers()" id="<?php echo $manufacturer['id']; ?>" /> <?php echo $manufacturer['name']; ?>
          </label>
          <?php
        }
        ?>
        <input type="hidden" name="manufacturer_id" value="0" id="wd_shop_selected_manufacturers" />
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="max_price"><?php _e('Filter by maximum price', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="max_price" id="max_price" value="" />
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label for="min_price"><?php _e('Filter by minimum price', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <input type="text" name="min_price" id="min_price" value="" />
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Filter by date added', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php
        $options = array(
          (object) array('value' => 0, 'text' => __('Any date', 'wde')),
          (object) array('value' => 1, 'text' => __('Today', 'wde')),
          (object) array('value' => 2, 'text' => __('Last week', 'wde')),
          (object) array('value' => 3, 'text' => __('Last two weeks', 'wde')),
          (object) array('value' => 4, 'text' => __('Last month', 'wde'))
        );
        echo WDFHTML::wd_radio_list('date_added', $options, 'value', 'text', 0); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Filter by minimum rating', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php
        $options = array(
          array('value' => 0, 'text' => 0),
          array('value' => 1, 'text' => 1),
          array('value' => 2, 'text' => 2),
          array('value' => 3, 'text' => 3),
          array('value' => 4, 'text' => 4),
          array('value' => 5, 'text' => 5)
        );
        echo WDFHTML::wd_select('min_rating', $options, 'value', 'text', 0); ?>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Filter by tags', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php
        $tags = isset($_POST['tags']) ? esc_html($_POST['tags']) : 0;
        ?>
        <div class="wdshop_mod_panel">
          <?php echo WDFHTML::jf_module_box('tag_box'); ?>
          <span id="buttons_container">
            <?php echo WDFHTML::jfbutton(__('Add tags', 'wde'), '', 'thickbox', 'onclick="onBtnAddTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_add_logo.png'); ?>
            <?php echo WDFHTML::jfbutton(__('Remove all', 'wde'), '', '', 'onclick="onBtnRemoveAllTagsClick(event, this);"', WDFHTML::BUTTON_COLOR_RED, WDFHTML::BUTTON_SIZE_SMALL, WDFUrl::get_com_admin_url() . '/images/btn_remove_logo.png'); ?>
          </span>
          <script>
            var _tags = JSON.parse("<?php echo $tags ? addslashes(stripslashes(html_entity_decode(wde_getTags($tags)))) : "[]" ; ?>");
            var tag_name = "tags";
          </script>
          <input type="hidden" id="tags" name="tags" value="<?php echo $tags; ?>" />
        </div>
      </td>
    </tr>
    <tr>
      <td class="col_key">
        <label><?php _e('Order by', 'wde'); ?>:</label>
      </td>
      <td class="col_value">
        <?php
        $options = array(
          array('value' => '', 'text' => __('Relevance', 'wde')),
          array('value' => 'name', 'text' => __('Name', 'wde')),
          array('value' => 'manufacturer', 'text' => __('Manufacturer', 'wde')),
          array('value' => 'price', 'text' => __('Price', 'wde')),
          array('value' => 'reviews_count', 'text' => __('Number of reviews', 'wde')),
          array('value' => 'rating', 'text' => __('Rating', 'wde'))
        );
        echo WDFHTML::wd_select('ordering', $options, 'value', 'text', ''); ?>
      </td>
    </tr>
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
        echo WDFHTML::wd_radio_list('order_dir', $options, 'value', 'text', 'asc'); ?>
      </td>
    </tr>
  </tbody>
</table>
<?php
function wde_getTags($tag_ids) {
  $tag_ids = explode(',', $tag_ids);
  if ($tag_ids) {
    $tags = array();
    foreach ($tag_ids as $tag_id) {
      $term = get_term((int) $tag_id, 'wde_tag');
      $tag = new stdClass();
      $tag->id = $term->term_id;
      $tag->name = $term->name;
      $tags[] = $tag;
    }
    return addslashes(WDFJson::encode($tags, 256)) ;
  }
  else {
    return false;
  }
}