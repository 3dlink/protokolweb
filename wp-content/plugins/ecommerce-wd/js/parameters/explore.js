

////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
  function submitCheckedItems() {
    jQuery("form[name=adminForm] input[type=checkbox][name^=cid]:checked").each(function () {
      var jq_thisTr = jQuery(this).closest("tr");
      var parameter = {};
      parameter.id = jq_thisTr.attr("itemId");
      parameter.name = jq_thisTr.attr("itemName");
      parameter.type_id = jq_thisTr.attr("itemTypeId");
      parameter.type_name = jq_thisTr.attr("itemTypeName");
      parameter.default_values = jq_thisTr.attr("itemDefaultValues");
      parameter.default_values_ids = jq_thisTr.attr("itemDefaultValuesIds");
      parameter.required = jq_thisTr.attr("itemRequired") == "1" ? true : false;
      parameter.add_parameter = true;
      window.parent[_callback](parameter);
    });
    // window.parent.SqueezeBox.close();
    window.parent.tb_remove();
  }

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onItemClick(event, obj) {
  jQuery("form[name=adminForm] input[type=checkbox][name=checkall-toggle]").prop("checked", false);
  jQuery("form[name=adminForm] input[type=checkbox][name^=cid]").prop("checked", false);
  jQuery(obj).closest("tr").find("input[type=checkbox][name^=cid]").prop("checked", true);
  submitCheckedItems();
}

function onBtnInsertClick(event, obj) {
  submitCheckedItems();
}