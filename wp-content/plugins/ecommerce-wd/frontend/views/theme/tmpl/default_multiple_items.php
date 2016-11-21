<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$product_name_color = $theme->multiple_product_name_color;
$product_name_font_size = $theme->multiple_product_name_font_size ? 'font-size: ' . $theme->multiple_product_name_font_size . ';' : '';
$product_name_font_family = $theme->multiple_product_name_font_family ? $theme->multiple_product_name_font_family : 'inherit';
$product_name_font_weight = $theme->multiple_product_name_font_weight ? $theme->multiple_product_name_font_weight : 'inherit';

$product_price_color = $theme->multiple_product_price_color;
$product_price_font_size = $theme->multiple_product_price_font_size ? 'font-size: ' . $theme->multiple_product_price_font_size . ';' : '';
$product_price_font_family = $theme->multiple_product_price_font_family ? $theme->multiple_product_price_font_family : 'inherit';
$product_price_font_weight = $theme->multiple_product_price_font_weight ? $theme->multiple_product_price_font_weight : 'inherit';

$product_market_price_color = $theme->multiple_product_market_price_color;
$product_market_price_font_size = $theme->multiple_product_market_price_font_size ? 'font-size: ' . $theme->multiple_product_market_price_font_size . ';' : '';
$product_market_price_font_family = $theme->multiple_product_market_price_font_family ? $theme->multiple_product_market_price_font_family : 'inherit';
$product_market_price_font_weight = $theme->multiple_product_market_price_font_weight ? $theme->multiple_product_market_price_font_weight : 'inherit';

$product_description_color = $theme->multiple_product_description_color;
$product_description_font_size = $theme->multiple_product_description_font_size ? 'font-size: ' . $theme->multiple_product_description_font_size . ';' : '';
$product_description_font_family = $theme->multiple_product_description_font_family ? $theme->multiple_product_description_font_family : 'inherit';
$product_description_font_weight = $theme->multiple_product_description_font_weight ? $theme->multiple_product_description_font_weight : 'inherit';
?>
<style>
  /* PRODUCT */
  <?php echo $prefix; ?> .wd_shop_product_name_all,
  <?php echo $prefix; ?> .wd_shop_product_name_all:hover,
  <?php echo $prefix; ?> .wd_shop_product_name_all:focus,
  <?php echo $prefix; ?> .wd_shop_product_name_all.disabled,
  <?php echo $prefix; ?> .wd_shop_product_name_all[disabled],
  <?php echo $prefix; ?> .wd_shop_product_name_all.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_name_all[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_name_all.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_name_all[disabled]:focus {
    color: <?php echo $product_name_color; ?>;
    <?php echo $product_name_font_size; ?>
    font-family: <?php echo $product_name_font_family; ?>;
    font-weight: <?php echo $product_name_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_price_all,
  <?php echo $prefix; ?> .wd_shop_product_price_all:hover,
  <?php echo $prefix; ?> .wd_shop_product_price_all:focus,
  <?php echo $prefix; ?> .wd_shop_product_price_all.disabled,
  <?php echo $prefix; ?> .wd_shop_product_price_all[disabled],
  <?php echo $prefix; ?> .wd_shop_product_price_all.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_price_all[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_price_all.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_price_all[disabled]:focus {
    color: <?php echo $product_price_color; ?>;
    <?php echo $product_price_font_size; ?>
    font-family: <?php echo $product_price_font_family; ?>;
    font-weight: <?php echo $product_price_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_price_all_small,
  <?php echo $prefix; ?> .wd_shop_product_price_all_small:hover,
  <?php echo $prefix; ?> .wd_shop_product_price_all_small:focus,
  <?php echo $prefix; ?> .wd_shop_product_price_all_small.disabled,
  <?php echo $prefix; ?> .wd_shop_product_price_all_small[disabled],
  <?php echo $prefix; ?> .wd_shop_product_price_all_small.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_price_all_small[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_price_all_small.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_price_all_small[disabled]:focus {
    color: <?php echo $product_price_color; ?>;
    font-family: <?php echo $product_price_font_family; ?>;
    font-weight: <?php echo $product_price_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_market_price_all,
  <?php echo $prefix; ?> .wd_shop_product_market_price_all:hover,
  <?php echo $prefix; ?> .wd_shop_product_market_price_all:focus,
  <?php echo $prefix; ?> .wd_shop_product_market_price_all.disabled,
  <?php echo $prefix; ?> .wd_shop_product_market_price_all[disabled],
  <?php echo $prefix; ?> .wd_shop_product_market_price_all.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_market_price_all[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_market_price_all.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_market_price_all[disabled]:focus {
    color: <?php echo $product_market_price_color; ?>;
    <?php echo $product_market_price_font_size; ?>
    font-family: <?php echo $product_market_price_font_family; ?>;
    font-weight: <?php echo $product_market_price_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_description_all,
  <?php echo $prefix; ?> .wd_shop_product_description_all:hover,
  <?php echo $prefix; ?> .wd_shop_product_description_all:focus,
  <?php echo $prefix; ?> .wd_shop_product_description_all.disabled,
  <?php echo $prefix; ?> .wd_shop_product_description_all[disabled],
  <?php echo $prefix; ?> .wd_shop_product_description_all.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_description_all[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_description_all.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_description_all[disabled]:focus {
    color: <?php echo $product_description_color; ?>;
    <?php echo $product_description_font_size; ?>
    font-family: <?php echo $product_description_font_family; ?>;
    font-weight: <?php echo $product_description_font_weight; ?>;
  }
  /* CATEGORY */
  <?php echo $prefix; ?> .wd_shop_category_name_all,
  <?php echo $prefix; ?> .wd_shop_category_name_all:hover,
  <?php echo $prefix; ?> .wd_shop_category_name_all:focus,
  <?php echo $prefix; ?> .wd_shop_category_name_all.disabled,
  <?php echo $prefix; ?> .wd_shop_category_name_all[disabled],
  <?php echo $prefix; ?> .wd_shop_category_name_all.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_category_name_all[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_category_name_all.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_category_name_all[disabled]:focus {
    color: <?php echo $product_name_color; ?>;
    <?php echo $product_name_font_size; ?>
    font-family: <?php echo $product_name_font_family; ?>;
    font-weight: <?php echo $product_name_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_category_description_all,
  <?php echo $prefix; ?> .wd_shop_category_description_all:hover,
  <?php echo $prefix; ?> .wd_shop_category_description_all:focus,
  <?php echo $prefix; ?> .wd_shop_category_description_all.disabled,
  <?php echo $prefix; ?> .wd_shop_category_description_all[disabled],
  <?php echo $prefix; ?> .wd_shop_category_description_all.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_category_description_all[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_category_description_all.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_category_description_all[disabled]:focus {
    color: <?php echo $product_description_color; ?>;
    <?php echo $product_description_font_size; ?>
    font-family: <?php echo $product_description_font_family; ?>;
    font-weight: <?php echo $product_description_font_weight; ?>;
  }
  /* MANUFACTURER */
  <?php echo $prefix; ?> .wd_shop_manufacturer_name_all,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name_all:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name_all:focus,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name_all.disabled,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name_all[disabled],
  <?php echo $prefix; ?> .wd_shop_manufacturer_name_all.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name_all[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name_all.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name_all[disabled]:focus {
    color: <?php echo $product_name_color; ?>;
    <?php echo $product_name_font_size; ?>
    font-family: <?php echo $product_name_font_family; ?>;
    font-weight: <?php echo $product_name_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_manufacturer_description_all,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description_all:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description_all:focus,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description_all.disabled,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description_all[disabled],
  <?php echo $prefix; ?> .wd_shop_manufacturer_description_all.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description_all[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description_all.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description_all[disabled]:focus {
    color: <?php echo $product_description_color; ?>;
    <?php echo $product_description_font_size; ?>
    font-family: <?php echo $product_description_font_family; ?>;
    font-weight: <?php echo $product_description_font_weight; ?>;
  }
</style>