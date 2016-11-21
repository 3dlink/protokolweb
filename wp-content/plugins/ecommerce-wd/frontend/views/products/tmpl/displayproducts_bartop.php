<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_displayproduct_bartop');
wp_enqueue_style('wde_displayproduct_bartop');

$row_user = $this->row_user;
$options = $this->options;

if ($options->search_enable_user_bar == 1) {
?>
<nav class="navbar navbar-default" role="navigation">
  <!-- toggle button -->
  <div class="navbar-header">
    <a class="navbar-toggle"
       data-toggle="collapse"
       data-target=".wd_shop_topbar_user_data">
      <span class="sr-only">Toggle user data</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
  </div>
  <!-- navbar content -->
  <div class="wd_shop_topbar_user_data collapse navbar-collapse">
    <ul class="nav navbar-nav navbar-right">
      <!-- shopping cart -->
      <li>
        <a href="<?php echo get_permalink($options->option_shopping_cart_page); ?>">
            &nbsp;<span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;
            <?php
            $products_in_cart_class = $row_user->products_in_cart > 0 ? '' : 'wd_hidden';
            ?>
          <span class="wd_shop_products_in_cart badge <?php echo $products_in_cart_class; ?>">
            <?php echo $row_user->products_in_cart; ?>
          </span>
        </a>
      </li>
      <li class="dropdown">
        <!-- log in/user button -->
        <a href="#"
           class="bs_dropdown-toggle"
           data-toggle="bs_dropdown">
          <?php echo is_user_logged_in() ? $row_user->name : __('Login', 'wde'); ?>
          <span class="glyphicon glyphicon-user"></span>
          <b class="caret"></b>
        </a>
        <ul class="bs_dropdown-menu" role="menu">
          <?php                    
          if (is_user_logged_in()) {
            ?>
            <!-- orders -->
            <li>
              <a href="<?php echo get_permalink($options->option_orders_page); ?>">
                <?php _e('Orders', 'wde'); ?>
              </a>
            </li>
            <!-- user account -->
            <li>
              <a href="<?php echo get_permalink($options->option_usermanagement_page); ?>">
                <?php _e('Account', 'wde'); ?>
              </a>
            </li>
            <li class="divider"></li>
            <!-- logout -->
            <li>
              <a href="<?php echo wp_logout_url(( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">
                  <?php _e('Logout', 'wde'); ?>
              </a>
            </li>
            <?php
          }
          else {
            ?>
            <li>
              <div class="container">
              <?php require WD_E_DIR . '/frontend/views/usermanagement/tmpl/displaylogin.php'; ?>
              </div>
            </li>
            <?php
          }
          ?>
        </ul>
      </li>
    </ul>
  </div>
</nav>
  <?php
}
?>