/**
 * package E-Commerce WD
 * author Web-Dorado
 * copyright (C) 2014 Web-Dorado. All rights reserved.
 * license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/


////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
  // dropdown
  jQuery(".bs_dropdown-menu").on("click", function (event, obj) {
    event.stopPropagation();
  });
  jQuery("[data-toggle=bs_dropdown]").parent().on("hidden.bs.dropdown", function () {	
    jQuery(this).closest("li").css("display", "initial");
  });
});

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function wdShop_updateProductsInCart(productsInCart) {
  var jq_productsInCart = jQuery(".wd_shop_products_in_cart");
  if (jq_productsInCart.length > 0) {
    if (productsInCart > 0) {
      jq_productsInCart
          .html(productsInCart)
          .removeClass("wd_hidden");
    }
    else {
      jq_productsInCart
          .html(0)
          .addClass("wd_hidden");
    }
  }
}

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function wdShop_getLoginFormInvalidFields() {
  var jq_formLogin = jQuery("form[name=loginform]");
  // required fields
  var invalidFields = [];
  jq_formLogin.find(".wd_shop_required_field").each(function () {
    var jq_field = jQuery(this);
    var field_type = jq_field.prop("tagName").toLowerCase();
    switch (field_type) {
      case "select":
        if (jq_field.find("option:selected").val() == "") {
          invalidFields.push(jq_field);
        }
        break;
      default:
        if (jq_field.val() == "") {
          invalidFields.push(jq_field);
        }
        break;
    }
  });
  return invalidFields;
}

////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function wdShop_onBtnLoginClick(event, obj) {
  jQuery("form[name=loginform] .form-group").removeClass("has-error");
  var invalidFields = wdShop_getLoginFormInvalidFields();
  if (invalidFields.length > 0) {
    for (var i = 0; i < invalidFields.length; i++) {
      var invalidField = invalidFields[i];
      jQuery(invalidField).closest(".form-group").addClass("has-error");
    }

    var jq_alert = jQuery(".wd_shop_alert_incorrect_data");
    if (jq_alert.is(":visible") == false) {
      jq_alert
        .removeClass("hidden")
        .slideUp(0)
        .slideDown(250);
    }
    else {
      jq_alert
        .fadeOut(100)
        .fadeIn(100);
    }
    return;
  }
  var jq_formLogin = jQuery("form[name=loginform]");
  jq_formLogin.submit();
}

function wd_shop_submit_form(e){
	if (!e) {
		var e = event || window.event;
	}
  if (e.keyCode == '13') {
		var jq_formLogin = jQuery("form[name=loginform]");
		jq_formLogin.submit();
  }
}