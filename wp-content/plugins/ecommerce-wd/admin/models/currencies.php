<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelCurrencies extends EcommercewdModel {
	public function get_currencies_data() {
		$published_payments = WDFDb::get_rows('payments',array('published = "1" '));
		$supported_currencies = $this->get_payment_supported_currencies();
		$currencies_data = array();
		foreach ($published_payments as $published_payment){
			if(isset($supported_currencies[$published_payment->base_name]) == true){
				$currency_data = new Stdclass;
				$currency_data->text = __(strtoupper($published_payment->base_name) . 'Paypal-supported currencies', 'wde');				
				$currency_data->currencies = $supported_currencies[$published_payment->base_name];
				$currency_data->payment_name = $published_payment->base_name;
				$currencies_data[$published_payment->base_name] = $currency_data;
			}
		}
		return $currencies_data;
	}

  protected function init_rows_filters() {
    $filter_items = array();

    // name
    $filter_item = new stdClass();
    $filter_item->type = 'string';
    $filter_item->name = 'name';
    $filter_item->default_value = null;
    $filter_item->operator = 'like';
    $filter_item->input_type = 'text';
    $filter_item->input_label = __('Name', 'wde');
    $filter_item->input_name = 'search_name';
    $filter_items[$filter_item->name] = $filter_item;

    $this->rows_filter_items = $filter_items;

    parent::init_rows_filters();
  }

	protected function get_payment_supported_currencies() {
		$payments_supported_currencies = array();
		$authorizenet = array();
		$authorizenet["USD"] = array("United States Dollar", "&#36;", 0);
		$authorizenet["CAD"] = array("Canadian Dollar", "&#36;", 0);
		$authorizenet["GBP"] = array("British Pounds", "&#163;", 0);
		$authorizenet["EUR"] = array("Euro", "&#8364;", 0);
		$authorizenet["AUD"] = array("Australian Dollar", "&#36;", 0);
		$authorizenet["NZD"] = array("New Zealand Dollar", "&#36;", 0);

		$payments_supported_currencies['authorizenet'] = $authorizenet;

		$stripe = array();
		$stripe["AED"] = array("United Arab Emirates Dirham","",0);
		$stripe["AFN"] = array("Afghan Afghani","",1);
		$stripe["ALL"] = array("Albanian Lek","",0);
		$stripe["AMD"] = array("Armenian Dram","&#1423;",0);
		$stripe["ANG"] = array("Netherlands Antillean Gulden","",0);
		$stripe["AOA"] = array("Angolan Kwanza","",1);
		$stripe["ARS"] = array("Argentine Peso","",1);
		$stripe["AUD"] = array("Australian Dollar","&#36;",0);
		$stripe["AWG"] = array("Aruban Florin","",0);
		$stripe["AZN"] = array("Azerbaijani Manat","",0);
		$stripe["BAM"] = array("Bosnia & Herzegovina Convertible Mark","",0);
		$stripe["BBD"] = array("Barbadian Dollar","",0);
		$stripe["BDT"] = array("Bangladeshi Taka","",0);
		$stripe["BGN"] = array("Bulgarian Lev","",0);
		$stripe["BIF"] = array("Burundian Franc","",0);
		$stripe["BIF"] = array("Burundian Franc","",0);
		$stripe["BMD"] = array("Bermudian Dollar","&#36;",0);
		$stripe["BND"] = array("Brunei Dollar","&#36;",0);
		$stripe["BOB"] = array("Bolivian Boliviano","",1);
		$stripe["BRL"] = array("Brazilian Real","&#82;&#36;",1);
		$stripe["BSD"] = array("Bahamian Dollar","&#36;",0);
		$stripe["BWP"] = array("Botswana Pula","",0);
		$stripe["BZD"] = array("Belize Dollar","&#36;",0);
		$stripe["CAD"] = array("Canadian Dollar","&#36;",0);
		$stripe["CDF"] = array("Congolese Franc","",0);
		$stripe["CHF"] = array("Swiss Franc","&#67;&#72;&#70;",0);
		$stripe["CLP"] = array("Chilean Peso","",1);
		$stripe["CNY"] = array("Chinese Renminbi Yuan","",0);
		$stripe["COP"] = array("Colombian Peso","",1);
		$stripe["CRC"] = array("Costa Rican Colón","",1);
		$stripe["CVE"] = array("Cape Verdean Escudo","",1);
		$stripe["CZK"] = array("Czech Koruna","&#75;&#269;",1);
		$stripe["DJF"] = array("Djiboutian Franc","",1);
		$stripe["DKK"] = array("Danish Krone","&#107;&#114;",0);
		$stripe["DOP"] = array("Dominican Peso","",0);
		$stripe["DZD"] = array("Algerian Dinar","",0);
		$stripe["EEK"] = array("Estonian Kroon","",1);
		$stripe["EGP"] = array("Egyptian Pound","",0);
		$stripe["ETB"] = array("Ethiopian Birr","",0);
		$stripe["EUR"] = array("Euro","&#8364;",0);
		$stripe["FJD"] = array("Fijian Dollar","&#36;",0);
		$stripe["FKP"] = array("Falkland Islands Pound","",1);
		$stripe["GBP"] = array("British Pound","",0);
		$stripe["GEL"] = array("Georgian Lari","",0);
		$stripe["GIP"] = array("Gibraltar Pound","",0);
		$stripe["GMD"] = array("Gambian Dalasi","",0);
		$stripe["GNF"] = array("Guinean Franc","",1);
		$stripe["GTQ"] = array("Guatemalan Quetzal","",0);
		$stripe["GYD"] = array("Guyanese Dollar","&#36;",0);
		$stripe["HKD"] = array("Hong Kong Dollar","&#36;",0);
		$stripe["HNL"] = array("Honduran Lempira","",1);
		$stripe["HRK"] = array("Croatian Kuna","",0);
		$stripe["HTG"] = array("Haitian Gourde","",0);
		$stripe["HUF"] = array("Hungarian Forint","&#70;&#116;",1);
		$stripe["IDR"] = array("Indonesian Rupiah","",0);
		$stripe["ILS"] = array("Israeli New Sheqel","&#8362;",0);
		$stripe["INR"] = array("Indian Rupee","",1);
		$stripe["ISK"] = array("Icelandic Króna","",0);
		$stripe["JMD"] = array("Jamaican Dollar","",0);
		$stripe["JPY"] = array("Japanese Yen","",0);
		$stripe["KES"] = array("Kenyan Shilling","",0);
		$stripe["KGS"] = array("Kyrgyzstani Som","",0);
		$stripe["KHR"] = array("Cambodian Riel","",0);
		$stripe["KMF"] = array("Comorian Franc","",0);
		$stripe["KRW"] = array("South Korean Won","",0);
		$stripe["KYD"] = array("Cayman Islands Dollar","",0);
		$stripe["KZT"] = array("Kazakhstani Tenge","",0);
		$stripe["LAK"] = array("Lao Kip","",1);
		$stripe["LBP"] = array("Lebanese Pound","",0);
		$stripe["LKR"] = array("Sri Lankan Rupee","",0);
		$stripe["LRD"] = array("Liberian Dollar","&#36;",0);
		$stripe["LSL"] = array("Lesotho Loti","",0);
		$stripe["LTL"] = array("Lithuanian Litas","",0);
		$stripe["LVL"] = array("Latvian Lats","",0);
		$stripe["MAD"] = array("Moroccan Dirham","",0);
		$stripe["MDL"] = array("Moldovan Leu","",0);
		$stripe["MGA"] = array("Malagasy Ariary","",0);
		$stripe["MKD"] = array("Macedonian Denar","",0);
		$stripe["MNT"] = array("Mongolian Tögrög","",0);
		$stripe["MOP"] = array("Macanese Pataca","",0);
		$stripe["MRO"] = array("Mauritanian Ouguiya","",0);
		$stripe["MUR"] = array("Mauritian Rupee","",1);
		$stripe["MVR"] = array("Maldivian Rufiyaa","",0);
		$stripe["MWK"] = array("Malawian Kwacha","",0);
		$stripe["MXN"] = array("Mexican Peso","",1);
		$stripe["MYR"] = array("Malaysian Ringgit","",0);
		$stripe["MZN"] = array("Mozambican Metical","",0);
		$stripe["NAD"] = array("Namibian Dollar","&#36;",0);
		$stripe["NGN"] = array("Nigerian Naira","",0);
		$stripe["NIO"] = array("Nicaraguan Córdoba","",1);
		$stripe["NOK"] = array("Norwegian Krone","",0);
		$stripe["NPR"] = array("Nepalese Rupee","",0);
		$stripe["NZD"] = array("New Zealand Dollar","&#36;",0);
		$stripe["PAB"] = array("Panamanian Balboa","",1);
		$stripe["PEN"] = array("Peruvian Nuevo Sol","",1);
		$stripe["PGK"] = array("Papua New Guinean Kina","",0);
		$stripe["PHP"] = array("Philippine Peso","",0);
		$stripe["PKR"] = array("Pakistani Rupee","",0);
		$stripe["PLN"] = array("Polish Złoty","",0);
		$stripe["PYG"] = array("Paraguayan Guaraní","",1);
		$stripe["QAR"] = array("Qatari Riyal","",0);
		$stripe["RON"] = array("Romanian Leu","",0);
		$stripe["RSD"] = array("Serbian Dinar","",0);
		$stripe["RUB"] = array("Russian Ruble","",0);
		$stripe["RWF"] = array("Rwandan Franc","",0);
		$stripe["SAR"] = array("Saudi Riyal","",0);
		$stripe["SBD"] = array("Solomon Islands Dollar","&#36;",0);
		$stripe["SCR"] = array("Seychellois Rupee","&#36;",0);
		$stripe["SEK"] = array("Swedish Krona","",0);
		$stripe["SGD"] = array("Singapore Dollar","&#36;",0);
		$stripe["SHP"] = array("Saint Helenian Pound","",1);
		$stripe["SLL"] = array("Sierra Leonean Leone","",0);
		$stripe["SOS"] = array("Somali Shilling","",0);
		$stripe["SRD"] = array("Surinamese Dollar","&#36;",1);
		$stripe["STD"] = array("São Tomé and Príncipe Dobra","",0);
		$stripe["SVC"] = array("Salvadoran Colón","",1);
		$stripe["SZL"] = array("Swazi Lilangeni","",0);
		$stripe["THB"] = array("Thai Baht","",0);
		$stripe["TJS"] = array("Tajikistani Somoni","",0);
		$stripe["TOP"] = array("Tongan Paʻanga","",0);
		$stripe["TRY"] = array("Turkish Lira","",0);
		$stripe["TTD"] = array("Trinidad and Tobago Dollar","&#36;",0);
		$stripe["TTD"] = array("New Taiwan Dollar","&#36;",0);
		$stripe["TZS"] = array("Tanzanian Shilling","",0);
		$stripe["UAH"] = array("Ukrainian Hryvnia","",0);
		$stripe["UGX"] = array("Ugandan Shilling","",0);
		$stripe["USD"] = array("United States Dollar","&#36;",0);
		$stripe["UYU"] = array("Uruguayan Peso","",1);
		$stripe["UZS"] = array("Uzbekistani Som","",0);
		$stripe["VEF"] = array("Venezuelan Bolívar","",1);
		$stripe["VND"] = array("Vietnamese Đồng","",0);
		$stripe["VUV"] = array("Vanuatu Vatu","",0);
		$stripe["WST"] = array("Samoan Tala","",0);
		$stripe["XAF"] = array("Central African Cfa Franc","",0);
		$stripe["XCD"] = array("East Caribbean Dollar","&#36;",0);
		$stripe["XOF"] = array("West African Cfa Franc","",1);
		$stripe["XPF"] = array("Cfp Franc","",1);
		$stripe["YER"] = array("Yemeni Rial","",0);
		$stripe["ZAR"] = array("South African Rand","",0);
		$stripe["ZMW"] = array("Zambian Kwacha","",0);
		
		$payments_supported_currencies['stripe'] = $stripe;
		
		$paypal = array();
		$paypal["AUD"] = array("Australian Dollar","&#36;",0);
		$paypal["BRL"] = array("Brazilian Real","&#82;&#36;",1);
		$paypal["CAD"] = array("Canadian Dollar","&#36;",0);
		$paypal["CZK"] = array("Czech Koruna","&#75;&#269;",0);
		$paypal["DKK"] = array("Danish Krone","&#107;&#114;",0);
		$paypal["EUR"] = array("Euro","&#8364;",0);
		$paypal["HKD"] = array("Hong Kong Dollar","&#36;",0);
		$paypal["HUF"] = array("Hungarian Forint","&#70;&#116;",0);
		$paypal["ILS"] = array("Israeli New Sheqel","&#8362;",0);
		$paypal["JPY"] = array("Japanese Yen","&#165;",0);
		$paypal["MYR"] = array("Malaysian Ringgit","&#82;&#77;",1);
		$paypal["MXN"] = array("Mexican Peso","&#36;",0);
		$paypal["NOK"] = array("Norwegian Krone","&#107;&#114;",0);
		$paypal["NZD"] = array("New Zealand Dollar","&#36;",0);
		$paypal["PHP"] = array("Philippine Peso","&#8369;",0);
		$paypal["PLN"] = array("Polish Zloty","&#122;&#322;",0);
		$paypal["GBP"] = array("Pound Sterling","&#163;",0);
		$paypal["RUB"] = array("Russian Ruble","&#1088;&#1091;&#1073;",0);
		$paypal["SGD"] = array("Singapore Dollar","&#36;",0);
		$paypal["SEK"] = array("Swedish Krona","&#107;&#114;",0);
		$paypal["CHF"] = array("Swiss Franc","&#67;&#72;&#70;",0);
		$paypal["TWD"] = array("Taiwan New Dollar","&#78;&#84;&#36;",0);
		$paypal["THB"] = array("Thai Baht","&#3647;",0);
		$paypal["TRY"] = array("Turkish Lira","&#8356;",1);
		$paypal["USD"] = array("United States Dollar","&#36;",0);

		$payments_supported_currencies['paypal'] = $paypal;

		return $payments_supported_currencies;
	}
}