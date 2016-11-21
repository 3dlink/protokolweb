<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$product_name_color = $theme->product_name_color;
$product_name_font_size = $theme->product_name_font_size ? 'font-size: ' . $theme->product_name_font_size . ';' : '';
$product_name_font_family = $theme->product_name_font_family ? $theme->product_name_font_family : 'inherit';
$product_name_font_weight = $theme->product_name_font_weight ? $theme->product_name_font_weight : 'inherit';

$product_category_color = $theme->product_category_color;
$product_manufacturer_color = $theme->product_manufacturer_color;
$product_model_color = $theme->product_model_color;
$product_procreator_font_size = $theme->product_procreator_font_size ? 'font-size: ' . $theme->product_procreator_font_size . ';' : '';
$product_procreator_font_family = $theme->product_procreator_font_family ? $theme->product_procreator_font_family : 'inherit';
$product_procreator_font_weight = $theme->product_procreator_font_weight ? $theme->product_procreator_font_weight : 'inherit';

$product_price_color = $theme->product_price_color;
$product_price_font_size = $theme->product_price_font_size ? 'font-size: ' . $theme->product_price_font_size . ';' : '';
$product_price_font_family = $theme->product_price_font_family ? $theme->product_price_font_family : 'inherit';
$product_price_font_weight = $theme->product_price_font_weight ? $theme->product_price_font_weight : 'inherit';

$product_market_price_color = $theme->product_market_price_color;
$product_market_price_font_size = $theme->product_market_price_font_size ? 'font-size: ' . $theme->product_market_price_font_size . ';' : '';
$product_market_price_font_family = $theme->product_market_price_font_family ? $theme->product_market_price_font_family : 'inherit';
$product_market_price_font_weight = $theme->product_market_price_font_weight ? $theme->product_market_price_font_weight : 'inherit';

$product_codes_color = $theme->product_code_color;
$product_code_font_size = $theme->product_code_font_size ? 'font-size: ' . $theme->product_code_font_size . ';' : '';
$product_code_font_family = $theme->product_code_font_family ? $theme->product_code_font_family : 'inherit';
$product_code_font_weight = $theme->product_code_font_weight ? $theme->product_code_font_weight : 'inherit';

$product_description_color = $theme->product_description_color;
$product_description_font_size = $theme->product_description_font_size ? 'font-size: ' . $theme->product_description_font_size . ';' : '';
$product_description_font_family = $theme->product_description_font_family ? $theme->product_description_font_family : 'inherit';
$product_description_font_weight = $theme->product_description_font_weight ? $theme->product_description_font_weight : 'inherit';
?>
<style>
  /* PRODUCT */
  <?php echo $prefix; ?> .wd_shop_product_name,
  <?php echo $prefix; ?> .wd_shop_product_name:hover,
  <?php echo $prefix; ?> .wd_shop_product_name:focus,
  <?php echo $prefix; ?> .wd_shop_product_name.disabled,
  <?php echo $prefix; ?> .wd_shop_product_name[disabled],
  <?php echo $prefix; ?> .wd_shop_product_name.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_name[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_name.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_name[disabled]:focus {
    color: <?php echo $product_name_color; ?>;
    <?php echo $product_name_font_size; ?>
    font-family: <?php echo $product_name_font_family; ?>;
    font-weight: <?php echo $product_name_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_category,
  <?php echo $prefix; ?> .wd_shop_product_category:hover,
  <?php echo $prefix; ?> .wd_shop_product_category:focus,
  <?php echo $prefix; ?> .wd_shop_product_category.disabled,
  <?php echo $prefix; ?> .wd_shop_product_category[disabled],
  <?php echo $prefix; ?> .wd_shop_product_category.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_category[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_category.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_category[disabled]:focus,
  <?php echo $prefix; ?> .wd_shop_product_category_name,
  <?php echo $prefix; ?> .wd_shop_product_category_name:hover,
  <?php echo $prefix; ?> .wd_shop_product_category_name:focus,
  <?php echo $prefix; ?> .wd_shop_product_category_name.disabled,
  <?php echo $prefix; ?> .wd_shop_product_category_name[disabled],
  <?php echo $prefix; ?> .wd_shop_product_category_name.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_category_name[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_category_name.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_category_name[disabled]:focus {
    color: <?php echo $product_category_color; ?>;
    <?php echo $product_procreator_font_size; ?>
    font-family: <?php echo $product_procreator_font_family; ?>;
    font-weight: <?php echo $product_procreator_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_manufacturer,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer:hover,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer:focus,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer.disabled,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer[disabled],
  <?php echo $prefix; ?> .wd_shop_product_manufacturer.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer[disabled]:focus,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer_name,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer_name:hover,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer_name:focus,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer_name.disabled,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer_name[disabled],
  <?php echo $prefix; ?> .wd_shop_product_manufacturer_name.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer_name[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer_name.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_manufacturer_name[disabled]:focus {
    color: <?php echo $product_manufacturer_color; ?>;
    <?php echo $product_procreator_font_size; ?>
    font-family: <?php echo $product_procreator_font_family; ?>;
    font-weight: <?php echo $product_procreator_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_price,
  <?php echo $prefix; ?> .wd_shop_product_price:hover,
  <?php echo $prefix; ?> .wd_shop_product_price:focus,
  <?php echo $prefix; ?> .wd_shop_product_price.disabled,
  <?php echo $prefix; ?> .wd_shop_product_price[disabled],
  <?php echo $prefix; ?> .wd_shop_product_price.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_price[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_price.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_price[disabled]:focus {
    color: <?php echo $product_price_color; ?>;
    <?php echo $product_price_font_size; ?>
    font-family: <?php echo $product_price_font_family; ?>;
    font-weight: <?php echo $product_price_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_price_small,
  <?php echo $prefix; ?> .wd_shop_product_price_small:hover,
  <?php echo $prefix; ?> .wd_shop_product_price_small:focus,
  <?php echo $prefix; ?> .wd_shop_product_price_small.disabled,
  <?php echo $prefix; ?> .wd_shop_product_price_small[disabled],
  <?php echo $prefix; ?> .wd_shop_product_price_small.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_price_small[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_price_small.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_price_small[disabled]:focus {
    color: <?php echo $product_price_color; ?>;
    font-family: <?php echo $product_price_font_family; ?>;
    font-weight: <?php echo $product_price_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_market_price,
  <?php echo $prefix; ?> .wd_shop_product_market_price:hover,
  <?php echo $prefix; ?> .wd_shop_product_market_price:focus,
  <?php echo $prefix; ?> .wd_shop_product_market_price.disabled,
  <?php echo $prefix; ?> .wd_shop_product_market_price[disabled],
  <?php echo $prefix; ?> .wd_shop_product_market_price.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_market_price[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_market_price.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_market_price[disabled]:focus {
    color: <?php echo $product_market_price_color; ?>;
    <?php echo $product_market_price_font_size; ?>
    font-family: <?php echo $product_market_price_font_family; ?>;
    font-weight: <?php echo $product_market_price_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_model,
  <?php echo $prefix; ?> .wd_shop_product_model:hover,
  <?php echo $prefix; ?> .wd_shop_product_model:focus,
  <?php echo $prefix; ?> .wd_shop_product_model.disabled,
  <?php echo $prefix; ?> .wd_shop_product_model[disabled],
  <?php echo $prefix; ?> .wd_shop_product_model.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_model[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_model.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_model[disabled]:focus,
  <?php echo $prefix; ?> .wd_shop_product_model_name,
  <?php echo $prefix; ?> .wd_shop_product_model_name:hover,
  <?php echo $prefix; ?> .wd_shop_product_model_name:focus,
  <?php echo $prefix; ?> .wd_shop_product_model_name.disabled,
  <?php echo $prefix; ?> .wd_shop_product_model_name[disabled],
  <?php echo $prefix; ?> .wd_shop_product_model_name.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_model_name[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_model_name.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_model_name[disabled]:focus {
    color: <?php echo $product_model_color; ?>;
    <?php echo $product_procreator_font_size; ?>
    font-family: <?php echo $product_procreator_font_family; ?>;
    font-weight: <?php echo $product_procreator_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_codes,
  <?php echo $prefix; ?> .wd_shop_product_codes:hover,
  <?php echo $prefix; ?> .wd_shop_product_codes:focus,
  <?php echo $prefix; ?> .wd_shop_product_codes.disabled,
  <?php echo $prefix; ?> .wd_shop_product_codes[disabled],
  <?php echo $prefix; ?> .wd_shop_product_codes.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_codes[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_codes.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_codes[disabled]:focus,
  <?php echo $prefix; ?> .wd_shop_product_codes_name,
  <?php echo $prefix; ?> .wd_shop_product_codes_name:hover,
  <?php echo $prefix; ?> .wd_shop_product_codes_name:focus,
  <?php echo $prefix; ?> .wd_shop_product_codes_name.disabled,
  <?php echo $prefix; ?> .wd_shop_product_codes_name[disabled],
  <?php echo $prefix; ?> .wd_shop_product_codes_name.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_codes_name[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_codes_name.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_codes_name[disabled]:focus {
    color: <?php echo $product_codes_color; ?>;
    <?php echo $product_code_font_size; ?>
    font-family: <?php echo $product_code_font_family; ?>;
    font-weight: <?php echo $product_code_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_product_description,
  <?php echo $prefix; ?> .wd_shop_product_description:hover,
  <?php echo $prefix; ?> .wd_shop_product_description:focus,
  <?php echo $prefix; ?> .wd_shop_product_description.disabled,
  <?php echo $prefix; ?> .wd_shop_product_description[disabled],
  <?php echo $prefix; ?> .wd_shop_product_description.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_product_description[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_product_description.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_product_description[disabled]:focus {
    color: <?php echo $product_description_color; ?>;
    <?php echo $product_description_font_size; ?>
    font-family: <?php echo $product_description_font_family; ?>;
    font-weight: <?php echo $product_description_font_weight; ?>;
  }
  /* CATEGORY */
  <?php echo $prefix; ?> .wd_shop_category_name,
  <?php echo $prefix; ?> .wd_shop_category_name:hover,
  <?php echo $prefix; ?> .wd_shop_category_name:focus,
  <?php echo $prefix; ?> .wd_shop_category_name.disabled,
  <?php echo $prefix; ?> .wd_shop_category_name[disabled],
  <?php echo $prefix; ?> .wd_shop_category_name.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_category_name[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_category_name.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_category_name[disabled]:focus {
    color: <?php echo $product_name_color; ?>;
    <?php echo $product_name_font_size; ?>
    font-family: <?php echo $product_name_font_family; ?>;
    font-weight: <?php echo $product_name_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_category_description,
  <?php echo $prefix; ?> .wd_shop_category_description:hover,
  <?php echo $prefix; ?> .wd_shop_category_description:focus,
  <?php echo $prefix; ?> .wd_shop_category_description.disabled,
  <?php echo $prefix; ?> .wd_shop_category_description[disabled],
  <?php echo $prefix; ?> .wd_shop_category_description.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_category_description[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_category_description.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_category_description[disabled]:focus {
    color: <?php echo $product_description_color; ?>;
    <?php echo $product_description_font_size; ?>
    font-family: <?php echo $product_description_font_family; ?>;
    font-weight: <?php echo $product_description_font_weight; ?>;
  }
  /* MANUFACTURER */
  <?php echo $prefix; ?> .wd_shop_manufacturer_name,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name:focus,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name.disabled,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name[disabled],
  <?php echo $prefix; ?> .wd_shop_manufacturer_name.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_manufacturer_name[disabled]:focus {
    color: <?php echo $product_name_color; ?>;
    <?php echo $product_name_font_size; ?>
    font-family: <?php echo $product_name_font_family; ?>;
    font-weight: <?php echo $product_name_font_weight; ?>;
  }
  <?php echo $prefix; ?> .wd_shop_manufacturer_description,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description:focus,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description.disabled,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description[disabled],
  <?php echo $prefix; ?> .wd_shop_manufacturer_description.disabled:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description[disabled]:hover,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description.disabled:focus,
  <?php echo $prefix; ?> .wd_shop_manufacturer_description[disabled]:focus {
    color: <?php echo $product_description_color; ?>;
    <?php echo $product_description_font_size; ?>
    font-family: <?php echo $product_description_font_family; ?>;
    font-weight: <?php echo $product_description_font_weight; ?>;
  }
</style>