<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$pagination_content_color = $theme->pagination_content_color;
$pagination_font_size = $theme->pagination_font_size ? 'font-size: ' . $theme->pagination_font_size . ';' : '';
$pagination_font_family = $theme->pagination_font_family ? $theme->pagination_font_family : 'inherit';
$pagination_font_weight = $theme->pagination_font_weight ? $theme->pagination_font_weight : 'inherit';

$pagination_bg_color = $theme->pagination_bg_color;
$pagination_hover_content_color = $theme->pagination_hover_content_color;
$pagination_hover_bg_color = $theme->pagination_hover_bg_color;
$pagination_active_content_color = $theme->pagination_active_content_color;
$pagination_active_bg_color = $theme->pagination_active_bg_color;
$pagination_border_color = $theme->pagination_border_color;
?>
<style>
  /* PAGINATION */
  <?php echo $prefix; ?>
  .pagination > li > a,
  <?php echo $prefix; ?> .pagination > li > span {
    <?php echo $pagination_font_size; ?>
    font-family: <?php echo $pagination_font_family; ?>;
    font-weight: <?php echo $pagination_font_weight; ?>;
    color: <?php echo $pagination_content_color; ?>;
    background-color: <?php echo $pagination_bg_color; ?>;
    border-color: <?php echo $pagination_border_color; ?>;
  }
  <?php echo $prefix; ?>
  .pagination > li > a:hover,
  <?php echo $prefix; ?> .pagination > li > span:hover,
  <?php echo $prefix; ?> .pagination > li > a:focus,
  <?php echo $prefix; ?> .pagination > li > span:focus {
    <?php echo $pagination_font_size; ?>
    font-family: <?php echo $pagination_font_family; ?>;
    font-weight: <?php echo $pagination_font_weight; ?>;
    color: <?php echo $pagination_hover_content_color; ?>;
    background-color: <?php echo $pagination_hover_bg_color; ?>;
  }
  <?php echo $prefix; ?>
  .pagination > .active > a,
  <?php echo $prefix; ?> .pagination > .active > span,
  <?php echo $prefix; ?> .pagination > .active > a:hover,
  <?php echo $prefix; ?> .pagination > .active > span:hover,
  <?php echo $prefix; ?> .pagination > .active > a:focus,
  <?php echo $prefix; ?> .pagination > .active > span:focus {
    color: <?php echo $pagination_active_content_color; ?>;
    background-color: <?php echo $pagination_active_bg_color; ?>;
    border-top: 1px solid <?php echo $pagination_active_bg_color; ?>;
    border-right: 1px solid <?php echo $pagination_active_bg_color; ?>;
    border-bottom: 1px solid <?php echo $pagination_active_bg_color; ?>;
    border-left: 1px solid <?php echo $pagination_active_bg_color; ?>;
  }
  <?php echo $prefix; ?>
  .pagination > .disabled > span,
  <?php echo $prefix; ?> .pagination > .disabled > a,
  <?php echo $prefix; ?> .pagination > .disabled > a:hover,
  <?php echo $prefix; ?> .pagination > .disabled > a:focus {
    <?php echo $pagination_font_size; ?>
    font-family: <?php echo $pagination_font_family; ?>;
    font-weight: <?php echo $pagination_font_weight; ?>;
    color: <?php echo $pagination_content_color; ?>;
    background-color: <?php echo $pagination_bg_color; ?>;
    border-color: <?php echo $pagination_border_color; ?>;
  }
</style>