<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$alert_info_content_color = $theme->alert_info_content_color;
$alert_font_size = $theme->alert_font_size ? 'font-size: ' . $theme->alert_font_size . ';' : '';
$alert_font_family = $theme->alert_font_family ? $theme->alert_font_family : 'inherit';
$alert_font_weight = $theme->alert_font_weight ? $theme->alert_font_weight : 'inherit';

$alert_info_bg_color = $theme->alert_info_bg_color;
$alert_info_border_color = $theme->alert_info_border_color;
$alert_info_link_color = WDFColorUtils::adjust_brightness($theme->alert_info_border_color, -15);

$alert_danger_content_color = $theme->alert_danger_content_color;
$alert_danger_bg_color = $theme->alert_danger_bg_color;
$alert_danger_border_color = $theme->alert_danger_border_color;
$alert_danger_link_color = WDFColorUtils::adjust_brightness($theme->alert_danger_border_color, -15);
?>
<style>
  /* ALERT */
  /* info */
  <?php echo $prefix; ?>
  .alert-info {
    <?php echo $alert_font_size; ?>
    font-family: <?php echo $alert_font_family; ?>;
    font-weight: <?php echo $alert_font_weight; ?>;
    color: <?php echo $alert_info_content_color; ?>;
    background-color: <?php echo $alert_info_bg_color; ?>;
    border-color: <?php echo $alert_info_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .alert-info * {
    <?php echo $alert_font_size; ?>
    font-family: <?php echo $alert_font_family; ?>;
    font-weight: <?php echo $alert_font_weight; ?>;
    color: <?php echo $alert_info_content_color; ?>;
    border-color: <?php echo $alert_info_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .alert-info .alert-link {
    color: <?php echo $alert_info_link_color; ?>;
  }
  /* danger */
  <?php echo $prefix; ?>
  .alert-danger {
    <?php echo $alert_font_size; ?>
    font-family: <?php echo $alert_font_family; ?>;
    font-weight: <?php echo $alert_font_weight; ?>;
    color: <?php echo $alert_danger_content_color; ?>;
    background-color: <?php echo $alert_danger_bg_color; ?>;
    border-color: <?php echo $alert_danger_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .alert-danger * {
    <?php echo $alert_font_size; ?>
    font-family: <?php echo $alert_font_family; ?>;
    font-weight: <?php echo $alert_font_weight; ?>;
    color: <?php echo $alert_danger_content_color; ?>;
    border-color: <?php echo $alert_danger_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .alert-danger .alert-link {
    color: <?php echo $alert_danger_link_color; ?>;
  }
</style>