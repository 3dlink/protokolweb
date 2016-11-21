<?php

defined('ABSPATH') || die('Access Denied');

$options = $this->options;
$theme = $this->theme;

$categories_list = $this->search_categories_list;
$search_data = $this->search_data;

?>
<div class="wd_shop_bar_search row">
  <div class="col-md-12">
    <form name="wd_shop_form_search" role="search" action="" method="POST">
      <div class="wd_input_group">
        <ul>
          <li class="wd_shop_bar_search_search_name_container wd_input_group_input">
            <input type="text" name="search_name" class="form-control"
                   placeholder="<?php _e('Name', 'wde'); ?>"
                   value="<?php echo $search_data['name']; ?>"
                   onkeypress="wdShop_formSearch__onInputSearchKeyPress(event, this);">
          </li>
          <li class="wd_input_group_btn">
            <a class="btn btn-primary"
               onclick="wdShop_formSearch_onBtnSearchClick(event, this); return false;">
                <span class="wd_shop_bar_search_btn_search_icon">&nbsp;<span
                        class="glyphicon glyphicon-search"></span>&nbsp;</span>
                <span class="wd_shop_bar_search_btn_search_text"><?php _e('Go', 'wde'); ?></span>
            </a>
          </li>
        </ul>
      </div>
    </form>
  </div>
</div>