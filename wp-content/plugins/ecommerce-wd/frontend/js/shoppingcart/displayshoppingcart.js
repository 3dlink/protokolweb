var wdShop_orderProductCurrentCount;
var wdShop_orderProductRequestsMap;
var wdShop_checkoutProductAfterUpdate;

jQuery(document).ready(function () {
  wde_add_tooltip();

  wdShop_orderProductRequestsMap = {};
  wdShop_checkoutProductAfterUpdate = -1;

  jQuery(window).on("resize", wdShop_onWindowResize);

  handleBootstrapEnvironmentChange();
  jQuery(".wd_shop_order_product_container").each(function () {
    wdShop_updateOrderProduct(jQuery(this));
  });
});

function wde_add_tooltip() {
  jQuery("[data-toggle=tooltip]").tooltip({container: ".wd_shop_tooltip_container"});
  jQuery(".wd_shop_order_product_final_price_info").tooltip({container: ".wd_shop_tooltip_container", "html": true});
}

function handleBootstrapEnvironmentChange() {
  var bsEnvironment = wdShop_getBootstrapEnvironment();
  jQuery(".wd_shop_order_product_container").off("mouseenter");
  jQuery(".wd_shop_order_product_container").off("mouseleave");
  switch (bsEnvironment) {
    case 'xs':
    case 'sm':
      jQuery('.wd_shop_order_product_container .panel-footer')
        .stop(true, true)
        .slideDown(0);
      break;
    case 'md':
    case 'lg':
      jQuery(".wd_shop_order_product_container .panel-footer")
        .stop(true, true)
        .slideUp(0);
      jQuery(".wd_shop_order_product_container").on("mouseenter", function () {
        jQuery(this).find(".panel-footer")
          .stop(true)
          .slideUp(150)
          .slideDown(150);
      });
      jQuery(".wd_shop_order_product_container").on("mouseleave", function () {
        jQuery(this).find(".panel-footer")
          .stop(true)
          .slideDown(150)
          .slideUp(150);
      });
      break;
  }
}

function wdShop_updateOrderProduct(jq_productContainer) {
  var orderProductId = jq_productContainer.attr("order_product_id");
  var jq_loadingClipContainer = jq_productContainer.find(".wd_shop_loading_clip_container");
  var jq_alertFailContainer = jq_productContainer.find(".wd_shop_alert_failed_to_update_container");
  // if another request of the same product is loading, abort it
  var orderProductRequest = wdShop_orderProductRequestsMap[orderProductId];
  if (orderProductRequest && orderProductRequest.abort) {
    orderProductRequest.abort();
    wdShop_orderProductRequestsMap[orderProductId] = null;
  }
  jq_loadingClipContainer
      .stop(true)
      .slideUp(250);
  jq_alertFailContainer.find(".alert").html("");
  jq_alertFailContainer
      .stop(true)
      .slideUp(250);

  var count = jQuery(jq_productContainer.find(".wd_shop_order_product_quantity")[0]).val();
  var parameters = {};
  var parameters_price = 0;
  jq_productContainer.find(".wd_shop_order_product_parameter").each(function () {
    var parameterId = jQuery(this).attr("parameter_id");
    var parameterTypeId = jQuery(this).attr("type_id");
    var parameterValue;
    var parameter_price_text = '';
    switch (parameterTypeId) {
      // Input
      case '1':
        var parameter_input = jQuery(this).find(".wd_shop_parameter_input");
        var input_parameter_val = jQuery(parameter_input).val();
        parameterValue = input_parameter_val;
        break;
      // Select
      case '3':
        var parameter_select = jQuery(this).find(".wd_shop_parameter_select");
        var selected = jQuery(parameter_select).find(':selected');
        var select_parameter_val = jQuery(selected).val();
        var select_parameter_price = jQuery(selected).attr('data-paramater-price');
        parameterValue = select_parameter_val;
        parameter_price_text = select_parameter_price;
        break;
      // Radio
      case '4':
        var parameter_radio_name = jQuery(this).find(".wd_shop_parameter_radio").attr('name');
        var radio_parameter_checked = jQuery("input[name=" + parameter_radio_name + "]:checked");
        var radio_parameter_value = jQuery(radio_parameter_checked).val();
        var radio_parameter_price = jQuery(radio_parameter_checked).attr('data-paramater-price');
        parameterValue = radio_parameter_value?radio_parameter_value:'';
        parameter_price_text = radio_parameter_price?radio_parameter_price:0;
        break;
      // Checkbox
      case '5':
        var parameter_checkbox_name = jQuery(this).find(".wd_shop_parameter_checkbox").attr('name');
        var checkbox_parameter_values = Array();
        var parameter_checkbox_price = 0;
        jQuery('input[name=' + parameter_checkbox_name + ']:checked').each(function () {
          checkbox_parameter_values.push(jQuery(this).val());
          var param_price = jQuery(this).attr('data-paramater-price');
          var sign = param_price.substr(0, 1);
          var price = param_price.substr(1, param_price.length);
          if (price) {
            if (sign == '+') {
              parameter_checkbox_price = (wde_parseFloat(parameter_checkbox_price, 2) + wde_parseFloat(price, 2)).toFixed(2);
            }
            else {
              parameter_checkbox_price = (wde_parseFloat(parameter_checkbox_price, 2) - wde_parseFloat(price, 2)).toFixed(2);
            }
          }
        });
        parameterValue = checkbox_parameter_values;
        parameter_price_text = (parameter_checkbox_price > 0) ? '+' + parameter_checkbox_price : parameter_checkbox_price;
        break;
    }
    if (parameter_price_text.length != 0 && parameter_price_text != 0) {
      var sign = parameter_price_text.substr(0, 1);
      var price = parameter_price_text.substr(1, parameter_price_text.length);
      if (price) {
        if (sign == '+') {
          parameters_price = (wde_parseFloat(parameters_price, 2) + wde_parseFloat(price, 2)).toFixed(2);
        }
        else {
          parameters_price = (wde_parseFloat(parameters_price, 2) - wde_parseFloat(price, 2)).toFixed(2);
        }
      }
    }
    parameters[parameterId + '_' + orderProductId] = parameterValue;
  });

  wdShop_orderProductRequestsMap[orderProductId] = jQuery.ajax({
    type: "POST",
    url: window.location,
    data: {
      "order_product_id": orderProductId,
      "order_product_count": count,
      "order_product_parameters_json": JSON.stringify(parameters),
      "order_product_parameters_price": parameters_price
    },
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
      wdShop_orderProductRequestsMap[orderProductId] = null;
      if (wdShop_checkoutProductAfterUpdate == 0) {
        wdShop_checkoutAllOrderProducts();
      }
      else if (wdShop_checkoutProductAfterUpdate > 0) {
        wdShop_checkoutOrderProduct(wdShop_checkoutProductAfterUpdate);
      }
      var content = jQuery(result).find("form[name='wd_shop_form_products']").html();
      jQuery("form[name='wd_shop_form_products']").html(content);
      wde_add_tooltip();
      handleBootstrapEnvironmentChange();
    },
    failure: function (errorMsg) {
      jq_alertFailContainer.find(".alert").html(errorMsg);
      jq_alertFailContainer
          .stop(true)
          .slideDown(250);
    }
  });
}

function wdShop_removeOrderProduct(jq_productContainer) {
  var orderProductId = jq_productContainer.attr("order_product_id");

  var jq_loadingClipContainer = jq_productContainer.find(".wd_shop_loading_clip_container");
  var jq_alertFailContainer = jq_productContainer.find(".wd_shop_alert_failed_to_update_container");

  jq_loadingClipContainer
      .stop(true)
      .slideUp(250);
  jq_alertFailContainer.find(".alert").html("");
  jq_alertFailContainer
      .stop(true)
      .slideUp(250);

  var orderProductId = jq_productContainer.attr("order_product_id");

  jQuery.ajax({
    type: "POST",
    url: wdShop_urlRemoveOrderProduct + "&order_product_id=" + orderProductId,
    data: {},
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
      var data = JSON.parse(result);

      if (data.failed == true) {
        jq_alertFailContainer.find(".alert").html(data.msg);
        jq_alertFailContainer
            .stop(true)
            .slideDown(250);
      }
      else {
        jq_productContainer.remove();

        if (data.order_products_left == 0) {
          wdShop_mainForm_setAction("");
          wdShop_mainForm_submit();
        }
      }

      jQuery(".wd_shop_total").html(data.total_text);
    },
    failure: function (errorMsg) {
      jq_alertFailContainer.find(".alert").html(errorMsg);
      jq_alertFailContainer
          .stop(true)
          .slideDown(250);
    }
  });
}

function wdShop_removeAllOrderProducts(jq_btnRemoveAll) {
  if ((jq_btnRemoveAll.attr("disabled") != undefined) || (jq_btnRemoveAll.hasClass("disabled"))) {
    return false;
  }

  jq_btnRemoveAll.addClass("disabled");
  jq_btnRemoveAll.attr("data-original-title", WD_SHOP_TEXT_PLEASE_WAIT);

  jq_btnRemoveAll.hover(function() {
    jq_btnRemoveAll.tooltip("show");
  });

  jQuery.ajax({
    type: "POST",
    url: wdShop_urlRemoveAllOrderProducts,
    data: {},
    complete: function () {
        jq_btnRemoveAll.removeClass("disabled");
    },
    success: function (result) {
      var data = JSON.parse(result);

      jq_btnRemoveAll.tooltip("hide");
      jq_btnRemoveAll.attr("data-original-title", data.msg);
      jq_btnRemoveAll.hover(function() {
        jq_btnRemoveAll.tooltip("show");
      });

      if (data.failed == false) {
        wdShop_mainForm_setAction("");
        wdShop_mainForm_submit();
      }
    },
    failure: function (errorMsg) {
      alert(errorMsg);
    }
  });
}

function wdShop_checkoutOrderProduct(orderProductId) {
  wdShop_checkoutProductAfterUpdate = orderProductId;
  // submit after all requests ended
  var hasActiveRequests = false;
  for (request_index in wdShop_orderProductRequestsMap) {
    var request = wdShop_orderProductRequestsMap[request_index];
    if (request != null) {
      hasActiveRequests = true;
    }
  }
  if (hasActiveRequests == true) {
    return;
  }
  wdShop_mainForm_set("order_product_id", orderProductId);
  wdShop_mainForm_setAction(wdShop_urlCheckoutOrderProduct);
  wdShop_mainForm_submit();
}

function wdShop_checkoutAllOrderProducts() {
  wdShop_checkoutProductAfterUpdate = 0;
  // submit after all requests ended
  var hasActiveRequests = false;
  for (request_index in wdShop_orderProductRequestsMap) {
    var request = wdShop_orderProductRequestsMap[request_index];
    if (request != null) {
      hasActiveRequests = true;
    }
  }

  if (hasActiveRequests == true) {
    return;
  }

  wdShop_mainForm_setAction(wdShop_urlCheckoutAllOrderProducts);
  wdShop_mainForm_submit();
}
/* function addParametersPrices() {
  for (var i in  product_parameters_price) {
    var final_price_conteiner = jQuery('.wd_shop_order_product_final_price[orderProductId = ' + i + ']');
    var product_container = jQuery(final_price_conteiner).closest('.wd_shop_order_product_container');

    var price_text = jQuery(final_price_conteiner).html();
    var currency_code = price_text.substr(price_text.length - 1);
    var product_parameters_price_sum = 0;
    var parameters_price = product_parameters_price[i];

    for (var j in parameters_price) {
      var parameter_price = parameters_price[j];
      var sign = parameter_price.substr(0, 1);
      var param_price = parameter_price.substr(1, parameter_price.length);
      if (param_price) {
        if (sign == '+') {
          product_parameters_price_sum = (wde_parseFloat(product_parameters_price_sum, 2) + wde_parseFloat(param_price, 2)).toFixed(2);
        }
        else {
          product_parameters_price_sum = (wde_parseFloat(product_parameters_price_sum, 2) - wde_parseFloat(param_price, 2)).toFixed(2);
        }
      }
    }
    wdShop_updateOrderProduct(product_container);
  }
} */

function wdShop_onWindowResize() {
  handleBootstrapEnvironmentChange();
}

function wdShop_onProductParameterChange(event, obj) {
    var jq_productContainer = jQuery(obj).closest(".wd_shop_order_product_container");
    wdShop_updateOrderProduct(jq_productContainer);
}

function wdShop_onProductCountFocus(event, obj) {
  var jq_productContainer = jQuery(obj).closest(".wd_shop_order_product_container");
  wdShop_orderProductCurrentCount = jQuery(jq_productContainer.find(".wd_shop_order_product_quantity")[0]).val();
}

function wdShop_onProductCountBlur(event, obj) {
  var jq_productContainer = jQuery(obj).closest(".wd_shop_order_product_container");
  var newCount = jQuery(jq_productContainer.find(".wd_shop_order_product_quantity")[0]).val();
  if (newCount != wdShop_orderProductCurrentCount) {
      wdShop_updateOrderProduct(jq_productContainer);
  }
}

function wdShop_onBtnRemoveProductClick(event, obj) {
    var jq_productContainer = jQuery(obj).closest(".wd_shop_order_product_container");
    wdShop_removeOrderProduct(jq_productContainer);
}

function wdShop_onBtnRemoveAllProductsClick(event, obj) {
    var jq_btnRemoveAll = jQuery(obj);
    wdShop_removeAllOrderProducts(jq_btnRemoveAll);
}

function wdShop_onBtnCheckoutProductClick(event, obj) {
  var jq_productContainer = jQuery(obj).closest(".wd_shop_order_product_container");
  var orderProductId = jq_productContainer.attr("order_product_id");

  wdShop_checkoutOrderProduct(orderProductId);
}

function wdShop_onBtnCheckoutAllProductsClick(event, obj) {
  wdShop_checkoutAllOrderProducts();
}
