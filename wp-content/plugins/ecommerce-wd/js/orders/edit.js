function updateProductsData(orderDataJson) {
  var orderData = JSON.parse(orderDataJson);

  jQuery(".el_product_names").html(orderData.product_names);
  jQuery(".el_total_price").html(orderData.total_price_text);
}

function showOrderProducts(orderId, obj) {
  var url = _wde_admin_url + "admin-ajax.php?action=wde_ajax" +
      "&page=wde_orderproducts" +
      "&task=explore" +
      "&callback=updateProductsData" +
      "&order_id=" + orderId +
      "&width=1000" +
      "&height=500" +
      "&TB_iframe=1";
  jQuery(obj).attr("href", url);
}

function onBtnEditProductsClick(event, obj, orderId) {
  showOrderProducts(orderId, obj);
}

function onAdminFormSubmit(pressbutton) { 
	var jq_mainForm = jQuery("form[name=adminForm]");
  if (pressbutton == "printorder") {
		jq_mainForm.attr('target','_blank');
  }	
	else {
		jq_mainForm.attr('target','_self');
	}
  return true;
}

function onBtnPaymentsDataClick(event, obj) {
  wdShop_paymentDataUrl = jQuery(obj).attr('data-payment-data-url');
  jQuery(obj).attr("href", wdShop_paymentDataUrl);
}

function onBtnSendInvoice(event, obj) {
  var jq_mainForm = jQuery("form[name=adminForm]");
  jq_mainForm.find("input[name=task]").val("send_invoice");
  jq_mainForm.submit();
}