jQuery(document).ready(function () {
  wde_add_tooltip();
});

function wde_add_tooltip() {
  jQuery(".wd_shop_order_product_final_price_info").tooltip({container: ".wd_shop_tooltip_container", "html": true});
}

function wde_display_confirm_order(that) {
  var main_form = jQuery(".wd_shop_order_product_container");
  var post_data = {};
  main_form.each(function () {
    var product_id = jQuery(this).attr("data-porduct-id");
    var order_id = jQuery(this).attr("data-order-id");
    post_data["product_shipping_method_id_" + product_id + "_" + order_id] = jQuery(this).find("input[name='product_shipping_method_id_" + product_id + "_" + order_id + "']:checked").val();
  });
  var jq_loadingClipContainer = jQuery(that).parents(".wd_shop_order_product_container").find(".wd_shop_loading_clip_container");
  var jq_alertFailContainer = jQuery(that).parents(".wd_shop_order_product_container").find(".wd_shop_alert_failed_to_update_container");
  jq_loadingClipContainer
      .stop(true)
      .slideUp(250);
  jq_alertFailContainer.find(".alert").html("");
  jq_alertFailContainer
      .stop(true)
      .slideUp(250);
  jQuery.ajax({
    type: "POST",
    url: window.location,
    data: post_data,
    beforeSend: function () {
      jq_loadingClipContainer
          .stop(true)
          .slideDown(250);
    },
    complete: function () {
      jq_loadingClipContainer
          .stop(true)
          .slideUp(250);
    },
    success: function (result) {
      var content = jQuery(result).find("form[name='wd_shop_main_form']").html();
      jQuery("form[name='wd_shop_main_form']").html(content);
      wde_add_tooltip();
    },
    failure: function (errorMsg) {
      console.log(errorMsg);
    }
  });
}

function onWDShop_pagerBtnClick(event, obj) {
  wdShop_mainForm_setAction(jQuery(obj).attr("href"));
  wdShop_mainForm_submit();
}

function wdShop_onBtnCheckoutClick(event, obj) {
  wdShop_mainForm_setAction(jQuery(obj).attr("href"));
  wdShop_mainForm_submit();
}