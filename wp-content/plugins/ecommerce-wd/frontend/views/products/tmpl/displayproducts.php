<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;
$theme = $this->theme;
?>
<div class="wd_shop_tooltip_container"></div>
<div class="wd_shop_modal_tooltip_container"></div>
<?php
require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_mainform.php';
require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_layout_' . $theme->products_filters_position . '.php';
require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_quickview.php';
?>
<script>
  var WD_SHOP_TEXT_ALREADY_ADDED_TO_CART = "<?php _e('Product already added to cart', 'wde'); ?>";
  var WD_SHOP_TEXT_PLEASE_WAIT = "<?php _e('Please wait', 'wde'); ?>";

  var wdShop_minicart = "";
  var wdShop_filtersAutoUpdate = <?php echo $theme->products_filters_position == 1 ? 'false' : 'true'; ?>;
  var wdShop_redirectToCart = <?php echo $options->checkout_redirect_to_cart_after_adding_an_item == 1 ? 'true' : 'false'; ?>;

  var wdShop_urlDisplayProducts = "";
  var wdShop_urlAddToShoppingCart = "<?php echo add_query_arg(array('action' => 'wde_AddToShoppingCart', 'type' => 'shoppingcart', 'task' => 'add'), admin_url('admin-ajax.php')); ?>";
  var wdShop_urlDisplayShoppingCart = "<?php echo get_permalink($options->option_shopping_cart_page); ?>";
  var option_redirect_to_cart_after_adding_an_item = "<?php echo $options->checkout_redirect_to_cart_after_adding_an_item;?>";	
</script>