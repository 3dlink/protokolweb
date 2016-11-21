

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
////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function resetValues(options, toDefault) {
  if (toDefault == undefined) {
    toDefault = false;
  }

  var values = toDefault == true ? _optionsDefaultValues : _optionsInitialValues;
  var inputNames = [];
  switch (options) {
    case "global":
      inputNames = [
        "option_date_format",
        "option_show_decimals",

        "search_enable_search",
        "search_by_category",
        "search_include_subcategories",
        "filter_manufacturers",
        "filter_price",
        "filter_date_added",
        "filter_minimum_rating",
        "filter_tags",
        "sort_by_name",
        "sort_by_manufacturer",
        "sort_by_price",
        "sort_by_count_of_reviews",
        "sort_by_rating"
      ];
      break;
    case "products_data":
      inputNames = [
        "weight_unit",
        "dimensions_unit",
        "enable_sku",
        "enable_upc",
        "enable_ean",
        "enable_jan",
        "enable_isbn",
        "enable_mpn",

        // "feedback_enable_guest_feedback",
        "feedback_enable_product_rating",
        "feedback_enable_product_reviews",
        // "feedback_publish_review_when_added",

        "social_media_integration_enable_fb_like_btn",
        "social_media_integration_enable_twitter_tweet_btn",
        "social_media_integration_enable_g_plus_btn",
        "social_media_integration_use_fb_comments",
        "social_media_integration_fb_color_scheme"
      ];
      break;
    case "email":
      inputNames = [
        "mailer",
        "admin_email",
        "from_mail",
        "from_name",

        "admin_email_enable",
        "admin_email_subject",
        "admin_email_mode",
        "admin_email_body",

        "user_email_enable",
        "user_email_subject",
        "user_email_mode",
        "user_email_body",

        "user_email_status_enable",
        "user_email_status_subject",
        "user_email_status_mode",
        "user_email_status_body",
        
        // "canceled_enable",
        // "canceled_user_enable",
        // "canceled_subject",
        // "canceled_mode",
        // "canceled_body",
        
        "failed_enable",
        "failed_user_enable",
        "failed_subject",
        "failed_mode",
        "failed_body",
        
        "pending_enable",
        "pending_user_enable",
        "pending_subject",
        "pending_mode",
        "pending_body",
        
        "completed_enable",
        "completed_user_enable",
        "completed_subject",
        "completed_mode",
        "completed_body",
        
        "refunded_enable",
        "refunded_user_enable",
        "refunded_subject",
        "refunded_mode",
        "refunded_body",

        "invoice_subject",
        "invoice_mode",
        "invoice_body"
      ];
      break;
    case "user_data":
      inputNames = [
        "user_data_middle_name",
        "user_data_last_name",
        "user_data_company",
        "user_data_country",
        "user_data_state",
        "user_data_city",
        "user_data_address",
        "user_data_mobile",
        "user_data_phone",
        "user_data_fax",
        "user_data_zip_code"
      ];
      break;
    case "checkout":
      inputNames = [
        "checkout_enable_checkout",
        "checkout_allow_guest_checkout",
        // "checkout_enable_shipping",
        "checkout_redirect_to_cart_after_adding_an_item"
      ];
      break;
    case "standart_pages":
      inputNames = [
        "option_ecommerce_base",
        "option_product_base",
        "option_manufacturer_base",
        "option_category_base",
        "option_tag_base",
        "option_parameter_base",
        "option_discount_base",
        "option_tax_base",
        "option_label_base",
        "option_shipping_method_base",
        "option_country_base",
        "option_endpoint_compare_products",
        "option_endpoint_orders_displayorder",
        "option_endpoint_orders_printorder",
        "option_endpoint_checkout_shipping_data",
        "option_endpoint_checkout_products_data",
        "option_endpoint_checkout_license_pages",
        "option_endpoint_checkout_confirm_order",
        "option_endpoint_checkout_finished_success",
        "option_endpoint_checkout_finished_failure",
        "option_endpoint_checkout_product",
        "option_endpoint_checkout_all_products",
        "option_endpoint_edit_user_account",
        "option_endpoint_systempages_errnum",
      ];
      break;
    case "other":
      inputNames = [
        "option_include_discount_in_price",
        "option_include_tax_in_price",
        "option_include_tax_in_checkout_price",
        "enable_tax",
        "round_tax_at_subtotal",
        "price_entered_with_tax",
        "tax_based_on",
        "base_location",
        "price_display_suffix",
        "option_order_shipping_type"
      ];
      break;
  }

  for (var i = 0; i < inputNames.length; i++) {
    var inputName = inputNames[i];
    values[inputName] = jQuery('<textarea />').html(values[inputName]).text();
    if (inputName == "admin_email_body"
      || inputName == "user_email_body"
      || inputName == "user_email_status_body"
      // || inputName == "canceled_body"
      || inputName == "failed_body"
      || inputName == "pending_body"
      || inputName == "completed_body"
      || inputName == "refunded_body"
      || inputName == "invoice_body") {
      var myField = document.getElementById(inputName);
      if (myField.style.display == "none") {
        var editor = tinymce.get(inputName);
        editor.setContent(values[inputName]);
      }
    }
    else {
      adminFormSet(inputName, values[inputName]);
    }
  }
}

////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onTabActivated(currentTabIndex) {
  adminFormSet("tab_index", currentTabIndex);
}

function onsubTabActivated(currentTabIndex) {
  adminFormSet("subtab_index", currentTabIndex);
}

function onBtnResetClick(event, obj, options) {
  resetValues(options);
}

function onBtnLoadDefaultValuesClick(event, obj, options) {
  resetValues(options, true);
}

function wde_insert_additional_data(textarea_id, value) {
  var myField = document.getElementById(textarea_id);
  if (myField.style.display == "none") {
    var ed = tinymce.get(textarea_id);
    if (typeof ed.insertContent == "undefined") {
      tinyMCE.execCommand('mceInsertContent', false, "{" + value + "}");
    }
    else {
      ed.insertContent("{" + value + "}");
    }
    return;
  }
  else {
    var startPos = myField.selectionStart;
    var endPos = myField.selectionEnd;
    myField.value = myField.value.substring(0, startPos)
      + "{" + value + "}"
      + myField.value.substring(endPos, myField.value.length);
  }
}