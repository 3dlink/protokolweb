<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$panel_product_bg_color = $theme->panel_product_bg_color;
$panel_product_border_color = $theme->panel_product_border_color;
$panel_product_footer_bg_color = $theme->panel_product_footer_bg_color;

$items_slider_hover_border_color_rgba = WDFColorUtils::color_to_rgba($panel_product_border_color);
$items_slider_hover_border_color_rgba['a'] = 0.45;
$items_slider_hover_border_color_rgba = WDFColorUtils::color_to_rgba($items_slider_hover_border_color_rgba, true);
$items_slider_active_border_color_rgba = WDFColorUtils::color_to_rgba($panel_product_border_color);
$items_slider_active_border_color_rgba['a'] = 0.85;
$items_slider_active_border_color_rgba = WDFColorUtils::color_to_rgba($items_slider_active_border_color_rgba, true);

//ob_start(); ?>
  <style>
    <?php //ob_clean();?>

    /* PANEL PRODUCT */
    <?php echo $prefix; ?>
    .panel.wd_shop_panel_product {
      background-color: <?php echo $panel_product_bg_color; ?>;
      border-color: <?php echo $panel_product_border_color; ?>;
    }

    <?php echo $prefix; ?>
    .wd_shop_panel_product .panel-footer {
      background-color: <?php echo $panel_product_footer_bg_color; ?>;
      border-top-color: <?php echo $panel_product_border_color; ?>;
    }

    /* IMG THUMB */
    <?php echo $prefix; ?>
    .wd_shop_product_image_container,
    <?php echo $prefix; ?> .wd_shop_category_image_container,
    <?php echo $prefix; ?> .wd_shop_manufacturer_logo_container {
      border-color: <?php echo $panel_product_border_color; ?>;
    }

    /* PRODUCT AND PRODUCT IMAGES SLIDER */
    <?php echo $prefix; ?>
    .wd_shop_product_images_slider ul.wd_items_slider_items_list li,
    <?php echo $prefix; ?> .wd_shop_products_slider ul.wd_items_slider_items_list li {
      border-color: transparent;
    }

    <?php echo $prefix; ?>
    .wd_shop_product_images_slider ul.wd_items_slider_items_list li:hover,
    <?php echo $prefix; ?> .wd_shop_products_slider ul.wd_items_slider_items_list li:hover {
      border-color: <?php echo $items_slider_hover_border_color_rgba; ?>;
    }

    <?php echo $prefix; ?>
    .wd_shop_product_images_slider ul.wd_items_slider_items_list li.active,
    <?php echo $prefix; ?> .wd_shop_products_slider ul.wd_items_slider_items_list li li.active,
    <?php echo $prefix; ?> .wd_shop_product_images_slider ul.wd_items_slider_items_list li.active:hover,
    <?php echo $prefix; ?> .wd_shop_products_slider ul.wd_items_slider_items_list li li.active:hover {
      border-color: <?php echo $items_slider_active_border_color_rgba; ?>;
    }

    /* PRODUCT DATA TABLE */
    <?php echo $prefix; ?>
    .wd_shop_table_product_data,
    <?php echo $prefix; ?> .wd_shop_table_product_data tbody,
    <?php echo $prefix; ?> .wd_shop_table_product_data tbody tr,
    <?php echo $prefix; ?> .wd_shop_table_product_data tbody tr td {
      border-color: <?php echo $panel_product_border_color; ?>;
      border-width: 1px;
      border-style: solid;
    }

    <?php //ob_start(); ?>
  </style>
<?php //ob_clean();