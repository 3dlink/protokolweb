<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;
$breadcrumb_content_color = $theme->breadcrumb_content_color;
$breadcrumb_font_size = $theme->breadcrumb_font_size ? 'font-size: ' . $theme->breadcrumb_font_size . ';' : '';
$breadcrumb_font_family = $theme->breadcrumb_font_family ? $theme->breadcrumb_font_family : 'inherit';
$breadcrumb_font_weight = $theme->breadcrumb_font_weight ? $theme->breadcrumb_font_weight : 'inherit';

$breadcrumb_bg_color = $theme->breadcrumb_bg_color;
$breadcrumb_active_content_color = WDFColorUtils::adjust_brightness($breadcrumb_bg_color, 8);
?>
<style>
  /* BREADCRUMB */
  <?php echo $prefix; ?>
  .breadcrumb {
    background-color: <?php echo $breadcrumb_bg_color; ?>;
  }
  <?php echo $prefix; ?> .breadcrumb > li + li:before,
  <?php echo $prefix; ?> .breadcrumb > li,
  <?php echo $prefix; ?> .breadcrumb > li a {
    color: <?php echo $breadcrumb_content_color; ?>;
    <?php echo $breadcrumb_font_size; ?>
    font-family: <?php echo $breadcrumb_font_family; ?>;
    font-weight: <?php echo $breadcrumb_font_weight; ?>;
  }
</style>