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
    jQuery(".wd_shop_star_rater").each(function () {
        new WdBsStarRater(jQuery(this));
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
function wdShop_formFilters_fillData() {
    wdShop_formFilters_fillManufacturersData();
    wdShop_formFilters_fillPriceData();
    wdShop_formFilters_fillDateAddedRangeData();
    wdShop_formFilters_fillMinimumRatingData();
    wdShop_formFilters_fillTagsData();
}

function wdShop_formFilters_fillManufacturersData() {
    var manufacturerIds = [];
    var jq_checkedManufacturers = jQuery("form[name=wd_shop_form_filters] input[name^=filter_manufacturer_id_]:checked");
    jq_checkedManufacturers.each(function () {
        var manufacturerId = jQuery(this).val();
        manufacturerIds.push(manufacturerId)
    });

    wdShop_mainForm_set("filter_manufacturer_ids", manufacturerIds.join(","));
}

function wdShop_formFilters_fillPriceData() {
    var priceFrom = jQuery("form[name=wd_shop_form_filters] input[name=filter_price_from]").val();
    wdShop_mainForm_set("filter_price_from", priceFrom);
    var priceTo = jQuery("form[name=wd_shop_form_filters] input[name=filter_price_to]").val();
    wdShop_mainForm_set("filter_price_to", priceTo);
}

function wdShop_formFilters_fillDateAddedRangeData() {
    var dateAddedRange = jQuery("form[name=wd_shop_form_filters] input[name=filter_date_added_range]:checked").val();
    wdShop_mainForm_set("filter_date_added_range", dateAddedRange);
}

function wdShop_formFilters_fillMinimumRatingData() {
    var minimumRating = jQuery("form[name=wd_shop_form_filters] input[name=filter_minimum_rating]:checked").val();
    wdShop_mainForm_set("filter_minimum_rating", minimumRating);
}

function wdShop_formFilters_fillTagsData() {
    var tags = jQuery("form[name=wd_shop_form_filters] textarea[name=filter_tags]").val();
    wdShop_mainForm_set("filter_tags", tags);
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function wdShop_formFilters_onManufacturerChange(event, obj) {
    if (wdShop_filtersAutoUpdate == true) {
        wdShop_formFilters_fillManufacturersData();

        wdShop_mainForm_setAction(wdShop_urlDisplayProducts);
        wdShop_mainForm_submit();
    }
}

function wdShop_formFilters_onBtnUpdatePricesClick(event, obj) {
    wdShop_formFilters_fillPriceData();

    wdShop_mainForm_setAction(wdShop_urlDisplayProducts);
    wdShop_mainForm_submit();
}

function wdShop_formFilters_onDateAddedRangeChange(event, obj) {
    if (wdShop_filtersAutoUpdate == true) {
        wdShop_formFilters_fillDateAddedRangeData();

        wdShop_mainForm_setAction(wdShop_urlDisplayProducts);
        wdShop_mainForm_submit();
    }
}

function wdShop_formFilters_onMinimumRatingChange(event, obj) {
    if (wdShop_filtersAutoUpdate == true) {
        wdShop_formFilters_fillMinimumRatingData();

        wdShop_mainForm_setAction(wdShop_urlDisplayProducts);
        wdShop_mainForm_submit();
    }
}

function wdShop_formFilters_onTagsChange(event, obj) {
}

function wdShop_formFilters_onBtnUpdateTagsClick(event, obj) {
    wdShop_formFilters_fillTagsData();

    wdShop_mainForm_setAction(wdShop_urlDisplayProducts);
    wdShop_mainForm_submit();
}

function wdShop_formFilters_onBtnResetClick(event, obj) {
    wdShop_mainForm_set("filter_manufacturer_ids", "");
    wdShop_mainForm_set("filter_price_from", 0);
    wdShop_mainForm_set("filter_price_to", 0);
    wdShop_mainForm_set("filter_date_added_range", 0);
    wdShop_mainForm_set("filter_minimum_rating", 0);
    wdShop_mainForm_set("filter_tags", "");

    wdShop_mainForm_setAction(wdShop_urlDisplayProducts);
    wdShop_mainForm_submit();
}
