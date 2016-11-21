<?php
defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;
$option_include_tax_in_checkout_price = isset($options->option_include_tax_in_checkout_price) ? $options->option_include_tax_in_checkout_price : 0;

$get_order = $this->order;
if (!$get_order) {
  return FALSE;
}
$order_product_rows = $get_order['order_product_rows'];
$total_price_text = $get_order['total_price'];
?>
<div class="wd_shop_tooltip_container"></div>
<div class="container wd_shop_shopping_cart_container">
  <div class="row">
    <div class="col-sm-12">
      <?php require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php'; ?>
    </div>
  </div>
  <?php
  if (empty($order_product_rows) == false) {
    ?>
    <form name="wd_shop_main_form" action="" method="POST">
      <input type="hidden" name="order_product_id" value="" />
    </form>
    <form name="wd_shop_form_products" action="" method="POST">
      <div class="row">
      <?php
      foreach ($order_product_rows as $order_product_row) {
          $id = $order_product_row->id;
          ?>
        <div class="wd_shop_order_product_container col-sm-12" order_product_id="<?php echo $id; ?>">
          <div class="wd_shop_panel_product panel panel-default">
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-3">
                  <div class="row">
                    <div class="wd_shop_order_product_image_container wd_center_wrapper col-sm-12">
                      <div>
                        <?php
                        if ($order_product_row->product_image != '') {
                          ?>
                        <img class="wd_shop_order_product_image" src="<?php echo $order_product_row->product_image; ?>" />
                          <?php
                        }
                        else {
                          ?>
                          <div class="wd_shop_order_product_no_image">
                            <span class="glyphicon glyphicon-picture"></span><br />
                            <span><?php _e('No Image', 'wde'); ?></span>
                          </div>
                          <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-sm-12">
                      <a href="<?php echo $order_product_row->product_url; ?>" class="wd_shop_order_product_name wd_shop_product_name_all btn btn-link">
                        <?php echo $order_product_row->product_name; ?>
                      </a>
                    </div>
                    <div class="col-sm-12">
                      <dl class="wd_shop_order_product_list_parameters dl-horizontal">
                        <?php
                        for ($j = 0; $j < count($order_product_row->product_parameter_datas); $j++) {
                          $product_parameter_data = $order_product_row->product_parameter_datas[$j];
                          $name = $product_parameter_data->name;
                          $name_ = str_replace(' ', '_', $product_parameter_data->name);
                          $type_id = $product_parameter_data->type_id;
                          if ($type_id == 2) {
                            continue;
                          }
                          $values_list = $product_parameter_data->values;
                          $value = $product_parameter_data->value;
                          ?>
                          <dt>
                            <p class="wd_shop_order_product_parameter_name">
                              <?php echo $product_parameter_data->name; ?>
                            </p>
                          </dt>
                          <dd class="wd_shop_order_product_parameter"
                              type_id='<?php echo $type_id;?>'
                              parameter_id='<?php echo $product_parameter_data->id;?>'>
                              <?php
                              switch ($type_id) {
                                // Input field
                                case 1:
                                  ?>
                                  <input type="text" name="parameter_value" id="<?php echo 'input_' . $id;?>"
                                         class=" wd_shop_parameter_input form-control wd-input-xs"
                                         value="<?php echo $product_parameter_data->value; ?>"
                                         onchange="wdShop_onProductParameterChange(event, this)">
                                  <?php
                                  break;
                                // Select
                                case 3:
                                  $default_value = array();
                                  $default_value['value'] = 0;
                                  $default_value['price'] = '';
                                  $default_value['text'] = __('- Select -', 'wde');
                                  $default_value['type_id'] = 0;
                                  array_unshift($values_list, $default_value);
                                  ?>
                                  <select id="wd_shop_selectable_parameter_<?php echo $name_  . '_' . $id; ?>"
                                          name="<?php echo $name_ . '_' . $id; ?> "
                                          onchange="wdShop_onProductParameterChange(event, this)"
                                          class=" wd_shop_parameter_select form-control wd-input-xs">
                                      <?php
                                      if (is_array($values_list)) {
                                        foreach ($values_list as $value_list) {
                                            ?>
                                            <option
                                                data-paramater-price="<?php echo $value_list['price'];?>"
                                                value="<?php echo $value_list['value']; ?>"
                                                <?php echo ($value_list['value'] === $value) ? 'selected="selected"' : '';?>>
                                                <?php echo $value_list['text']; ?>
                                            </option>
                                        <?php
                                        }
                                      }
                                      ?>
                                  </select>
                                  <?php
                                  break;
                                // Radio
                                case 4:
                                  if (is_array($values_list)) {
                                      foreach ($values_list as $value_list) {
                                          ?>
                                          <input type="radio"
                                                 id="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value'] . '_' . $id; ?>"
                                                 name="<?php echo $name_ . '_' . $id; ?>"
                                                 value="<?php echo $value_list['value'] ?>"
                                                 onchange="wdShop_onProductParameterChange(event, this)"
                                                 data-paramater-price="<?php echo $value_list['price'];?>"
                                                 class="   parameters_input wd_shop_parameter_radio"
                                                 <?php echo ($value_list['value'] == $value) ? 'checked="checked"' : '';?>>
                                      <label
                                          for="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value']   . '_' . $id; ?>"
                                          id="wd_shop_checkbox_parameter_<?php echo $name_; ?>"
                                          class="parameters_label">
                                          <?php echo $value_list['text'] ?>
                                      </label>

                                  <?php
                                  }
                                }
                                    break;
                                // Checkbox
                                case 5:
                                    if (is_array($values_list)) {
                                      foreach ($values_list as $value_list) {
                                          ?>
                                          <input type="checkbox"
                                                 id="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value'] . '_' . $id; ?>"
                                                 name="<?php echo $name_ . '_' . $id; ?>"
                                                 value="<?php echo $value_list['value'] ?>"
                                                 data-paramater-price="<?php echo $value_list['price'];?>"
                                                 onchange="wdShop_onProductParameterChange(event, this)"
                                                 class=" parameters_input wd_shop_parameter_checkbox"
                                                 <?php
                                                  if (gettype($value) != 'string') {
                                                    echo in_array($value_list['value'], $value) ? 'checked="checked"' : '';
                                                  }
                                                  elseif ($value_list['value'] == $value) {
                                                    ?>
                                                    checked="checked"
                                                    <?php
                                                  }
                                                  ?>>
                                          <label
                                              for="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value']  . '_' . $id; ?>"
                                              id="label_<?php echo $name_; ?>"
                                              class="parameters_label">
                                              <?php echo $value_list['text'] ?>
                                          </label>
                                      <?php
                                      }
                                    }
                                    break;
                                default: 
                                  break;
                              }
                              ?>
                          </dd>
                          <?php
                        }
                        ?>
                      </dl>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 text-right">
                  <?php
                  if ($order_product_row->product_final_price_text) {
                    ?>
                  <p>
                    <span>
                      <span class="wd_shop_order_product_final_price wd_shop_product_price_all" orderProductId="<?php echo $order_product_row->id; ?>">
                        <?php echo $order_product_row->product_final_price_text; ?>
                      </span>
                      <?php
                      if ($order_product_row->product_final_price_text != $order_product_row->price_text
                        || $order_product_row->product_discount_rate
                        || !($option_include_tax_in_checkout_price && !$order_product_row->product_tax_rate_text)) {
                        ?>
                      <span class="wd_shop_order_product_final_price_info glyphicon glyphicon-info-sign"
                            title="<?php echo $order_product_row->product_final_price_info; ?>"></span>
                        <?php
                      }
                      ?>
                    </span>
                  </p>
                    <?php
                  }
                  if (!$option_include_tax_in_checkout_price && $order_product_row->product_tax_rate_text) {
                    ?>
                  <p class="wd_shop_order_product_tax_price_container wd_shop_product_price_all_small">
                    <?php
                    if ($options->tax_total_display == 'itemized') {
                      foreach ($order_product_row->tax_info as $tax_info) {
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
                    elseif ($order_product_row->product_tax_rate_text) {
                      ?>
                      <span><?php _e('Tax', 'wde'); ?>:</span>
                      <span><?php echo $order_product_row->product_tax_rate_text; ?></span>
                      <?php
                    }
                    ?>
                  </p>
                    <?php
                  }
                  ?>
                  <p>
                    <label for="count">
                      <span class="wd_shop_order_product_quantity_title">
                        <?php _e('Quantity', 'wde'); ?>:
                      </span>
                      <input type="number"
                             class="wd_shop_order_product_quantity form-control wd-input-xs"
                             onfocus="wdShop_onProductCountFocus(event, this);"
                             onkeydown="return wdShop_disableEnterKey(event);"
                             onchange="wdShop_onProductCountBlur(event, this);"
                             value="<?php echo $order_product_row->product_count; ?>" min="1" />
                    </label>
                    <br />
                    <small class="wd_shop_order_product_available <?php echo $order_product_row->stock_class; ?>">
                      <?php echo $order_product_row->product_availability_msg; ?>
                    </small>
                  </p>
                </div>
              </div>
              <?php
              if ($order_product_row->subtotal_text) {
                ?>
              <div class="row">
                <div class="col-sm-12 text-right">
                   <p>
                     <span class="wd_shop_order_product_subtotal_title wd_shop_product_price_all">
                       <?php _e('Subtotal', 'wde'); ?>:
                     </span>
                     <span class="wd_shop_order_product_subtotal wd_shop_product_price_all" productId="<?php echo $order_product_row->product_id; ?>">
                       <?php echo $order_product_row->subtotal_text; ?>
                     </span>
                   </p>
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
            </div>
            <div class="panel-footer">
              <div class="row">
                <div class="col-sm-12 text-right">
                  <div class="wd_shop_order_product_ctrls">
                    <?php
                    if (($options->checkout_enable_checkout == 1) && ($order_product_row->product_available == true)) {
                      ?>
                      <a class="btn btn-link btn-sm"
                         onclick="wdShop_onBtnCheckoutProductClick(event, this); return false;">
                        <?php _e('Checkout this item', 'wde'); ?>
                      </a>
                      <?php
                    }
                    ?>
                    <a class="btn btn-link btn-sm"
                       onclick="wdShop_onBtnRemoveProductClick(event, this); return false;">
                      <?php _e('Remove this item', 'wde'); ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
      </div>
      <div class="wd_divider"></div>
      <?php
      if ($total_price_text) {
        ?>
      <div class="row">
        <div class="col-sm-12 text-right">
            <span class="wd_shop_total_title wd_shop_product_price_all">
              <?php _e('Total price', 'wde'); ?>:
            </span>
            <span class="wd_shop_total wd_shop_product_price_all">
              <?php echo $total_price_text; ?>
            </span>
        </div>
      </div>
      <div class="wd_divider"></div>
        <?php
      }
      ?>
      <div class="row">
        <div class="col-sm-12 text-right">
          <a class="btn btn-default btn-sm"
             data-toggle="tooltip"
             onclick="wdShop_onBtnRemoveAllProductsClick(event, this); return false;">
            <?php _e('Remove all', 'wde'); ?>
          </a>
          <?php
          if ($options->checkout_enable_checkout == 1) {
            ?>
            <a class="btn btn-primary btn-sm"
               onclick="wdShop_onBtnCheckoutAllProductsClick(event, this); return false;">
              <?php _e('Checkout all', 'wde'); ?>
            </a>
            <?php
          }
          ?>
        </div>
      </div>
    </form>
    <?php
  }
  else {
    ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-info">
          <?php _e('Your cart is empty', 'wde') ?>
        </div>
      </div>
    </div>
  <?php
}
?>
</div>
<script>
  var WD_SHOP_TEXT_PLEASE_WAIT = "<?php _e('Pleasa wait', 'wde'); ?>";
  var wdShop_urlRemoveOrderProduct = "<?php echo add_query_arg(array('action' => 'wde_RemoveOrderProduct', 'type' => 'shoppingcart', 'task' => 'ajax_remove_order_product'), admin_url('admin-ajax.php')); ?>";
  var wdShop_urlRemoveAllOrderProducts = "<?php echo add_query_arg(array('action' => 'wde_RemoveOrderProduct', 'type' => 'shoppingcart', 'task' => 'ajax_remove_all_order_products'), admin_url('admin-ajax.php')); ?>";
  var wdShop_urlCheckoutOrderProduct = "<?php echo WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_product, '1', FALSE); ?>";
  var wdShop_urlCheckoutAllOrderProducts = "<?php echo WDFPath::add_pretty_query_args(get_permalink($options->option_checkout_page), $options->option_endpoint_checkout_all_products, '1', FALSE); ?>";
</script>