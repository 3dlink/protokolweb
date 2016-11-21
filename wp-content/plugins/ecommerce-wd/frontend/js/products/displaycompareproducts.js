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
var wdShop_compareProductAjaxRequest;

var wdShop_compareProductStarRater;


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
    jQuery(".wd_shop_col_value:not(.wd_shop_col_compare_product) .wd_shop_product_star_rater").each(function () {
        new WdBsStarRater(jQuery(this));
    });

    jQuery(".wd_shop_col_value.wd_shop_col_compare_product .wd_shop_product_star_rater").each(function () {
        wdShop_compareProductStarRater = new WdBsStarRater(jQuery(this));
    });

    wdShop_clearCompareProductData();
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
function wdShop_clearCompareProductData() {
    // image
    var jq_image = jQuery(".wd_shop_col_compare_product .wd_shop_product_image");
    jq_image.attr("src", "");
    jq_image.attr("alt", "");
    jq_image.css("display", "none");

    var jq_noImage = jQuery(".wd_shop_col_compare_product .wd_shop_product_no_image");
    jq_noImage.css("display", "none");

    // price
    var jq_price = jQuery(".wd_shop_col_compare_product .wd_shop_product_price");
    jq_price.html("");

    // manufacturer
    var jq_manufacturerName = jQuery(".wd_shop_col_compare_product .wd_shop_product_manufacturer_name");
    jq_manufacturerName.html("");

    var jq_manufacturerLogo = jQuery(".wd_shop_col_compare_product .wd_shop_product_manufacturer_logo");
    jq_manufacturerLogo.css("display", "none");
    jq_manufacturerLogo.attr("src", "");
    jq_manufacturerLogo.attr("alt", "");

    // rating
    var jq_starRater = jQuery(".wd_shop_col_compare_product .wd_shop_product_star_rater");
    jq_starRater.css("display", "none");
    wdShop_compareProductStarRater.setRatingUrl('');
    wdShop_compareProductStarRater.setRating(0);
    wdShop_compareProductStarRater.disable();

    // parameters
    var jq_parameterRows = jQuery(".wd_shop_row_parameter");
    jq_parameterRows.each(function () {
        var jq_parameterRow = jQuery(this);

        var jq_parameterValue = jq_parameterRow.find(".wd_shop_col_compare_product .wd_shop_product_parameter_value");
        jq_parameterValue.html("");
    });
}

function wdShop_fillCompareProductData(productRow) {
    // image
    if (productRow["image"] != '') {
        var jq_image = jQuery(".wd_shop_col_compare_product .wd_shop_product_image");
        jq_image.attr("src", wdShop_root_url + productRow.image);
        jq_image.attr("alt", productRow.name);
        jq_image.css("display", "initial");
    } else {
        var jq_noImage = jQuery(".wd_shop_col_compare_product .wd_shop_product_no_image");
        jq_noImage.css("display", "initial");
    }

    // price
    var jq_price = jQuery(".wd_shop_col_compare_product .wd_shop_product_price");
    jq_price.html(productRow["price_text"]);

    // manufacturer
    var jq_manufacturerName = jQuery(".wd_shop_col_compare_product .wd_shop_product_manufacturer_name");
    jq_manufacturerName.html(productRow["manufacturer_name"]);

    if (productRow["manufacturer_logo"] != "") {
        var jq_manufacturerLogo = jQuery(".wd_shop_col_compare_product .wd_shop_product_manufacturer_logo");
        jq_manufacturerLogo.css("display", "initial");
        jq_manufacturerLogo.attr("src",wdShop_root_url+ productRow["manufacturer_logo"]);
        jq_manufacturerLogo.attr("alt", productRow["manufacturer_name"]);
    }

    // rating
    wdShop_compareProductStarRater.setRatingUrl(productRow["rating_url"]);
    wdShop_compareProductStarRater.setRating(productRow["rating"]);
    var jq_starRater = jQuery(".wd_shop_col_compare_product .wd_shop_product_star_rater");
    jq_starRater.css("display", "inline-block");

    // parameters
    var productParameters = productRow["parameters"];
    var jq_parameterRows = jQuery(".wd_shop_row_parameter");
    jq_parameterRows.each(function () {
        var jq_parameterRow = jQuery(this);
        var parameterId = jq_parameterRow.attr("parameter_id");

        var parameter = productParameters[parameterId];
        if (parameter != null) {
            var jq_parameterValue = jq_parameterRow.find(".wd_shop_col_compare_product .wd_shop_product_parameter_value");
            jq_parameterValue.html(parameter["values"].join(" / "));
        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function wdShop_onCompareProductChange(event, obj) {
    // if another request is loading, abort it
    if (wdShop_compareProductAjaxRequest && wdShop_compareProductAjaxRequest.abort) {
        wdShop_compareProductAjaxRequest.abort();
    }

    wdShop_clearCompareProductData();

    var jq_select = jQuery(obj);
    var compareProductId = jq_select.find("option:checked").val();
    jq_select.addClass("disabled");

    if (compareProductId == 0) {
        return;
    }

    wdShop_compareProductAjaxRequest = jQuery.ajax({
        type: "POST",
        url: wdShop_urlGetCompareProduct,
        data: {"product_id": compareProductId},
        success: function (productRowJson) {
            var productRow = JSON.parse(productRowJson);
            wdShop_fillCompareProductData(productRow);

            // enable select
            jq_select.removeClass("disabled");

            wdShop_compareProductAjaxRequest = null;
        },
        failure: function (errorMsg) {
            alert(errorMsg);
        }
    });
}
