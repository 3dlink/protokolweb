<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$tab_link_content_color = $theme->tab_link_content_color;
$tab_link_font_size = $theme->tab_link_font_size ? 'font-size: ' . $theme->tab_link_font_size . ';' : '';
$tab_link_font_family = $theme->tab_link_font_family ? $theme->tab_link_font_family : 'inherit';
$tab_link_font_weight = $theme->tab_link_font_weight ? $theme->tab_link_font_weight : 'inherit';

$tab_link_hover_content_color = $theme->tab_link_hover_content_color;
$tab_link_hover_bg_color = $theme->tab_link_hover_bg_color;
$tab_link_active_content_color = $theme->tab_link_active_content_color;
$tab_link_active_bg_color = $theme->tab_link_active_bg_color;
$tab_border_color = $theme->tab_border_color;
?>
<style>
  /* TAB */
  <?php echo $prefix; ?>
  .nav-tabs {
    border-bottom-color: <?php echo $tab_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .nav-tabs > li > a {
    color: <?php echo $tab_link_content_color; ?>;
    <?php echo $tab_link_font_size; ?>
    font-family: <?php echo $tab_link_font_family; ?>;
    font-weight: <?php echo $tab_link_font_weight; ?>;
  }
  <?php echo $prefix; ?>
  .nav-tabs > li > a:hover {
    <?php echo $tab_link_font_size; ?>
    font-family: <?php echo $tab_link_font_family; ?>;
    font-weight: <?php echo $tab_link_font_weight; ?>;
    color: <?php echo $tab_link_hover_content_color; ?>;
    background-color: <?php echo $tab_link_hover_bg_color; ?>;
    border-color: <?php echo $tab_link_hover_bg_color . ' ' . $tab_link_hover_bg_color . ' ' . $tab_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .nav-tabs > li.active > a,
  <?php echo $prefix; ?> .nav-tabs > li.active > a:hover,
  <?php echo $prefix; ?> .nav-tabs > li.active > a:focus {
    <?php echo $tab_link_font_size; ?>
    font-family: <?php echo $tab_link_font_family; ?>;
    font-weight: <?php echo $tab_link_font_weight; ?>;
    color: <?php echo $tab_link_active_content_color; ?>;
    background-color: <?php echo $tab_link_active_bg_color; ?>;
    border-color: <?php echo $tab_border_color; ?>;
    border-bottom-color: transparent;
  }
</style>