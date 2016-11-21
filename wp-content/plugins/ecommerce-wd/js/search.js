function wde_search(form, event) {
  if (typeof event != 'undefined') {
    var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if (keyCode != 13) {
      return false;
    }
  }
  if (document.getElementById("page_number")) {
    document.getElementById("page_number").value = "1";
  }
  if (document.getElementById("search_or_not")) {
    document.getElementById("search_or_not").value = "search";
  }
  if (document.getElementById("#" + form)) {
    document.getElementById("#" + form).submit();
  }
}

function wde_reset(form, event) {
  if (document.getElementById("search_value")) {
    document.getElementById("search_value").value = "";
  }
  if (document.getElementById("#" + form)) {
    document.getElementById("#" + form).submit();
  }
}