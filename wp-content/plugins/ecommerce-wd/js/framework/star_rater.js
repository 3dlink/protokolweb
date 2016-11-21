function WdBsStarRater(starRaterContainer) {
  var thisObj = this;

  this._jq_starRaterContainer = jQuery(starRaterContainer);

  this._isActive = this._jq_starRaterContainer.hasClass("active") == true ? true : false;
  this._tooltipsDisabled = thisObj._jq_starRaterContainer.attr("tooltipsdisabled") == "true" ? true : false;

  this._rating = parseFloat(this._jq_starRaterContainer.attr("rating"));
  if (isNaN(this._rating)) {
      this._rating = 0;
  }
  this._ratingUrl = this._jq_starRaterContainer.attr("ratingurl");
  this._msg = this._jq_starRaterContainer.attr("msg");

  this._jq_starsList = this._jq_starRaterContainer.find(".wd_bs_rater_stars_list");
  this._jq_starItems = this._jq_starsList.children("li");


  this.updateIsActive = function () {
    if (thisObj._isActive == true) {
      thisObj._jq_starRaterContainer.addClass("active");

      thisObj._jq_starsList.off("mouseenter");
      thisObj._jq_starItems.off("mouseenter");
      thisObj._jq_starItems.off("click");

      thisObj._jq_starItems.on("mouseenter", onStarMouseEnter);
      thisObj._jq_starItems.on("click", onStarClick);
    }
    else {
      thisObj._jq_starRaterContainer.removeClass("active");
      thisObj.displayRating();

      thisObj._jq_starsList.off("mouseenter");
      thisObj._jq_starItems.off("mouseenter");
      thisObj._jq_starItems.off("click");

      thisObj._jq_starsList.on("mouseenter", onStarsListMouseEnter);
    }
  }

  this.displayRating = function (rating) {
    if (rating == undefined) {
      rating = this._rating;
    }

    if (rating >= this._jq_starItems.length) {
      this._jq_starItems.children(".wd_star_color").css("width", "100%");
    }
    else {
      var sliceStarItem = this._jq_starItems[Math.floor(rating)];
      var slicePercent = Math.floor((rating - Math.floor(rating)) * 100);
      jQuery(sliceStarItem).prevAll().children(".wd_star_color").css("width", "100%");
      jQuery(sliceStarItem).children(".wd_star_color").css("width", slicePercent + "%");
      jQuery(sliceStarItem).nextAll().children(".wd_star_color").css("width", "0");
    }
  }

  this.showTooltip = function (title, msg) {
    if (this._tooltipsDisabled == true) {
      return;
    }

    var tooltipTitle = (msg == undefined) || (msg == '') ? title : title + "<br><small>" + msg + "</small>";

    jQuery(thisObj._jq_starsList).tooltip("hide");
    jQuery(thisObj._jq_starsList).attr("data-original-title", tooltipTitle);
    jQuery(thisObj._jq_starsList).tooltip("show");
  }

  this.hideTooltip = function () {
    if (this._tooltipsDisabled == true) {
      return;
    }

    jQuery(thisObj._jq_starsList).tooltip("hide");
  }

  this.showTooltipStarRate = function (rate) {
    thisObj.showTooltip(WD_TEXT_RATE + " " + rate);
  }

  this.showTooltipRating = function () {
    if (thisObj._rating > 0) {
      thisObj.showTooltip(WD_TEXT_RATING + " " + thisObj._rating, thisObj._msg);
    }
    else {
      thisObj.showTooltip(WD_TEXT_NOT_RATED, thisObj._msg);
    }
}

  function onStarsListMouseEnter() {
    thisObj.showTooltipRating();
  }

  function onStarMouseEnter() {
    var rate = thisObj._jq_starItems.index(jQuery(this)) + 1;

    jQuery(this).prevAll().andSelf().children(".wd_star_color").css("width", "100%");
    jQuery(this).nextAll().children(".wd_star_color").css("width", "0");

    thisObj.showTooltipStarRate(rate);
  }

  function onStarClick() {
    var rate = thisObj._jq_starItems.index(jQuery(this)) + 1;

    thisObj.hideTooltip();
    thisObj.disable();

    thisObj._msg = WD_TEXT_PLEASE_WAIT;
    thisObj.showTooltipRating();

    var ratingData = new Object();
    ratingData["rating"] = rate;
    var ratingDataJson = JSON.stringify(ratingData);
    jQuery.ajax({
      type: "POST",
      url: thisObj._ratingUrl,
      data: {"rating_data_json": ratingDataJson},
      complete: function () {},
      success: function (result) {
        var data = JSON.parse(result);
        thisObj._rating = data["rating"] == null ? thisObj._rating : data["rating"];
        thisObj.displayRating();
        thisObj._msg = data["msg"];
        thisObj.hover(function() {
          thisObj.showTooltipRating("show");
        });
      },
      failure: function (errorMsg) {
        thisObj._msg = WD_TEXT_FAILED_TO_RATE;
      }
    });
  }

  if (this._tooltipsDisabled == false) {
    // prepare tooltip
    jQuery(thisObj._jq_starsList).tooltip({"animation": false, "html": true, "placement": "top", "trigger": "manual"});
  }

  // on stars list mouseleave
  thisObj._jq_starsList.on("mouseleave", function () {
    thisObj.hideTooltip();
    thisObj.displayRating();
  });

  this.displayRating();
  this.updateIsActive();
}

WdBsStarRater.prototype.enable = function (id) {
  var thisObj = this;

  thisObj._isActive = true;
  thisObj.updateIsActive();
}

WdBsStarRater.prototype.disable = function () {
  var thisObj = this;

  thisObj._isActive = false;
  thisObj.updateIsActive();
}

WdBsStarRater.prototype.setRatingUrl = function (ratingUrl) {
  var thisObj = this;

  thisObj._ratingUrl = ratingUrl;
}

WdBsStarRater.prototype.setRating = function (rating) {
  var thisObj = this;

  thisObj._rating = rating;
  thisObj.displayRating();
}

WdBsStarRater.prototype.setMsg = function (msg) {
  var thisObj = this;

  thisObj._msg = msg;
}