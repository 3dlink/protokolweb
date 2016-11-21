


////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
function TagBox(tagsContainer) {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    var thisObj = this;

    this._tagsContainer = tagsContainer;
    this._tagTemplate = jQuery(this._tagsContainer).find(".template");
    this._tags = [];


    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    this.onBtnRemoveClick = function (event, obj, tagId) {
        thisObj.removeTagById(tagId);
    }
}

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
TagBox.prototype.addTag = function (tagData) {
    var id = typeof(tagData["id"]) == "undefined" ? tagData["term_id"] : tagData["id"];
    if (this._tags[id]) {
        return;
    }

    var tag = [];

    var tagItem = jQuery(this._tagTemplate).clone();
    jQuery(tagItem).removeClass("template");
    jQuery(tagItem).find(".jf_tag_box_item_name").html(tagData["name"]);
    var onBtnRemoveClick = this.onBtnRemoveClick;
    jQuery(tagItem).find(".jf_tag_box_item_btn").click(function (event) {
        onBtnRemoveClick(event, this, id);
    });
    jQuery(this._tagsContainer).append(tagItem);

    tag["tagData"] = tagData;
    tag["tagItem"] = tagItem;
    this._tags[id] = tag;
    fillInputTagIds();
}

TagBox.prototype.removeTagById = function (id) {
    var tag = this._tags[id];
    jQuery(tag["tagItem"]).remove();
    delete this._tags[id];
    fillInputTagIds();
}

TagBox.prototype.removeAllTags = function () {
    for (var id in this._tags) {
        this.removeTagById(id);
    }
    fillInputTagIds();
}

TagBox.prototype.getTagDatas = function () {
    var tagDatas = [];
    for (var id in this._tags) {
        if (this._tags.hasOwnProperty(id)) {
            var tag = this._tags[id];
            tagDatas.push(tag["tagData"]);
        }
    }
    return tagDatas;
}


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////