<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_jquery.zoom');
wp_enqueue_script('wde_' . $this->_layout . '_imagesviewermodal');
wp_enqueue_style('wde_' . $this->_layout . '_imagesviewermodal');

$product_row = $this->product_row;
$images_ids = explode(',', $product_row->images);
?>
<div class="wd_shop_product_images_viewer_modal modal wd-modal-wide fade in"
     role="dialog"
     tabindex="-1"
     aria-labelledby="ImagesViewerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- modal body -->
      <div class="wd-modal-body">
				<div>
					<!-- btn close -->
					<a href="#" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
					<!-- main image -->
					<div class="wd_shop_product_main_image_container wd_center_wrapper">
						<div>
							<?php
              if ($product_row->image != '') {
                ?>
                <span id="wde_zoom" class="wde_zoom">
                  <img class="wd_shop_product_main_image" src="<?php echo $product_row->image; ?>" alt="<?php echo $product_row->post_title; ?>" />
                </span>
                <?php
              }
              else {
                ?>
              <div class="wd_shop_product_no_image">
                <span class="glyphicon glyphicon-picture"></span>
                <br />
                <span><?php _e('No Image', 'wde'); ?></span>
              </div>
                <?php
              }
              ?>
						</div>
					</div>
				</div>
				<!-- modal footer -->
				<div class="wd-modal-footer">
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
                        <img src="<?php echo $image; ?>" data-src="<?php echo $image; ?>" />											
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
			</div>
		</div>
	</div>
</div>