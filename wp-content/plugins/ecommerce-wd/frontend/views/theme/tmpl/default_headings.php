<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$header_font_size = $theme->header_font_size ? 'font-size: ' . $theme->header_font_size . ';' : '';
$header_font_family = $theme->header_font_family ? $theme->header_font_family : 'inherit';
$header_font_weight = $theme->header_font_weight ? $theme->header_font_weight : 'inherit';

$header_content_color = $theme->header_content_color;
$header_border_color = WDFColorUtils::color_to_rgba($theme->header_content_color);
$header_border_color['a'] = 0.15;
$header_border_color = WDFColorUtils::color_to_rgba($header_border_color, TRUE);

$subtext_font_size = $theme->subtext_font_size ? 'font-size: ' . $theme->subtext_font_size . ';' : '';
$subtext_font_family = $theme->subtext_font_family ? $theme->subtext_font_family : 'inherit';
$subtext_font_weight = $theme->subtext_font_weight ? $theme->subtext_font_weight : 'inherit';
$subtext_content_color = $theme->subtext_content_color;

?>
<style>
  /* HEADER */
  <?php echo $prefix; ?>
  .wd_shop_header {
    <?php echo $header_font_size; ?>
    font-family: <?php echo $header_font_family; ?>;
    font-weight: <?php echo $header_font_weight; ?>;
    color: <?php echo $header_content_color; ?>;
    border-bottom-color: <?php echo $header_border_color; ?>;
  }

  <?php echo $prefix; ?>
  .wd_shop_header_sm {
    font-family: <?php echo $header_font_family; ?>;
    font-weight: <?php echo $header_font_weight; ?>;
    color: <?php echo $header_content_color; ?>;
    border-bottom-color: <?php echo $header_border_color; ?>;
  }

  /* SUBTEXT */
  <?php echo $prefix; ?>
  small {
    <?php echo $subtext_font_size; ?>
    font-family: <?php echo $subtext_font_family; ?>;
    font-weight: <?php echo $subtext_font_weight; ?>;
    color: <?php echo $subtext_content_color; ?>;
  }
</style>