var wdShop_starRaters;

jQuery(document).ready(function () {
  jQuery("[data-toggle=tooltip]").not(".modal [data-toggle=tooltip]").tooltip({container: ".wd_shop_tooltip_container"});
  wdShop_starRaters = {};
  jQuery(".wd_shop_star_rater").each(function () {
    var productId = parseInt(jQuery(this).closest(".wd_shop_product").attr("product_id"));
    wdShop_starRaters[productId] = new WdBsStarRater(jQuery(this));
  });	
});

function wdShop_onBtnQuickViewClick(event, obj) {
  wdShopQuickViewProductIndex = jQuery(".wd_shop_product").index(jQuery(obj).closest(".wd_shop_product"));
  jQuery('#wd_shop_product_quick_view').modal();
}

function wdShop_onBtnBuyNowClick(event, obj) {
  var productId = jQuery(obj).closest(".wd_shop_product").attr("product_id");
  var count = 1;
  var parameters = {};

  wdShop_mainForm_set("product_id", productId);
  wdShop_mainForm_set("product_count", count);
  wdShop_mainForm_set("product_parameters_json", JSON.stringify(parameters));

  wdShop_mainForm_setAction(jQuery(obj).attr("href"));
  wdShop_mainForm_submit();
}

function wdShop_onBtnAddToCartClick(event, obj) {
  var jq_btn = jQuery(obj);
  if (option_redirect_to_cart_after_adding_an_item == 2) {
    if ((jq_btn.attr("disabled") != undefined) || (jq_btn.hasClass("disabled"))) {
      return false;
    }	
    jq_btn.addClass("disabled");
  }
  jq_btn.attr("data-original-title", WD_SHOP_TEXT_PLEASE_WAIT);
  jq_btn.tooltip("show");

  var productId = jq_btn.closest(".wd_shop_product").attr("product_id");
  var count = 1;
  var parameters = {};
  var product_parameters_array = products_parameters;
  var parameters_objects = product_parameters_array[productId];
  for (var key in parameters_objects) {
    var id = parameters_objects[key]['id'];
    var value;
    var type_id = parameters_objects[key]['type_id'];
    if (id) {
      switch (type_id) {
        // Input field
        case '1':
        // Radio
        case '4':
          value = '';
          break;
        // Select
        case '3':
          value = '0';
          break;
        // Checkbox
        case '5':
          value = [];
          break;
      }
    }
    if(id) {
        parameters[id] = value;
    }
  }

  jQuery.ajax({
    type: "POST",
    url: wdShop_urlAddToShoppingCart,
    data: {
      "product_id": productId,
      "product_count": count,
      "product_parameters_json": JSON.stringify(parameters)
    },
    complete: function () {
    },
    success: function (result) {
      var data = JSON.parse(result);
      jq_btn.attr("data-original-title", data["msg"]);
      jq_btn.tooltip("show");
      if (typeof wdShop_updateProductsInCart == 'function') {
        wdShop_updateProductsInCart(data['products_in_cart']);
      }
      if ((data.product_added == true) && (wdShop_redirectToCart == true)) {
        wdShop_mainForm_setAction(wdShop_urlDisplayShoppingCart);
        wdShop_mainForm_submit();
      }
      if ( jQuery(".minicart_module_container").length > 0 ) {
        if (typeof wdef_load == 'function') { 
          wdef_load(window.location, 'minicart_module_container');
        }
      }
    },
    failure: function (errorMsg) {
      alert(errorMsg);
    }
  });
}