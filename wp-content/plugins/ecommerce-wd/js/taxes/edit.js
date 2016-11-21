jQuery(document).ready(function () {
  jQuery(".colspanchange").attr("colspan", jQuery("table.tags>thead>tr>th").length + 1);
  jQuery('#submit').click(function () {
    if (!jQuery('#addtag .form-invalid').length && jQuery('#tag-name').val()) {
      jQuery(".wde_tax_class tbody tr").each(function () {
        jQuery(this).remove(".wde_remove");
        if (!jQuery(this).hasClass("wde_hide")) {
          jQuery(this).addClass("wde_remove");
        }
      });
    }
  });
});

function wde_add_tax_rates_row() {
  var index_number = jQuery(".wde_tax_class>tbody>tr").length;
  var index = "default" + jQuery(".wde_tax_class>tbody>tr").length;

  // Clone tax row from template.
  var row = jQuery(".wde_hide").clone().removeClass("wde_hide").addClass("row" + index);
  row.html(function(i, oldHTML) {
    return oldHTML.replace(/default/gi, index);
  });

  // Get maximum value of existing priorities.
  // var priorities = new Array();
  // jQuery("input[name^='priorities'").each(function() {
    // priorities.push(parseInt(jQuery(this).val()));
  // });
  // var max_priority = Math.max.apply(null, priorities) + 1;

  // Insert new tax row to the end of taxes table.
  var inserted_obj = jQuery(row).insertBefore(".wde_hide");
  // Change new tax order and priority.
  inserted_obj.find("input[name='orders[" + index + "]']").val(index_number);
  // inserted_obj.find("input[name='priorities[" + index + "]']").val(max_priority);
  return;
}

function wde_remove_tax_rates_row() {
	var col_checked = jQuery('.wde_tax_class').find('td.col_checked input[type="checkbox"]');
  var removed = new Array();
	col_checked.each(function() {
		if (jQuery(this).prop('checked')) {
      if (jQuery(this).val().indexOf("default") === -1) {
        // Add only taxes saved in DB.
        removed.push(jQuery(this).val());
      }
			jQuery(this).parent().parent().remove();
		}	
	});
  jQuery('input[name="removed"]').val(removed);
	return false;
}

function taxExport(obj) {
	var taxRateCSVContent = "data:text/csv; charset=utf-8,";
	var taxRateOptions = [wde_localize.country_id];
	jQuery('.wd_taxes thead th').each(function(index, value) {
		if (index > 1) {
			taxRateOptions.push(jQuery(this).text().trim());
    }
	});
	taxRateCSVContent += taxRateOptions.join(",");
	taxRateCSVContent += "\n";
  var flag = true;
	jQuery('.wd_taxes tbody tr').each(function() {
    if (jQuery(this).find('.wde_check').is( ":checked" )) {
      flag = false;
      var taxRateOptionRow = '';
      jQuery(this).find('td:not(.col_ordering, .col_checked) select,td:not(.col_ordering) input').each(function(index, element) {
        var taxRateOptionValue = "";
        if (index == 0) {
          taxRateOptionValue = jQuery(this).parent("td").next().find("select").val();
        }
        else if (jQuery(this).is('.checkbox')) {
          if (jQuery(this).prop('checked')) {
            taxRateOptionValue = "1";
          }
          else {
            taxRateOptionValue = "0";
          }
        }
        else {
          if (index == 1) {
            taxRateOptionValue = jQuery(this).find("option[selected='selected']").text();
          }
          else {
            taxRateOptionValue = jQuery(this).val();
          }
        }
        taxRateOptionRow += taxRateOptionValue + ",";
      });
      taxRateCSVContent += taxRateOptionRow + "\n";
    }
	});
  if (flag) {
    alert(wde_localize.select_one_item);
    return;
  }
	jQuery(obj).attr('href', encodeURI(taxRateCSVContent));
}

function wde_getfileextension(filename, type_file_message, choose_file_message) {
  if (filename.length == 0) {
    alert(choose_file_message);
    return false;
  }
  var dot = filename.lastIndexOf(".");
  var extension = filename.substr(dot + 1, filename.length);
  if (extension.toLowerCase() == 'csv') {
    return true;
  }
  else {
    alert(type_file_message);
  }
  return false;
}

function taxImport(term_id) {
  jQuery('#edittag').attr("enctype", "multipart/form-data");
  var url = _wde_admin_url + "admin-ajax.php?action=wde_ajax" +
    "&page=wde_taxes" +
    "&task=import_taxes" +
    "&taxonomy=wde_taxes" +
    "&tag_ID=" + term_id +
    "&opened=true";
  var file_data = document.getElementById("fileupload").files[0];
  var form_data = new FormData();                  
  form_data.append('file', file_data);
  jQuery.ajax({
    url: url,
    dataType: 'text',  // what to expect back from the PHP script, if anything
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,                         
    type: 'post',
    success: function(result) {
      jQuery('.wde_opacity_popup').hide();
      jQuery('.wde_popup_div').hide();
      window.parent.location.href = result;
    }
  });
}

jQuery(document).ready(function () {
	jQuery( ".adminlist tbody" ).sortable({
		axis: 'y',
		opacity: 0.8,
		handle: ".col_ordering",
		update: function( event, ui ) {
      jQuery.each( jQuery('[name^="orders["]'), function( key, value ) {
        if (jQuery(this).val() != 'default') {
          jQuery(this).val(key + 1);
        }
      });
		}
	});
  jQuery(".wde_info").tooltip({container: ".wde_tooltip", "html": true});
});