<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout . '_imagesviewer');
wp_enqueue_style('wde_' . $this->_layout . '_imagesviewer');

$theme = $this->theme;
$product_row = $this->product_row;
$images_ids = explode(',', $product_row->images);

if ($product_row->label_thumb != '') {
  switch ($product_row->label_thumb_position) {
    case 0:
      $label_position_class = 'wd_align_tl';
      break;
    case 1:
      $label_position_class = 'wd_align_tr';
      break;
    case 2:
      $label_position_class = 'wd_align_bl';
      break;
    case 3:
      $label_position_class = 'wd_align_br';
      break;
  }
  $el_product_image_label = '<img class="wd_shop_product_main_image_label ' . $label_position_class . '" src="' . $product_row->label_thumb . '" title="' . $product_row->label_name . '">';
}
else {
  $el_product_image_label = '';
}
if ($product_row->image != '') {
	?>
  <div class="wd_shop_product_images_viewer">
    <!-- main image -->
    <a href="#" class="wd_shop_product_btn_main_image" onclick="return false;">
      <div class="wd_shop_product_image_label_container">
        <div class="wd_shop_product_main_image_container wd_shop_product_image_container wd_center_wrapper img-thumbnail">
          <div>
            <img class="wd_shop_product_main_image" src="<?php echo $product_row->image; ?>" itemprop="image" />
          </div>
        </div>
        <?php
        if ($theme->product_view_show_label == 1) {
          echo $el_product_image_label;
        }
        ?>
      </div>
    </a>
    <!-- images slider -->
    <div class="wd_shop_product_images_slider">
      <a class="wd_items_slider_btn_prev btn btn-link pull-left">
          <span class="glyphicon glyphicon-chevron-left"></span>
      </a>

      <a class="wd_items_slider_btn_next btn btn-link pull-right">
          <span class="glyphicon glyphicon-chevron-right"></span>
      </a>

      <div class="wd_items_slider_mask">
        <ul class="wd_items_slider_items_list">
          <?php
          $active_class = 'active';
          for ($i = 0; $i < count($images_ids); $i++) {
            $image_id = $images_ids[$i];
            if ($image_id) {
              $image = wp_get_attachment_url($image_id);
              ?>
          <li class="<?php echo $active_class; ?>">
            <a class="btn btn-link">
              <div class="wd_center_wrapper">
                <div>										
                  <img src="<?php echo $image; ?>" data-src="<?php echo $image;?>" />					
                </div>
              </div>
            </a>
          </li>
              <?php
              $active_class = '';
            }
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
  <?php
}
else {
  ?>
  <div class="wd_shop_product_images_viewer">
    <div class="wd_shop_product_image_label_container">
      <div class="wd_shop_product_main_image_container wd_shop_product_image_container wd_center_wrapper img-thumbnail">
        <div>
          <div class="wd_shop_product_no_image">
            <span class="glyphicon glyphicon-picture"></span>
            <br />
            <span><?php _e('No Image', 'wde'); ?></span>
          </div>
        </div>
      </div>
      <?php
      if ($theme->product_view_show_label == 1) {
        echo $el_product_image_label;
      }
      ?>
    </div>
  </div>
  <?php
}