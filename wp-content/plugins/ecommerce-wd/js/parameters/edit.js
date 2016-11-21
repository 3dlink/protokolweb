

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function addParameterValue(parameterContainer) {
    if (!parameterContainer) {
        parameterContainer = '.parameter_container';
    }
    var parameterValuesContainer = jQuery(parameterContainer).find(".parameter_values_container");
    var template = jQuery(parameterValuesContainer).children(".template")[0];
    var newValueContainer = jQuery(template).clone();
    jQuery(newValueContainer).removeClass("template");
    jQuery(parameterValuesContainer).append(newValueContainer);

    checkParameterSingleValue(parameterValuesContainer);
}

function removeParameterValue(parameterValueContainer) {
    var parameterValuesContainer = jQuery(parameterValueContainer).closest(".parameter_values_container");
    jQuery(parameterValueContainer).remove();

    checkParameterSingleValue(parameterValuesContainer);
}

function checkParameterType(event, obj) {
    if(obj.value == 1) {
        jQuery('.parameter_container').addClass('hidden');
        jQuery('.parameter_values_container').children(":not(.template)").each(function () {
            var parentElement = (this).parentNode;
            parentElement.removeChild(this);
        });
        addParameterValue();
    } else if(obj.value == 2){;
        jQuery('.parameter_container').removeClass('hidden');
        jQuery('.btn_add_parameter_value').css('display', 'none')
    } else {
        jQuery('.parameter_container').removeClass('hidden');
        jQuery('.btn_add_parameter_value').css('display', 'inline-block')
    }

}

function defineParameterType(type_id){
    if(type_id == 0 || type_id == 1){
        jQuery('.parameter_container').addClass('hidden');
    } else if(type_id == 2) {
        jQuery('.btn_add_parameter_value').css('display', 'none')
    }

}
////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function checkParameterSingleValue(parameterValuesContainer) {
    var valueContainers = jQuery(parameterValuesContainer).children(":not(.template)");
    if (valueContainers.length > 1) {
        jQuery(parameterValuesContainer).children(".parameter_value_container:not(.template)").removeClass("single_parameter_value_container");
    } else {
        jQuery(jQuery(parameterValuesContainer).children(".parameter_value_container:not(.template)")[0]).addClass("single_parameter_value_container");
    }
}

function checkForm() {
    fillInputParametersDefaultValue();
}

function fillInputParametersDefaultValue() {
    var parameters = [];
    jQuery(".parameter_values_container").children(":not(.template)").each(function () {
        var inputParameterValue = jQuery(this).find(".parameter_value")[0];
        if (jQuery(inputParameterValue).val().length > 0) {
            parameters.push(jQuery(inputParameterValue).val());
        }
    });
    adminFormSet("default_values", JSON.stringify(parameters));
}

function addParameter(parameter) {
    var parameterValuesContainer = jQuery(".parameter_container").find(".parameter_values_container");
    var template = jQuery(parameterValuesContainer).children(".template")[0];
    var newValueContainer = jQuery(template).clone();
    jQuery(newValueContainer).removeClass("template");
    jQuery(newValueContainer).find(".parameter_value").val(parameter);
    jQuery(parameterValuesContainer).append(newValueContainer);

    checkParameterSingleValue(parameterValuesContainer);
}
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onBtnAddParameterValueClick(event, obj) {
    var parameterContainer = jQuery(obj).closest(".parameter_container");
    addParameterValue(parameterContainer);
}

function onBtnRemoveParameterValueClick(event, obj) {
    var parameterValueContainer = jQuery(obj).closest(".parameter_value_container");
    removeParameterValue(parameterValueContainer);
}
function OnParameterTypesChange(event, obj) {
    checkParameterType(event, obj);
}