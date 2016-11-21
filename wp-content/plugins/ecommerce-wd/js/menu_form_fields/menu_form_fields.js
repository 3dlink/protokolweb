

jQuery(document).ready(function () {
  wde_update_shortcode();
  get_tags();
});

// Insert shortcode to editor.
function onBtnInsertClick(event, that) {
  var type = jQuery("input[name='tab_index']").val();
  var layout = jQuery("input[name='layout']").val();
  var str = '';
  jQuery(".tab-pane.active table input, .tab-pane.active table select").each(function () {
    var name = jQuery(this).attr("name");
    if (name && name != "view_type") {
      if (jQuery(this).attr("type") == "text") {
        str += name + "=" + '"' + jQuery(this).val() + '" ';
      }
      else if (jQuery(this).attr("type") == "radio") {
        if (jQuery(this).is(':checked')) {
          str += name + "=" + '"' + jQuery(this).val() + '" ';
        }
      }
      else if (jQuery(this).attr("type") != "checkbox") {
        str += name + "=" + '"' + jQuery(this).val() + '" ';
      }
    }
  });

  str += 'type="' + type + '" ';
  str += 'layout="' + layout + '"';
  str = 'wde ' + str;
  var shortcode = "";
  if (str) {
    shortcode = '[' + str + ']';
    // window.parent.send_to_editor(str);
  }
  var wde_image = "products_48";
  var wde_title = "Products";
  if (type == "categories") {
    wde_image = 'categories_48';
    wde_title = "Categories";
  }
  else if (type == "manufacturers") {
    wde_image = 'manufacturers_48';
    wde_title = "Manufacturers";
  }
  shortcode = shortcode.replace(/\[wde([^\]]*)\]/g, function(d, c) {
    return "<img src='" + window.parent.wde_plugin_url + "/images/toolbar_icons/" + wde_image + ".png' class='wde_shortcode mceItem' data-title='" + str + "' title='" + wde_title + "' />";
  });
  window.tinyMCE.execCommand('mceInsertContent', false, shortcode);
  tinyMCEPopup.editor.execCommand('mceRepaint');
  tinyMCEPopup.close();
}

// Get shortcodes attributes.
function get_params(module_name) {
  var selected_text = tinyMCE.activeEditor.selection.getContent();
  var module_start_index = selected_text.indexOf("[" + module_name);
  var module_end_index = selected_text.indexOf("]", module_start_index);
  var module_str = "";
  var short_code_attr = new Array();
  if ((module_start_index >= 0) && (module_end_index >= 0)) {
    module_str = selected_text.substring(module_start_index + 1, module_end_index);
  }
  else {
    // Default parameters on shortocode insert.
    module_str = 'wde arrangement="thumbs" category_id="0" manufacturer_id="" max_price="" min_price="" date_added="0" min_rating="0" tags="" ordering="" order_dir="asc" type="products" layout="displayproducts"';
    if (typeof wde_btn_insert == "undefined") {
      var wde_btn_insert = "Insert";
    }
    jQuery(".wde_shortcode_btn span").html(wde_btn_insert);
  }
  var params_str = module_str.substring(module_str.indexOf(" ") + 1);
  var key_values = params_str.split('" ');
  for (var key in key_values) {
    var short_code_index = key_values[key].split('=')[0];
    var short_code_value = key_values[key].split('=')[1];
    short_code_value = short_code_value.replace(/\"/g, '');
    short_code_attr[short_code_index] = short_code_value;
  }
  return short_code_attr;
}

function wde_update_shortcode() {
  var short_code = get_params("wde");
  jQuery("#adminForm a[data-toggle=tab]").each(function () {
    if (jQuery(this).attr("href") == "#" + short_code["type"]) {
      jQuery(this).trigger("click");
    }
  });
  jQuery("[name=tab_index]").val(short_code["type"]);
  jQuery("[name=layout]").val(short_code["layout"]);

  // Categories options.
  jQuery("select[id=ccategory_id] option[value='" + short_code['ccategory_id'] + "']").attr('selected', 'selected');
  jQuery("#corder_dir" + short_code['corder_dir']).attr('checked', 'checked');
  jQuery("#cshow_info" + short_code['cshow_info']).attr('checked', 'checked');

  // Manufacturers options.
  jQuery("#morder_dir" + short_code['morder_dir']).attr('checked', 'checked');
  jQuery("#mshow_info" + short_code['mshow_info']).attr('checked', 'checked');

  // Products options.
  jQuery("#arrangement" + short_code['arrangement']).attr('checked', 'checked');
  jQuery("select[id=category_id] option[value='" + short_code['category_id'] + "']").attr('selected', 'selected');
  jQuery("#wd_shop_selected_manufacturers").val(short_code['manufacturer_id']);
  jQuery("#max_price").val(short_code['max_price']);
  jQuery("#min_price").val(short_code['min_price']);
  jQuery("#date_added" + short_code['date_added']).attr('checked', 'checked');
  jQuery("select[id=min_rating] option[value='" + short_code['min_rating'] + "']").attr('selected', 'selected');
  jQuery("#tags").val(short_code['tags']);
  jQuery("select[id=ordering] option[value='" + short_code['ordering'] + "']").attr('selected', 'selected');
  jQuery("#order_dir" + short_code['order_dir']).attr('checked', 'checked');
}

// Change tab type on tab change.
function onTabActivated(currentTabIndex) {
  adminFormSet("tab_index", currentTabIndex);
  var layout = "displaycategory";
  switch (currentTabIndex) {
    case "categories": {
      layout = "displaycategories";
      break;
    }
    case "manufacturers": {
      layout = "displaymanufacturers";
      break;
    }
    case "product": {
      layout = "displayproduct";
      break;
    }
    case "products": {
      layout = "displayproducts";
      break;
    }
    case "orders": {
      layout = "displayorders";
      break;
    }
    case "shoppingcart": {
      layout = "displayshoppingcart";
      break;
    }
    case "useraccount": {
      layout = "displayuseraccount";
      break;
    }
    case "login": {
      layout = "displaylogin";
      break;
    }
  }
  adminFormSet("layout", layout);
}

function selectCategory(id, name) {
  jQuery("form[name=adminForm] input#category_id").val(id);
  jQuery("form[name=adminForm] input#category_name").val(name);
  tb_remove();
}

function onBtnSelectCategoryClick(event, obj, categoryId) {
  var url = _wde_admin_url + "admin-ajax.php?action=wde_ajax" +
      "&page=wde_categories" +
      "&task=show_tree" +
      "&callback=selectCategory" +
      "&opened=true" +
      "&selected_node_id=" + categoryId +
      "&width=400" +
      "&height=250" +
      "&TB_iframe=1";
  jQuery(obj).attr("href", url);
}


var _tagBox;

// Insert tags on shortcode update.
function insert_tags() {
  // tags
  _tagBox = new ModuleBox(jQuery("#tag_box"));
  for (var i = 0; i < _tags.length; i++) {
    _tagBox.addItem(_tags[i]);
  }
	if (_tags.length == 0) {
		jQuery("#tag_box .jf_module_box_item_all").html("All");
  }
}

// Get tags by id on shortcode update.
function get_tags() {
  var post_data = {};
  post_data["tags"] = jQuery("#tags").val();
  jQuery.post(
    window.location,
    post_data,
    function (data) {
      var str = jQuery(data).find(".wdshop_mod_panel").html();
      jQuery(".wdshop_mod_panel").html(str);
    }
  ).success(function(jqXHR, textStatus, errorThrown) {
    insert_tags();
  });
}

// tags
function addTag(tag) {
  _tagBox.addItem(tag);
}

// tags
function showTags(callback, obj) {
  var url = _wde_admin_url + "admin-ajax.php?action=wde_ajax" +
      "&page=wde_tags" +
      "&task=explore" +
      "&callback=" + callback +
      "&width=400" +
      "&height=250" +
      "&TB_iframe=true";
  jQuery(obj).attr("href", url);
}

function fillInputTagIds() {
  var tags = _tagBox.getItemDatas();
  var tagIds = [];
  for (var i = 0; i < tags.length; i++) {
    var tag = tags[i];
    tagIds.push(tag.id);
  }
  jQuery("#tags").val(tagIds.join());
}

// tags
function onBtnAddTagsClick(event, obj) {
	jQuery("#tag_box .jf_module_box_item_all").hide();
  showTags("addTag", obj);
}

function onBtnRemoveAllTagsClick(event, obj) {
  _tagBox.removeAllItems();
}

function wd_shop_fillInputmanufacturers() {
	var jq_checked = '';
	jQuery('[name="manufacturers[]"]:checked').each(function() {
		jq_checked += jQuery(this).val() + ',';
	});
	jq_checked =  jq_checked.substr(0,jq_checked.length - 1);
	jQuery('#wd_shop_selected_manufacturers').val(jq_checked);
}