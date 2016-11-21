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
    var jq_formUpdateData = jQuery("form[name=wd_shop_form_update_data]");

    // fields that needs to be checked
    jq_formUpdateData.find(".wd_shop_required_field").each(function () {
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
function wdShop_getInvalidFields() {
    var jq_formUpdateData = jQuery("form[name=wd_shop_form_update_data]");

    // required fields
    var invalidFields = [];
    jq_formUpdateData.find(".wd_shop_required_field").each(function () {
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
function wdShop_onBtnUpdateUserDataClick(event, obj) {
    var jq_formUpdateData = jQuery("form[name=wd_shop_form_update_data]");
    jq_formUpdateData.find(".form-group").removeClass("has-error");

    var invalidFields = wdShop_getInvalidFields();
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
        } else {
            jq_alert
                .fadeOut(100)
                .fadeIn(100);
        }
        return;
    }

    jq_formUpdateData.submit();
}