<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;
$theme = $this->theme;

$lists = $this->lists;
$list_products = $lists['products'];

$product_row = $this->row_product;
$required_parameters = $this->required_parameters;
?>
<div class="container">
  <!-- header -->
  <h2 class="wd_shop_header">
    <?php _e('Compare products', 'wde'); ?>
  </h2>
  <div class="row">
    <div class="col-sm-12">
      <table class="wd_shop_table_product_data table table-responsive">
        <!-- info -->
        <tbody>
          <!-- image -->
          <tr class="wd_shop_row_image">
            <td class="wd_shop_col_key" rowspan="3">
            </td>
            <td class="wd_shop_col_value">
              <div class="wd_shop_product_image_container wd_center_wrapper">
                <div>
                  <?php 
                  if ($product_row->image != '') {
                    ?>
                    <img class="wd_shop_product_image" src="<?php echo $product_row->image; ?>" />
                    <?php
                  }
                  else {
                    ?>
                    <div class="wd_shop_product_no_image">
                      <span class="glyphicon glyphicon-picture"></span>
                      <br />
                      <span><?php _e('No Image', 'wde'); ?></span>
                    </div>
                    <?php
                  }
                  ?>
                </div>
              </div>
            </td>
            <td class="wd_shop_col_compare_product wd_shop_col_value">
              <div class="wd_shop_product_image_container wd_center_wrapper">
                <div>
                  <img class="wd_shop_product_image img-responsive" src="" />
                  <div class="wd_shop_product_no_image">
                    <span class="glyphicon glyphicon-picture"></span>
                    <br />
                    <span><?php _e('No Image', 'wde'); ?></span>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <!-- name -->
          <tr class="wd_shop_row_name">
            <td class="wd_shop_col_value">
              <a href="<?php echo $product_row->url ?>" class="wd_shop_product_name btn btn-link">
                <?php echo $product_row->name; ?>
              </a>
            </td>
            <td class="wd_shop_col_compare_product wd_shop_col_value">
              <?php echo WDFHTML::wd_select('compare_product_id', $list_products, 'id', 'name', '', 'class="wd_shop_product_name form-control" onchange="wdShop_onCompareProductChange(event, this)"'); ?>
            </td>
          </tr>
          <!-- price -->
          <tr class="wd_shop_row_price">
            <td class="wd_shop_col_value">
              <span class="wd_shop_product_price"><?php echo $product_row->price_text; ?></span>
            </td>
            <td class="wd_shop_col_compare_product wd_shop_col_value">
              <span class="wd_shop_product_price"></span>
            </td>
          </tr>
          <!-- manufacturer -->
          <tr class="wd_shop_row_manufacturer">
            <td class="wd_shop_col_key">
              <h5><?php _e('Manufacturer', 'wde') ?></h5>
            </td>
            <td class="wd_shop_col_value">
              <span class="wd_shop_product_manufacturer_name">
                <?php echo $product_row->manufacturer_name; ?>
              </span>
              <?php
              if ($product_row->manufacturer_logo != '') {
                ?>
                <img class="wd_shop_product_manufacturer_logo" src="<?php echo $product_row->manufacturer_logo; ?>" alt="" />
                <?php
              }
              ?>
            </td>
            <td class="wd_shop_col_compare_product wd_shop_col_value">
              <span class="wd_shop_product_manufacturer_name"></span>
              <img class="wd_shop_product_manufacturer_logo" src="" alt="">
            </td>
          </tr>
          <!-- rating -->
          <?php
          if ($options->feedback_enable_product_rating == 1) {
            ?>
          <tr class="wd_shop_row_rating">
            <td class="wd_shop_col_key">
              <h5><?php _e('Rating', 'wde') ?></h5>
            </td>
            <td class="wd_shop_col_value">
              <?php
              echo WDFHTML::jf_bs_rater('', 'wd_shop_product_star_rater', '', $product_row->rating, false, $product_row->rating_url, '', false, 5, ($theme->rating_star_font_size ? $theme->rating_star_font_size : '16px'), $theme->rating_star_type, $theme->rating_star_color, $theme->rating_star_bg_color);
              ?>
            </td>
            <td class="wd_shop_col_compare_product wd_shop_col_value">
              <?php
              echo WDFHTML::jf_bs_rater('', 'wd_shop_product_star_rater', '', 0, false, '', '', false, 5, ($theme->rating_star_font_size ? $theme->rating_star_font_size : '16px'), $theme->rating_star_type, $theme->rating_star_color, $theme->rating_star_bg_color);
              ?>
            </td>
          </tr>
            <?php
          }
          ?>
        </tbody>
        <!-- parameters -->
        <tbody>
          <?php
          if (is_array($required_parameters)) {
            foreach ($required_parameters as $parameter_id => $required_parameter) {
              ?>
          <tr class="wd_shop_row_parameter" parameter_id="<?php echo $required_parameter->id; ?>">
            <td class="wd_shop_col_key">
              <h5><?php echo $required_parameter->name; ?></h5>
            </td>
            <td class="wd_shop_col_value">
              <span class="wd_shop_product_parameter_value">
                <?php
                // if (isset($product_parameters[$parameter_id])) {
                  // $product_parameter = $product_parameters[$parameter_id];
                  echo implode(' / ', $required_parameter->values);
                // }
                ?>
              </span>
            </td>
            <td class="wd_shop_col_compare_product wd_shop_col_value">
              <span class="wd_shop_product_parameter_value"></span>
            </td>
          </tr>
              <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
  var wdShop_urlGetCompareProduct = "<?php echo add_query_arg(array('task' => 'ajax_getcompareproductrow'), $product_row->url_absolute); ?>";
	var wdShop_root_url = "";
</script>