<?php

defined('ABSPATH') || die('Access Denied');

$prefix = $this->prefix;
$theme = $this->theme;

$modal_backdrop_color = $theme->modal_backdrop_color;
$modal_bg_color = $theme->modal_bg_color;
$modal_border_color = $theme->modal_border_color;
$modal_dividers_color = $theme->modal_dividers_color;

$modal_ctrl_color = $theme->modal_bg_color;
$modal_ctrl_hover_color = WDFColorUtils::adjust_brightness($modal_ctrl_color, -10);
$modal_ctrl_mdown_color = WDFColorUtils::adjust_brightness($modal_ctrl_color, -20);
?>
<style>
  /* MODAL */
  <?php echo $prefix; ?>
  .modal-content {
    background-color: <?php echo $modal_bg_color; ?>;
    border-color: <?php echo $modal_border_color; ?>;
  }

  <?php echo $prefix; ?>
  .modal-backdrop {
    background-color: <?php echo $modal_backdrop_color; ?>;
  }

  <?php echo $prefix; ?>
  .modal-header {
    border-bottom-color: <?php echo $modal_dividers_color; ?>;
  }

  <?php echo $prefix; ?>
  .modal-footer {
    border-top-color: <?php echo $modal_dividers_color; ?>;
  }

  /* buttons */
  <?php echo $prefix; ?>
  .wd-modal-ctrl.btn-link {
    color: <?php echo $modal_ctrl_color; ?>;
  }

  <?php echo $prefix; ?>
  .wd-modal-ctrl.btn-link:hover,
  <?php echo $prefix; ?> .wd-modal-ctrl.btn-link:focus {
    color: <?php echo $modal_ctrl_hover_color; ?>;
  }

  <?php echo $prefix; ?>
  .wd-modal-ctrl.btn-link:active {
    color: <?php echo $modal_ctrl_mdown_color; ?>;
  }

  <?php echo $prefix; ?>
  .wd-modal-ctrl.btn-link.disabled,
  <?php echo $prefix; ?> .wd-modal-ctrl.btn-link[disabled],
  <?php echo $prefix; ?> .wd-modal-ctrl.btn-link.disabled:hover,
  <?php echo $prefix; ?> .wd-modal-ctrl.btn-link[disabled]:hover,
  <?php echo $prefix; ?> .wd-modal-ctrl.btn-link.disabled:focus,
  <?php echo $prefix; ?> .wd-modal-ctrl.btn-link[disabled]:focus,
  <?php echo $prefix; ?> .wd-modal-ctrl.btn-link.disabled:active,
  <?php echo $prefix; ?> .wd-modal-ctrl.btn-link[disabled]:active {
    color: <?php echo $modal_ctrl_color; ?> !important;
  }
</style>