jQuery(document).ready(function () {
    var jq_mainForm = jQuery("form[name=wd_shop_main_form]");

    // fields that needs to be checked
    jq_mainForm.find(".wd_shop_required_field").each(function () {
        var jq_field = jQuery(this);
        var field_type = jq_field.prop("tagName").toLowerCase();
        switch (field_type) {
            case "select":
                jq_field.on("change", function () {
                    if (jq_field.find("option:selected").val() == "") {
                        jq_field.closest(".form-group").addClass("has-error");
                    } else {
                        jq_field.closest(".form-group").removeClass("has-error");
                    }
                });
                break;
            default:
                jq_field.on("blur", function () {
                    if (jq_field.val() == "") {
                        jq_field.closest(".form-group").addClass("has-error");
                    } else {
                        jq_field.closest(".form-group").removeClass("has-error");
                    }
                });
                break;
        }
    });

    // email
    var jq_filedEmail = jq_mainForm.find("input[name=wde_billing_email]");
    jq_filedEmail.off("blur");
    jq_filedEmail.on("blur", function () {
        if (validateEmail(jq_filedEmail.val()) == false) {
            jq_filedEmail.closest(".form-group").addClass("has-error");
        } else {
            jq_filedEmail.closest(".form-group").removeClass("has-error");

        }
    });
});

function wdShop_checkout_getInvalidFields() {
    var jq_mainForm = jQuery("form[name=wd_shop_main_form]");

    // required fields
    var invalidFields = [];
    jq_mainForm.find(".wd_shop_required_field").each(function () {
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

    // email
    var jq_fieldEmail = jq_mainForm.find("input[name=wde_billing_email]");
    var email = jq_fieldEmail.val();
    if (validateEmail(email) == false) {
        invalidFields.push(jq_fieldEmail);
    }

    return invalidFields;
}
function wd_ShopCopyBillingInformation(event, obj) {
  var wdShop_billing_fields = ['first_name','middle_name','last_name','company','country_id','state','city','address','zip_code'];
  if (jQuery(obj).prop('checked') == true) {
    for (var i = 0; i < wdShop_billing_fields.length; i++) {
      jQuery('#wde_shipping_' + wdShop_billing_fields[i]).val(jQuery('#wde_billing_' + wdShop_billing_fields[i]).val());
    }
  }
}

function onWDShop_pagerBtnClick(event, obj) {
  jQuery("form[name=wd_shop_main_form] .form-group").removeClass("has-error");

  var invalidFields = wdShop_checkout_getInvalidFields();

  if (invalidFields.length > 0) {
    for (var i = 0; i < invalidFields.length; i++) {
      var invalidField = invalidFields[i];
      jQuery(invalidField).closest(".form-group").addClass("has-error");
    }

    var jq_alert = jQuery(".wd_shop_checkout_alert_incorrect_data");
    if (jq_alert.is(":visible") == false) {
      jq_alert
          .removeClass("hidden")
          .slideUp(0)
          .slideDown(250);
    } else {
      jq_alert
          .fadeOut(100)
          .fadeIn(100);
    }
    return;
  }

  wdShop_mainForm_setAction(jQuery(obj).attr("href"));
  wdShop_mainForm_submit();
}
