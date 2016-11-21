<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_items_slider');
wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;
$theme = $this->theme;
$product_row = $this->product_row;
$row_default_currency = $this->row_default_currency;

WDFFb::init();
WDFTwitter::init();
?>
<form name="wd_shop_main_form" action="" method="POST">
  <input type="hidden" name="product_id" value="" />
  <input type="hidden" name="product_count" value="" />
  <input type="hidden" name="product_parameters_json" value="" />
  <input type="hidden" name="task" />
</form>
<div class="wd_shop_tooltip_container"></div>
<div class="container" itemscope itemtype="http://schema.org/Product">
  <!-- main data -->
  <?php
  $main_data_divider = false;
  $show_image = $theme->product_view_show_image == 1 ? true : false;
  $show_info = ($theme->product_view_show_name == 1) || ($theme->product_view_show_category == 1) || ($theme->product_view_show_manufacturer == 1) || ($theme->product_view_show_rating == 1) || ($theme->product_view_show_price == 1) || ($theme->product_view_show_market_price == 1) || ((($product_row->can_checkout == true) && ($theme->product_view_show_button_buy_now == 1)) || ($theme->product_view_show_button_add_to_cart == 1)) || ($theme->product_view_show_button_compare == 1) || ($theme->product_view_show_button_write_review == 1) || ($theme->product_view_show_social_buttons == 1) ? true : false;
  $product_image_col_class = $show_info == true ? 'col-sm-6' : 'col-sm-12';
  $product_info_col_class = $show_image == true ? 'col-sm-6' : 'col-sm-12';
  ?>
  <div class="row">
    <div class="col-sm-12">
      <?php
      require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php';
      ?>
    </div>
  </div>
  <div class="row">
    <!-- images viewer -->
    <?php
    if ($theme->product_view_show_image == 1) {
      $main_data_divider = true;
      ?>
    <div class="<?php echo $product_image_col_class; ?>">
      <?php
      require WD_E_DIR . '/frontend/views/products/tmpl/displayproduct_imagesviewer.php';
      ?>
    </div>
      <?php
    }
    ?>
    <!-- info -->
    <div class="<?php echo $product_info_col_class; ?>">
      <!-- name -->
      <?php
      $info_divider = false;
      if ($theme->product_view_show_name == 1) {
        $info_divider = true;
        ?>
      <div class="row">
        <div class="col-sm-12">
          <h1 class="wd_shop_product_name text-left" itemprop="name">
            <?php echo $product_row->name; ?>
          </h1>
        </div>
      </div>
        <?php
      }
      ?>
      <div class="row">
        <div class="col-sm-6">
          <!-- category -->
          <?php
          if (($theme->product_view_show_category == 1) && ($product_row->category_url)) {
            $info_divider = true;
            foreach ($product_row->category_url as $category) {
            ?>
          <div>
            <a href="<?php echo get_term_link((int) $category->term_id, 'wde_categories'); ?>"
               class="wd_shop_product_btn_category btn btn-link">
              <small class="wd_shop_product_category_name">
                <?php echo $category->name; ?>
              </small>
            </a>
          </div>
            <?php
            }
          }
          ?>
          <!-- model -->
          <?php
          if (($theme->product_view_show_model == 1) && $product_row->model != '') {
            $info_divider = true;
            ?>
          <div>
            <small class="wd_shop_product_model_name">
              <?php echo $product_row->model; ?>
            </small>               
          </div>
            <?php
          }
          ?>
          <!-- manufacturer -->
          <?php
          if (($theme->product_view_show_manufacturer == 1) && ($product_row->manufacturer_url != '')) {
            $info_divider = true;
            ?>
          <div>
            <a href="<?php echo $product_row->manufacturer_url; ?>" class="wd_shop_product_btn_manufacturer btn btn-link">
              <small class="wd_shop_product_manufacturer_name">
                <?php echo $product_row->manufacturer_name; ?>
              </small>
              <?php
              if ($product_row->manufacturer_logo != '') {
                ?>
              <img class="wd_shop_product_manufacturer_logo" src="<?php echo $product_row->manufacturer_logo; ?>" alt="" />
                <?php
              }
              ?>
            </a>
          </div>
            <?php
          }
          ?>
        </div>
        <!-- rating -->
        <?php
        if (($options->feedback_enable_product_rating == 1) && ($theme->product_view_show_rating == 1)) {
          $info_divider = true;
          ?>
        <div class="col-sm-6 text-right">
          <?php
          echo WDFHTML::jf_bs_rater('', 'wd_shop_product_star_rater pull-right', '', $product_row->rating, $product_row->can_rate, $product_row->rating_url, $product_row->rating_msg, false, 5, ($theme->rating_star_font_size ? $theme->rating_star_font_size : '16px'), $theme->rating_star_type, $theme->rating_star_color, $theme->rating_star_bg_color); ?>
        </div>
          <?php
        }
        ?>
      </div>
      <?php
      if ($info_divider == true) {
        ?>
      <div class="wd_divider"></div>
        <?php
      }
      $info_divider = false;
      if ($product_row->short_description) {
        $info_divider = true;
        ?>
      <div class="row">
        <div class="wd_shop_product_description col-sm-12">
          <?php echo $product_row->short_description; ?>
        </div>
      </div>
        <?php
      }
      if ($info_divider == true) {
        ?>
      <div class="wd_divider"></div>
        <?php
      }
      $info_divider = false;
      ?>
      <!-- price and codes -->
      <div class="row">
        <div class="col-sm-6">
          <?php
          if ( $options->enable_sku == 1 && $product_row->sku != '') {
            $info_divider = true;
            ?>			
          <div class="wd_shop_product_codes"><?php _e('SKU', 'wde');?>: <?php echo $product_row->sku; ?></div>
            <?php
          }
          if ($options->enable_upc == 1 && $product_row->upc != '') {
            $info_divider = true;
            ?>
          <div class="wd_shop_product_codes"><?php _e('UPC', 'wde');?>: <?php echo $product_row->upc; ?></div>
            <?php
          }
          if ($options->enable_ean == 1 && $product_row->ean != '') {
            $info_divider = true;
            ?>
          <div class="wd_shop_product_codes"><?php _e('EAN', 'wde');?>: <?php echo $product_row->ean; ?></div>
            <?php
          }
          if ($options->enable_jan == 1 && $product_row->jan != '') {
            $info_divider = true;
            ?>
          <div class="wd_shop_product_codes"><?php _e('JAN', 'wde');?>: <?php echo $product_row->jan; ?></div>
            <?php
          }		
          if ($options->enable_mpn == 1 && $product_row->mpn != '') {
            $info_divider = true;
            ?>
          <div class="wd_shop_product_codes"><?php _e('MPN', 'wde');?>: <?php echo $product_row->mpn; ?></div>
            <?php
          }
          if ($options->enable_isbn == 1 && $product_row->isbn != '') {
            $info_divider = true;
            ?>
          <div class="wd_shop_product_codes"><?php _e('ISBN', 'wde');?>: <?php echo $product_row->isbn; ?></div>
            <?php
          }
          ?>		
        </div>
      </div>
      <?php
      if ($info_divider == true) {
        ?>
      <div class="wd_divider"></div>
        <?php
      }
      $info_divider = false;
      ?>
      <!-- order data container -->
      <?php
      $show_button_buy_now = ($options->checkout_enable_checkout == 1) && ($theme->product_view_show_button_buy_now == 1) && ($product_row->can_checkout == true) == true ? true : false;
      $show_button_add_to_cart = $theme->product_view_show_button_add_to_cart == 1 ? true : false;
      if (($show_button_buy_now == true) || ($show_button_add_to_cart == true)) {
        $info_divider = true;
        ?>
      <div class="row">
        <!-- order data -->
        <div class="wd_shop_products_order_data_container col-sm-6">
            <!-- order form -->
          <form name="wd_shop_form_order" action="" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_row->id; ?>" />
            <!-- count -->
            <div class="form-group">
              <?php
              if ($product_row->is_available == true) {
                ?>
                <label for="wd_shop_product_quantity" class="control-label">
                  <?php _e('Quantity', 'wde') ?>:
                </label>
                <input type="number"
                       name="product_count"
                       id="wd_shop_product_quantity"
                       class="wd_shop_product_quantity form-control wd-input-xs"
                       value="1"
                       min="1"
                       onchange="wdShop_onProductCountBlur(event, this);">
                <?php
              }
              ?>
              <div>
                <small <?php echo $product_row->stock_class;?>><?php echo $product_row->available_msg; ?></small>
              </div>
            </div>
            <br />
            <!-- parameters -->
            <?php
            if (is_array($product_row->selectable_parameters)) {
              foreach ($product_row->selectable_parameters as $selectable_parameter) {
                $id = $selectable_parameter->id;
                $name = $selectable_parameter->name;
                $name_ = str_replace(' ', '_', $selectable_parameter->name);
                $values_list = $selectable_parameter->values_list;
                $type_id = $selectable_parameter->type_id;
                for ($i = 0; $i < count($values_list); $i++) {
                  $parameter_price = $values_list[$i]['parameter_price'];
                  $price = substr($parameter_price, 1, strlen($parameter_price) - 1);
                  $sign = substr($parameter_price, 0, 1);
                  $value_price_str = '';
                  if (strlen($price) > 0 && $price) {
                    if ($row_default_currency->sign_position == 1) {
                      $value_price_str = $values_list[$i]['value'] . ' (' . $sign. $price . $product_row->currency_sign . ')';
                    }
                    else {
                      $value_price_str = $values_list[$i]['value'] . ' (' . $sign . $product_row->currency_sign . $price .  ')';
                    }
                  }
                  else {
                    $value_price_str = $values_list[$i]['value'];
                  }
                  $values_list[$i]['text'] = $value_price_str;
                }
                ?>
              <div class="form-group">
                <label for="wd_shop_selectable_parameter_<?php echo $name_; ?>">
                  <?php echo $type_id != 2 ? $name : ''; ?>:
                </label>
                <div class="wd_shop_product_selectable_parameter" parameter_id="<?php echo $id;?>" type_id="<?php echo $type_id;?>">
                  <?php
                  switch ($type_id) {
                    // Input field
                    case 1:
                      ?>
                  <input type="text" name="parameter_value" id="" class="wd_shop_parameter_input form-control wd-input-xs" />
                      <?php
                      break;
                    // Select
                    case 3:
                      $default_value = array();
                      $default_value['value'] = 0;
                      $default_value['text'] = '- Select -';
                      $default_value['parameter_price'] = '';
                      $default_value['type_id'] = 0;
                      array_unshift($values_list, $default_value);?>
                  <select id="wd_shop_selectable_parameter_'<?php echo $name_; ?>'"
                          name="<?php echo $name_; ?>"
                          data-type="<?php echo $type_id; ?>"
                          onchange="onSelectableParameterChange(this, event)"
                          class="wd_shop_parameter_select form-control wd-input-xs">
                      <?php
                      if (is_array($values_list)) {
                        foreach ($values_list as $value_list) {
                          ?>
                      <option
                          value="<?php echo $value_list['value'] ?>"
                          data-price="<?php echo $value_list['parameter_price']; ?>">
                        <?php echo $value_list['text'] ?>
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
                    <label
                        for="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value']; ?>"
                        id="wd_shop_checkbox_parameter_<?php echo $name_; ?>"
                        class="parameters_label">
                    <input type="radio"
                           id="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value']; ?>"
                           name="<?php echo $name_; ?>"
                           data-type="<?php echo $type_id; ?>"
                           value="<?php echo $value_list['value'] ?>"
                           onchange="onSelectableParameterChange(this, event)"
                           data-price="<?php echo $value_list['parameter_price']; ?>"
                           class="parameters_input wd_shop_parameter_radio">
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
                    <label
                        for="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value']; ?>"
                        id="label_<?php echo $name_; ?>"
                        class="parameters_label">
                      <input type="checkbox"
                             id="wd_shop_checkbox_parameter_<?php echo $name_ . $value_list['value']; ?>"
                             name="<?php echo $name_; ?>"
                             data-type="<?php echo $type_id; ?>"
                             value="<?php echo $value_list['value'] ?>"
                             onchange="onSelectableParameterChange(this, event)"
                             data-price="<?php echo $value_list['parameter_price']; ?>"
                             class="parameters_input wd_shop_parameter_checkbox" />
                      <?php echo $value_list['text'] ?>
                    </label>
                          <?php
                        }
                      }
                      break;
                  }
                  ?>
                </div>
              </div>
                <?php
              }
            }
            ?>
          </form>
        </div>
        <!-- order buttons -->
        <div class="wd_shop_products_order_btns_container col-sm-6" style="border-color: <?php echo $theme->divider_color; ?>">          
          <div class="col-sm-12 text-right wde_product_price_cont">
            <?php
            if ($theme->product_view_show_market_price == 1 && $product_row->market_price_text) {
              $info_divider = true;
              ?>			
            <span class="wd_shop_product_market_price"><?php echo $product_row->market_price_text; ?></span>
              <?php
            }
            ?>
            <?php
            if ($theme->product_view_show_price == 1 && $product_row->price_text) {
              $info_divider = true;
              ?>
            <span class="wd_shop_product_price wd_shop_product_price_text"><?php echo $product_row->price_text; ?></span>
              <?php
              if ($product_row->price_suffix) {
                ?>
            <span class="wd_shop_product_market_price wde_price_suffix"><?php echo $product_row->price_suffix; ?></span>
              <?php
              }
            }
            ?>
          </div>
          <!-- button buy now -->
          <?php
          if ($show_button_buy_now == true) {
            ?>
          <div class="btn-group btn-group-justified">
            <a href="<?php echo get_permalink($options->option_checkout_page); ?>"
               class="wd_shop_product_btn_checkout btn btn-default"
               onclick="wdShop_onBtnBuyNowClick(event, this); return false;">
              <?php _e('Buy now', 'wde'); ?>
            </a>
          </div>
            <?php
          }
          if (($show_button_buy_now == true) && ($show_button_add_to_cart == true)) {
            ?>
          <br />
            <?php
          }
          ?>
          <!-- button add to cart -->
          <?php
          if ($show_button_add_to_cart == true) {
            ?>
            <div class="btn-group btn-group-justified">
              <a class="wd_shop_product_btn_add_to_cart btn btn-primary"
                  data-toggle="tooltip"
                  data-html="true"
                  data-delay='{"show":"0", "hide":"2000"}'
                  title="<?php echo ($product_row->added_to_cart == 1 && $options->checkout_redirect_to_cart_after_adding_an_item == 2) ? __('Product already added to cart', 'wde') : ''; ?>" 
                  onclick="wdShop_onBtnAddToCartClick(event, this); return false;" 
                  <?php echo ($product_row->added_to_cart == 1 && $options->checkout_redirect_to_cart_after_adding_an_item == 2) ? 'disabled="disabled"' : ''; ?>>                      
                <span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;
                <?php _e('Add to cart', 'wde'); ?>
              </a>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
        <?php
      }
      if ($info_divider == true) {
        ?>
      <div class="wd_shop_order_data_additional_btns_divider wd_divider"></div>
        <?php
      }
      $info_divider = false;
      ?>
      <!-- additional buttons -->
      <div class="row">
        <div class="col-sm-12">
          <!-- button compare -->
          <?php
          if ($theme->product_view_show_button_compare == 1) {
              $info_divider = true;
              ?>
          <a href="<?php echo $product_row->compare_url; ?>" class="wd_shop_product_btn_compare btn btn-link btn-sm" data-id="<?php echo $product_row->id; ?>">
            <span class="glyphicon glyphicon-stats"></span> <?php _e('Compare', 'wde'); ?>
          </a>
            <?php
          }
          ?>
          <!-- button write review -->
          <?php
          if (FALSE/*($options->feedback_enable_product_reviews) && ($theme->product_view_show_button_write_review == 1)*/) {
            $info_divider = true;
            ?>
          <a href="<?php echo $product_row->write_review_url; ?>"
             class="wd_shop_product_btn_write_review btn btn-link btn-sm pull-right">
            <span class="glyphicon glyphicon-edit"></span> <?php _e('Write review', 'wde'); ?>
          </a>
            <?php
          }
          ?>
        </div>
      </div>
      <?php
      if ($info_divider == true) {
        ?>
      <div class="wd_shop_additional_btns_social_btns_divider wd_divider"></div>
        <?php
      }
      ?>
      <!-- social buttons -->
      <?php
      if ($theme->product_view_show_social_buttons == 1) {
        $show_button_fb = $options->social_media_integration_enable_fb_like_btn;
        $show_button_twitter = $options->social_media_integration_enable_twitter_tweet_btn;
        $show_button_gplus = $options->social_media_integration_enable_g_plus_btn;
        if (($show_button_fb == true) || ($show_button_twitter == true) || ($show_button_gplus == true)) {
          $main_data_divider = true;
          ?>
      <div class="row">
        <?php
        if ($show_button_fb == true) {
          ?>
        <div class="col-sm-4">
          <div class="wd_shop_product_social_btn">
            <?php echo WDFFb::like_button($product_row->url_absolute); ?>
          </div>
        </div>
          <?php
        }
        if ($show_button_twitter == true) {
          ?>
        <div class="col-sm-4">
          <div class="wd_shop_product_social_btn">
            <?php echo WDFTwitter::tweet_button($product_row->url_absolute); ?>
          </div>
        </div>
          <?php
        }
        if ($show_button_gplus == true) {
          ?>			
        <div class="col-sm-4">
          <div class="wd_shop_product_social_btn">
            <?php echo WDFGPlus::plus_button($product_row->url_absolute, array('annotation' => 'bubble')); ?>
          </div>
        </div>
          <?php
        }
        ?>
      </div>
          <?php
        }
      }
      ?>
    </div>
  </div>
  <?php
  if ($main_data_divider == true) {
    ?>
  <div class="wd_divider"></div>
    <?php
  }
  $main_data_divider = false;
  ?>
  <!-- tabs -->
  <?php
  $show_description = ($theme->product_view_show_description == 1) && ($product_row->description != '' || $product_row->videos ) ? true : false;
  $show_parameters = ($theme->product_view_show_parameters == 1) && (empty($product_row->parameters) == false) ? true : false;
  $show_shipping_info = ($product_row->enable_shipping == 1) && ($theme->product_view_show_shipping_info == 1) ? true : false;
  $show_reviews = ($options->feedback_enable_product_reviews) && ($theme->product_view_show_reviews == 1) ? true : false;

  $show_dimensions = ($product_row->weight || $product_row->dimensions) ? true : false;

  $has_tabs = true;

  $tab_head_description_active_class = '';
  $tab_head_parameters_active_class = '';
  $tab_head_shipping_info_active_class = '';
  $tab_head_reviews_active_class = '';

  $tab_content_description_active_class = '';
  $tab_content_parameters_active_class = '';
  $tab_content_shipping_info_active_class = '';
  $tab_content_reviews_active_class = '';

  if ($show_description == true) {
    $main_data_divider = true;
    $tab_head_description_active_class = 'active';
    $tab_content_description_active_class = 'active in';
  }
  else if ($show_parameters == true) {
    $main_data_divider = true;
    $tab_head_parameters_active_class = 'active';
    $tab_content_parameters_active_class = 'active in';
  }
  else if ($show_shipping_info == true) {
    $main_data_divider = true;
    $tab_head_shipping_info_active_class = 'active';
    $tab_content_shipping_info_active_class = 'active in';
  }
  else if ($show_reviews == true) {
    $main_data_divider = true;
    $tab_head_reviews_active_class = 'active';
    $tab_content_reviews_active_class = 'active in';
  }
  else {
    $has_tabs = false;
  }

  if ($has_tabs == true) {
    ?>
  <div class="row">
    <div class="col-sm-12">
      <!-- tabs heads -->
      <ul class="nav nav-tabs">
        <?php
        if ($show_description == true) {
          ?>
        <li class="<?php echo $tab_head_description_active_class; ?>">
          <a data-toggle="tab" href="#wd_shop_tab_content_product_description">
            <?php _e('Description', 'wde'); ?>
          </a>
        </li>
          <?php
        }
        if ($show_parameters == true) {
          ?>
        <li class="<?php echo $tab_head_parameters_active_class; ?>">
          <a data-toggle="tab" href="#wd_shop_tab_content_product_parameters">
            <?php _e('Parameters', 'wde'); ?>
          </a>
        </li>
          <?php
        }
        if ($show_shipping_info == true) {
          ?>
        <li class="<?php echo $tab_head_shipping_info_active_class; ?>">
          <a data-toggle="tab" href="#wd_shop_tab_content_product_shipping_info">
            <?php _e('Shipping info', 'wde'); ?>
          </a>
        </li>
          <?php
        }
        if ($show_reviews == true) {
          ?>
        <li class="<?php echo $tab_head_reviews_active_class; ?>">
          <a data-toggle="tab" href="#wd_shop_tab_content_product_reviews">
            <?php _e('Reviews', 'wde'); ?>
          </a>
        </li>
          <?php
        }
        ?>
      </ul>
      <!-- tabs content -->
      <div class="tab-content">
        <!-- description -->
        <?php
        if ($show_description == true) {
          ?>
        <div id="wd_shop_tab_content_product_description"
             class="wd_shop_product_description wd_shop_tab_content tab-pane fade <?php echo $tab_content_description_active_class; ?>">
          <div class="text-justify" itemprop="description">
            <?php echo $product_row->description; ?>
          </div>
          <div class="text-justify" itemprop="videos">
            <?php
            if (is_array($product_row->videos)) {
              foreach($product_row->videos as $video) {
                if ($video) {
                  ?>
                <video controls class="wd_shop_video">
                  <source src="<?php echo $video; ?>">  									
                </video>
                  <?php
                }
              }
            }
            ?>
          </div>
        </div>
          <?php
        }
        ?>
        <!-- parameters -->
        <?php
        if ($show_parameters == true) {
          ?>
        <div id="wd_shop_tab_content_product_parameters"
             class="wd_shop_tab_content tab-pane fade <?php echo $tab_content_parameters_active_class; ?>">
          <dl class="wd_shop_dl_parameters dl-horizontal">
            <?php
            if (is_array($product_row->parameters)) {
              foreach ($product_row->parameters as $parameter) {
                ?>
                <dt><?php echo $parameter->name; ?></dt>
                <dd><?php echo implode(' / ', $parameter->values); ?></dd>
                <?php
              }
            }
            ?>
          </dl>
        </div>
          <?php
        }
        ?>
        <!-- shipping info -->
        <?php
        if ($show_shipping_info == true) {
          ?>
        <div id="wd_shop_tab_content_product_shipping_info"
             class="wd_shop_tab_content tab-pane fade <?php echo $tab_content_shipping_info_active_class; ?>">
          <?php
          if ($show_dimensions == true) {
            ?>
          <div class="row">
            <?php
            if ($product_row->weight != '') {
              ?>
            <div class="col-sm-8">
              <span><?php _e('Weight', 'wde'); ?>:</span>
              <span><?php echo $product_row->weight . ' ' . $options->weight_unit; ?></span>
            </div>
              <?php
            }
            if ($product_row->dimensions != '') {
              ?>
            <div class="col-sm-8">
              <span><?php _e('Dimensions', 'wde'); ?>:</span>
              <span><?php echo $product_row->dimensions . ' ' . $options->dimensions_unit; ?></span>
            </div>
              <?php
            }
            ?>
          </div>						
          <div class="wd_divider"></div>
            <?php
          }
          if (is_array($product_row->shipping_methods)) {
            foreach ($product_row->shipping_methods as $shipping_method) {
              ?>
          <div class="wd_shop_shipping_info_row row">
            <div class="col-sm-8">
              <div><?php echo $shipping_method->name; ?>:</div>
              <small><?php echo $shipping_method->description; ?></small>
            </div>
            <div class="col-sm-4">
              <div><?php echo $shipping_method->price_text; ?></div>
            </div>
          </div>
              <?php
            }
          }
          else {
            ?>
          <div class="alert alert-info">
            <?php _e('No shipping specified for this product', 'wde'); ?>
          </div>
            <?php
          }
          ?>
        </div>
          <?php
        }
        ?>
        <!-- reviews -->
        <?php
        if ($show_reviews == true) {
          ?>
        <div id="wd_shop_tab_content_product_reviews"
             class="wd_shop_tab_content tab-pane fade <?php echo $tab_content_reviews_active_class; ?>">
          <?php
          if ($options->social_media_integration_use_fb_comments == 1) {
            ?>
          <div class="text-center">
            <?php
            echo WDFFb::comments($product_row->url_absolute, array('num_posts' => 3, 'color_scheme' => $options->social_media_integration_fb_color_scheme));
            ?>
          </div>
            <?php
          }
          else {
            if (TRUE/*get_comments_number($product_row->id)*/) {
              comments_template();
            }
            else {
              ?>
          <div class="row">
            <div class="col-sm-12">
              <div class="alert alert-info">
                <?php _e('No reviews yet', 'wde') ?>
              </div>
            </div>
          </div>
            <?php
            }
          }
          ?>
        </div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
    <?php
  }
  if ($main_data_divider == true) {
    ?>
  <div class="wd_divider"></div>
    <?php
  }
  ?>
  <!-- tags -->
  <?php
  if (($options->filter_tags == 1) && (empty($product_row->tags) == false)) {
    ?>
  <div class="row">
    <div class="col-sm-12">
      <form name="wd_shop_form_tags"
            action="<?php echo get_permalink($options->option_all_products_page); ?>"
            method="POST">
        <h4 class="wd_shop_header_sm">
          <?php _e('Tags', 'wde'); ?>
        </h4>
        <div class="wd_shop_tags_container well">
          <?php
          if (is_array($product_row->tags)) {
            foreach ($product_row->tags as $tag) {
              ?>
              <a href="#" class="wd_shop_tag" onclick="wdShop_onTagClick(event, this); return false;"
                 data-name="<?php echo $tag->name; ?>">
                <span class="label label-default"><?php echo $tag->name; ?></span>
              </a>
              <?php
            }
          }
          ?>
        </div>
        <input type="hidden" name="filter_tags" />
        <input type="hidden" name="filter_filters_opened" value="1" />
      </form>
    </div>
  </div>
  <div class="wd_divider"></div>
    <?php
  }
  ?>
  <!-- related products -->
  <?php
  if (($theme->product_view_show_related_products == 1) && (empty($product_row->related_products) == false)) {
    $main_data_divider = true;
    ?>
  <div class="row">
    <div class="col-sm-12">
      <h4 class="wd_shop_header_sm">
        <?php _e('Related products', 'wde'); ?>
      </h4>
      <div class="wd_shop_products_slider">
        <a class="wd_items_slider_btn_prev btn btn-link pull-left">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="wd_items_slider_btn_next btn btn-link pull-right">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
        <div class="wd_items_slider_mask">
          <ul class="wd_items_slider_items_list">
            <?php
            for ($i = 0; $i < count($product_row->related_products); $i++) {
              $related_product = $product_row->related_products[$i];
              if ($related_product->image != '') {
                $el_related_product_image = '<img src="' . $related_product->image . '">';
              }
              else {
                $el_related_product_image = '
                    <div class="wd_shop_product_related_product_no_image">
                        <span class="glyphicon glyphicon-picture"></span>
                        <br />
                        <span>' . __('No Image', 'wde') . '</span>
                    </div>';
              }
              ?>
              <li>
                <a class="wd_shop_product_related_product_container btn btn-link"
                   href="<?php echo $related_product->link; ?>"
                   title="<?php echo $related_product->name; ?>">
                  <div class="wd_shop_product_related_product_image_container wd_center_wrapper">
                    <div>
                      <?php echo $el_related_product_image; ?>
                    </div>
                  </div>
                  <div class="wd_shop_product_related_product_name text-center">
                    <?php echo $related_product->name; ?>
                  </div>
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
    <?php
  }
  ?>
</div>

<!-- images viewer modal -->
<?php
require WD_E_DIR . '/frontend/views/products/tmpl/displayproduct_imagesviewermodal.php';

WDFGPlus::render();

$selectable_parameter_array = array();
if (is_array($product_row->selectable_parameters)) {
  foreach ($product_row->selectable_parameters as $selectable_parameter) {
    if ($selectable_parameter->type_id != 1) {
      $selectable_parameter_array[$selectable_parameter->name] = 0;
    }
  }
}
$selectable_parameter_json = json_encode($selectable_parameter_array);
?>
<script>
  var WD_SHOP_TEXT_ALREADY_ADDED_TO_CART = "<?php _e('Product already added to cart', 'wde'); ?>";
  var WD_SHOP_TEXT_PLEASE_WAIT = "<?php _e('Please wait', 'wde'); ?>";

  var wdShop_redirectToCart = <?php echo $options->checkout_redirect_to_cart_after_adding_an_item == 1 ? 'true' : 'false'; ?>;
	var wdShop_minicart = "";
  var wdShop_minicart_js_path = "";
	var wdShop_urlAddToShoppingCart = "<?php echo add_query_arg(array('action' => 'wde_AddToShoppingCart', 'type' => 'shoppingcart', 'task' => 'add'), admin_url('admin-ajax.php')); ?>";
  var wdShop_urlDisplayShoppingCart = "";
	var wdShop_amount_in_stock = "<?php echo $product_row->amount_in_stock; ?>";
	var wdShop_product_unlimited = "<?php echo $product_row->unlimited; ?>";
	var wdShop_currency_code = "<?php echo $row_default_currency->sign; ?>";
	var wdShop_currency_position = "<?php echo $row_default_currency->sign_position; ?>";
  
  var parameters_price = JSON.parse("<?php echo addslashes($selectable_parameter_json); ?>");
  var product_price = "<?php echo $product_row->price_without_t_d; ?>";
  var tax_rate = "<?php echo $product_row->tax_rate; ?>";
  var discount_rate = "<?php echo $product_row->discount_rate; ?>";
  var option_include_discount_in_price = "<?php echo $options->option_include_discount_in_price; ?>";
  var option_include_tax_in_price = "<?php echo $options->option_include_tax_in_price; ?>";
	var option_redirect_to_cart_after_adding_an_item = "<?php echo $options->checkout_redirect_to_cart_after_adding_an_item; ?>";
	var decimals = "<?php echo $options->option_show_decimals == 1 ? 2 : 0; ?>";
</script>