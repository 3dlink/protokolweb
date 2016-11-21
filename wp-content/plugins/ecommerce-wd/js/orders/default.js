function onBtnSendInvoice(event, obj) {
  var jq_mainForm = jQuery("form[name=adminForm]");

  jq_mainForm.find("input[name^=cid], input[name=checkall-toggle]").prop("checked", false);
  jQuery(obj).parents("tr").find(".wde_check").prop("checked", true);

  jq_mainForm.find("input[name=task]").val("send_invoice");
  jq_mainForm.submit();
}

function onBtnUpdateOrderStatusClick(event, obj, orderStatusId) {
  var jq_mainForm = jQuery("form[name=adminForm]");

  jq_mainForm.find("input[name^=cid], input[name=checkall-toggle]").prop("checked", false);
  jq_mainForm.find("input[name^=cid][value=" + orderStatusId + "]").prop("checked", true);

  jq_mainForm.find("input[name=order_status]").val("checked");

  jq_mainForm.find("input[name=task]").val("update_order_status");
  jq_mainForm.submit();
}

function onBtnPaymentsDataClick(event, obj) {
  wdShop_paymentDataUrl = jQuery(obj).attr('data-payment-data-url');
  jQuery(obj).attr("href", wdShop_paymentDataUrl);
}

function onAdminFormSubmit(pressbutton) { 
	var jq_mainForm = jQuery("form[name=adminForm]");
  if (pressbutton == "printorderbulk") {
		jq_mainForm.attr('target','_blank');
  }
	else {
		jq_mainForm.attr('target','_self');
	}
  return true;
}