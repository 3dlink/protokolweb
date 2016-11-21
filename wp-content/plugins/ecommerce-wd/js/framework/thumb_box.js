



////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
function ThumbBox(thumbBoxContainer, fmTabIndex) {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    var thisObj = this;

    this._isMulti = jQuery(thumbBoxContainer).hasClass("jf_thumb_box_multi") == true ? true : false;

    this._thumbBoxContainer = thumbBoxContainer;
    this._thumbItemsContainer = jQuery(this._thumbBoxContainer).find(".jf_thumb_box_items_container")[0];
    this._thumbItemTemplate = jQuery(this._thumbItemsContainer).find(".template")[0];
    this._uploadUrls = [];
    this._uploadIds = [];

    this._addBtn = jQuery(this._thumbBoxContainer).find(".jf_thumb_box_btn_add_" + fmTabIndex)[0];
    jQuery(this._addBtn).click(function (event) {
        jfThumbBoxOpenFileManager(thisObj, undefined, undefined, fmTabIndex, event);
    });


    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    thisObj.checkUploadsCount = function () {
        if (thisObj._isMulti == true) {
            return;
        }
        if (thisObj._uploadUrls.length > 0) {
            jQuery(thisObj._addBtn).hide(0);
        } else {
            jQuery(thisObj._addBtn).show(0);
        }
    };


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////

    this.onImageClick = function (event, image) {
      var thumbItem = jQuery(image).closest(".jf_thumb_box_item");
      var index = jQuery(thisObj._thumbItemsContainer).children(":not(.template)").index(thumbItem);
        jfThumbBoxOpenFileManager(thisObj, index, true, fmTabIndex, event);
    }

    this.onBtnRemoveClick = function (event, btnRemove) {
        var thumbItem = jQuery(btnRemove).closest(".jf_thumb_box_item");
        var index = jQuery(thisObj._thumbItemsContainer).children(":not(.template)").index(thumbItem);
        thisObj.removeThumbAt(index);
        fillInputImages();
        if (typeof(fillInputVideos) != "undefined") {
          fillInputVideos();
        }
    }
}


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
ThumbBox.prototype.addThumbAt = function (UploadUrl, index, fmtab_index) {
    var thisObj = this;
    if ((thisObj._isMulti == false) && (thisObj._uploadUrls.length > 0)) {
        return;
    }

    if ((index == undefined) || (index > thisObj._uploadUrls.length)) {
        index = thisObj._uploadUrls.length;
    }

    var thumbItem = jQuery(thisObj._thumbItemTemplate).clone();
    jQuery(thumbItem).removeClass("template");
   
	
    if (fmtab_index == "images") {
      var onImageClick = thisObj.onImageClick;
      jQuery(thumbItem).find(".jf_thumb_box_item_image").attr("data-id", UploadUrl.id)[0];
      var upload = jQuery(thumbItem).find(".jf_thumb_box_item_image").attr("src", UploadUrl.url)[0];
      if (!this._isMulti) {
        jQuery(upload).click(function (event) {
        onImageClick(event, this);
        });
      }
    }
    else if (fmtab_index == "videos") {
      jQuery(thumbItem).find(".jf_thumb_box_item_video").attr("data-id", UploadUrl.id)[0];
      var upload = jQuery(thumbItem).find(".jf_thumb_box_item_video").html(UploadUrl.url)[0];
    }

    var onBtnRemoveClick = thisObj.onBtnRemoveClick;
    var btnRemove = jQuery(thumbItem).find(".jf_thumb_box_item_btn_remove")[0];
    jQuery(btnRemove).click(function (event) {
        onBtnRemoveClick(event, this);
    });
    if (index < thisObj._uploadUrls.length) {
        //TODO: template index
        var nextThumbItem = jQuery(thisObj._thumbItemsContainer).children()[index + 1];
        jQuery(thumbItem).insertBefore(jQuery(nextThumbItem));
    } else {
        jQuery(thisObj._thumbItemsContainer).append(thumbItem);
    }

    thisObj._uploadUrls.splice(index, 0, UploadUrl.url);
    thisObj._uploadIds.splice(index, 0, UploadUrl.id);
    thisObj.checkUploadsCount();
}

ThumbBox.prototype.removeThumbAt = function (index) {
    var thisObj = this;
    jQuery(jQuery(this._thumbItemsContainer).children(":not(.template)")[index]).remove();
    this._uploadUrls.splice(index, 1);
    this._uploadIds.splice(index, 1);

    thisObj.checkUploadsCount();
}

ThumbBox.prototype.getUploadUrls = function () {
    return this._uploadUrls;
}

ThumbBox.prototype.getUploadIds = function () {
    return this._uploadIds;
}


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
