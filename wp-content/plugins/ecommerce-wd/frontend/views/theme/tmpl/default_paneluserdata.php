<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$panel_user_data_bg_color = $theme->panel_user_data_bg_color;
$panel_user_data_border_color = $theme->panel_user_data_border_color;
$panel_user_data_footer_bg_color = $theme->panel_user_data_footer_bg_color;
?>
<style>
  /* PANEL USER DATA */
  <?php echo $prefix; ?>
  .panel.wd_shop_panel_user_data {
    background-color: <?php echo $panel_user_data_bg_color; ?>;
    border-color: <?php echo $panel_user_data_border_color; ?>;
  }

  <?php echo $prefix; ?>
  .wd_shop_panel_user_data .panel-footer {
    background-color: <?php echo $panel_user_data_footer_bg_color; ?>;
    border-top-color: <?php echo $panel_user_data_border_color; ?>;
  }
</style>