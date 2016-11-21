<?php

function wde_update($version) {
  global $wpdb;
  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_tax_rates` (
    `id`		 		INT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `country` 	 	INT(20) NOT NULL,
    `state`			VARCHAR(200) NOT NULL,
    `zipcode`	 		VARCHAR(200) NOT NULL,
    `city` 	 		VARCHAR(200) NOT NULL,
    `rate` 			DECIMAL(16,2) NOT NULL,
    `tax_name` 		VARCHAR(200) NOT NULL,
    `priority` 		INT(20) NOT NULL,
    `compound` 		INT(20) NOT NULL,
    `shipping_rate` 	DECIMAL(16,2) NOT NULL,
    `ordering` 		INT(20) NOT NULL,
    `tax_id` 			INT(20) NOT NULL,
    PRIMARY KEY (`id`)
    )
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8
    AUTO_INCREMENT = 1;");
  if (version_compare($version, '1.1.0') == -1) {
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'ecommercewd_options` (`id`, `name`, `value`, `default_value`) VALUES
      ("", "enable_tax", 1, 1),
      ("", "round_tax_at_subtotal", 0, 0),
      ("", "price_entered_with_tax", 0, 0),
      ("", "option_include_tax_in_checkout_price", 0, 0),
      ("", "tax_based_on", "shipping_address", "shipping_address"),
      ("", "price_display_suffix", "", ""),
      ("", "base_location", "", ""),
      ("", "tax_total_display", "single", "single")');
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "ecommercewd_orderproducts ADD `discount_rate` int(3) DEFAULT NULL");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "ecommercewd_orderproducts ADD `discount` decimal(16,2) DEFAULT NULL");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "ecommercewd_orderproducts ADD `shipping_method_type` varchar(10) DEFAULT NULL");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "ecommercewd_orderproducts ADD `tax_info` longtext DEFAULT ''");
  }
  return;
}
