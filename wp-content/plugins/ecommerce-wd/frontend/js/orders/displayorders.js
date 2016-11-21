jQuery(document).ready(function () {
  jQuery(window).on("resize", wdShop_onWindowResize);
  handleBootstrapEnvironmentChange();
});

function handleBootstrapEnvironmentChange() {
  var bsEnvironment = wdShop_getBootstrapEnvironment();
  jQuery(".wd_shop_order_container").off("mouseenter");
  jQuery(".wd_shop_order_container").off("mouseleave");
  switch (bsEnvironment) {
    case 'xs':
    case 'sm':
      jQuery('.wd_shop_order_container .panel-footer').stop(true, true).slideDown(0);
      break;
    case 'md':
    case 'lg':
      jQuery(".wd_shop_order_container .panel-footer").stop(true, true).slideUp(0);
      jQuery(".wd_shop_order_container").on("mouseenter", function () {
        jQuery(this).find(".panel-footer").stop(true, true).slideDown(150);
      });
      jQuery(".wd_shop_order_container").on("mouseleave", function () {
        jQuery(this).find(".panel-footer").stop(true, true).slideUp(150);
      });
      break;
  }
}

function wdShop_onWindowResize() {
  handleBootstrapEnvironmentChange();
}

// Pagination bar.
function wdShop_formPagination_onPageClick(event, obj, limitStart) {
  var jq_btn = jQuery(obj);
  if ((jq_btn.parent().hasClass("disabled")) || (jq_btn.parent().hasClass("active"))) {
    return false;
  }
  wdShop_mainForm_set("pagination_limit_start", limitStart);
  wdShop_mainForm_submit();
}

function wdShop_formPagination_onItemsPerPageChange(event, obj) {
  wdShop_mainForm_set("pagination_limit_start", 0);
  var limit = jQuery("form[name=wd_shop_form_pagination] select[name=items_per_page] option:selected").val();
  wdShop_mainForm_set("pagination_limit", limit);
  wdShop_mainForm_submit();
}