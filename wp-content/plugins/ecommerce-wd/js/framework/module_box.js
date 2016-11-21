

////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
function ModuleBox(Container) {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  var thisObj = this;

  this._Container = Container;
  this._Template = jQuery(this._Container).find(".template");
  this._items = [];

  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  this.onBtnRemoveClick = function (event, obj, Id) {
    thisObj.removeItemById(Id);
  }
}

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
ModuleBox.prototype.addItem = function (Data) {
  var id = Data["id"];
  if (this._items[id]) {
    return;
  }

  var item = [];

  var Item = jQuery(this._Template).clone();
  jQuery(Item).removeClass("template");

	var name = '<span class="jf_module_box_cat_tree_last_child">'+Data["name"]+'</span>';
	if (Data["level"] != 1 && Data["level"]) {
		name  = Data["tree"] + ' &#8594; ' + '<span class="jf_module_box_cat_tree_last_child">'+Data["name"]+'</span>';
	}
  jQuery(Item).find(".jf_module_box_item_name").html(name);
  jQuery(Item).find(".jf_module_box_item_id").html(Data["id"]);
  var onBtnRemoveClick = this.onBtnRemoveClick;
  jQuery(Item).find(".jf_module_box_item_btn").click(function (event) {
      onBtnRemoveClick(event, this, Data["id"]);
  });

  jQuery(this._Container).append(Item);

  item["Data"] = Data;
  item["Item"] = Item;
  this._items[id] = item;
  fillInputTagIds();
}

ModuleBox.prototype.removeItemById = function (id) {
  var item = this._items[id];
  jQuery(item["Item"]).remove();
  delete this._items[id];
  fillInputTagIds();
}

ModuleBox.prototype.removeAllItems = function () {
  for (var id in this._items) {
    this.removeItemById(id);
  }
}

ModuleBox.prototype.getItemDatas = function () {
  var itemDatas = [];
  for (var id in this._items) {
    if (this._items.hasOwnProperty(id)) {
      var item = this._items[id];
      itemDatas.push(item["Data"]);
    }
  }
  return itemDatas;
}

String.prototype.repeat = function(count) {
  if (count < 1 || count == undefined) return '';
  var result = '', pattern = this.valueOf();
  while (count > 1) {
    if (count & 1) result += pattern;
    count >>= 1, pattern += pattern;
  }
  return result + pattern;
};

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////