jQuery(document).ready(function () {
  var form = jQuery("form");
  validator = form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slide",
    autoFocus: true,
    enableAllSteps: false,
    labels: {
      finish: wizard_params.finish,
      next: wizard_params.next,
      previous: wizard_params.previous,
    },
    onFinished: function (event, currentIndex) {
      jQuery("#wizard_save").val(1);
      jQuery("form").submit();
    },
    onStepChanging: function (event, currentIndex, newIndex) {
      // Allways allow previous action even if the current form is not valid!
      if (currentIndex > newIndex) {
        return true;
      }
      // Needed in some cases if the user went back (clean up).
      if (currentIndex < newIndex) {
        // To remove error styles.
        form.find("body:eq(" + newIndex + ") label.error").remove();
        form.find("body:eq(" + newIndex + ") .error").removeClass("error");
      }
      form.validate().settings.ignore = ":disabled,:hidden";
      return form.valid();
    }
  });

  jQuery(".state_change").each(function () {
    if (this.checked) {
      state_change(this);
    }
  });
});

function state_change(ev) {
  var closest_tbody = jQuery(ev).closest("tbody").next("tbody");
  if (jQuery(ev).val() == 1) {
    closest_tbody.show();
  }
  else {
    closest_tbody.hide();
  }
}