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
var wdShop_productImagesVierSlider;

////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
  wdShop_productImagesVierSlider = new WDItemsSlider(jQuery(".wd_shop_product_images_viewer .wd_shop_product_images_slider"), {loop: true, slideWidth: "slideSizePage"});
  jQuery(".wd_shop_product_images_viewer .wd_shop_product_btn_main_image").on("click", function () {
    jQuery(".wd_shop_product_images_viewer_modal").modal("show");
  });
  jQuery(".wd_shop_product_images_viewer .wd_shop_product_images_slider .wd_items_slider_items_list li")
    .on("mouseenter", function () {
      var jq_this = jQuery(this);
      jQuery(".wd_shop_product_images_viewer .wd_shop_product_main_image").attr("src", jq_this.find("img").attr("data-src"));
    })
    .on("click", function () {
      var jq_this = jQuery(this);
      jQuery(".wd_shop_product_images_viewer .wd_items_slider_items_list li.active").removeClass("active");
      jq_this.addClass("active");
      jQuery(".wd_shop_product_images_viewer .wd_shop_product_main_image").attr("src", jq_this.find("img").attr("data-src"));
    });
  jQuery(".wd_shop_product_images_viewer .wd_shop_product_images_slider .wd_items_slider_items_list").on("mouseleave", function () {
    jQuery(".wd_shop_product_images_viewer .wd_shop_product_main_image").attr("src", jQuery(".wd_shop_product_images_viewer .wd_items_slider_items_list li.active").find("img").attr("data-src"));
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
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////