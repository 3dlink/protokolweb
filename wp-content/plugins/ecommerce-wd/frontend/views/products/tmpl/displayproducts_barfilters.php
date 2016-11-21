<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout . '_barfilters');
wp_enqueue_style('wde_' . $this->_layout . '_barfilters');

$options = $this->options;
$theme = $this->theme;

$row_default_currency = $this->row_default_currency;

$manufacturer_rows = $this->filter_manufacturer_rows;
$date_added_ranges = $this->filter_date_added_ranges;
$products_min_price = $this->filter_products_min_price;
$products_max_price = $this->filter_products_max_price;
$filters_data = $this->filters_data;

// if filters on top and closed
$filters_bar_class_hidden = '';
if (($theme->products_filters_position == 1) && ($filters_data['filters_opened'] != 1)) {
    $filters_bar_class_hidden = 'wd_hidden';
}

// determine filters col class
if ($theme->products_filters_position == 1) {
    $filters_col_class = 'col-sm-4 col-xs-12';
} else {
    $filters_col_class = 'col-sm-12';
}

// determine filters autoupdate
$filters_auto_update = $theme->products_filters_position == 1 ? false : true;


if ($options->search_enable_search == 1) {
    ?>
    <div class="wd_shop_bar_filters row <?php echo $filters_bar_class_hidden; ?>">
    <div class="col-sm-12">
    <!-- filters form -->
    <form name="wd_shop_form_filters" class="form-horizontal" action="" method="POST">
    <div class="row">
        <!-- manufacturers -->
        <?php
        if ($options->filter_manufacturers == 1) {
            ?>
            <div class="<?php echo $filters_col_class; ?>">
                <fieldset>
                    <h5 class="wd_shop_header_sm"><?php _e('Manufacturers', 'wde') ?></h5>

                    <ul>
                        <?php
                        for ($i = 0; $i < count($manufacturer_rows); $i++) {
                            $manufacturer_row = $manufacturer_rows[$i];
                            $checked = in_array($manufacturer_row->id, $filters_data['manufacturer_ids']) == true ? 'checked="checked"' : '';
                            ?>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                               name="filter_manufacturer_id_<?php echo $i; ?>"
                                               value="<?php echo $manufacturer_row->id; ?>"
                                               onchange="wdShop_formFilters_onManufacturerChange(event, this);"
                                            <?php echo $checked; ?>>
                                        <span><?php echo $manufacturer_row->name; ?></span>
                                    </label>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </fieldset>
            </div>
        <?php
        }
        ?>

        <!-- price -->
        <?php
        if ($options->filter_price == 1) {
            ?>
            <div class="<?php echo $filters_col_class; ?>">
                <fieldset>
                    <h5 class="wd_shop_header_sm"><?php _e('Price', 'wde') ?></h5>

                    <div class="form-group">
                        <label for="wd_shop_bar_filters_filter_price_from" class="col-sm-5 control-label">
                            <?php _e('Price from', 'wde') . '&nbsp;(' . $row_default_currency->sign . ')'; ?>:
                        </label>

                        <div class="col-sm-7">
                            <input type="text"
                                   name="filter_price_from"
                                   id="wd_shop_bar_filters_filter_price_from"
                                   class="form-control wd-input-xs"
                                   value="<?php echo $filters_data['price_from']; ?>"
                                   placeholder="<?php echo $products_min_price; ?>"
                                   onkeydown="return wdShop_disableEnterKey(event);">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="wd_shop_bar_filters_filter_price_to" class="col-sm-5 control-label">
                            <?php _e('Price to', 'wde') . '&nbsp;(' . $row_default_currency->sign . ')'; ?>:
                        </label>

                        <div class="col-sm-7">
                            <input type="text"
                                   name="filter_price_to"
                                   id="wd_shop_bar_filters_filter_price_to"
                                   class="form-control wd-input-xs"
                                   value="<?php echo $filters_data['price_to']; ?>"
                                   placeholder="<?php echo $products_max_price; ?>"
                                   onkeydown="return wdShop_disableEnterKey(event);">
                        </div>
                    </div>

                    <?php
                    if ($filters_auto_update == true) {
                        ?>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <a class="btn btn-default btn-xs"
                                   onclick="wdShop_formFilters_onBtnUpdatePricesClick(event, this); return false;">
                                    <?php _e('Update filters', 'wde'); ?>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </fieldset>
            </div>
        <?php
        }
        ?>

        <!-- date added -->
        <?php
        if ($options->filter_date_added == 1) {
            ?>
            <div class="<?php echo $filters_col_class; ?>">
                <fieldset>
                    <h5 class="wd_shop_header_sm"><?php _e('Date Added', 'wde') ?></h5>

                    <ul>
                        <?php
                        if (is_array($date_added_ranges)) {
                          foreach ($date_added_ranges as $value => $date_added_range_name) {
                              $checked = $filters_data['date_added_range'] == $value ? 'checked="checked"' : '';
                              ?>
                              <li>
                                  <div class="radio">
                                      <label>
                                          <input type="radio"
                                                 name="filter_date_added_range"
                                                 value="<?php echo $value; ?>"
                                              <?php echo $checked; ?>
                                                 onchange="wdShop_formFilters_onDateAddedRangeChange(event, this);">
                                          <span><?php echo $date_added_range_name; ?></span>
                                      </label>
                                  </div>
                              </li>
                          <?php
                          }
                        }
                        ?>
                    </ul>
                </fieldset>
            </div>
        <?php
        }
        ?>

        <!-- minimum rating -->
        <?php
        if (($options->feedback_enable_product_rating == 1) && ($options->filter_minimum_rating == 1)) {
            ?>
            <div class="<?php echo $filters_col_class; ?>">
                <fieldset>
                    <h5 class="wd_shop_header_sm"><?php _e('Filter by minimum rating', 'wde') ?></h5>

                    <ul>
                        <?php
                        for ($i = 0; $i <= 5; $i++) {
                            $checked = $i == $filters_data['minimum_rating'] ? 'checked="checked"' : '';
                            ?>
                            <li>
                                <div class="radio">
                                    <label>
                                        <input type="radio"
                                               name="filter_minimum_rating"
                                               value="<?php echo $i; ?>"
                                            <?php echo $checked; ?>
                                               onchange="wdShop_formFilters_onMinimumRatingChange(event, this);">
                                        <?php
                                        echo WDFHTML::jf_bs_rater('', 'wd_shop_star_rater', '', $i, false, '', '', true, 5, ($theme->rating_star_font_size ? $theme->rating_star_font_size : '14px'), $theme->rating_star_type, $theme->rating_star_color, $theme->rating_star_bg_color);
                                        ?>
                                    </label>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </fieldset>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- tags -->
    <?php
    if ($options->filter_tags == 1) {
        ?>
        <div class="row">
            <div class="col-sm-12">
                <fieldset>
                    <h5 class="wd_shop_header_sm"><?php _e('Tags separated by comma', 'wde') ?></h5>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea name="filter_tags"
                                      class="form-control"
                                      onkeydown="return wdShop_disableEnterKey(event);"
                                      onblur="wdShop_formFilters_onTagsChange(event, this);"><?php echo implode(', ', $filters_data['tags']); ?></textarea>
                        </div>
                    </div>

                    <?php
                    if ($filters_auto_update == true) {
                        ?>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <a class="btn btn-default btn-xs"
                                   onclick="wdShop_formFilters_onBtnUpdateTagsClick(event, this); return false;">
                                    <?php _e('Update filters', 'wde'); ?>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </fieldset>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    if ($filters_auto_update == true) {
        ?>
        <div class="row">
            <div class="col-sm-12 text-right">
                <a class="btn btn-default btn-sm"
                   onclick="wdShop_formFilters_onBtnResetClick(event, this); return false;">
                    <?php _e('Reset', 'wde'); ?>
                </a>
            </div>
        </div>
    <?php
    }
    ?>
    </form>
    </div>
    </div>
<?php
}