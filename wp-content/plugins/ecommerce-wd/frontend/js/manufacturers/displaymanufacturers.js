 /**
 * package E-Commerce WD
 * author Web-Dorado
 * copyright (C) 2014 Web-Dorado. All rights reserved.
 * license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

// Pagination bar.
function wdShop_formPagination_onPageClick(event, obj, limitStart) {
  var jq_btn = jQuery(obj);
  if ((jq_btn.parent().hasClass("disabled")) || (jq_btn.parent().hasClass("active"))) {
    return false;
  }
  wdShop_mainForm_set('pagination_limit_start', limitStart);
  wdShop_mainForm_setAction("");
  wdShop_mainForm_submit();
}

function wdShop_formPagination_onItemsPerPageChange(event, obj) {
  wdShop_mainForm_set('pagination_limit_start', 0);
  var limit = jQuery("form[name=wd_shop_form_pagination] select[name=items_per_page] option:selected").val();
  wdShop_mainForm_set('pagination_limit', limit);
  wdShop_mainForm_setAction("");
  wdShop_mainForm_submit();
}

// Search bar.
function wdShop_formSearch_fillData() {	
  var searchName = jQuery("form[name=wd_shop_form_search] input[name=search_name]").val();
  wdShop_mainForm_set("search_name", searchName);
  var searchCategoryId = jQuery("form[name=wd_shop_form_search] select[name=search_category_id] option:selected").val();
  wdShop_mainForm_set("search_category_id", searchCategoryId);
}

function wdShop_formSearch_onBtnToggleFiltersClick(event, obj) {
  // check filters bar
  var jq_barFilters = jQuery(".wd_shop_bar_filters");
  if (jq_barFilters.length == 0) {
    return;
  }
  var jq_btn = jQuery(obj);
  if (jq_btn.hasClass("active") == true) {
    jq_btn.removeClass("active");
    wdShop_mainForm_set("filter_filters_opened", 0);
    jq_barFilters.slideUp(250);
  }
  else {
    jq_btn.addClass("active");
    wdShop_mainForm_set("filter_filters_opened", 1);
    jq_barFilters.slideDown(250);
  }
}

function wdShop_formSearch__onInputSearchKeyPress(event, obj) {
  var keyCode = (event.keyCode ? event.keyCode : event.which);
  if (keyCode == 13) {
    wdShop_formSearch_fillData();
    wdShop_mainForm_set("pagination_limit_start", 0);
    wdShop_mainForm_submit();
    event.preventDefault();
    return false;
  }
}

function wdShop_formSearch_onBtnSearchClick(event, obj) {
  wdShop_formSearch_fillData();
  wdShop_mainForm_set("pagination_limit_start", 0);
  wdShop_mainForm_submit();
}