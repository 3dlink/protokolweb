


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
    window.parent[_callback](_orderDataJson);
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onBtnDeleteProductClick(event, obj) {
  if (confirm(MSG_DELETE_CONFIRM_SINGLE) == false) {
    return;
  }

  var jq_adminForm = jQuery("form[name=adminForm]");
  var jq_itemContainer = jQuery(obj).closest("tr");

  // disable close btn
  jq_adminForm.find("a.btn_close").addClass("disabled");

  var itemId = jq_itemContainer.attr("item_id");
  jq_adminForm.find("input[name=id]").val(itemId);

  jq_adminForm.find("input[name=task]").val("remove");
  jq_adminForm.submit();
}

function onBtnUpdateProductClick(event, obj) {
  var jq_adminForm = jQuery("form[name=adminForm]");
  var jq_itemContainer = jQuery(obj).closest("tr");

  // disable close btn
  jq_adminForm.find("a.btn_close").addClass("disabled");

  var itemId = jq_itemContainer.attr("item_id");
  jq_adminForm.find("input[name=id]").val(itemId);

  var productName = jq_itemContainer.find("input[name^=product_name]").val();
  jq_adminForm.find("input[name=product_name]").val(productName);

  var productParameters = jq_itemContainer.find("textarea[name^=product_parameters]").val();
  jq_adminForm.find("input[name=product_parameters]").val(productParameters);

  var productPrice = jq_itemContainer.find("input[name^=product_price]").val();
  jq_adminForm.find("input[name=product_price]").val(productPrice);

  var productCount = jq_itemContainer.find("input[name^=product_count]").val();
  jq_adminForm.find("input[name=product_count]").val(productCount);

  var taxPrice = jq_itemContainer.find("input[name^=tax_price]").val();
  jq_adminForm.find("input[name=tax_price]").val(taxPrice);

  var shippingMethodPrice = jq_itemContainer.find("input[name^=shipping_method_price]").val();
  jq_adminForm.find("input[name=shipping_method_price]").val(shippingMethodPrice);

  jq_adminForm.find("input[name=task]").val("update");
  jq_adminForm.submit();
}

function onBtnCloseClick(event, obj) {
  var jq_obj = jQuery(obj);
  if (jq_obj.hasClass("disabled")) {
      return false;
  }
  window.parent.tb_remove();
}
