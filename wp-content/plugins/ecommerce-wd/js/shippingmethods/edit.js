

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
  updateFreeShipping();
});

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function selectCountries(countries) {
  var countryIds = [];
  var countryNames = [];

  for (var i = 0; i < countries.length; i++) {
    var country = countries[i];
    countryIds.push(country.id);
    countryNames.push(country.name);
  }

  adminFormSet("country_ids", countryIds.join(","));
  adminFormSet("country_names", countryNames.join("&#13;"));
}

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
function showCountries(callback, obj) {
  var selectedIds = adminFormGet("country_ids");
  var url = _wde_admin_url + "admin-ajax.php?action=wde_ajax" +
      "&page=wde_countries" +
      "&task=explore" +
      "&selected_ids=" + selectedIds +
      "&callback=" + callback +
      "&width=800" +
      "&height=500" +
      "&TB_iframe=1";
  jQuery(obj).attr("href", url);
}

function updateFreeShipping() {
  var value_free_shipping = jQuery("input[name=free_shipping]:checked").val();
  value_free_shipping == "1" ? jQuery(".price_container").addClass("hidden") : jQuery(".price_container").removeClass("hidden");
}

function updateFreeShippingAfterCertainPrice() {
  var freeShippingAfterCertainPriceChecked = jQuery("input[name=free_shipping_after_certain_price]:checked").val();
  freeShippingAfterCertainPriceChecked == "1" ? jQuery(".free_shipping_start_price_container").removeClass("hidden") : jQuery(".free_shipping_start_price_container").addClass("hidden");
}

function selectTax(id, name) {
    adminFormSet("tax_id", id);
    adminFormSet("tax_name", name);
}

function showTaxes(callback, obj) {
  var url = _wde_admin_url + "admin-ajax.php?action=wde_ajax" +
      "&page=wde_taxes" +
      "&task=explore" +
      "&callback=" + callback +
      "&width=800" +
      "&height=500" +
      "&TB_iframe=1";
  jQuery(obj).attr("href", url);
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onBtnRemoveCountriesClick(event, obj) {
  selectCountries([]);
}

function onBtnSelectCountriesClick(event, obj) {
  showCountries('selectCountries', obj);
}

function onFreeShippingChange(event, obj) {
  updateFreeShipping();
}

function onFreeShippingAfterCertainPriceChange(event, obj) {
  updateFreeShippingAfterCertainPrice();
}

function onBtnRemoveTaxClick(event, obj) {
    selectTax(0, "");
}

function onBtnSelectTaxClick(event, obj) {
  showTaxes('selectTax', obj);
}