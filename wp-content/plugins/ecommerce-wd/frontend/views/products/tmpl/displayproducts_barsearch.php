<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout . '_barsearch');
wp_enqueue_style('wde_' . $this->_layout . '_barsearch');

$options = $this->options;
$theme = $this->theme;

$show_filters = ($options->filter_manufacturers == 1) || ($options->filter_price == 1) || ($options->filter_date_added == 1) || ($options->filter_minimum_rating == 1) || ($options->filter_tags == 1) ? true : false;

$categories_list = $this->search_categories_list;
$search_data = $this->search_data;
$filters_data = $this->filters_data;

if ($options->search_enable_search == 1) {
    ?>
    <div class="wd_shop_bar_search row">
        <div class="col-md-12">
            <!-- search form -->
            <form name="wd_shop_form_search" role="search" action="" method="POST">
                <div class="wd_input_group">
                    <ul>
                        <?php
                        if ($options->search_by_category == 1) {
                            ?>
                            <!-- category -->
                            <li class="wd_shop_bar_search_search_category_id_container wd_input_group_input">
                                <?php echo wp_dropdown_categories($categories_list); ?>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- name -->
                        <li class="wd_shop_bar_search_search_name_container wd_input_group_input">
                            <input type="text" name="search_name" class="form-control"
                                   placeholder="<?php _e('Name', 'wde'); ?>"
                                   value="<?php echo $search_data['name']; ?>"
                                   onkeypress="wdShop_formSearch__onInputSearchKeyPress(event, this);">
                        </li>

                        <?php
                        // if filters on top
                        if (($theme->products_filters_position == 1) && ($show_filters == true)) {
                            ?>
                            <!-- filters toggle button -->
                            <li class="wd_input_group_btn">
                                <a class="wd_shop_bar_search_btn_toggle_filters btn btn-primary <?php echo $filters_data["filters_opened"] == 1 ? 'active' : ''; ?>"
                                   onclick="wdShop_formSearch_onBtnToggleFiltersClick(event, this); return false;">
                                    &nbsp;<span class="wd_shop_bar_search_btn_toggle_filters_icon caret"></span>&nbsp;
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <!-- search button -->
                        <li class="wd_input_group_btn">
                            <a class="btn btn-primary"
                               onclick="wdShop_formSearch_onBtnSearchClick(event, this); return false;">
                                <span class="wd_shop_bar_search_btn_search_icon">&nbsp;<span
                                        class="glyphicon glyphicon-search"></span>&nbsp;</span>
                                <span
                                    class="wd_shop_bar_search_btn_search_text"><?php _e('Go', 'wde'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
<?php
}