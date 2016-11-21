


////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var wdShop_reviewsOffset;


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {

    wdShop_reviewsOffset = 0;

    // tooltips
    jQuery("[data-toggle=tooltip]").tooltip({container: ".wd_shop_tooltip_container"});

    if (wdShop_writeReview == true) {
        wdShop_showWriteReview();
    }

    loadReviews();
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function wdShop_showWriteReview() {
    var jq_writeReviewContainer = jQuery(".wd_shop_write_review_data_container");
    jq_writeReviewContainer
        .removeClass("wd_hidden")
        .slideUp(0)
        .slideDown(250);

    jQuery(".wd_shop_btn_group_reviews_closed")
        .slideDown(0)
        .slideUp(125, function () {
            jQuery(".wd_shop_btn_group_reviews_opened")
                .removeClass("wd_hidden")
                .slideDown(125);
        });

    var jq_formWriteReview = jQuery("form[name=wd_shop_form_write_review]");
    jq_formWriteReview.find("textarea[name=review_text]").focus();
}

function wdShop_hideWriteReview() {
    var jq_writeReviewContainer = jQuery(".wd_shop_write_review_data_container");
    jq_writeReviewContainer
        .slideDown(0)
        .slideUp(250);

    jQuery(".wd_shop_btn_group_reviews_opened")
        .slideDown(0)
        .slideUp(125, function () {
            jQuery(".wd_shop_btn_group_reviews_closed").slideDown(125);
        });
}

function loadReviews() {
    var jq_btnLoadMore = jQuery(".wd_shop_btn_load_more");
    if ((jq_btnLoadMore.attr("disabled") != undefined) || (jq_btnLoadMore.hasClass("disabled"))) {
        return false;
    }

    jq_btnLoadMore.addClass("disabled");
    jq_btnLoadMore.hide();

    jQuery.ajax({
        type: "POST",
        url: wdShop_urlGetProductReviews,
        data: {
            "product_id": wdShop_productId,
            "reviews_start": wdShop_reviewsOffset
        },
        complete: function () {
        },
        success: function (result) {
            var data = JSON.parse(result);
            var reviewRows = data['rows'];
            wdShop_reviewsOffset += reviewRows.length;

            for (var i = 0; i < reviewRows.length; i++) {
                var reviewRow = reviewRows[i];
				
                wdShop_displayReview(reviewRow);
            }

            if (data['can_load_more'] == 1) {
                jq_btnLoadMore.removeClass("disabled");
                jq_btnLoadMore.show();
            }
        },
        failure: function (errorMsg) {
            alert(errorMsg);
        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function wdShop_displayReview(reviewRow) {
    var jq_reviewsContainer = jQuery(".wd_shop_reviews_container");

    var jq_template = jq_reviewsContainer.find(".wd_shop_review_template");
    var jq_review = jq_template.clone().removeClass("wd_shop_review_template");
    jq_review.find(".wd_shop_review_user_name").html(reviewRow.sender_name);
    jq_review.find(".wd_shop_review_date").html(reviewRow.date);
    jq_review.find(".wd_shop_review_text").html(reviewRow.text);

    jq_reviewsContainer.append(jq_review);
}

function wdShop_formWriteReviewCheck() {
    var jq_formReview = jQuery("form[name=wd_shop_form_write_review]");
    var hasInvalidField = false;

    var userName = jq_formReview.find('input[name=user_name]').val();
    if (userName == "") {
        hasInvalidField = true;
    }

    var reviewText = jq_formReview.find('textarea[name=review_text]').val();
    if (reviewText == "") {
        hasInvalidField = true;
    }

    if (hasInvalidField == true) {
        jq_alert = jQuery(".wd_shop_alert_fill_fields");
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
        return false;
    }

    return true;
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function wdShop_onBtnWriteReviewClick(event, obj) {
    wdShop_showWriteReview();
}

function wdShop_onBtnSubmitReviewClick(event, obj) {
    var isFormValid = wdShop_formWriteReviewCheck();
    if (isFormValid == false) {
        return;
    }

    var jq_formReview = jQuery("form[name=wd_shop_form_write_review]");
    jq_formReview.submit();
}

function wdShop_onBtnCancelReviewClick(event, obj) {
    wdShop_hideWriteReview();
}

function wdShop_onBtnLoadMoreClick(event, obj) {
    loadReviews();
}


					
				
