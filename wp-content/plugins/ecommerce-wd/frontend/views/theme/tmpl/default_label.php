<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$label_content_color = $theme->label_content_color;
$label_font_size = $theme->label_font_size ? 'font-size: ' . $theme->label_font_size . ';' : '';
$label_font_family = $theme->label_font_family ? $theme->label_font_family : 'inherit';
$label_font_weight = $theme->label_font_weight ? $theme->label_font_weight : 'inherit';

$label_bg_color = $theme->label_bg_color;
$label_bg_hover_color = WDFColorUtils::adjust_brightness($label_bg_color, -10);
?>
<style>
  /* LABEL */
  <?php echo $prefix; ?>
  .label-default {
    <?php echo $label_font_size; ?>
    font-family: <?php echo $label_font_family; ?>;
    font-weight: <?php echo $label_font_weight; ?>;
    color: <?php echo $label_content_color; ?>;
    background-color: <?php echo $label_bg_color; ?>;
  }
  <?php echo $prefix; ?>
  .label-default[href]:hover,
  <?php echo $prefix; ?> .label-default[href]:focus {
    background-color: <?php echo $label_bg_hover_color; ?>;
  }
</style>