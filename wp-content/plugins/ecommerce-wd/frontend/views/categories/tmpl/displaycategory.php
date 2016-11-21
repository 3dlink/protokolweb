<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_items_slider');
wp_enqueue_script('wde_' . $this->_layout);
wp_enqueue_style('wde_' . $this->_layout);

$options = $this->options;

$row = $this->row;

$path_categories = $row->path_categories;
$subcategories = $row->subcategories;
$products = $row->products;
?>
<form name="wd_shop_main_form" action="<?php echo get_permalink($options->option_all_products_page); ?>" method="POST">
  <input type="hidden" name="search_category_id" value="<?php echo $row->id; ?>">
</form>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php
      require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php';
      ?>
    </div>
  </div>
  <?php
  if ( $row->show_tree == 1 ) {
    ?>
	<ul class="breadcrumb">
		<?php
		foreach ($path_categories AS $path_category) {
			?>
			<li>
				<?php
				if ($path_category->is_active == true) {
					?>
					<a href="<?php echo $path_category->url; ?>" class="btn-link">
						<?php echo $path_category->name; ?>
					</a>
				<?php
				}
        else {
					echo $path_category->name;
				}
				?>
			</li>
		<?php
		}
		?>
	</ul>
    <?php
  }
  ?>
  <h1 class="wd_shop_category_name wd_shop_header">
    <?php echo $row->name; ?>
  </h1>
  <?php
  if ($row->show_info == 1 && $row->id != 0 ) {
    ?>
  <div class="row">
    <div class="col-sm-5">
      <div class="wd_shop_category_image_container wd_center_wrapper img-thumbnail">
        <div>
          <?php
          if ($row->image != '') {
            ?>
            <img class="wd_shop_category_image" src="<?php echo $row->image; ?>" alt="<?php echo $row->name; ?>" title="<?php echo $row->name; ?>" />
            <?php
          }
          else {
            ?>
            <div class="wd_shop_category_no_image">
              <span class="glyphicon glyphicon-picture"></span><br />
              <span><?php _e('No Image', 'wde'); ?></span>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
    <div class="wd_shop_category_description col-sm-7">
      <p class="text-justify">
        <?php echo $row->description; ?>
      </p>
    </div>
  </div>
    <?php
  }
  if (($row->show_info == 1) && (($row->show_products == 1) || ($row->show_subcategories == 1 || $row->id == 0 ))) {
    ?>
    <div class="wd_divider"></div>
    <?php
  }
  if ($row->show_products == 1) {
    ?>
    <div class="row">
        <div class="col-sm-12">
            <h4 class="wd_shop_header_sm">
                <?php _e('Products', 'wde'); ?>
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
                        for ($i = 0; $i < count($products); $i++) {
                            $product = $products[$i];
                            if ($product->image != '') {
                                $el_category_product_image = '<img src="' . $product->image . '">';
                            } else {
                                $el_category_product_image = '
                                    <div class="wd_shop_product_no_image">
                                        <span class="glyphicon glyphicon-picture"></span>
                                        <br>
                                        <span>' . __('No Image', 'wde') . '</span>
                                    </div>
                                    ';
                            }
                            ?>
                            <li>
                                <a class="wd_shop_product_container btn btn-link"
                                   href="<?php echo $product->url; ?>"
                                   title="<?php echo $product->name; ?>">
                                    <div class="wd_shop_product_image_container wd_center_wrapper">
                                        <div>
                                            <?php echo $el_category_product_image; ?>
                                        </div>
                                    </div>
                                    <div class="wd_shop_product_link_name text-center">
                                        <?php echo $product->name; ?>
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
    if ($options->search_by_category == 1) {
      ?>
    <div class="row">
      <div class="col-sm-12 text-center">
        <a class="btn btn-primary" href="<?php echo get_permalink($options->option_all_products_page); ?>" onclick="wdShop_mainForm_submit(); return false;">
          <?php _e('View all products', 'wde'); ?>
        </a>
      </div>
    </div>
      <?php
    }
    ?>
    <?php
  }
  if (($row->show_products == 1) && ($row->show_subcategories == 1 || $row->id == 0)) {
    ?>
    <div class="wd_divider"></div>
    <?php
  }
  if ($row->show_subcategories || $row->id == 0) {
    switch ($row->subcategories_cols) {
      case 1:
        $category_subcategory_col_class = 'col-md-3 col-sm-4 col-xs-12';
        break;
      case 2:
        $category_subcategory_col_class = 'col-md-4 col-sm-6 col-xs-12';
        break;
      case 3:
        $category_subcategory_col_class = 'col-md-6 col-sm-12 col-xs-12';
        break;
    }
    ?>
    <h4 class="wd_shop_header_sm">
      <?php _e('Subcategories', 'wde'); ?>
    </h4>
    <div class="row">
      <?php
      foreach ($subcategories as $subcategory) {
        ?>
        <div class="<?php echo $category_subcategory_col_class; ?>">
          <div class="wd_shop_panel_product wd_shop_subcategory_container panel panel-default">
            <div class="panel-body">
              <a class="btn btn-link" href="<?php echo $subcategory->url; ?>" title="<?php echo $subcategory->name; ?>">
                <div class="wd_shop_subcategory_image_container wd_center_wrapper">
                  <?php
                  if ($subcategory->images != '') {
                    ?>
                    <div>
                      <img src="<?php echo $subcategory->images; ?>" class="wd_align_center_block img-responsive" alt="<?php echo $subcategory->name; ?>" title="<?php echo $subcategory->name; ?>" />
                    </div>
                    <?php
                  }
                  else {
                      ?>
                      <div class="wd_shop_subcategory_no_image ">
                          <span class="glyphicon glyphicon-picture"></span>
                          <br>
                          <span><?php _e('No Image', 'wde'); ?></span>
                      </div>
                  <?php } ?>
                </div>
                <div class="wd_shop_subcategory_name">
                  <?php echo $subcategory->name; ?>
                </div>
              </a>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
    <?php
  }
?>
</div>