<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$navbar_bg_color = $theme->navbar_bg_color;
$navbar_border_color = $theme->navbar_border_color;
$navbar_link_content_color = $theme->navbar_link_content_color;
$navbar_link_hover_content_color = $theme->navbar_link_hover_content_color;
$navbar_link_open_content_color = $theme->navbar_link_open_content_color;
$navbar_link_open_bg_color = $theme->navbar_link_open_bg_color;
$navbar_badge_content_color = $theme->navbar_badge_content_color;
$navbar_badge_font_size = $theme->navbar_badge_font_size ? 'font-size: ' . $theme->navbar_badge_font_size . ';' : '';
$navbar_badge_font_family = $theme->navbar_badge_font_family ? $theme->navbar_badge_font_family : 'inherit';
$navbar_badge_font_weight = $theme->navbar_badge_font_weight ? $theme->navbar_badge_font_weight : 'inherit';

$navbar_badge_bg_color = $theme->navbar_badge_bg_color;
$navbar_dropdown_link_content_color = $theme->navbar_dropdown_link_content_color;
$navbar_dropdown_link_font_size = $theme->navbar_dropdown_link_font_size ? 'font-size: ' . $theme->navbar_dropdown_link_font_size . ';' : '';
$navbar_dropdown_link_font_family = $theme->navbar_dropdown_link_font_family ? $theme->navbar_dropdown_link_font_family : 'inherit';
$navbar_dropdown_link_font_weight = $theme->navbar_dropdown_link_font_weight ? $theme->navbar_dropdown_link_font_weight : 'inherit';

$navbar_dropdown_link_hover_content_color = $theme->navbar_dropdown_link_hover_content_color;
$navbar_dropdown_link_hover_background_content_color = $theme->navbar_dropdown_link_hover_background_content_color;
$navbar_dropdown_divider_color = $theme->navbar_dropdown_divider_color;
$navbar_dropdown_background_color = $theme->navbar_dropdown_background_color;
$navbar_dropdown_border_color = $theme->navbar_dropdown_border_color;
?>
<style>
  /* NAVBAR */
  <?php echo $prefix; ?>
  .navbar-default {
    background-color: <?php echo $navbar_bg_color; ?>;
    border-color: <?php echo $navbar_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav > li > a,
  <?php echo $prefix; ?>
  .bs_dropdown-toggle {
    color: <?php echo $navbar_link_content_color; ?>;
    <?php echo $navbar_badge_font_size; ?>
    font-family: <?php echo $navbar_badge_font_family; ?>;
    font-weight: <?php echo $navbar_badge_font_weight; ?>;
  }
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav > li > a .caret {
    border-top-color: <?php echo $navbar_link_content_color; ?>;
    border-bottom-color: <?php echo $navbar_link_content_color; ?>;
  }
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav > li > a:hover,
  <?php echo $prefix; ?> .navbar-default .navbar-nav > li > a:focus {
    color: <?php echo $navbar_link_hover_content_color; ?>;
  }
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav > li > a:hover .caret,
  <?php echo $prefix; ?> .navbar-default .navbar-nav > li > a:focus .caret {
    border-top-color: <?php echo $navbar_link_hover_content_color; ?>;
    border-bottom-color: <?php echo $navbar_link_hover_content_color; ?>;
  }
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav > .open > a,
  <?php echo $prefix; ?> .navbar-default .navbar-nav > .open > a:hover,
  <?php echo $prefix; ?> .navbar-default .navbar-nav > .open > a:focus {
    color: <?php echo $navbar_link_open_content_color; ?>;
    background-color: <?php echo $navbar_link_open_bg_color; ?>;
  }
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav > .open > a .caret,
  <?php echo $prefix; ?> .navbar-default .navbar-nav > .open > a:hover .caret,
  <?php echo $prefix; ?> .navbar-default .navbar-nav > .open > a:focus .caret {
    border-top-color: <?php echo $navbar_link_open_content_color; ?>;
    border-bottom-color: <?php echo $navbar_link_open_content_color; ?>;
  }
  /* badge */
  <?php echo $prefix; ?>
  .badge {
    <?php echo $navbar_badge_font_size; ?>
    font-family: <?php echo $navbar_badge_font_family; ?>;
    font-weight: <?php echo $navbar_badge_font_weight; ?>;
    color: <?php echo $navbar_badge_content_color; ?>;
    background-color: <?php echo $navbar_badge_bg_color; ?>;
  }
  /* navbar dropdown */
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav .open .bs_dropdown-menu {
    background-color: <?php echo $navbar_dropdown_background_color; ?>;
    border-color: <?php echo $navbar_dropdown_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav .open .bs_dropdown-menu > li.divider {
    background-color: <?php echo $navbar_dropdown_divider_color; ?>;
  }
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav .open .bs_dropdown-menu > li > a {
    color: <?php echo $navbar_dropdown_link_content_color; ?>;
    <?php echo $navbar_dropdown_link_font_size; ?>
    font-family: <?php echo $navbar_dropdown_link_font_family; ?>;
    font-weight: <?php echo $navbar_dropdown_link_font_weight; ?>;
  }
  <?php echo $prefix; ?>
  .navbar-default .navbar-nav .open .bs_dropdown-menu > li > a:hover,
  <?php echo $prefix; ?> .navbar-default .navbar-nav .open .bs_dropdown-menu > li > a:focus {
    color: <?php echo $navbar_dropdown_link_hover_content_color; ?>;
    background-color: <?php echo $navbar_dropdown_link_hover_background_content_color; ?>;
  }
</style>