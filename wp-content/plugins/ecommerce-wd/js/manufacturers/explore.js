

function onItemClick(event, obj) {
  var jq_thisTr = jQuery(obj).closest("tr");
  var manufacturerId = jq_thisTr.attr("itemId");
  var manufacturerName = jq_thisTr.attr("itemName");
  window.parent[_callback](manufacturerId, manufacturerName);
  window.parent.tb_remove();
}