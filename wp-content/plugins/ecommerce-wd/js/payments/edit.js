

////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
	if (payment_method == 'stripe') {
		ShowStripeField();
	}
});

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function checkForm() {
  var invalidField;
  jQuery(".required_field:not(.template .required_field)").each(function () {
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

  fillInputOption();

  return true;
}

function fillInputOption(){
	var valueOption
	if (_fields) {
		elements = {};
		var fields = JSON.parse(_fields);
		var cc_fields = JSON.parse(_cc_fields);
		for (var field in fields) {
			if (field == 'options') {
				var options = {};
				for (i = 0; i < cc_fields.length; i++) {
					options[cc_fields[i]] = jQuery("[name=" + cc_fields[i] + "]:checked").val();
				}
				elements[field] = options;
			}
			else {
				var value;
				if (jQuery("[name="+field+"]").prop("tagName") == 'select') {
					value = jQuery("[name="+field+"]:selected").val();
        }
				else if (jQuery("[name="+field+"]").attr("type") == 'radio' || jQuery("[name="+field+"]").attr("type") == 'checkbox') {
					value = jQuery("[name="+field+"]:checked").val();
        }
				else {
					value = jQuery("[name="+field+"]").val();
        }
				elements[field] = value;
			}			
		}	
		valueOption = JSON.stringify(elements);
	}
	else {
		valueOption = '';
  }
  adminFormSet("options", valueOption);
}

function ShowStripeField() {
	if (jQuery('[name=mode]:checked').val() == 0) {		
		jQuery('.stripe-test').parent().parent().show();
		jQuery('.stripe-live').parent().parent().hide();		
	}
	else {
		jQuery('.stripe-test').parent().parent().hide();
		jQuery('.stripe-live').parent().parent().show();	
	}
}

////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onTabActivated(currentTabIndex) {
  adminFormSet("tab_index", currentTabIndex);
}

function onBtnClickShowStripeField() {
	ShowStripeField();
}