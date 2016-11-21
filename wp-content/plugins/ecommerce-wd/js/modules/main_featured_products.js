

////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////

var _tagBox;
var _productBox;
var _categoryBox;


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////

jQuery(document).ready(function () {
	Joomla.submitbutton = onAdminFormSubmit;
    // tags
    _tagBox = new ModuleBox(jQuery("#tag_box"));
    for (var i = 0; i < _tags.length; i++) {
        _tagBox.addItem(_tags[i]);
    }

	//products
	_productBox = new ModuleBox(jQuery("#product_box"));
    for (var i = 0; i < _products.length; i++) {
        _productBox.addItem(_products[i]);
    }
	
	//categories
	_categoryBox = new ModuleBox(jQuery("#category_box"));
    for (var i = 0; i < _categories.length; i++) {
        _categoryBox.addItem(_categories[i]);
    }
	
	var elem_Ordering = _type == 4 ? ",:nth-child(6)" : ""; 
	var elem_Count = _type == 4 ? "" : ":nth-child(5),"; 
	
	if(!is_j3)
		jQuery( "#WDelementForParent").parent().parent().find("li:not(" + elem_Count + " :nth-child(1),:nth-child(" + _type + ") " + elem_Ordering + ")").hide();
	else
		jQuery( "#WDelementForParent").parent().parent().parent().find(".control-group:not(" + elem_Count + " :nth-child(1),:nth-child(" + _type + ") " + elem_Ordering + ")").hide();

	
	jQuery(function() {
		jQuery( "#product_box" ).sortable({
			cursor: 'move',	
		});
		
		jQuery( ".sortable" ).disableSelection();
	  });
	  
	if ( _products.length == 0 )	  
		jQuery( "#product_box .jf_module_box_item_all" ).html("All");
	if( _categories.length == 0 )
		jQuery( "#category_box .jf_module_box_item_all" ).html("All");
	if( _tags.length == 0 )		
		jQuery( "#tag_box .jf_module_box_item_all" ).html("All");
		
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
// select type
function SelectType(){
	var _elem_Ordering = jQuery('#jformparamstype').val() == 4 ? ",:nth-child(6)" : "";
	var _elem_Count = jQuery('#jformparamstype').val() == 4 ? "" : ":nth-child(5),"; 
	if(!is_j3)
	{
		jQuery( "#WDelementForParent").parent().parent().find("li").show();
		jQuery( "#WDelementForParent").parent().parent().find("li:not(" + _elem_Count + " :nth-child(1),:nth-child(" + jQuery('#jformparamstype').val() + ") " + _elem_Ordering + ")").hide();
	}
	else
	{
		jQuery( "#WDelementForParent").parent().parent().parent().find(".control-group").show();
		jQuery( "#WDelementForParent").parent().parent().parent().find(".control-group:not(" + _elem_Count + " :nth-child(1),:nth-child(" + jQuery('#jformparamstype').val() + ") " + _elem_Ordering + ")").hide();
	}
}

// tags
function addTag(tag) {
    _tagBox.addItem(tag);
}

// products
function addProduct(product) {
    _productBox.addItem(product);
}

// categories
function addCategory(category) {
    _categoryBox.addItem(category);
}

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////



function fillInputTagIds() {
    var tags = _tagBox.getItemDatas();
    var tagIds = [];
    for (var i = 0; i < tags.length; i++) {
        var tag = tags[i];
        tagIds.push(tag.id);
    }
    adminFormSet( tag_name, JSON.stringify(tagIds));
}

function fillInputProductIds() {
  var productIds = [];	
	jQuery("#product_box").children().not(".template, .jf_module_box_item_all").each(function(index, currentElem) {
		currentElem = jQuery(this);		
		id = jQuery(this).find(".jf_module_box_item_id").html();
		productIds.push(id);
	});
  adminFormSet( product_name, JSON.stringify(productIds));
}

function fillInputCategoryIds() {
  var categories = _categoryBox.getItemDatas();
  var categoryIds = [];
  for (var i = 0; i < categories.length; i++) {
    var category = categories[i];
    categoryIds.push(category.id);
  }
  adminFormSet(category_name, JSON.stringify(categoryIds));
}

////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////

// tags
function onBtnAddTagsClick(event, obj) {
	jQuery("#tag_box .jf_module_box_item_all").hide();
  showTags("addTag");
}

function onBtnRemoveAllTagsClick(event, obj) {
  _tagBox.removeAllItems();
}

// products
function onBtnAddProductsClick(event, obj) {
	jQuery("#product_box .jf_module_box_item_all").hide();
  showProducts("addProduct");
}

function onBtnRemoveAllProductsClick(event, obj) {
    _productBox.removeAllItems();
}

// categories
function onBtnAddCategoriesClick(event, obj) {
	jQuery("#category_box .jf_module_box_item_all").hide();
    showCategories("addCategory");
}

function onBtnRemoveAllCategoriesClick(event, obj) {
    _categoryBox.removeAllItems();
}

function onAdminFormSubmit(pressbutton) {
    switch (pressbutton) {
        case "module.apply":
        case "module.save":
        case "module.save2new":
        case "module.save2copy":
			fillInputTagIds();
			fillInputProductIds();
			fillInputCategoryIds();
            break;
    }
    submitform(pressbutton);
}
