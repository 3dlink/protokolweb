<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$pager_content_color = $theme->pager_content_color;
$pager_font_size = $theme->pager_font_size ? 'font-size: ' . $theme->pager_font_size . ';' : '';
$pager_font_family = $theme->pager_font_family ? $theme->pager_font_family : 'inherit';
$pager_font_weight = $theme->pager_font_weight ? $theme->pager_font_weight : 'inherit';

$pager_bg_color = $theme->pager_bg_color;
$pager_border_color = $theme->pager_border_color;
$pager_hover_content_color = WDFColorUtils::adjust_brightness($pager_content_color, -15);
$pager_hover_bg_color = WDFColorUtils::adjust_brightness($pager_bg_color, -8);
?>
<style>
  /* PAGER */
  <?php echo $prefix; ?>
  .pager li > a,
  <?php echo $prefix; ?> .pager li > span {
    <?php echo $pager_font_size; ?>
    font-family: <?php echo $pager_font_family; ?>;
    font-weight: <?php echo $pager_font_weight; ?>;
    color: <?php echo $pager_content_color; ?>;
    background-color: <?php echo $pager_bg_color; ?>;
    border-color: <?php echo $pager_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .pager li > a:hover,
  <?php echo $prefix; ?> .pager li > a:focus {
    color: <?php echo $pager_hover_content_color; ?>;
    background-color: <?php echo $pager_hover_bg_color; ?>;
  }
  <?php echo $prefix; ?>
  .pager .disabled > a,
  <?php echo $prefix; ?> .pager .disabled > a:hover,
  <?php echo $prefix; ?> .pager .disabled > a:focus,
  <?php echo $prefix; ?> .pager .disabled > span {
    background-color: <?php echo $pager_bg_color; ?>;
  }
</style>