<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$divider_color = $theme->divider_color;
?>
<style>
  /* DIVIDER */
  <?php echo $prefix; ?>
  .wd_divider {
    background-color: <?php echo $divider_color; ?>;
  }
</style>