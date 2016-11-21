<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_items_slider');
wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;

$row = $this->row;

$products = $row->products;
?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php'; ?>
    </div>
  </div>
  <h1 class="wd_shop_manufacturer_name wd_shop_header">
    <?php echo $row->name; ?>
  </h1>
  <?php
  if ($row->show_info == 1) {
    ?>
    <div class="row">
      <div class="col-sm-5">
        <div class="wd_shop_manufacturer_logo_container wd_center_wrapper img-thumbnail">
          <div>
            <?php
            if ($row->logo != '') {
                ?>
              <img class="wd_shop_manufacturer_logo" src="<?php echo $row->logo; ?>" alt="<?php echo $row->name; ?>" title="<?php echo $row->name; ?>" />
              <?php
            }
            else {
              ?>
              <div class="wd_shop_manufacturer_no_image">
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
      <div class="col-sm-7">
        <p class="text-right">
          <?php
          if ($row->site != '') {
              ?>
              <a href="<?php echo $row->site; ?>" class="wd_shop_manufacturer_link btn btn-link" target="_blank">
                <?php _e('Visit site', 'wde'); ?>
              </a>
          <?php
          }
          ?>
        </p>
        <p class="wd_shop_manufacturer_description text-justify">
          <?php echo $row->description; ?>
        </p>
      </div>
    </div>
    <?php
  }
  if (($row->show_info == 1) && ($row->show_products == 1)) {
    ?>
    <div class="wd_divider"></div>
    <?php
  }
  if ($row->show_products == 1) {
    ?>
    <div class="row">
      <div class="col-sm-12">
        <h4 class="wd_shop_header_sm">
          <?php _e('Products', 'wde'); ?>
        </h4>
        <div class="wd_shop_products_slider">
          <a class="wd_items_slider_btn_prev btn btn-link pull-left">
            <span class="glyphicon glyphicon-chevron-left"></span>
          </a>
          <a class="wd_items_slider_btn_next btn btn-link pull-right">
            <span class="glyphicon glyphicon-chevron-right"></span>
          </a>
          <div class="wd_items_slider_mask">
            <ul class="wd_items_slider_items_list">
              <?php
              if (is_array($products)) {
                foreach ($products as $i => $product) {
                  ?>
                  <li>
                    <a class="wd_shop_product_container btn btn-link"
                       href="<?php echo $product->url; ?>"
                       title="<?php echo $product->name; ?>">
                      <div class="wd_shop_product_image_container wd_center_wrapper">
                        <div>
                          <?php
                          if ($product->image != '') {
                            ?>
                            <img src="<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>" title="<?php echo $product->name; ?>" />
                            <?php
                          }
                          else {
                            ?>
                            <div class="wd_shop_product_no_image">
                              <span class="glyphicon glyphicon-picture"></span><br />
                              <span><?php _e('No Image', 'wde'); ?></span>
                            </div>
                            <?php
                          }
                          ?>
                        </div>
                      </div>
                      <div class="wd_shop_product_link_name text-center">
                        <?php echo $product->name; ?>
                      </div>
                    </a>
                  </li>
                  <?php
                }
              }
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php
    if ($options->filter_manufacturers == 1) {
      ?>
      <form name="wd_shop_form_all_products"
            action="<?php echo get_permalink($options->option_all_products_page); ?>"
            method="POST">
        <div class="row">
          <div class="col-sm-12 text-center">
            <a class="btn btn-primary" href="#" onclick="wdShop_onAllProductsClick(event, this); return false;" data-manufacturer-id="<?php echo $row->id; ?>">
              <?php _e('View all products', 'wde'); ?>
            </a>
          </div>
        </div>
        <input type="hidden" name="filter_manufacturer_ids" />
        <input type="hidden" name="filter_filters_opened" value="1" />
      </form>
      <?php
    }
  }
  ?>
</div>