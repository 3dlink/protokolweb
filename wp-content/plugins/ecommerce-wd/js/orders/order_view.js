

function onBtnUpdateOrderStatusClick(event, obj) {
  var jq_mainForm = jQuery("form[name=adminForm]");

  jq_mainForm.find("input[name=task]").val("update_order_status");
  var orderStatusId = jq_mainForm.find("select[name=status_id] option:checked").val();
  jq_mainForm.find("input[name^=order_status]").val(orderStatusId);
  jq_mainForm.find("input[name=redirect_task]").val("view");
  jq_mainForm.submit();
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