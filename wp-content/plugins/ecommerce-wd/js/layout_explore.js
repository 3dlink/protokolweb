jQuery(document).ready(function () {
  jQuery(".colspanchange").attr("colspan", jQuery("#adminForm table.adminlist>thead>tr>th").length);
});