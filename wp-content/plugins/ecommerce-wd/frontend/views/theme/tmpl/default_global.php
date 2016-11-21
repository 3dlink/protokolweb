<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$rounded_corners = $theme->rounded_corners;
$content_main_color = $theme->content_main_color;
$main_font_size = $theme->main_font_size ? 'font-size: ' . $theme->main_font_size . ';' : '';
$main_font_family = $theme->main_font_family ? $theme->main_font_family : 'inherit';
$main_font_weight = $theme->main_font_weight ? $theme->main_font_weight : 'inherit';
?>
<style>
  /* ROUNDED CORNERS */
  <?php
  if ($rounded_corners == 0) {
    ?>
  <?php echo $prefix; ?>
  * {
    -moz-border-radius: 0 !important;
    -webkit-border-radius: 0 !important;
    -khtml-border-radius: 0 !important;
    border-radius: 0 !important;
  }
    <?php
  }
  ?>
  /* CONTENT MAIN COLOR */
  <?php echo $prefix; ?>,
  <?php echo $prefix; ?> h1,
  <?php echo $prefix; ?> h2,
  <?php echo $prefix; ?> h3,
  <?php echo $prefix; ?> h4,
  <?php echo $prefix; ?> h5,
  <?php echo $prefix; ?> h6 {
    <?php echo $main_font_size; ?>
    font-family: <?php echo $main_font_family; ?>;
    font-weight: <?php echo $main_font_weight; ?>;
    color: <?php echo $content_main_color; ?>;
  }
</style>