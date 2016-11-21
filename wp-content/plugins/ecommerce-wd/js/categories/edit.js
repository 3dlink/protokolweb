

////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var _thumb_box;
var _tagBox;

////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
    _thumb_box = new ThumbBox(jQuery("#thumb_box"),'images');

    for (var i = 0; i < _imageUrls.length; i++) {
      if (_imageUrls[i]) {
        var imageUrl = {url: _imageUrls[i]};
        _thumb_box.addThumbAt(imageUrl, undefined, 'images');
      }
    }

    //tags
    _tagBox = new TagBox(jQuery("#tag_box"));
    for (var i = 0; i < _tags.length; i++) {
        _tagBox.addTag(_tags[i]);
    }
    
    //parameters
    for (var i = 0; i < _parameters.length; i++) {
        addParameter(_parameters[i]);
    }

	orderParameters();
});


////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function changeParent(id) {
    fillInputImages();
    fillInputTagIds();
    fillInputParameters();

    adminFormSet("task", TASK == "add" ? "add_refresh" : "edit_refresh");
    adminFormSet("parent_id", id);
    adminFormSubmit();
}

function addParameter(parameter) {
    //check if parameter exists
    var parameterRow = null;
    jQuery("#parameters_container").children(":not(.template)").each(function () {
        if (parameter["id"] == jQuery(this).attr("parameter_id")) {
            parameterRow = jQuery(this);
            return;
        }
    });

    //add new if doesn't
    if (parameterRow == null) {
        var parameterRow = jQuery(jQuery("#parameters_container").children(".template")[0]).clone();
        jQuery("#parameters_container").append(parameterRow);
        jQuery(parameterRow).removeClass("template");
        jQuery(parameterRow).attr("parameter_id", parameter["id"]);
        jQuery(parameterRow).attr("parameter_name", parameter["name"]);
        jQuery(parameterRow).find(".parameter_name").html(parameter["name"]);
        if (parameter["required"] == false) {
            jQuery(parameterRow).find(".required_sign").remove();
        }
    }
    fillInputParameters();
}

function removeAllParameters() {
    jQuery("#parameters_container").children(":not(.template)").remove();
    fillInputParameters();
}

function addParameterValue(parameterContainer, value) {
    if (value == undefined) {
        value = "";
    }

    var isRequired = jQuery(parameterContainer).hasClass("required_parameter") == true ? true : false;

    var parameterValuesContainer = jQuery(parameterContainer).find(".parameter_values_container");
    var template = jQuery(parameterValuesContainer).children(".template")[0];
    var newValueContainer = jQuery(template).clone();
    jQuery(newValueContainer).removeClass("template");
    var inputValue = jQuery(newValueContainer).find(".parameter_value")[0];
    jQuery(inputValue).val(value);
    if (isRequired == true) {
        jQuery(inputValue).addClass("required_field");
    }
    jQuery(parameterValuesContainer).append(newValueContainer);

    checkParameterSingleValue(parameterValuesContainer);
}

function removeParameterValue(parameterValueContainer) {
    var parameterValuesContainer = jQuery(parameterValueContainer).closest(".parameter_values_container");
    jQuery(parameterValueContainer).remove();
    checkParameterSingleValue(parameterValuesContainer);
}

function removeParameter(parameterContainer) {
    jQuery(parameterContainer).remove();
    fillInputParameters();
}

function addTag(tag) {
    _tagBox.addTag(tag);
}


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function orderParameters(){
	jQuery( "#parameters_container" ).sortable({	
		axis: 'y',
		opacity: 0.8,
		cursor: 'move',	
		handle: ".col-ordering",		
    update: function( event, ui ) { fillInputParameters(); }
	});

}


function showCategoriesTree(callback, obj) {
  /* controller=categories to page=wde_categories*/
  var url = _wde_admin_url + "admin-ajax.php?action=wde_ajax" +
      "&page=wde_categories" +
      "&task=show_tree" +
      "&callback=" + callback +
      "&disabled_node_and_children_id=" + _categoryId +
      "&selected_node_id=" + _parentId +
      "&opened=true" +
      "&TB_iframe=1";
  /*openPopUp(url);*/
  jQuery(obj).attr("href", url);
}

function showParameters(callback, obj) {
  var url = _wde_admin_url + "admin-ajax.php?action=wde_ajax" +
        "&page=wde_parameters" +
        "&task=explore" +
        "&callback=" + callback +
        "&TB_iframe=1";
  /*openPopUp(url);*/
  jQuery(obj).attr("href", url);
}

function showTags(callback, obj) {
  var url = _wde_admin_url + "admin-ajax.php?action=wde_ajax" +
      "&page=wde_tags" +
      "&task=explore" +
      "&callback=" + callback +
      "&TB_iframe=1";
  /*openPopUp(url);*/
  jQuery(obj).attr("href", url);
}

function checkParameterSingleValue(parameterValuesContainer) {
    var valueContainers = jQuery(parameterValuesContainer).children(":not(.template)");
    if (valueContainers.length > 1) {
        jQuery(parameterValuesContainer).children(".parameter_value_container:not(.template)").removeClass("single_parameter_value_container");
    } else {
        jQuery(jQuery(parameterValuesContainer).children(".parameter_value_container:not(.template)")[0]).addClass("single_parameter_value_container");
    }
}

function checkForm() {
    var invalidField;
    jQuery(".required_field").each(function () {
        if (invalidField != null) {
            return false;
        }
        var value = jQuery(this).val();
        if (value.trim() == "") {
            invalidField = this;
            return false;
        }
    });

    if (invalidField != null) {
        alert("Please fill in all required fields!");
        jQuery(invalidField).focus();
        jQuery("html, body").animate({
            scrollTop: jQuery(invalidField).offset().top - 200
        }, "fast");
        return false;
    }

    fillInputImages();
    fillInputParameters();
    fillInputTagIds();

    return true;
}

function fillInputImages() {
  var imageUrls = _thumb_box.getUploadUrls();
	for(i=0; i<imageUrls.length; i++ ) {
		imageUrls[i] = imageUrls[i].substr(_url_root.length);
  }
  var valueImageUrls = JSON.stringify(imageUrls);
  jQuery("input[name=images]").val(valueImageUrls);
}

function fillInputParameters() {
    var parameters = [];
    jQuery("#parameters_container").children(":not(.template)").each(function () {
        var parameter = {};
        parameter.id = jQuery(this).attr("parameter_id");
        parameter.values = [];
        jQuery(this).find(".parameter_value_container:not(.template)").each(function () {
            var inputParameterValue = jQuery(this).find(".parameter_value")[0];
            parameter.values.push(jQuery(inputParameterValue).val());
        });
        parameters.push(parameter);
    });
    adminFormSet("parameters", JSON.stringify(parameters));
}

function fillInputTagIds() {
    var tags = _tagBox.getTagDatas();
    var tagIds = [];
    for (var i = 0; i < tags.length; i++) {
      var tag = tags[i];
      if (typeof(tag.id) == "undefined") {          
        tagIds.push(tag.term_id);
      }
      else {
        tagIds.push(tag.id);
      }
    }
    adminFormSet("tags", JSON.stringify(tagIds))
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onBtnRemoveParentCategoryClick(event, obj) {
    changeParent(0);
}

function onBtnChangeParentCategoryClick(event, obj) {
  showCategoriesTree("changeParent", obj);
}


function onBtnAddParametersClick(event, obj) {
    showParameters("addParameter", obj);
}

function onBtnRemoveAllParametersClick(event, obj) {
    removeAllParameters();
}


function onBtnAddParameterValueClick(event, obj) {
    var parameterContainer = jQuery(obj).closest(".parameter_container");
    addParameterValue(parameterContainer);
}

function onBtnInheritParentsParametersClick(event, obj) {
    for (var i = 0; i < _parentParameters.length; i++) {
        addParameter(_parentParameters[i]);
    }
}

function onBtnRemoveParameterValueClick(event, obj) {
    var parameterValueContainer = jQuery(obj).closest(".parameter_value_container");
    removeParameterValue(parameterValueContainer);
}

function onBtnRemoveParameterClick(event, obj) {
    var parameterContainer = jQuery(obj).closest(".parameter_container");
    removeParameter(parameterContainer);
}


function onBtnAddTagsClick(event, obj) {
  showTags("addTag", obj);
}

function onBtnInheritParentsTagsClick(event, obj) {
    for (var i = 0; i < _parentTags.length; i++) {
        _tagBox.addTag(_parentTags[i]);
    }
}

function onBtnRemoveAllTagsClick(event, obj) {
    _tagBox.removeAllTags();
}