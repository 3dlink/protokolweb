<?php
defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;
$option_include_tax_in_checkout_price = isset($options->option_include_tax_in_checkout_price) ? $options->option_include_tax_in_checkout_price : 0;

$final_checkout_data = $this->final_checkout_data;
$products_data = $final_checkout_data['products_data'];
$total_shipping_method = $final_checkout_data['shipping_method'];

$total_price_text = $final_checkout_data['total_price_text'];

$payment_buttons_data = $this->payment_buttons_data;
$pager_data = $this->pager_data;
?>
<div class="wd_shop_tooltip_container"></div>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="wd_shop_panel_user_data panel panel-default">
        <div class="panel-body">
          <h2 class="wd_shop_header"><?php _e('Confirm order', 'wde'); ?></h2>
          <form name="wd_shop_main_form" action="" method="POST">
            <?php
            foreach ($products_data as $product_data) {
              ?>
            <div class="wd_shop_order_product_container" data-porduct-id="<?php echo $product_data->id; ?>" data-order-id="<?php echo $product_data->order_product_id; ?>">
              <div class="row">
                <div class="col-sm-12">
                  <h4 class="wd_shop_order_product_name wd_shop_product_name_all wd_shop_header_sm">
                    <?php echo $product_data->name; ?>
                  </h4>
                </div>
                <div class="col-sm-8">
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="row">
                        <div class="wd_shop_order_product_image_container wd_center_wrapper col-sm-12">
                          <div>
                            <?php 
                            if ($product_data->image != '') {
                              ?>
                              <img class="wd_shop_order_product_image" src="<?php echo $product_data->image; ?>" />
                              <?php
                            }
                            else {
                              ?>
                              <div class="wd_shop_order_product_no_image">
                                <span class="glyphicon glyphicon-picture"></span>
                                <br />
                                <span><?php _e('No image', 'wde'); ?></span>
                              </div>
                              <?php
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <?php
                      if ($product_data->parameters != '') {
                        ?>
                        <p>
                          <strong><?php _e('Parameters', 'wde'); ?>:</strong><br />
                          <?php echo stripslashes(str_replace('%br%', '<br />', $product_data->parameters)); ?>
                        </p>
                        <?php
                      }
                      ?>
                    </div>
                    <div class="col-sm-8">
                      <?php
                      if ($product_data->enable_shipping == 1 or $product_data->enable_shipping == 2) {
                        if (!empty($product_data->shipping_method_rows) && is_array($product_data->shipping_method_rows)) {
                          ?>
                          <strong><?php _e('Shipping', 'wde'); ?>:</strong>
                          <?php
                          foreach ($product_data->shipping_method_rows as $shipping_method) {
                            ?>
                          <div>
                            <label>
                              <input type="radio"
                                     name="product_shipping_method_id_<?php echo $product_data->id . '_' . $product_data->order_product_id; ?>"
                                     class="wd_shop_product_data_shipping_method_id"
                                     value="<?php echo $shipping_method->id; ?>"
                                     <?php checked( TRUE, $shipping_method->checked, TRUE ); ?>
                                     onclick="wde_display_confirm_order(this)" />
                              <?php
                              echo $shipping_method->label;
                              ?>
                            </label>
                          </div>
                            <?php
                          }
                        }
                        else {
                          ?>
                          <div class="alert alert-danger">
                            <?php _e('This item will not ship to your country', 'wde'); ?>
                          </div>
                          <?php
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 text-right">
                  <?php
                  if ($product_data->price_text) {
                    ?>
                  <p class="wd_shop_order_product_price_container">
                    <span class="wd_shop_order_product_price wd_shop_product_price_all">
                      <?php echo $product_data->price_text; ?>
                    </span>
                    <?php
                    if ($product_data->current_price_text != $product_data->price_text
                      || $product_data->discount_rate
                      || !($option_include_tax_in_checkout_price && !$product_data->tax_info)) {
                      ?>
                    <span class="wd_shop_order_product_final_price_info glyphicon glyphicon-info-sign"
                          title="<?php echo $product_data->price_info; ?>"></span>
                      <?php
                    }
                    ?>
                  </p>
                    <?php
                  }
                  if ($product_data->shipping_price_text) {
                    ?>
                  <p class="wd_shop_order_product_shipping_price_container wd_shop_product_price_all_small">
                    <span><?php _e('Shipping', 'wde'); ?>:</span>
                    <span><?php echo $product_data->shipping_price_text; ?></span>
                  </p>
                    <?php
                  }
                  if (!$option_include_tax_in_checkout_price && $product_data->tax_info) {
                    ?>
                  <p class="wd_shop_order_product_tax_price_container wd_shop_product_price_all_small">
                    <?php
                    if ($options->tax_total_display == 'itemized') {
                      foreach ($product_data->tax_info as $tax_info) {
                        ?>
                        <div class="wd_shop_product_price_all_small">
                          <span>
                            <?php echo ($tax_info['name'] != '' ? $tax_info['name'] : __('Tax', 'wde')) . ': '; ?>
                          </span>
                          <span><?php echo $tax_info['tax_text']; ?></span>
                        </div>
                        <?php
                      }
                    }
                    elseif ($product_data->tax_total_text) {
                      ?>
                      <span><?php _e('Tax', 'wde'); ?>:</span>
                      <span><?php echo $product_data->tax_total_text; ?></span>
                      <?php
                    }
                    ?>
                  </p>
                    <?php
                  }
                  ?>
                  <p class="wd_shop_order_product_quantity_container">
                    <span><?php _e('Quantity', 'wde'); ?>:</span>
                    <span><?php echo $product_data->count; ?></span>
                  </p>                
                </div>
              </div>
              <?php
              if ($product_data->subtotal_price_text) {
                ?>
              <div class="row">
                <div class="col-sm-12 text-right">
                  <span class="wd_shop_order_product_subtotal_title wd_shop_product_price_all"><?php _e('Subtotal', 'wde'); ?>:</span>
                  <span class="wd_shop_order_product_subtotal wd_shop_product_price_all">
                    <?php echo $product_data->subtotal_price_text; ?>
                  </span>
                </div>
              </div>
                <?php
              }
              ?>
              <!-- loading and alerts -->
              <div class="row">
                <div class="wd_shop_loading_clip_container wd_hidden col-sm-12 text-right">
                  <span><?php _e('Updating', 'wde'); ?></span>
                  <div class="wd_loading_clip_small"></div>
                </div>
                <div class="wd_shop_alert_failed_to_update_container wd_hidden col-sm-12">
                  <div class="alert alert-danger"></div>
                </div>
              </div>
              <div class="row"><div class="col-sm-12"><div class="wd_divider"></div></div></div>
            </div>
              <?php
            }
            if ($total_shipping_method->shipping_type == 'per_order' && $total_shipping_method->shipping_method_price_text) {
              ?>
            <div class="col-sm-12 text-right">
              <div class="row">
                <span class="wd_shop_total_title wd_shop_product_price_all"><?php _e('Shipping', 'wde'); ?>:</span>
                <span class="wd_shop_total wd_shop_product_price_all"><?php echo $total_shipping_method->shipping_method_price_text; ?></span>
              </div>
            </div>
              <?php
            }
            if ($total_price_text) {
              ?>
            <div class="col-sm-12 text-right">
              <div class="row">
                <span class="wd_shop_total_title wd_shop_product_price_all"><?php _e('Total price', 'wde'); ?>:</span>
                <span class="wd_shop_total wd_shop_product_price_all"><?php echo $total_price_text; ?></span>
              </div>
            </div>
            <div class="row"><div class="col-sm-12"><div class="wd_divider"></div></div></div>
              <?php
            }
            ?>
            <div class="row">
              <div class="col-sm-12">
                <?php
                foreach ($payment_buttons_data as $payment_button_data) {
                  ?>
                <p class="text-right">
                  <a href="<?php echo $payment_button_data->action; ?>" class="btn btn-primary" onclick="wdShop_onBtnCheckoutClick(event, this); return false;">
                    <?php echo $payment_button_data->text; ?>
                  </a>
                </p>
                  <?php
                }
                ?>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div>
        <ul class="pager">
          <?php
          $btn_cancel_checkout_data = $pager_data['btn_cancel_checkout_data'];
          ?>
          <li class="previous">
            <a href="<?php echo $btn_cancel_checkout_data['url']; ?>">
              <span><?php _e('Cancel checkout', 'wde'); ?></span>
            </a>
          </li>
          <?php
          if (isset($pager_data['btn_prev_page_data'])) {
            $btn_prev_page_data = $pager_data['btn_prev_page_data'];
            ?>
            <li class="previous">
              <a href="<?php echo $btn_prev_page_data['action']; ?>"
                 onclick="onWDShop_pagerBtnClick(event, this); return false;">
                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;
                <span><?php echo $btn_prev_page_data['text']; ?></span>
              </a>
            </li>
            <?php
          }
          if (isset($pager_data['btn_next_page_data'])) {
            $btn_next_page_data = $pager_data['btn_next_page_data'];
            ?>
            <li class="next">
              <a href="<?php echo $btn_next_page_data['action']; ?>"
                 onclick="onWDShop_pagerBtnClick(event, this); return false;">
                <span><?php echo $btn_next_page_data['text']; ?></span>&nbsp;
                <span class="glyphicon glyphicon-arrow-right"></span>
              </a>
            </li>
            <?php
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
</div>