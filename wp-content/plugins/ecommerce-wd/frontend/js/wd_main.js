 /**
 * package E-Commerce WD
 * author Web-Dorado
 * copyright (C) 2014 Web-Dorado. All rights reserved.
 * license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/



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
////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function wde_parseFloat(num, decimals) {
  if (!num) {
    return 0;
  }
  dotPos = num.lastIndexOf('.');
  commaPos = num.lastIndexOf(',');
  sep = false;
  if (commaPos != -1 && dotPos != -1) {
    sep = (dotPos > commaPos) ? dotPos : commaPos;
  }
  else {
    sep = (commaPos != -1) ? commaPos : (dotPos != -1) ? dotPos : false;
    if (sep) {
      if (parseInt(sep) + /*parseInt(decimals)*/2 + 1 != num.length) {
        sep = false;
      }
    }
  }
  if (!sep) {
    return parseFloat(num.replace(/,/g,'').replace(/\./g,''));
  }
  return parseFloat(num.substring(0, sep).replace(/,/g,'').replace(/\./g,'') + '.' + num.substring(sep + 1, num.length));
}

function wdShop_disableEnterKey(event) {
    var key;
    if (window.event) {
        key = window.event.keyCode;     //IE
    } else {
        key = event.which;              //firefox
    }
    return key == 13 ? false : true;
}

function wdShop_getBootstrapEnvironment() {
    var envs = ['xs', 'sm', 'md', 'lg'];

    jq_el = jQuery('<div>');
    jq_el.appendTo(jQuery('#wd_shop_container'));

    for (var i = envs.length - 1; i >= 0; i--) {
        var env = envs[i];

        jq_el.addClass('hidden-' + env);
        if (jq_el.is(':hidden')) {
            jq_el.remove();
            return env
        }
    }
}

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function wdShop_mainForm_get(key) {
    return jQuery("form[name=wd_shop_main_form] input[name=" + key + "]").val();
}

function wdShop_mainForm_set(key, value) {
    jQuery("form[name=wd_shop_main_form] input[name=" + key + "]").val(value);
}

function wdShop_mainForm_setAction(action) {
    jQuery("form[name=wd_shop_main_form]").attr("action", action);
}

function wdShop_mainForm_submit() {
    jQuery("form[name=wd_shop_main_form]").submit();
}

////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////