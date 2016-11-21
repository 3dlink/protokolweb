function wde_parseFloat(num) {
  if (!num) {
    return 0;
  }
  dotPos = num.lastIndexOf('.');
  commaPos = num.lastIndexOf(',');
  sep = ((dotPos > commaPos) && commaPos != -1 && dotPos != -1) ? dotPos : (((commaPos > dotPos) && commaPos != -1 && dotPos != -1) ? commaPos : false);
  if (!sep) {
    return parseFloat(num);
  }
  return parseFloat(num.substring(0, sep).replace(/,/g,'').replace(/\./g,'') + '.' + num.substring(sep + 1, num.length));
}

function disableEnterKey(event) {
  var key;
  if (window.event) {
    key = window.event.keyCode;     //IE
  }
  else {
    key = event.which;              //firefox
  }
  return key == 13 ? false : true;
}

function adminFormGet(name) {
  var jq_input = jQuery("form [name='" + name + "']");
  return getInputValue(jq_input);
}

function adminFormSet(name, value) {
  var jq_input = jQuery("form [name='" + name + "']");
  setInputValue(jq_input, value);
}

function adminFormSubmit() {
  var jq_adminForm = jQuery("form[name=adminForm]");
  jq_adminForm.submit();
}

function tableOrdering(sort_by, sort_order, task) {	
  var form = document.adminForm;
  form.sort_by.value = sort_by;
  form.sort_order.value = sort_order;
  submitform(task);
}

function submitform(a) {
  var form_checked = true;
  if (typeof(onAdminFormSubmit) == "function") {
    form_checked = onAdminFormSubmit(a);
  }
  if (!form_checked) {
    return false;
  }
  if (a) document.adminForm.task.value=a;
  if ("function"==typeof document.adminForm.onsubmit) document.adminForm.onsubmit();
  "function"==typeof document.adminForm.fireEvent&&document.adminForm.fireEvent("submit");
  document.adminForm.submit();
}

function wde_check_one(chb) {
  jQuery(".wde_check").prop("checked", false);
  jQuery(chb).prop("checked", true);
}

function getInputValue(input) {
  var jq_input = jQuery(input);

  var tagName = jq_input.prop("tagName").toLowerCase();
  switch (tagName) {
    case "input":
      var type = jq_input.attr("type");
      switch (type) {
        case "radio":
          var inputName = jq_input.attr("name");
          var jq_checked_input = jQuery("radio[name='" + inputName + "']:checked");
          return jq_checked_input.val();
          break;
        case "checkbox":
          return jq_input.prop('checked') == true ? true : false;
          break;
        default:
          return jq_input.val();
          break;
      }
      break;
    case "select":
      jq_input.find("option:selected").val();
      break;
    case "textarea":
      jq_input.html();
      break;
  }
}

function setInputValue(inputs, value) {
  var jq_input = jQuery(inputs);

  var tagName = jq_input.prop("tagName").toLowerCase();
  switch (tagName) {
    case "input":
      var type = jq_input.attr("type");
      switch (type) {
        case "radio":
          var inputName = jq_input.attr("name");
          jQuery("input[name=" + inputName + "][value='" + value + "']").prop("checked", true);
          break;
        case "checkbox":
          jq_input.prop("checked", value ? true : false);
          break;
        default:
          jq_input.val(value);
          break;
      }
      break;
    case "select":
      jq_input.find("option[value='" + value + "']").prop("selected", true);
      break;
    case "textarea":
      jq_input.html(value);
      break;
  }
}

function openPopUp(url, width, height, options) {
  if (options == undefined) {
    options = {};
  }

  options.handler = "iframe";
  options.size = {
    x: width == undefined ? 800 : width,
    y: height == undefined ? 500 : height
  };

  SqueezeBox.open(url, options);
}

function onBtnSearchClick(event, obj) {
  jQuery("form[name=adminForm] input[name=option]").val('del_mes');
  jQuery("#page_number").val(1);
  jQuery("form[name=adminForm]").submit();
}

function onBtnResetClick(event, obj) {
  jQuery("form[name=adminForm] input[name=option]").val('del_mes');
  jQuery('.searchable').each(function () {
    var jq_input = jQuery(this);
    var tagName = jq_input.prop("tagName").toLowerCase();
    switch (tagName) {
      case "select":
        setInputValue(jq_input, -1);
        break;
      default:
        setInputValue(jq_input, "");
        break;
    }
  });
  jQuery("#page_number").val(1);
  jQuery("form[name=adminForm]").submit();
}

function wde_delete(action, confirm_message, select_message) {
  if (jQuery("#adminForm input:checkbox:checked").length > 0) {
    if (confirm(confirm_message)) {
      submitform(action);
    }
    return false;
  }
  else {
    alert(select_message);
  }
  return false;
}

function exportOrders( event ){
  alert( translate.export_text );
}

function selectAllOrders( event ){
  alert( translate.select_orders );
  jQuery('#select_all_check').prop('checked', false);
}

function selectAllItems( obj ) {
  var checked = jQuery( '#check_all_items' ).prop( 'checked' );
  jQuery( '#check_all' ).prop( 'checked', checked );
  jQuery( '.wde_check' ).prop( 'checked', checked );
  var checked_all = checked === true ? 1 : 0;
  jQuery( '#check_all_form' ).val( checked_all );

  if ( checked === true && jQuery( '.wde_check' ).length > 0 ) {
    var displaying_num = jQuery( '.tablenav-pages' ).find( '.displaying-num' );
    if ( jQuery('#current_page').length > 0 ) {
        var selected_numb = jQuery( displaying_num[0] ).text();
    }
    else {
        var selected_numb  = jQuery( '.wde_check' ).size();
    }
    jQuery( '<div id="all_select_info" class="all-select-info"><p><strong>' + wde_localize.select_all_message.replace("xx", selected_numb) + '</strong></p></div>' ).insertAfter( '.buttons_div' );
    jQuery( '#checked_orders' ).val( 'all' );
  } 
  else {
    if ( jQuery('#all_select_info' ).length > 0 ) {
      jQuery( '#all_select_info' ).remove();
    }
    jQuery( '#checked_orders' ).val( '' );
  }
}

jQuery( document ).on( 'change', '.wde_check, #check_all', function() {
  if (has_checked( '.wde_check', 'all' ) === true && jQuery('#current_page').length == 0 ) {
    jQuery( '#check_all_items' ).prop( 'checked', true );
    selectAllItems( event, jQuery( '#check_all_items' ) ); 
  } 
  else {
    jQuery( '#check_all_items' ).prop( 'checked', false );
    jQuery( '#check_all_form' ).val( 0 );
    if (jQuery( '#all_select_info' ).length > 0 ) { 
      jQuery( '#all_select_info' ).remove();
    }
  }
});

jQuery( '#check_all_items' ).click( function(event) {
  event.stopPropagation();
  selectAllItems(this);
});

jQuery( '#check_all_btn' ).click( function(e) {
  if ( jQuery('#check_all_items' ).prop( 'checked' ) == false ) {
    var checked = true;
  } 
  else {
    var checked = false;
  }
  jQuery( '#check_all_items' ).prop( 'checked', checked );
  selectAllItems( jQuery( '#check_all_items' ) );       
});

function has_checked( cls, count ) {
  var elems = jQuery( cls );
  for ( var i = 0; i < elems.length; i++ ) {
    if ( count === 'all' ) {  
      if ( jQuery(elems[i] ).prop( 'checked' ) == false ) {
        var checked = false;
        break;
      } 
      else {
        var checked = true;
      }
    }
    else if ( count === 'one' ) {
      if ( jQuery( elems[i] ).prop( 'checked' ) == true ) {
        var checked = true;
        break;
      } 
      else {
        var checked = false;
      }
    }
  }
  return checked;
} 