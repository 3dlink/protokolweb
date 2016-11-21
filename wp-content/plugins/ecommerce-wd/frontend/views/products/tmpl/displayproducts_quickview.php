<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout . '_quickview');
wp_enqueue_style('wde_' . $this->_layout . '_quickview');

$queried_object = get_queried_object();
$current_url = $_SERVER['REQUEST_URI'];
if (isset($queried_object) && isset($queried_object->ID)) {
  $current_url = get_permalink($queried_object->ID);
}

$options = $this->options;
$theme = $this->theme;

$show_image = $theme->products_quick_view_show_image == 1 ? true : false;
$show_info = ($theme->products_quick_view_show_name == 1) || ($theme->products_quick_view_show_rating == 1) || ($theme->products_quick_view_show_category == 1) || ($theme->products_quick_view_show_manufacturer == 1) || ($theme->products_quick_view_show_price == 1) || ($theme->products_quick_view_show_market_price == 1) || ($theme->products_quick_view_show_description == 1) || ($theme->products_quick_view_show_button_compare == 1) || ($theme->products_quick_view_show_button_buy_now == 1) || ($theme->products_quick_view_show_button_add_to_cart == 1) ? true : false;
$product_row = $this->product_row;
$product_image_col_class = $show_info == true ? 'col-sm-4' : 'col-sm-12';
$product_info_col_class = $show_image == true ? 'col-sm-8' : 'col-sm-12';

?>
<div id="wd_shop_product_quick_view"
     class="modal wd-modal-wide fade"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- modal header -->
      <div class="modal-header">
        <!-- btn close -->
        <a href="#" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
        <!-- header -->
        <h4 class="modal-title">
          <?php _e('Quick view', 'wde'); ?>&nbsp;
        </h4>
      </div>
      <!-- modal body -->
      <div class="modal-body">
        <!-- prev, next buttons -->
        <a class="btn btn-link btn-lg wd-modal-ctrl wd-modal-ctrl-left hidden-xs"
           onclick="wdShopOnQuickViewBtnLeftClick(event, this); return false;">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="btn btn-link btn-lg wd-modal-ctrl wd-modal-ctrl-right hidden-xs"
           onclick="wdShopOnQuickViewBtnRightClick(event, this); return false;">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
        <!-- product -->
        <div class="row">
          <!-- image -->
          <?php
          if ($theme->products_quick_view_show_image == 1) {
            ?>
          <div class="<?php echo $product_image_col_class; ?>">
            <div class="row">
              <div class="col-sm-12">
                <div class="wd_shop_product_image_label_container">
                  <div class="wd_shop_product_image_container wd_shop_product_quick_view_image_container wd_center_wrapper">
                    <div>
                      <img class="wd_shop_product_image wd_shop_product_quick_view_image" src="" />
                      <div class="wd_shop_product_no_image wd_shop_product_quick_view_no_image">
                        <span class="glyphicon glyphicon-picture"></span>
                        <br />
                        <span><?php _e('No Image', 'wde'); ?></span>
                      </div>
                    </div>
                  </div>
                  <!-- label -->
                  <?php
                  if ($theme->products_quick_view_show_label == 1) {
                    ?>
                  <img class="wd_shop_product_image_label wd_shop_product_quick_view_image_label" src="" alt="" />
                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
            <?php
          }
          ?>
          <div class="<?php echo $product_info_col_class; ?>">
            <div class="row">
              <?php
              // name visibility
              if ($theme->products_quick_view_show_name == 1) {
                $show_name = true;
                $rating_col_class = 'col-sm-4';
              }
              else {
                $show_name = false;
                $rating_col_class = 'col-sm-12';
              }
              // rating visibility
              if (($options->feedback_enable_product_rating == 1) && ($theme->products_quick_view_show_rating == 1)) {
                $show_rating = true;
                $name_col_class = 'col-sm-8';
              }
              else {
                $show_rating = false;
                $name_col_class = 'col-sm-12';
              }
              ?>
              <!-- name -->
              <?php
              if ($show_name == true) {
                ?>
              <div class="<?php echo $name_col_class; ?>">
                <a class="wd_shop_product_name wd_shop_product_quick_view_name btn btn-link"></a>
              </div>
              <?php
              }
              ?>
              <!-- rating -->
              <?php
              if ($show_rating) {
                ?>
              <div class="<?php echo $rating_col_class; ?> text-right">
                <?php
                echo WDFHTML::jf_bs_rater('', 'wd_shop_product_star_rater wd_shop_product_quick_view_star_rater pull-right', '', 0, false, '', '', false, 5, ($theme->rating_star_font_size ? $theme->rating_star_font_size : '24px'), $theme->rating_star_type, $theme->rating_star_color, $theme->rating_star_bg_color);
                ?>
              </div>
                <?php
              }
              ?>
            </div>
            <div class="row">
              <div class="col-sm-6 hidden-xs">
                <!-- category -->
                <?php
                if ($theme->products_quick_view_show_category == 1) {
                    ?>
                    <div>
                        <a href="#" class="wd_shop_product_quick_view_btn_category btn btn-link">
                            <small
                                class="wd_shop_product_category_name wd_shop_product_quick_view_category_name"></small>
                        </a>
                    </div>
                <?php
                }
                ?>
                <!-- model -->
                <?php
                if ($theme->products_quick_view_show_model == 1) {
                    ?>
                    <div>
                            <small class="
                            wd_shop_product_model_name
                            wd_shop_product_quick_view_model_name btn btn-link">
                            </small>
                    </div>
                <?php
                }
                ?>			

                <!-- manufacturer -->
                <?php
                if ($theme->products_quick_view_show_manufacturer == 1) {
                    ?>
                    <div>
                        <a class="wd_shop_product_quick_view_btn_manufacturer btn btn-link">
                            <small class="
                            wd_shop_product_manufacturer_name
                            wd_shop_product_quick_view_manufacturer_name">
                            </small>
                            <img class="wd_shop_product_manufacturer_logo
                            wd_shop_product_quick_view_manufacturer_logo"
                                 src="" alt="">
                        </a>
                    </div>
                  <?php
                }
                ?>
              </div>
              <!-- price -->
              <div class="wd_shop_product_prices_container wd_shop_product_quick_view_prices_container col-sm-6 col-xs-12 text-right">
                <?php
                if ($theme->products_quick_view_show_price == 1) {
                  ?>
                  <span class="wd_shop_product_price wd_shop_product_quick_view_price"></span>
                  <br />
                  <?php
                }
                if ($theme->products_quick_view_show_market_price == 1) {
                  ?>
                  <span class="wd_shop_product_market_price wd_shop_product_quick_view_market_price"></span>				
                  <?php
                }
                ?>
              </div>
            </div>
            <!-- product codes -->
            <div class="col-sm-6">
              <?php
              if ($options->enable_sku == 1) {
                ?>			
              <div class="wd_shop_product_codes_names wd_shop_product_quick_view_sku"></div>
                <?php
              }
              if ($options->enable_upc == 1) {
                ?>
                <div class="wd_shop_product_codes_names wd_shop_product_quick_view_upc"></div>
                <?php
              }
              if ($options->enable_ean == 1) {
                ?>
                <div class="wd_shop_product_codes_names wd_shop_product_quick_view_ean"></div>
              <?php
              }
              if ($options->enable_jan == 1) {
                ?>
                <div class="wd_shop_product_codes_names wd_shop_product_quick_view_jan"></div>
              <?php
              }		
              if ($options->enable_mpn == 1) {
                ?>
                <div class="wd_shop_product_codes_names wd_shop_product_quick_view_mpn"></div>
              <?php
              }
              if ($options->enable_isbn == 1) {
                ?>
                <div class="wd_shop_product_codes_names wd_shop_product_quick_view_isbn"></div>
                <?php
              }
              ?>		
            </div>	
            <!-- description -->
            <?php
            if ($theme->products_quick_view_show_description == 1) {
            ?>
            <div class="row">
              <div class="col-sm-12">
                <p class="wd_shop_product_description wd_shop_product_quick_view_description text-justify"></p>
              </div>
            </div>
              <?php
            }
            ?>
            <div class="wd_shop_product_quick_view_buttons_container row">
              <div class="col-sm-12">
                <!-- buttons on left -->
                <div class="btn-group btn-group-sm hidden-xs">
                  <!-- compare button -->
                  <?php
                  if ($theme->products_quick_view_show_button_compare == 1) {
                    ?>
                  <a href=""
                     class="wd_shop_product_quick_view_btn_compare btn btn-default btn-sm">
                    <?php _e('Compare', 'wde'); ?>
                  </a>
                    <?php
                  }
                  ?>
                </div>
                <!-- buttons on right -->
                <div class="btn-group btn-group-sm pull-right">
                  <!-- button buy now -->
                  <?php
                  if (($options->checkout_enable_checkout == 1) && ($theme->products_quick_view_show_button_buy_now == 1)) {
                    ?>
                  <a href="<?php echo get_permalink($options->option_checkout_page); ?>"
                     class="wd_shop_product_quick_view_btn_buy_now btn btn-default"
                     onclick="wdShopQuickView_onBtnBuyNowClick(event, this); return false;">
                    <?php _e('Buy now', 'wde'); ?>
                  </a>
                    <?php
                  }
                  ?>
                  <!-- button add to cart -->
                  <?php				
                  if ($theme->products_quick_view_show_button_add_to_cart == 1) {
                    ?>
                    <a class="wd_shop_product_quick_view_btn_add_to_cart btn btn-primary"
                       data-toggle="tooltip"
                       data-html="true"
                       data-delay='{"show":"0", "hide":"2000"}'
                       title="<?php echo ($product_row->added_to_cart == 1 && $options->checkout_redirect_to_cart_after_adding_an_item == 2) ? __('Product already added to cart', 'wde') : ''; ?>" 
                       <?php echo ($product_row->added_to_cart == 1 && $options->checkout_redirect_to_cart_after_adding_an_item == 2) ? 'disabled="disabled"' : ''; ?> 
                       onclick="wdShopQuickView_onBtnAddToCartClick(event, this); return false;">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                      <?php _e('Add to cart', 'wde'); ?>
                    </a>
                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- loading clip -->
        <div class="wd-modal-loading-clip"></div>
      </div>
      <!-- modal footer -->
      <div class="modal-footer">
        <!-- view item button -->
        <div class="btn-group">
          <a class="wd_shop_product_quick_view_btn_view_item btn btn-success">
            <?php _e('View item', 'wde'); ?>
          </a>
        </div>
      </div>
      </div>
    </div>
  </div>
<input type="hidden" id="product_parameters_json" name="product_parameters_json" value="" />
<script>
  var wdShop_urlGetQuickViewProductRow = "<?php echo add_query_arg(array('action' => 'WDEQuickView', 'type' => 'products', 'task' => 'ajax_getquickviewproductrow'), admin_url('admin-ajax.php')); ?>";
	var wdShop_minicart = "";
	var _url_root = "";
	var option_redirect_to_cart_after_adding_an_item = "<?php echo $options->checkout_redirect_to_cart_after_adding_an_item;?>";	
</script>