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
var wdShop_productImagesVierModalSlider;

////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
  if (jQuery.fn.zoom) {
    jQuery('#wde_zoom').zoom({on: 'click', onZoomIn: function() {wde_onZoom('out');}, onZoomOut: function() {wde_onZoom('in');}});
  }
  jQuery(".wd_shop_product_images_viewer_modal").modal({show: false});
  wdShop_productImagesVierModalSlider = new WDItemsSlider(jQuery(".wd_shop_product_images_viewer_modal .wd_shop_product_images_slider"), {loop: true, slideWidth: "slideSizePage"});

  jQuery(".wd_shop_product_images_viewer_modal .wd_shop_product_images_slider .wd_items_slider_items_list li")
    .on("mouseenter", function () {
        var jq_this = jQuery(this);
        jQuery(".wd_shop_product_images_viewer_modal .wd_shop_product_main_image").attr("src", jq_this.find("img").attr("data-src"));
    })
    .on("click", function () {
        var jq_this = jQuery(this);
        jQuery(".wd_shop_product_images_viewer_modal .wd_items_slider_items_list li.active").removeClass("active");

        if (jQuery.fn.zoom) {
          jQuery('#wde_zoom').trigger('zoom.destroy');
        }
        jq_this.addClass("active");
        jQuery(".wd_shop_product_images_viewer_modal .wd_shop_product_main_image").attr("src", jq_this.find("img").attr("data-src"));
        if (jQuery.fn.zoom) {
          jQuery('#wde_zoom').zoom({on: 'click', onZoomIn: function() {wde_onZoom('out');}, onZoomOut: function() {wde_onZoom('in');}});
        }
  });
  jQuery(".wd_shop_product_images_viewer_modal .wd_shop_product_images_slider .wd_items_slider_items_list").on("mouseleave", function () {
    jQuery(".wd_shop_product_images_viewer_modal .wd_shop_product_main_image").attr("src", jQuery(".wd_shop_product_images_viewer_modal .wd_items_slider_items_list li.active").find("img").attr("data-src"));
  });

  // on show
  jQuery('.wd_shop_product_images_viewer_modal').on('show.bs.modal', function () {
    var jq_sliderItems = jQuery(".wd_shop_product_images_viewer .wd_items_slider_items_list li");
    var jq_modalSliderItems = jQuery(".wd_shop_product_images_viewer_modal .wd_items_slider_items_list li");
    jq_modalSliderItems.removeClass("active");

    var jq_activeItem = jq_sliderItems.filter(".active");
    var activeItemIndex = jq_sliderItems.index(jq_activeItem);
    var activeItemImgSrc = jq_activeItem.find("img").attr("data-src");

    jQuery(jq_modalSliderItems.get(activeItemIndex)).addClass("active");
    jQuery(".wd_shop_product_images_viewer_modal .wd_shop_product_main_image").attr("src", activeItemImgSrc);
  });

  jQuery('.wd_shop_product_images_viewer_modal').on('shown.bs.modal', function () {
    wdShop_productImagesVierModalSlider.updateItems();
  });

  jQuery('.wd_shop_product_images_viewer_modal').on('hide.bs.modal', function () {
    var jq_sliderItems = jQuery(".wd_shop_product_images_viewer .wd_items_slider_items_list li");
    var jq_modalSliderItems = jQuery(".wd_shop_product_images_viewer_modal .wd_items_slider_items_list li");
    jq_sliderItems.removeClass("active");

    var jq_activeItem = jq_modalSliderItems.filter(".active");
    var activeItemIndex = jq_modalSliderItems.index(jq_activeItem);
    var activeItemImgSrc = jq_activeItem.find("img").attr("data-src");

    jQuery(jq_sliderItems.get(activeItemIndex)).addClass("active");
    jQuery(".wd_shop_product_images_viewer .wd_shop_product_main_image").attr("src", activeItemImgSrc);
  });
});

function wde_onZoom(dir) {
  jQuery(".wde_zoom").css("cursor", "zoom-" + dir);
}

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