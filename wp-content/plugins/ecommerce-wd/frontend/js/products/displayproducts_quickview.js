var wdShopQuickViewProductIds;
var wdShopQuickViewProductIndex;
var wdShopQuickViewAjaxRequest;

var wdShopQuickViewStarRater;

var wdShopLastTouchStartX;
var wdShopLastTouchStartY;

var product_parameters_json;

jQuery(document).ready(function () {
  wdShopQuickViewProductIds = [];
  wdShopQuickViewProductIndex = 0;

  // modal tooltips
  jQuery(".modal [data-toggle=tooltip]").tooltip({container: ".wd_shop_modal_tooltip_container"});

  var jq_starRaters = jQuery(".wd_shop_product_quick_view_star_rater");
  if (jq_starRaters.length > 0) {
    wdShopQuickViewStarRater = new WdBsStarRater(jq_starRaters[0]);
  }

  // hide loading clip
  jQuery("#wd_shop_product_quick_view .wd-modal-loading-clip").fadeOut(0);

  // update product data on show modal
  jQuery('#wd_shop_product_quick_view').on('show.bs.modal', function () {
    wdShopQuickViewClearProductData();
    wdShopQuickViewUpdateProductIds();
    wdShopQuickViewUpdateProduct();

    // swipe functionality
    jQuery("#wd_shop_product_quick_view").on("touchstart", function (event) {
      var originalEvent = event.originalEvent;
      wdShopLastTouchStartX = originalEvent.touches[0].clientX;
      wdShopLastTouchStartY = originalEvent.touches[0].clientY;
    });

    jQuery("#wd_shop_product_quick_view").on("touchend", function (event) {
      var originalEvent = event.originalEvent;

      var deltaX = wdShopLastTouchStartX - originalEvent.changedTouches[0].clientX;
      var deltaY = wdShopLastTouchStartY - originalEvent.changedTouches[0].clientY;
      if (Math.abs(deltaX) > Math.abs(deltaY)) {
        if (deltaX < -20) {
          wdShopQuickView_loadPreviousProduct();
          return false;
        }
        else if (deltaX > 20) {
          wdShopQuickView_loadNextProduct();
          return false;
        }
      }
    });
  });

  // abort product data request when modal closed
  jQuery('#wd_shop_product_quick_view').on('hidden.bs.modal', function () {
      if (wdShopQuickViewAjaxRequest && wdShopQuickViewAjaxRequest.abort) {
          wdShopQuickViewAjaxRequest.abort();
          if (wdShopQuickViewStarRater != undefined) {
              wdShopQuickViewStarRater.setRatingUrl('');
              wdShopQuickViewStarRater.setRating(0);
              wdShopQuickViewStarRater.setMsg('');
              wdShopQuickViewStarRater.disable();
          }
      }

      // swipe functionality
      jQuery("#wd_shop_product_quick_view").off("touchstart");
      jQuery("#wd_shop_product_quick_view").off("touchend");
  });
});

function wdShopQuickViewUpdateProductIds() {
  // get product ids from products view
  wdShopQuickViewProductIds = [];

  var productObjs = jQuery(".wd_shop_product");
  productObjs.each(function () {
    wdShopQuickViewProductIds.push(jQuery(this).attr("product_id"));
  });

  // if current item is first disable left button
  var btnLeft = jQuery("#wd_shop_product_quick_view .wd-modal-ctrl-left");
  if (wdShopQuickViewProductIndex <= 0) {
    btnLeft.addClass("disabled");
  }
  else {
    btnLeft.removeClass("disabled");
  }

  // if current item is last disable right button
  var btnRight = jQuery("#wd_shop_product_quick_view .wd-modal-ctrl-right");
  if (wdShopQuickViewProductIndex >= wdShopQuickViewProductIds.length - 1) {
    btnRight.addClass("disabled");
  }
  else {
    btnRight.removeClass("disabled");
  }
}

function wdShopQuickViewGetProductIds(){
  // get product ids from products view
  wdShopQuickViewProductIds = [];

  var productObjs = jQuery(".wd_shop_product");
  productObjs.each(function () {
      wdShopQuickViewProductIds.push(jQuery(this).attr("product_id"));
  });
}

function wdShopQuickView_loadPreviousProduct() {
  if (wdShopQuickViewProductIndex <= 0) {
    return;
  }

  wdShopQuickViewProductIndex--;
  wdShopQuickViewUpdateProductIds();
  wdShopQuickViewUpdateProduct();
}

function wdShopQuickView_loadNextProduct() {
  if (wdShopQuickViewProductIndex >= wdShopQuickViewProductIds.length - 1) {
    return;
  }

  wdShopQuickViewProductIndex++;
  wdShopQuickViewUpdateProductIds();
  wdShopQuickViewUpdateProduct();
}

function wdShopQuickViewUpdateProduct() {
  // if another request is loading, abort it
  if (wdShopQuickViewAjaxRequest && wdShopQuickViewAjaxRequest.abort) {
    wdShopQuickViewAjaxRequest.abort();
  }

  // get current product id and load it
  var productId = wdShopQuickViewProductIds[wdShopQuickViewProductIndex];
  wdShopQuickViewAjaxRequest = jQuery.ajax({
      type: "POST",
      url: wdShop_urlGetQuickViewProductRow,
      data: {"product_id": productId},
      beforeSend: function () {
          // show loading clip and disable view item button when sending request
          jQuery("#wd_shop_product_quick_view .wd-modal-loading-clip").fadeIn(250);
          jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_view_item").addClass("disabled");
      },
      complete: function () {
          // hide loading clip when response received and nothing is loading
          if (!wdShopQuickViewAjaxRequest) {
              jQuery("#wd_shop_product_quick_view .wd-modal-loading-clip").fadeOut(250);
          }
      },
      success: function (productRowJson) {
          var productRow = JSON.parse(productRowJson);
          wdShopQuickViewDisplayProduct(productRow);

          // enable view item button
          var btnViewItem = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_view_item");
          btnViewItem.removeClass("disabled");

          wdShopQuickViewAjaxRequest = null;
      },
      failure: function (errorMsg) {
          alert(errorMsg);
      }
  });
}

function wdShopQuickViewClearProductData(productRow) {
  var modalObj = jQuery("#wd_shop_product_quick_view");

  // image
  var imageObj = jQuery(modalObj).find(".wd_shop_product_quick_view_image");
  imageObj.attr("src", "");
  imageObj.attr("alt", "");
  imageObj.css("display", "none");

  var noImageObj = jQuery(modalObj).find(".wd_shop_product_quick_view_no_image");
  noImageObj.css("display", "none");

  // label
  var imageLabelObj = jQuery(modalObj).find(".wd_shop_product_quick_view_image_label");
  imageLabelObj.attr("src", "");
  imageLabelObj.removeClass("wd_align_tl");
  imageLabelObj.removeClass("wd_align_tr");
  imageLabelObj.removeClass("wd_align_bl");
  imageLabelObj.removeClass("wd_align_br");
  imageLabelObj.attr("title", "");
  imageLabelObj.css("display", "none");

  // name
  var nameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_name");
  nameObj.html("");

  // rating
  if (wdShopQuickViewStarRater != undefined) {
      wdShopQuickViewStarRater.setRatingUrl('');
      wdShopQuickViewStarRater.setRating(0);
      wdShopQuickViewStarRater.setMsg('');
      wdShopQuickViewStarRater.disable();
  }

  // category
  var categoryNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_category_name");
  categoryNameObj.html("");

  // manufacturer
  var manufacturerNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_manufacturer_name");
  manufacturerNameObj.html("");
	
	// model
  var modelNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_model_name");
  modelNameObj.html("");
	
	//codes
	var SKUNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_sku");
      SKUNameObj.html("");
	
	var UPCNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_upc");
      UPCNameObj.html("");
	
	var EANNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_ean");
      EANNameObj.html("");
	
	var JANNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_jan");
      JANNameObj.html("");
	
	var MPNNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_mpn");
      MPNNameObj.html("");
	
	var ISBNNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_isbn");
      ISBNNameObj.html("");	

  var manufacturerLogoObj = jQuery(modalObj).find(".wd_shop_product_quick_view_manufacturer_logo");
  manufacturerLogoObj.css("display", "none");
  manufacturerLogoObj.attr("src", "");
  manufacturerLogoObj.attr("alt", "");

  // price
  var marketPriceObj = jQuery(modalObj).find(".wd_shop_product_quick_view_market_price");
  marketPriceObj.html("");

  var priceObj = jQuery(modalObj).find(".wd_shop_product_quick_view_price");
  priceObj.html("");

  // description
  var descriptionObj = jQuery(modalObj).find(".wd_shop_product_quick_view_description");
  descriptionObj.html("");


  //buttons functioanlity
  var btnName = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_name");
  btnName.attr("href", "#");

  var btnCategory = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_category");
  btnCategory.addClass("wd_hidden");
  btnCategory.attr("href", "#");

  var btnManufacturer = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_manufacturer");
  btnManufacturer.addClass("wd_hidden");
  btnManufacturer.attr("href", "#");

  var btnCompare = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_compare");
  btnCompare.attr("href", "#");

  var btnAddToCart = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_add_to_cart");
  btnAddToCart.attr("data-original-title", "");
  if (option_redirect_to_cart_after_adding_an_item == 2) {
		btnAddToCart.addClass("disabled");
	}

  var btnBuyNow = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_buy_now");
  btnBuyNow.css("display", "none");

  var btnViewItem = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_view_item");
  btnViewItem.attr("href", "#");
}

function wdShopQuickViewDisplayProduct(productRow) {
  wdShopQuickViewClearProductData();

  var modalObj = jQuery("#wd_shop_product_quick_view");

  // image
  if (productRow["image"] != '') {
    var imageObj = jQuery(modalObj).find(".wd_shop_product_quick_view_image");
    imageObj.attr("src", _url_root + productRow["image"]);
    imageObj.css("display", "initial");
  }
  else {
    var noImageObj = jQuery(modalObj).find(".wd_shop_product_quick_view_no_image");
    noImageObj.css("display", "initial");
  }

  // label
  if (productRow["label_thumb"] != '') {
    var label_position_class;
    switch (parseInt(productRow["label_thumb_position"])) {
        case 0:
            label_position_class = "wd_align_tl";
            break;
        case 1:
            label_position_class = "wd_align_tr";
            break;
        case 2:
            label_position_class = "wd_align_bl";
            break;
        case 3:
            label_position_class = "wd_align_br";
            break;
    }
    var imageLabelObj = jQuery(modalObj).find(".wd_shop_product_quick_view_image_label");
    imageLabelObj.attr("src", _url_root +  productRow["label_thumb"]);
    imageLabelObj.addClass(label_position_class);
    imageLabelObj.attr("title", productRow["label_name"]);
    imageLabelObj.css("display", "initial");
  }

  // name
  var nameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_name");
  nameObj.html(productRow["name"]);

  // rating
  if (wdShopQuickViewStarRater != undefined) {
      wdShopQuickViewStarRater.setRatingUrl(productRow["rating_url"]);
      wdShopQuickViewStarRater.setRating(productRow["rating"]);
      wdShopQuickViewStarRater.setMsg(productRow["rating_msg"]);
      if (productRow["can_rate"] == 1) {
          wdShopQuickViewStarRater.enable();
      }
  }

  // category
  var categoryNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_category_name");
  categoryNameObj.html(productRow["category_name"]);

  // manufacturer
  var manufacturerNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_manufacturer_name");
  manufacturerNameObj.html(productRow["manufacturer_name"]);

	//model

	var modelNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_model_name");
      modelNameObj.html(productRow["model"]);

	//codes
	if (productRow["sku"] != '') {
		var SKUNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_sku");
		SKUNameObj.html('SKU: ' + productRow["sku"]);
	}

	if (productRow["upc"] != '') {
		var UPCNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_upc");
		UPCNameObj.html('UPC: ' + productRow["upc"]);
	}

	if (productRow["ean"] != '') {
		var EANNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_ean");
		EANNameObj.html('EAN: ' + productRow["ean"]);
	}

	if (productRow["jan"] != '') {
		var JANNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_jan");
		JANNameObj.html('JAN: ' + productRow["jan"]);
	}

	if (productRow["mpn"] != '') {
		var MPNNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_mpn");
		MPNNameObj.html('MPN: ' + productRow["mpn"]);
	}

	if (productRow["isbn"] != '') {
		var ISBNNameObj = jQuery(modalObj).find(".wd_shop_product_quick_view_isbn");
		ISBNNameObj.html('ISBN: ' + productRow["isbn"]);
	}	

  if (productRow["manufacturer_logo"] != "") {
      var manufacturerLogoObj = jQuery(modalObj).find(".wd_shop_product_quick_view_manufacturer_logo");
      manufacturerLogoObj.css("display", "initial");
      manufacturerLogoObj.attr("src",_url_root +  productRow["manufacturer_logo"]);
      manufacturerLogoObj.attr("alt", productRow["manufacturer_name"]);
  }

  // price
  var marketPriceObj = jQuery(modalObj).find(".wd_shop_product_quick_view_market_price");
  marketPriceObj.html(productRow["market_price_text"]);

  var priceObj = jQuery(modalObj).find(".wd_shop_product_quick_view_price");
  priceObj.html(productRow["price_text"]);

  // description
  var descriptionObj = jQuery(modalObj).find(".wd_shop_product_quick_view_description");
  descriptionObj.html(productRow["description"]);

  //parameters
  product_parameters_json = JSON.stringify(productRow['selectable_parameters'])

  //buttons functioanlity
  var btnName = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_name");
  btnName.attr("href", productRow["url"]);

  if (productRow["category_url"] != "") {
      var btnCategory = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_category");
      btnCategory.removeClass("wd_hidden");
      btnCategory.attr("href", productRow["category_url"]);
  }

  if (productRow["manufacturer_url"] != "") {
      var btnManufacturer = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_manufacturer");
      btnManufacturer.removeClass("wd_hidden");
      btnManufacturer.attr("href", productRow["manufacturer_url"]);
  }

  var btnCompare = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_compare");
  btnCompare.attr("href", productRow["compare_url"]);

  var btnAddToCart = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_add_to_cart");
	if (option_redirect_to_cart_after_adding_an_item == 2) {
	    if (productRow["added_to_cart"] == 1) {
			btnAddToCart.attr("data-original-title", WD_SHOP_TEXT_ALREADY_ADDED_TO_CART);
		}
    else {
			btnAddToCart.removeClass("disabled");
		}
	}

  if (productRow["can_checkout"] == true) {
      var btnBuyNow = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_buy_now");
      btnBuyNow.css("display", "initial");
  }

  var btnViewItem = jQuery("#wd_shop_product_quick_view .wd_shop_product_quick_view_btn_view_item");
  btnViewItem.attr("href", productRow["url"]);
}

function wdShopOnQuickViewBtnLeftClick(event, obj) {
  var jq_btn = jQuery(obj);
  if ((jq_btn.attr("disabled") != undefined) || (jq_btn.hasClass("disabled"))) {
    return false;
  }

  wdShopQuickView_loadPreviousProduct();
}

function wdShopOnQuickViewBtnRightClick(event, obj) {
  var jq_btn = jQuery(obj);
  if ((jq_btn.attr("disabled") != undefined) || (jq_btn.hasClass("disabled"))) {
    return false;
  }

  wdShopQuickView_loadNextProduct();
}

function wdShopQuickView_onBtnBuyNowClick(event, obj) {
  var productId = wdShopQuickViewProductIds[wdShopQuickViewProductIndex];
  var count = 1;
  var parameters = {};

  wdShop_mainForm_set("product_id", productId);
  wdShop_mainForm_set("product_count", count);
  wdShop_mainForm_set("product_parameters_json", JSON.stringify(parameters));

  wdShop_mainForm_setAction(jQuery(obj).attr("href"));
  wdShop_mainForm_submit();
}

function wdShopQuickView_onBtnAddToCartClick(event, obj) {
  var jq_btn = jQuery(obj);

  if (option_redirect_to_cart_after_adding_an_item == 2) {
    if ((jq_btn.attr("disabled") != undefined) || (jq_btn.hasClass("disabled"))) {
      return false;
    }	
    jq_btn.addClass("disabled");
  }
  jq_btn.attr("data-original-title", WD_SHOP_TEXT_PLEASE_WAIT);
  jq_btn.tooltip("show");

  var productId = wdShopQuickViewProductIds[wdShopQuickViewProductIndex];
  var jq_btnInProductsView = jQuery(".wd_shop_products_container .wd_shop_product[product_id=" + productId + "] .wd_shop_btn_add_to_cart");
  var count = 1;

  var parameters = {};
  var product_params = JSON.parse(product_parameters_json);
  for (var key in product_params) {
    var id  = product_params[key]['id'];
    var value;
    var type_id = product_params[key]['type_id'];
    switch (type_id) {
      // Input field
      case '1':
      // Radio
      case '4':
        value = '';
        break;
      // Select
      case '3':
        value = '0';
        break;
      // Checkbox
      case '5':
        value = [];
        break;
    }
    parameters[id] = value;
  }

  jQuery.ajax({
    type: "POST",
    url: wdShop_urlAddToShoppingCart,
    data: {
      "product_id": productId,
      "product_count": count,
      "product_parameters_json": JSON.stringify(parameters)
    },
    complete: function () {},
    success: function (result) {			
      var data = JSON.parse(result);
      jq_btn.attr("data-original-title", data["msg"]);
      jq_btn.tooltip("show");

      jq_btnInProductsView.attr("data-original-title", data["msg"]);

      if (typeof wdShop_updateProductsInCart == 'function') {
        wdShop_updateProductsInCart(data['products_in_cart']);
      }

      if ((data.product_added == true) && (wdShop_redirectToCart == true)) {
        wdShop_mainForm_setAction(wdShop_urlDisplayShoppingCart);
        wdShop_mainForm_submit();
      }
      if ( jQuery(".minicart_module_container").length > 0 ) {
        if (typeof wdef_load == 'function') { 
          wdef_load(window.location, 'minicart_module_container');
        }
      }
    },
    failure: function (errorMsg) {
        alert(errorMsg);
    }
  });
}