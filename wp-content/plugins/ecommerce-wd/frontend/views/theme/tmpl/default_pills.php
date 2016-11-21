<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$pill_link_content_color = $theme->pill_link_content_color;
$pill_link_font_size = $theme->pill_link_font_size ? 'font-size: ' . $theme->pill_link_font_size . ';' : '';
$pill_link_font_family = $theme->pill_link_font_family ? $theme->pill_link_font_family : 'inherit';
$pill_link_font_weight = $theme->pill_link_font_weight ? $theme->pill_link_font_weight : 'inherit';

$pill_link_hover_content_color = $theme->pill_link_hover_content_color;
$pill_link_hover_bg_color = $theme->pill_link_hover_bg_color;
?>
<style>
  /* PILLS */
  <?php echo $prefix; ?> .nav-pills > li > a {
    color: <?php echo $pill_link_content_color; ?>;
    <?php echo $pill_link_font_size; ?>
    font-family: <?php echo $pill_link_font_family; ?>;
    font-weight: <?php echo $pill_link_font_weight; ?>;
  }
  <?php echo $prefix; ?> .nav-pills > li > a:hover,
  <?php echo $prefix; ?> .nav-pills > li > a:focus {
    color: <?php echo $pill_link_hover_content_color; ?>;
    background-color: <?php echo $pill_link_hover_bg_color; ?>;
  }
</style>