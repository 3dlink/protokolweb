<?php
defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);

$options_model = WDFHelper::get_model('options');
$options = $options_model->get_options();
$action_display_confirm_order = WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_confirm_order, '1', FALSE);
$action_display_confirm_order = add_query_arg('session_id' , WDFInput::get('session_id'), $action_display_confirm_order);

$action_shopping_cart = get_permalink($options->option_shopping_cart_page);
?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php'; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="wd_shop_panel_user_data panel panel-default">
        <div class="panel-body">
          <h3 class="wd_shop_header">
            <?php _e('Checkout failed', 'wde'); ?>
          </h3>
          <p>
            <?php echo WDFInput::get('error_msg'); ?>
          </p>
          <div>
            <ul class="pager">			
              <li class="previous">
                <a href="<?php echo $action_shopping_cart; ?>">
                  <span><?php _e('Cancel checkout', 'wde'); ?></span>
                </a>
              </li>
              <li class="previous">
                <a href="<?php echo $action_display_confirm_order; ?>"
                   onclick="onWDShop_pagerBtnClick(event, this); return false;">
                  <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;
                  <span><?php _e('Confirm order', 'wde'); ?></span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>