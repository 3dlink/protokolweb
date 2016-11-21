

function WDItemsSlider(container, options) {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  this._container;

  this._jq_itemsMask;
  this._jq_itemsList;
  this._jq_items;
  this._itemIndex

  this._jq_btnPrev;
  this._jq_btnNext;

  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  this.handleWidthChange = function () {
    // check if content width is bigger than mask's
    if (thisObj._jq_itemsList.width() <= thisObj._jq_itemsMask.width()) {
      thisObj.disableButtons();
      var itemsListX = (thisObj._jq_itemsMask.width() - thisObj._jq_itemsList.width()) / 2;
      thisObj._jq_itemsList.css("left", itemsListX);
    }
    else {
      thisObj.enableButtons();
      thisObj.setIndex();
    }
  };

  this.enableButtons = function () {
    thisObj._jq_btnPrev.off("click");
    thisObj._jq_btnPrev.on("click", thisObj.onBtnLeftClick);
    thisObj._jq_btnPrev.removeClass("disabled");
    thisObj._jq_btnNext.off("click");
    thisObj._jq_btnNext.on("click", thisObj.onBtnRightClick);
    thisObj._jq_btnNext.removeClass("disabled");
  };

  this.disableButtons = function () {
    thisObj._jq_btnPrev.off("click");
    thisObj._jq_btnPrev.addClass("disabled");
    thisObj._jq_btnNext.off("click");
    thisObj._jq_btnNext.addClass("disabled");
  };

  this.determineLastIndex = function () {
    var lastIndex = thisObj._jq_items.length - 1;
    var width = 0;
    jQuery(thisObj._jq_items.get().reverse()).each(function () {
      var thisItem = jQuery(this);
      width += thisItem.outerWidth(true);
      if (width > thisObj._jq_itemsMask.width()) {
        lastIndex = Math.min(thisObj._jq_items.index(thisItem) + 1, lastIndex);
        return false;
      }
    });
    return lastIndex;
  };


  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  this.onBtnLeftClick = function (event) {
    var index;
    switch (thisObj._options.slideWidth) {
      case thisObj.SLIDE_SIZE_PAGE:
        index = Math.min(thisObj._itemIndex - 1, 0);
        var curItemLeftX = thisObj._jq_items.eq(thisObj._itemIndex).position().left;
        var leftXLimit = curItemLeftX - thisObj._jq_itemsMask.width();
        jQuery(thisObj._jq_items.get().slice(0, thisObj._itemIndex).reverse()).each(function () {
            var thisItem = jQuery(this);
            if (thisItem.position().left <= leftXLimit) {
                index = thisObj._jq_items.index(thisItem) + 1;
                return false;
            }
        });
        thisObj.setIndex(index);
        break;
      case thisObj.SLIDE_SIZE_ITEM:
        thisObj.setIndex(thisObj._itemIndex - 1);
        break;
      default:
        break;
    }
  };

  this.onBtnRightClick = function (event) {
    var index;

    switch (thisObj._options.slideWidth) {
      case thisObj.SLIDE_SIZE_PAGE:
        index = Math.max(thisObj._itemIndex + 1, thisObj._jq_items.length - 1);
        var curItemleftX = thisObj._jq_items.eq(thisObj._itemIndex).position().left;
        var rightXLimit = curItemleftX + thisObj._jq_itemsMask.width();
        jQuery(thisObj._jq_items.get().slice(thisObj._itemIndex + 1)).each(function () {
            var thisItem = jQuery(this);
            if (thisItem.position().left + thisItem.outerWidth() >= rightXLimit) {
                index = thisObj._jq_items.index(thisItem);
                return false;
            }
        });
        thisObj.setIndex(index);
        break;
      case thisObj.SLIDE_SIZE_ITEM:
        thisObj.setIndex(thisObj._itemIndex + 1);
        break;
      default:
        break;
    }
  };

  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor                                                                        //
  ////////////////////////////////////////////////////////////////////////////////////////
  var thisObj = this;

  // options
  this._options = {
    loop: false,
    slideWidth: thisObj.SLIDE_SIZE_PAGE
  };

  if (options != undefined) {
    for (option_key in this._options) {
      if (options.hasOwnProperty(option_key) == true) {
        this._options[option_key] = options[option_key];
      }
    }
  }

  this._container = container;

  this._jq_btnPrev = this._container.find(".wd_items_slider_btn_prev");
  this._jq_btnNext = this._container.find(".wd_items_slider_btn_next");

  this._jq_itemsMask = this._container.find(".wd_items_slider_mask");
  this._jq_itemsMask.css({position: "relative"});
  this._jq_itemsList = this._container.find(".wd_items_slider_items_list");
  this._jq_itemsList.css({position: "relative", margin: 0, padding: 0});
  this._itemIndex = 0;

  jQuery(window).on("resize", function () {
    thisObj.updateItems();
  });

  thisObj.updateItems();
}

////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
WDItemsSlider.prototype.SLIDE_SIZE_PAGE = "slideSizePage";
WDItemsSlider.prototype.SLIDE_SIZE_ITEM = "slideSizeItem";

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
WDItemsSlider.prototype.updateItems = function () {
  var thisObj = this;

  thisObj._jq_items = thisObj._jq_itemsList.children();
  thisObj._jq_items.css({display: "block", float: "left"});

  // update items list width
  var width = 0;
  thisObj._jq_items.each(function () {
    width += jQuery(this).outerWidth(true);
  });
  thisObj._jq_itemsList.width(width);

  thisObj.handleWidthChange();
};

WDItemsSlider.prototype.getIndex = function (index) {
  var thisObj = this;
  return thisObj._itemIndex;
};

WDItemsSlider.prototype.setIndex = function (index) {
  var thisObj = this;

  if (index == undefined) {
    index = thisObj._itemIndex;
  }

  var lastIndex = thisObj.determineLastIndex();
  if (thisObj._options.loop == true) {
    if (index < 0) {
      index = thisObj._itemIndex == 0 ? lastIndex : 0;
    }
    else if (index > lastIndex) {
      index = thisObj._itemIndex == lastIndex ? 0 : lastIndex;
    }
  }
  else {
    index = Math.max(0, Math.min(index, lastIndex));
  }
  thisObj._itemIndex = index;
  thisObj._jq_itemsList.animate({left: -thisObj._jq_items.eq(thisObj._itemIndex).position().left}, 250);
};