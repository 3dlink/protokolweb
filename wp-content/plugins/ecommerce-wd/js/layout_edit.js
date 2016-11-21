

function spider_check_isnum(e) {
  var chCode1 = e.which || e.paramlist_keyCode;
  if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57) && (chCode1 != 46) && (chCode1 != 45)) {
    return false;
  }
  return true;
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
    jQuery('html, body').animate({
      scrollTop: jQuery(invalidField).offset().top
    }, 1000);
    return false;
  }

  return true;
}

function onAdminFormSubmit(pressbutton) {
  switch (pressbutton) {
    case "apply":
    case "save":
    case "save2new":
    case "save2copy":
      if (checkForm() == false) {
        return false;
      }
      break;
  }
  return true;
}