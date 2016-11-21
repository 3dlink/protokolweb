<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$well_bg_color = $theme->well_bg_color;
$well_border_color = $theme->well_border_color;
?>
<style>
  /* WELL */
  <?php echo $prefix; ?>
  .well {
    background-color: <?php echo $well_bg_color; ?>;
    border-color: <?php echo $well_border_color; ?>;
  }
</style>