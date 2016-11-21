<?php

function wde_insert() {
  global $wpdb;

  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_currencies` (
    `id`            INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`          VARCHAR(256)     NOT NULL,
    `code`          VARCHAR(256)     NOT NULL,
    `sign`          VARCHAR(256)     NOT NULL,
    `sign_position` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `exchange_rate` DECIMAL(10, 5)   NOT NULL,
    `default`       TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;");
  
  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_options` (
    `id`            INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`          VARCHAR(256)     NOT NULL,
    `value`         LONGTEXT     NOT NULL,
    `default_value` LONGTEXT     NOT NULL,
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;");

  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_orderproducts` (
    `id`                    INT(16) UNSIGNED   NOT NULL AUTO_INCREMENT,
    `rand_id`               INT(16) UNSIGNED   NOT NULL,
    `order_id`              INT(16)   UNSIGNED NOT NULL,
    `j_user_id`             INT(16)   UNSIGNED NOT NULL,
    `user_ip_address`       VARCHAR(256)            NOT NULL,
    `product_id`            INT(16)   UNSIGNED NOT NULL,
    `product_name`          VARCHAR(256)       NOT NULL,
    `product_image`         TEXT,
    `product_parameters`    TEXT,
    `product_parameters_price` VARCHAR(256) NOT NULL,
    `product_price`         DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
    `product_count`         INT(16)  UNSIGNED  NOT NULL,
    `tax_id`                INT(16)   UNSIGNED NOT NULL,
    `tax_name`              VARCHAR(1024)      NOT NULL,
    `tax_price`             DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
    `shipping_method_id`    INT(16)   UNSIGNED NOT NULL,
    `shipping_method_name`  VARCHAR(1024)      NOT NULL,
    `shipping_method_price` DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
    `currency_id`           INT(16)   UNSIGNED NOT NULL,
    `currency_code`         VARCHAR(1024)      NOT NULL,
    `discount_rate`         int(3) DEFAULT 0,
    `discount`              decimal(16,2) DEFAULT 0,
    `shipping_method_type`  VARCHAR(10) DEFAULT '',
    `tax_info`              longtext DEFAULT '',
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;");

  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_orders` (
    `id`                        INT(16) UNSIGNED        NOT NULL AUTO_INCREMENT,
    `rand_id`                   INT(16) UNSIGNED        NOT NULL,
    `checkout_type`             VARCHAR(256)            NOT NULL,
    `checkout_date`             DATETIME,
    `date_modified`             TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `j_user_id`                 INT(16) UNSIGNED,
    `user_ip_address`           VARCHAR(256)            NOT NULL,
    `status_id`                 INT(16) UNSIGNED,
    `status_name`               VARCHAR(256)            NOT NULL,
    `payment_method`            VARCHAR(256)            NOT NULL,
    `payment_data`              TEXT
                                CHARACTER SET utf8
                                COLLATE utf8_unicode_ci NOT NULL,
    `payment_data_status`       VARCHAR(256)            NOT NULL,
    `billing_data_first_name`   VARCHAR(256)            NOT NULL,
    `billing_data_middle_name`  VARCHAR(256)            NOT NULL,
    `billing_data_last_name`    VARCHAR(256)            NOT NULL,
    `billing_data_company`      VARCHAR(256)            NOT NULL,
    `billing_data_email`        VARCHAR(256)            NOT NULL,
    `billing_data_country_id`   INT(16) UNSIGNED        NOT NULL,
    `billing_data_country`      VARCHAR(256)            NOT NULL,
    `billing_data_state`        VARCHAR(256)            NOT NULL,
    `billing_data_city`         VARCHAR(256)            NOT NULL,
    `billing_data_address`      VARCHAR(256)            NOT NULL,
    `billing_data_mobile`       VARCHAR(256)            NOT NULL,
    `billing_data_phone`        VARCHAR(256)            NOT NULL,
    `billing_data_fax`          VARCHAR(256)            NOT NULL,
    `billing_data_zip_code`     VARCHAR(256)            NOT NULL,
    `shipping_data_first_name`  VARCHAR(256)            NOT NULL,
    `shipping_data_middle_name` VARCHAR(256)            NOT NULL,
    `shipping_data_last_name`   VARCHAR(256)            NOT NULL,
    `shipping_data_company`     VARCHAR(256)            NOT NULL,
    `shipping_data_country_id`  INT(16) UNSIGNED        NOT NULL,
    `shipping_data_country`     VARCHAR(256)            NOT NULL,
    `shipping_data_state`       VARCHAR(256)            NOT NULL,
    `shipping_data_city`        VARCHAR(256)            NOT NULL,
    `shipping_data_address`     VARCHAR(256)            NOT NULL,
    `shipping_data_zip_code`    VARCHAR(256)            NOT NULL,
    `shipping_type`             VARCHAR(1024)           NOT NULL,
    `shipping_method_price`     DECIMAL(16, 2) UNSIGNED DEFAULT NULL,
    `currency_id`               INT(16)   UNSIGNED      NOT NULL,
    `currency_code`             VARCHAR(1024)           NOT NULL,
    `read`                      TINYINT UNSIGNED        NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;");

  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_orderstatuses` (
    `id`        INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`      VARCHAR(256)     NOT NULL,
    `ordering`  INT(16)          NOT NULL,
    `published` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `default`   TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;");
  
  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_parametertypes` (
    `id`       INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`     VARCHAR(256)     NOT NULL,
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;");

  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_payments` (
    `id`         INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
    `tool_id`    INT(16) UNSIGNED NOT NULL,
    `name`       VARCHAR(256)     NOT NULL,
    `options`    LONGTEXT         NOT NULL,
    `short_name` VARCHAR(256)     NOT NULL,
    `base_name`  VARCHAR(256)     NOT NULL,
    `ordering`   INT(16)          NOT NULL,
    `published`  TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;");

  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_ratings` (
    `id`              INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
    `j_user_id`       INT(16) UNSIGNED,
    `user_ip_address` VARCHAR(256)     NOT NULL,
    `product_id`      INT(16)          NOT NULL,
    `rating`          INT(16)          NOT NULL,
    `date`            DATETIME         NOT NULL,
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;");

  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_tools` (
    `id`        	         INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`      	         VARCHAR(256)     NOT NULL,
    `create_toolbar_icon`  INT(16) UNSIGNED NOT NULL,
    `author_url`           VARCHAR(256)     NOT NULL,
    `description`          VARCHAR(256)     NOT NULL,
    `tool_type`            VARCHAR(256)     NOT NULL,
    `creation_date`        DATE     		  NOT NULL,
    `published` 	         TINYINT UNSIGNED NOT NULL DEFAULT 1, 
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;");

  $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ecommercewd_themes` (
    `id`                                                  INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`                                                VARCHAR(256)     NOT NULL,
    `data`                                                mediumtext       NOT NULL,
    `basic`                                               TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `default`                                             TINYINT UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
    )
    ENGINE = MyISAM
    DEFAULT CHARSET = utf8
    AUTO_INCREMENT = 1;");

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

  $wde_sample_data = array();
  $wde_sample_data['wde_images'] = array();
  /* tags */
  $wde_tag_ipad = wp_insert_term('ipad', 'wde_tag');
  $wde_tag_ipad = is_wp_error($wde_tag_ipad) ? '' : $wde_tag_ipad['term_id'];
  $wde_tag_tablet = wp_insert_term('tablet', 'wde_tag');
  $wde_tag_tablet = is_wp_error($wde_tag_tablet) ? '' : $wde_tag_tablet['term_id'];
  $wde_tag_phone = wp_insert_term('phone', 'wde_tag');
  $wde_tag_phone = is_wp_error($wde_tag_phone) ? '' : $wde_tag_phone['term_id'];
  $wde_sample_data['wde_tag'] = array($wde_tag_ipad, $wde_tag_tablet, $wde_tag_phone);
  
  /* categories */
  $wde_sample_data['wde_categories'] = array();
  $wde_category_tablets = wp_insert_term(
    'Tablets', // the term 
    'wde_categories', // the taxonomy
    array(
      'description'=> 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    )
  );
  if (!is_wp_error($wde_category_tablets)) {
    $term_meta = array();
    $img_id = wde_add_to_media_library(WD_E_URL . '/images/categories/thumb/tablets.jpg');
    $wde_sample_data['wde_images'][] = $img_id;
    $term_meta['images'] = $img_id;
    $term_meta['tags'] = '[\"' . $wde_tag_tablet . '\"]';
    $term_meta['parameters'] = '';
    update_option("wde_categories_" . $wde_category_tablets['term_id'], $term_meta);
    $wde_sample_data['wde_categories'][] = $wde_category_tablets['term_id'];
  }
  else {
    $wde_category_tablets = '';
  }
  
  $wde_category_phones = wp_insert_term(
    'Phones', // the term 
    'wde_categories', // the taxonomy
    array(
      'description'=> 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    )
  );
  if (!is_wp_error($wde_category_phones)) {
    $term_meta = array();
    $img_id = wde_add_to_media_library(WD_E_URL . '/images/categories/thumb/phones.jpg');
    $wde_sample_data['wde_images'][] = $img_id;
    $term_meta['images'] = $img_id;
    $term_meta['tags'] = '[\"' . $wde_tag_phone . '\"]';
    $term_meta['parameters'] = '';
    update_option("wde_categories_" . $wde_category_phones['term_id'], $term_meta);
    $wde_sample_data['wde_categories'][] = $wde_category_phones['term_id'];
  }
  else {
    $wde_category_phones = '';
  }

  /* labels */
  $wde_sample_data['wde_labels'] = array();
  $wde_label_sale = wp_insert_term('Sale', 'wde_labels');
  if (!is_wp_error($wde_label_sale)) {
    $term_meta = array();
    $img_id = wde_add_to_media_library(WD_E_URL . '/images/labels/thumb/03.png');
    $wde_sample_data['wde_images'][] = $img_id;
    $term_meta['thumb'] = $img_id;
    $term_meta['thumb_position'] = 0;
    update_option("wde_labels_" . $wde_label_sale['term_id'], $term_meta);
    $wde_sample_data['wde_labels'][] = $wde_label_sale['term_id'];
  }
  else {
    $wde_label_sale = '';
  }
  
  $wde_label_new = wp_insert_term('New', 'wde_labels');
  if (!is_wp_error($wde_label_new)) {
    $term_meta = array();
    $img_id = wde_add_to_media_library(WD_E_URL . '/images/labels/thumb/01.png');
    $wde_sample_data['wde_images'][] = $img_id;
    $term_meta['thumb'] = $img_id;
    $term_meta['thumb_position'] = 0;
    update_option("wde_labels_" . $wde_label_new['term_id'], $term_meta);
    $wde_sample_data['wde_labels'][] = $wde_label_new['term_id'];
  }
  else {
    $wde_label_new = '';
  }
  
  $wde_label_best_offer = wp_insert_term('Best Offer', 'wde_labels');
  if (!is_wp_error($wde_label_best_offer)) {
    $term_meta = array();
    $img_id = wde_add_to_media_library(WD_E_URL . '/images/labels/thumb/02.png');
    $wde_sample_data['wde_images'][] = $img_id;
    $term_meta['thumb'] = $img_id;
    $term_meta['thumb_position'] = 0;
    update_option("wde_labels_" . $wde_label_best_offer['term_id'], $term_meta);
    $wde_sample_data['wde_labels'][] = $wde_label_best_offer['term_id'];
  }
  else {
    $wde_label_best_offer = '';
  }
  
  /* manufacturers */
  $wde_manufacturer_apple = array(
    'post_content'   => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    'post_status'    => 'publish',
    'post_title'     => 'Apple',
    'post_type'      => 'wde_manufacturers'
  );  
  $wde_manufacturer_apple = wp_insert_post($wde_manufacturer_apple);
  $img_id = wde_add_to_media_library(WD_E_URL . '/images/manufacturers/apple.jpg');
  $wde_sample_data['wde_images'][] = $img_id;
  set_post_thumbnail($wde_manufacturer_apple, $img_id);
  update_post_meta($wde_manufacturer_apple, 'wde_show_info', 1);
  update_post_meta($wde_manufacturer_apple, 'wde_show_products', 1);
  
  $wde_manufacturer_samsung = array(
    'post_content'   => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    'post_status'    => 'publish',
    'post_title'     => 'Samsung',
    'post_type'      => 'wde_manufacturers'
  );  
  $wde_manufacturer_samsung = wp_insert_post($wde_manufacturer_samsung);
  $img_id = wde_add_to_media_library(WD_E_URL . '/images/manufacturers/samsung.jpg');
  $wde_sample_data['wde_images'][] = $img_id;
  set_post_thumbnail($wde_manufacturer_samsung, $img_id);
  update_post_meta($wde_manufacturer_samsung, 'wde_show_info', 1);
  update_post_meta($wde_manufacturer_samsung, 'wde_show_products', 1);

  $wde_sample_data['wde_manufacturers'] = array($wde_manufacturer_apple, $wde_manufacturer_samsung);
 
  /* parametres */
  $wde_sample_data['wde_parameters'] = array();
  $wde_parameter_color = wp_insert_term('Color', 'wde_parameters');
  if (!is_wp_error($wde_parameter_color)) {
    $term_meta = array();
    $term_meta['type_id'] = 3;
    update_option("wde_parameters_" . $wde_parameter_color['term_id'], $term_meta);
    $wde_sample_data['wde_parameters'][] = $wde_parameter_color['term_id'];
    $wde_parameter_color = get_term($wde_parameter_color['term_id'], 'wde_parameters');
    $labels = array();
    $args = array(
      'labels'                 => $labels,
      'public'                 => TRUE,
      'show_ui'                => TRUE,
      'show_in_menu'           => FALSE,
      'show_in_nav_menus'      => FALSE,
      'show_tagcloud'          => FALSE,
      'show_in_quick_edit'     => FALSE,
      'meta_box_cb'            => NULL,
      'show_admin_column'      => FALSE,
      'hierarchical'           => FALSE,
      'update_count_callback'  => NULL,
      'query_var'              => FALSE,
      'rewrite'                => array('slug' => 'wde_par_' . $wde_parameter_color->slug),
      'sort'                   => TRUE,
    );
    register_taxonomy('wde_par_' . $wde_parameter_color->slug, 'wde_products', $args);
    $wde_parameter_color_pink = wp_insert_term('pink', 'wde_par_' . $wde_parameter_color->slug);
    $wde_parameter_color_black = wp_insert_term('black', 'wde_par_' . $wde_parameter_color->slug);
    $wde_parameter_color_white = wp_insert_term('white', 'wde_par_' . $wde_parameter_color->slug);
  }
  else {
    $wde_parameter_color_pink = '';
    $wde_parameter_color_black = '';
    $wde_parameter_color_white = '';
    $wde_parameter_color->term_id = '';
  }

  $wpdb->query("INSERT INTO `" . $wpdb->prefix . "ecommercewd_parametertypes` (`id`, `name`)
    VALUES
    ('', 'Input'),
    ('', 'Single value'),
    ('', 'Select'),
    ('', 'Radio'),
    ('', 'Checkbox')");
  
  /* products */
  $wde_product_iPad = array(
    'post_content'   => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    'post_status'    => 'publish',
    'post_title'     => 'iPad',
    'post_parent'     => $wde_manufacturer_apple,
    'post_type'      => 'wde_products'
  );  
  $wde_product_iPad = wp_insert_post($wde_product_iPad);
  $img_id = wde_add_to_media_library(WD_E_URL . '/images/products/ipad/thumb/01.jpg');
  $wde_sample_data['wde_images'][] = $img_id;
  set_post_thumbnail($wde_product_iPad, $img_id);
  $img_id = array();
  $img_id[] = wde_add_to_media_library(WD_E_URL . '/images/products/ipad/thumb/02.jpg');
  $img_id[] = wde_add_to_media_library(WD_E_URL . '/images/products/ipad/thumb/03.jpg');
  $img_id[] = wde_add_to_media_library(WD_E_URL . '/images/products/ipad/thumb/04.jpg');
  $wde_sample_data['wde_images'] = array_merge($wde_sample_data['wde_images'], $img_id);
  update_post_meta($wde_product_iPad, 'wde_images', implode(',', $img_id));
  update_post_meta($wde_product_iPad, 'wde_price', 499.00);
  update_post_meta($wde_product_iPad, 'wde_market_price', 600.00);
  update_post_meta($wde_product_iPad, 'wde_unlimited', 1);
  update_post_meta($wde_product_iPad, 'wde_parameters', addslashes('[{"id":"' . $wde_parameter_color->term_id . '","type_id":"3","values":["{\"value\":\"black\",\"price\":\"+\"}","{\"value\":\"white\",\"price\":\"+\"}"]}]'));
  wp_set_object_terms($wde_product_iPad, $wde_label_sale, 'wde_labels', FALSE);
  wp_set_object_terms($wde_product_iPad, $wde_category_tablets, 'wde_categories', FALSE);
  wp_set_object_terms($wde_product_iPad, array($wde_tag_ipad, $wde_tag_tablet), 'wde_tag', FALSE);
  
  $wde_product_galaxy = array(
    'post_content'   => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    'post_status'    => 'publish',
    'post_title'     => 'Samsung Galaxy Note3',
    'post_parent'     => $wde_manufacturer_samsung,
    'post_type'      => 'wde_products'
  );  
  $wde_product_galaxy = wp_insert_post($wde_product_galaxy);
  $img_id = wde_add_to_media_library(WD_E_URL . '/images/products/note3/thumb/01.jpg');
  $wde_sample_data['wde_images'][] = $img_id;
  set_post_thumbnail($wde_product_galaxy, $img_id);
  $img_id = wde_add_to_media_library(WD_E_URL . '/images/products/note3/thumb/02.jpg');
  $wde_sample_data['wde_images'][] = $img_id;
  update_post_meta($wde_product_galaxy, 'wde_images', $img_id);
  update_post_meta($wde_product_galaxy, 'wde_price', 400.00);
  update_post_meta($wde_product_galaxy, 'wde_unlimited', 1);
  update_post_meta($wde_product_galaxy, 'wde_parameters', addslashes('[{"id":"' . $wde_parameter_color->term_id . '","type_id":"3","values":["{\"value\":\"black\",\"price\":\"+\"}","{\"value\":\"pink\",\"price\":\"+\"}","{\"value\":\"white\",\"price\":\"+\"}"]}]'));
  wp_set_object_terms($wde_product_galaxy, $wde_label_best_offer, 'wde_labels', FALSE);
  wp_set_object_terms($wde_product_galaxy, $wde_category_phones, 'wde_categories', FALSE);
  wp_set_object_terms($wde_product_galaxy, $wde_tag_phone, 'wde_tag', FALSE);
  $wde_sample_data['wde_products'] = array($wde_product_iPad, $wde_product_galaxy);
  
  /* currencies */
  $wpdb->query("INSERT INTO `" . $wpdb->prefix . "ecommercewd_currencies` (`id`, `name`, `code`, `sign`, `sign_position`, `exchange_rate`, `default`)
    VALUES
    ('', '" . __('Argentine Peso', 'wde') . "', 'ARS', '&#36;', 1, 1.00, 0),
    ('', '" . __('Australian Dollars', 'wde') . "', 'AUD', '&#36;', 1, 1.00, 0),
    ('', '" . __('Bangladeshi Taka', 'wde') . "', 'BDT', '&#2547;&nbsp;', 1, 1.00, 0),
    ('', '" . __('Bulgarian Lev', 'wde') . "', 'BGN', '&#1083;&#1074;.', 1, 1.00, 0),
    ('', '" . __('Brazilian Real', 'wde') . "', 'BRL', '&#82;&#36;', 1, 1.00, 0),
    ('', '" . __('Canadian Dollars', 'wde') . "', 'CAD', '&#36;', 1, 1.00, 0),
    ('', '" . __('Swiss Franc', 'wde') . "', 'CHF', '&#67;&#72;&#70;', 1, 1.00, 0),
    ('', '" . __('Chilean Peso', 'wde') . "', 'CLP', '&#36;', 1, 1.00, 0),
    ('', '" . __('Chinese Yuan', 'wde') . "', 'CNY', '&yen;', 1, 1.00, 0),
    ('', '" . __('Colombian Peso', 'wde') . "', 'COP', '&#36;', 1, 1.00, 0),
    ('', '" . __('Czech Koruna', 'wde') . "', 'CZK', '&#75;&#269;', 1, 1.00, 0),
    ('', '" . __('Danish Krone', 'wde') . "', 'DKK', 'DKK', 1, 1.00, 0),
    ('', '" . __('Dominican Peso', 'wde') . "', 'DOP', 'RD&#36;', 1, 1.00, 0),
    ('', '" . __('Egyptian Pound', 'wde') . "', 'EGP', 'EGP', 1, 1.00, 0),
    ('', '" . __('Euros', 'wde') . "', 'EUR', '&euro;', 1, 1.00, 0),
    ('', '" . __('Pounds Sterling', 'wde') . "', 'GBP', '&pound;', 1, 1.00, 0),
    ('', '" . __('Hong Kong Dollar', 'wde') . "', 'HKD', '&#36;', 1, 1.00, 0),
    ('', '" . __('Croatia kuna', 'wde') . "', 'HRK', 'Kn', 1, 1.00, 0),
    ('', '" . __('Hungarian Forint', 'wde') . "', 'HUF', '&#70;&#116;', 1, 1.00, 0),
    ('', '" . __('Indonesia Rupiah', 'wde') . "', 'IDR', 'Rp', 1, 1.00, 0),
    ('', '" . __('Israeli Shekel', 'wde') . "', 'ILS', '&#8362;', 1, 1.00, 0),
    ('', '" . __('Indian Rupee', 'wde') . "', 'INR', '&#8377;', 1, 1.00, 0),
    ('', '" . __('Icelandic krona', 'wde') . "', 'ISK', 'Kr.', 1, 1.00, 0),
    ('', '" . __('Japanese Yen', 'wde') . "', 'JPY', '&yen;', 1, 1.00, 0),
    ('', '" . __('Kenyan shilling', 'wde') . "', 'KES', 'KSh', 1, 1.00, 0),
    ('', '" . __('Lao Kip', 'wde') . "', 'LAK', '&#8365;', 1, 1.00, 0),
    ('', '" . __('South Korean Won', 'wde') . "', 'KRW', '&#8361;', 1, 1.00, 0),
    ('', '" . __('Mexican Peso', 'wde') . "', 'MXN', '&#36;', 1, 1.00, 0),
    ('', '" . __('Malaysian Ringgits', 'wde') . "', 'MYR', '&#82;&#77;', 1, 1.00, 0),
    ('', '" . __('Nigerian Naira', 'wde') . "', 'NGN', '&#8358;', 1, 1.00, 0),
    ('', '" . __('Norwegian Krone', 'wde') . "', 'NOK', '&#107;&#114;', 1, 1.00, 0),
    ('', '" . __('Nepali Rupee', 'wde') . "', 'NPR', '&#8360;', 1, 1.00, 0),
    ('', '" . __('New Zealand Dollar', 'wde') . "', 'NZD', '&#36;', 1, 1.00, 0),
    ('', '" . __('Philippine Pesos', 'wde') . "', 'PHP', '&#8369;', 1, 1.00, 0),
    ('', '" . __('Pakistani Rupee', 'wde') . "', 'PKR', '&#8360;', 1, 1.00, 0),
    ('', '" . __('Polish Zloty', 'wde') . "', 'PLN', '&#122;&#322;', 1, 1.00, 0),
    ('', '" . __('Paraguayan Guarani', 'wde') . "', 'PYG', '&#8370;', 1, 1.00, 0),
    ('', '" . __('Romanian Leu', 'wde') . "', 'RON', 'lei', 1, 1.00, 0),
    ('', '" . __('Russian Ruble', 'wde') . "', 'RUB', '&#1088;&#1091;&#1073;.', 1, 1.00, 0),
    ('', '" . __('Swedish Krona', 'wde') . "', 'SEK', '&#107;&#114;', 1, 1.00, 0),
    ('', '" . __('Singapore Dollar', 'wde') . "', 'SGD', '&#36;', 1, 1.00, 0),
    ('', '" . __('Thai Baht', 'wde') . "', 'THB', '&#3647;', 1, 1.00, 0),
    ('', '" . __('Turkish Lira', 'wde') . "', 'TRY', '&#8378;', 1, 1.00, 0),
    ('', '" . __('Taiwan New Dollars', 'wde') . "', 'TWD', '&#78;&#84;&#36;', 1, 1.00, 0),
    ('', '" . __('Ukrainian Hryvnia', 'wde') . "', 'UAH', '&#8372;', 1, 1.00, 0),
    ('', '" . __('US Dollars', 'wde') . "', 'USD', '&#36;', 1, 1.00, 1),
    ('', '" . __('Vietnamese Dong', 'wde') . "', 'VND', '&#8363;', 1, 1.00, 0),
    ('', '" . __('South African rand', 'wde') . "', 'ZAR', '&#82;', 1, 1.00, 0)
    ");

  /* payments */
  $wpdb->query("INSERT INTO `" . $wpdb->prefix . "ecommercewd_payments` (`id`, `tool_id` ,`name`, `short_name`, `base_name`, `ordering`, `options`, `published`)
    VALUES
    ('','', '" . __('Without Online Payment', 'wde') . "', 'without_online_payment', '',1, '', 1),
    ('', '', '" . __('Paypal Standard', 'wde') . "','paypalstandard', 'paypalstandard', 2, '{\"mode\":0,\"paypal_email\":\"\"}', 1),
    ('', '', '" . __('Paypal Express Checkout', 'wde') . "', 'paypalexpress', 'paypalexpress', 3, '{\"mode\":0,\"paypal_user\":\"\",\"paypal_password\":\"\",\"paypal_signature\":\"\"}', 0)");

  /* create standart posts for ecommerce-wd */
  /* all products */
  $wde_post_args = array(
    'post_title'    => __('All Products', 'wde'),
    'post_content'  => '[wde arrangement="thumbs" category_name="Main" category_id="0" manufacturer_id="0" max_price="" min_price="" date_added="0" min_rating="0" tags="0" ordering="" order_dir="asc" type="products" layout="displayproducts"]',
    'post_status'   => 'publish',
    'post_type'   => 'wde_page'
  );
  $all_products_page = wp_insert_post($wde_post_args);

  /* shopping cart */
  $wde_post_args = array(
    'post_title'    => __('Shopping cart', 'wde'),
    'post_content'  => '[wde type="shoppingcart" layout="displayshoppingcart"]',
    'post_status'   => 'publish',
    'post_type'   => 'wde_page'
  );
  $shopping_cart_page = wp_insert_post($wde_post_args);

  /* orders */
  $wde_post_args = array(
    'post_title'    => __('Orders', 'wde'),
    'post_content'  => '[wde type="orders" layout="displayorders"]',
    'post_status'   => 'publish',
    'post_type'   => 'wde_page'
  );
  $orders_page = wp_insert_post($wde_post_args);

  /* checkout */
  $wde_post_args = array(
    'post_title'    => __('Checkout', 'wde'),
    'post_content'  => '[wde type="checkout" layout="quick_checkout"]',
    'post_status'   => 'publish',
    'post_type'   => 'wde_page'
  );
  $checkout_page = wp_insert_post($wde_post_args);

  /* usermanagement */
  $wde_post_args = array(
    'post_title'    => __('User management', 'wde'),
    'post_content'  => '[wde type="usermanagement" layout="displaylogin"]',
    'post_status'   => 'publish',
    'post_type'   => 'wde_page'
  );
  $usermanagement_page = wp_insert_post($wde_post_args);

  /* system pages */
  $wde_post_args = array(
    'post_title'    => __('System pages', 'wde'),
    'post_content'  => '[wde type="systempages" layout="displayerror"]',
    'post_status'   => 'publish',
    'post_type'   => 'wde_page'
  );
  $systempages_page = wp_insert_post($wde_post_args);

  $admin_data = get_userdata(1);
  $admin_email = $admin_data->user_email;
  $site_name = get_bloginfo();

  $email_template = "<div style='width: 800px; border: 1px solid #ddd;'><div style='background: #00a0d2; padding: 20px; color: #ffffff; font-size: 23px'>%email_subject%</div><div style='background: #ffffff; padding: 20px 20px 0; line-height: 26px; font-size: 14px;'>%email_header%</div><div style='background: #ffffff; padding: 20px; line-height: 26px; font-size: 14px;'>%email_body%</div><div style='font-size: 13px; padding: 0px 20px 20px;'>%email_footer%</div></div>";

  $email_subject = __('Order details', 'wde');
  $email_header = sprintf(__('Hello administrator, <br>Here are details for order of user %s on %s at %s %s.', 'wde'), '{customer_name}', '{checkout_date}', '{site_name}', '{site_url}');
  $email_body = sprintf(__('Order id: %s<br>Products details:<br>%s<br>Customer details:<br>%s<br>%s%s', 'wde'), '{order_id}', '{product_details}', '{customer_details}', '{billing_data}', '{shipping_data}');
  $email_footer = sprintf(__('Mail successfully sent to user: %s', 'wde'), '{is_mail_to_user_sent}');
  $admin_email_subject = $email_subject;
  $admin_email_body = str_replace(array('%email_subject%', '%email_header%', '%email_body%', '%email_footer%'), array($email_subject, $email_header, $email_body, $email_footer), $email_template);

  
  $email_subject = __('Order details', 'wde');
  $email_header = sprintf(__('Hello %s,<br>Here are details for your order on %s at %s %s.', 'wde'), '{customer_name}', '{checkout_date}', '{site_name}', '{site_url}');
  $email_body = sprintf(__('Order id: %s<br>%s<br>Products details:<br>%s<br>%s<br>%s', 'wde'), '{order_id}', '{order_details}', '{product_details}', '{billing_data}', '{shipping_data}');
  $email_footer = '';
  $user_email_subject = $email_subject;
  $user_email_body = str_replace(array('%email_subject%', '%email_header%', '%email_body%', '%email_footer%'), array($email_subject, $email_header, $email_body, $email_footer), $email_template);

  $email_subject = __('Order status', 'wde');
  $email_header = sprintf(__('Hello %s,<br>The order status of your order on %s at %s %s is updated from <em>%s</em> to <em>%s</em>.', 'wde'), '{customer_name}', '{checkout_date}', '{site_name}', '{site_url}', '{old_status_name}', '{new_status_name}');
  $email_body = sprintf(__('<br>Products details:<br>%s<br>', 'wde'), '{product_details}');
  $email_footer = '';
  $user_email_status_subject = __('The order status of your order is updated', 'wde');
  $user_email_status_body = str_replace(array('%email_subject%', '%email_header%', '%email_body%', '%email_footer%'), array($email_subject, $email_header, $email_body, $email_footer), $email_template);

  $email_subject = __('Canceled', 'wde');
  $email_header = '';
  $email_body = sprintf(__('The order #%s from %s has been canceled.', 'wde'), '{order_id}', '{customer_name}');
  $email_footer = '';
  $canceled_subject = __('Your order has been canceled', 'wde');
  $canceled_body = '';//str_replace(array('%email_subject%', '%email_header%', '%email_body%', '%email_footer%'), array($email_subject, $email_header, $email_body, $email_footer), $email_template);

  $email_subject = __('Failed', 'wde');
  $email_header = '';
  $email_body = sprintf(__('Payment for order #%s from %s has failed.', 'wde'), '{order_id}', '{customer_name}');
  $email_footer = '';
  $failed_subject = __('Your order has failed', 'wde');
  $failed_body = str_replace(array('%email_subject%', '%email_header%', '%email_body%', '%email_footer%'), array($email_subject, $email_header, $email_body, $email_footer), $email_template);

  $email_subject = __('Processed', 'wde');
  $email_header = '';
  $email_body = sprintf(__('Your order #%s from %s is now being processed.', 'wde'), '{order_id}', '{customer_name}');
  $email_footer = '';
  $pending_subject = __('Your order is now being processed', 'wde');
  $pending_body = str_replace(array('%email_subject%', '%email_header%', '%email_body%', '%email_footer%'), array($email_subject, $email_header, $email_body, $email_footer), $email_template);

  $email_subject = __('Completed', 'wde');
  $email_header = '';
  $email_body = sprintf(__('Your order #%s from %s has been completed.', 'wde'), '{order_id}', '{customer_name}');
  $email_footer = '';
  $completed_subject = __('Your order has been completed', 'wde');
  $completed_body = str_replace(array('%email_subject%', '%email_header%', '%email_body%', '%email_footer%'), array($email_subject, $email_header, $email_body, $email_footer), $email_template);

  $email_subject = __('Refunded', 'wde');
  $email_header = '';
  $email_body = sprintf(__('Your order #%s from %s has been refunded.', 'wde'), '{order_id}', '{customer_name}');
  $email_footer = '';
  $refunded_subject = __('Your order has been refunded', 'wde');
  $refunded_body = str_replace(array('%email_subject%', '%email_header%', '%email_body%', '%email_footer%'), array($email_subject, $email_header, $email_body, $email_footer), $email_template);

  $email_subject = __('Invoice', 'wde');
  $email_header = sprintf(__('Hello %s,<br>Here are details for your order on %s at %s %s.<br>', 'wde'), '{customer_name}', '{checkout_date}', '{site_name}', '{site_url}');
  $email_body = sprintf(__('Order id: %s<br>%s<br>Product details:<br>%s<br>%s%s', 'wde'), '{order_id}', '{order_details}', '{product_details}', '{billing_data}', '{shipping_data}');
  $email_footer = '';
  $invoice_subject = __('Invoice for Your order', 'wde');
  $invoice_body = str_replace(array('%email_subject%', '%email_header%', '%email_body%', '%email_footer%'), array($email_subject, $email_header, $email_body, $email_footer), $email_template);

  /* options */
  $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'ecommercewd_options` (`id`, `name`, `value`, `default_value`) VALUES
    /* products data options */
    ("", "enable_sku", 1, 1),
    ("", "enable_upc", 1, 1),
    ("", "enable_ean", 1, 1),
    ("", "enable_jan", 1, 1),
    ("", "enable_isbn", 1, 1),
    ("", "enable_mpn", 1, 1),
    ("", "weight_unit", "kg", "kg"),
    ("", "dimensions_unit", "cm", "cm"),

    /* email options */
    ("", "mailer", 1, 1),
    ("", "admin_email", "' . $admin_email . '", "' . $admin_email . '"),
    ("", "from_mail", "' . $admin_email . '", "' . $admin_email . '"),
    ("", "from_name", "' . $site_name . '", "' . $site_name . '"),

    ("", "admin_email_enable", 1, 1),
    ("", "admin_email_subject", "' . $admin_email_subject . '", "' . $admin_email_subject . '"),
    ("", "admin_email_mode", 1, 1),
    ("", "admin_email_body", "' . $admin_email_body . '", "' . $admin_email_body . '"),

    ("", "user_email_enable", 1, 1),
    ("", "user_email_subject", "' . $user_email_subject . '", "' . $user_email_subject . '"),
    ("", "user_email_mode", 1, 1),
    ("", "user_email_body", "' . $user_email_body . '", "' . $user_email_body . '"),

    ("", "user_email_status_enable", 1, 1),
    ("", "user_email_status_subject", "' . $user_email_status_subject . '", "' . $user_email_status_subject . '"),
    ("", "user_email_status_from_mail", "' . $admin_email . '", "' . $admin_email . '"),
    ("", "user_email_status_from_name", "' . $site_name . '", "' . $site_name . '"),
    ("", "user_email_status_mode", 1, 1),
    ("", "user_email_status_body", "' . $user_email_status_body . '", "' . $user_email_status_body . '"),

    ("", "canceled_enable", 1, 1),
    ("", "canceled_user_enable", 0, 0),
    ("", "canceled_subject", "' . $canceled_subject . '", "' . $canceled_subject . '"),
    ("", "canceled_mode", 1, 1),
    ("", "canceled_body", "' . $canceled_body . '", "' . $canceled_body . '"),

    ("", "failed_enable", 1, 1),
    ("", "failed_user_enable", 1, 1),
    ("", "failed_subject", "' . $failed_subject . '", "' . $failed_subject . '"),
    ("", "failed_mode", 1, 1),
    ("", "failed_body", "' . $failed_body . '", "' . $failed_body . '"),

    ("", "pending_enable", 1, 1),
    ("", "pending_user_enable", 1, 1),
    ("", "pending_subject", "' . $pending_subject . '", "' . $pending_subject . '"),
    ("", "pending_mode", 1, 1),
    ("", "pending_body", "' . $pending_body . '", "' . $pending_body . '"),

    ("", "completed_enable", 1, 1),
    ("", "completed_user_enable", 1, 1),
    ("", "completed_subject", "' . $completed_subject . '", "' . $completed_subject . '"),
    ("", "completed_mode", 1, 1),
    ("", "completed_body", "' . $completed_body . '", "' . $completed_body . '"),

    ("", "refunded_enable", 0, 0),
    ("", "refunded_user_enable", 1, 1),
    ("", "refunded_subject","' . $refunded_subject . '", "' . $refunded_subject . '"),
    ("", "refunded_mode", 1, 1),
    ("", "refunded_body", "' . $refunded_body . '", "' . $refunded_body . '"),

    ("", "invoice_subject", "' . $invoice_subject . '", "' . $invoice_subject . '"),
    ("", "invoice_mode", 1, 1),
    ("", "invoice_body", "' . $invoice_body . '", "' . $invoice_body . '"),

    /* user data fields */
    ("", "user_data_middle_name", 1, 1),
    ("", "user_data_last_name", 1, 1),
    ("", "user_data_company", 1, 1),
    ("", "user_data_country", 2, 2),
    ("", "user_data_state", 1, 1),
    ("", "user_data_city", 1, 1),
    ("", "user_data_address", 1, 1),
    ("", "user_data_mobile", 1, 1),
    ("", "user_data_phone", 1, 1),
    ("", "user_data_fax", 1, 1),
    ("", "user_data_zip_code", 1, 1),

    /* checkout options */
    ("", "checkout_enable_checkout", 1, 1),
    ("", "checkout_allow_guest_checkout", 0, 0),
    ("", "checkout_redirect_to_cart_after_adding_an_item", 0, 0),
    ("", "checkout_enable_shipping", 0, 0),

    /* customer feedback options */
    ("", "feedback_enable_guest_feedback", 1, 1),
    ("", "feedback_enable_product_rating", 1, 1),
    ("", "feedback_enable_product_reviews", 1, 1),
    ("", "feedback_publish_review_when_added", 0, 0),

    /* search and sort options */
    ("", "search_enable_user_bar", 1, 1),
    ("", "search_enable_search", 1, 1),
    ("", "search_by_category", 1, 1),
    ("", "search_include_subcategories", 1, 1),
    ("", "filter_manufacturers", 1, 1),
    ("", "filter_price", 1, 1),
    ("", "filter_date_added", 1, 1),
    ("", "filter_minimum_rating", 1, 1),
    ("", "filter_tags", 1, 1),
    ("", "sort_by_name", 1, 1),
    ("", "sort_by_manufacturer", 1, 1),
    ("", "sort_by_price", 1, 1),
    ("", "sort_by_count_of_reviews", 1, 1),
    ("", "sort_by_rating", 1, 1),

    /* social media integration options */
    /* share buttons */
    ("", "social_media_integration_enable_fb_like_btn", 1, 1),
    ("", "social_media_integration_enable_twitter_tweet_btn", 1, 1),
    ("", "social_media_integration_enable_g_plus_btn", 1, 1),
    /* facebook comments */
    ("", "social_media_integration_use_fb_comments", 0, 0),
    ("", "social_media_integration_fb_color_scheme", "light", "light"),

    /* standart pages options */
    ("", "option_ecommerce_base", "ecommerce", "ecommerce"),
    ("", "option_product_base", "product", "product"),
    ("", "option_manufacturer_base", "manufacturer", "manufacturer"),
    ("", "option_category_base", "product-category", "product-category"),
    ("", "option_tag_base", "product-tag", "product-tag"),
    ("", "option_parameter_base", "product-parameter", "product-parameter"),
    ("", "option_discount_base", "product-discount", "product-discount"),
    ("", "option_tax_base", "product-tax", "product-tax"),
    ("", "option_label_base", "product-label", "product-label"),
    ("", "option_shipping_method_base", "product-shipping-method", "product-shipping-method"),
    ("", "option_country_base", "product-country", "product-country"),
    ("", "option_all_products_page", "' . $all_products_page . '", "' . $all_products_page . '"),
    ("", "option_endpoint_compare_products", "compare", "compare"),
    ("", "option_shopping_cart_page", "' . $shopping_cart_page . '", "' . $shopping_cart_page . '"),
    ("", "option_orders_page", "' . $orders_page . '", "' . $orders_page . '"),
    ("", "option_endpoint_orders_displayorder", "displayorder", "displayorder"),
    ("", "option_endpoint_orders_printorder", "printorder", "printorder"),
    ("", "option_checkout_page", "' . $checkout_page . '", "' . $checkout_page . '"),
    ("", "option_endpoint_checkout_shipping_data", "shipping-data", "shipping-data"),
    ("", "option_endpoint_checkout_products_data", "products-data", "products-data"),
    ("", "option_endpoint_checkout_license_pages", "license-pages", "license-pages"),
    ("", "option_endpoint_checkout_confirm_order", "confirm-order", "confirm-order"),
    ("", "option_endpoint_checkout_finished_success", "finished-success", "finished-success"),
    ("", "option_endpoint_checkout_finished_failure", "finished-failure", "finished-failure"),
    ("", "option_endpoint_checkout_product", "checkout-product", "checkout-product"),
    ("", "option_endpoint_checkout_all_products", "all-products", "all-products"),
    ("", "option_usermanagement_page", "' . $usermanagement_page . '", "' . $usermanagement_page . '"),
    ("", "option_endpoint_edit_user_account", "edit", "edit"),
    ("", "option_systempages_page", "' . $systempages_page . '", "' . $systempages_page . '"),
    ("", "option_endpoint_systempages_errnum", "code", "code"),

    /* other options */
    ("", "option_date_format", "d/m/Y", "d/m/Y"),
    ("", "option_include_discount_in_price", 1, 1),
    ("", "option_include_tax_in_price", 0, 0),
    ("", "option_include_tax_in_checkout_price", 0, 0),
    ("", "enable_tax", 1, 1),
    ("", "round_tax_at_subtotal", 0, 0),
    ("", "price_entered_with_tax", 0, 0),
    ("", "tax_based_on", "shipping_address", "shipping_address"),
    ("", "price_display_suffix", "", ""),
    ("", "tax_total_display", "single", "single"),
    ("", "base_location", "", ""),
    ("", "option_order_shipping_type", "per_order", "per_order"),
    ("", "option_show_decimals", 1, 1)');

  /* orderstatuses */
  $wpdb->query("INSERT INTO `" . $wpdb->prefix . "ecommercewd_orderstatuses` (`id`, `name`, `ordering`, `published`, `default`)
    VALUES
    ('', 'Pending', '', 1, 1),
    ('', 'Confirmed by shopper', '', 1, 0),
    ('', 'Confirmed', '', 1, 0),
    ('', 'Cancelled', '', 1, 0),
    ('', 'Refunded', '', 1, 0),
    ('', 'Shipped', '', 1, 0)");

  /* themes */
  $keys_arr = array(
    'main_font_size', 'main_font_family', 'main_font_weight',
    'header_font_size', 'header_font_family', 'header_font_weight',
    'subtext_font_size', 'subtext_font_family', 'subtext_font_weight',
    'input_font_size', 'input_font_family', 'input_font_weight',
    'button_font_size', 'button_font_family', 'button_font_weight',
    'product_name_font_size', 'product_name_font_family', 'product_name_font_weight',
    'product_procreator_font_size', 'product_procreator_font_family', 'product_procreator_font_weight',
    'product_price_font_size', 'product_price_font_family', 'product_price_font_weight',
    'product_market_price_font_size', 'product_market_price_font_family', 'product_market_price_font_weight',
    'product_code_font_size', 'product_code_font_family', 'product_code_font_weight',
    'navbar_badge_font_size', 'navbar_badge_font_family', 'navbar_badge_font_weight',
    'navbar_dropdown_link_font_size', 'navbar_dropdown_link_font_family', 'navbar_dropdown_link_font_weight',
    'rating_star_font_size',
    'label_font_size', 'label_font_family', 'label_font_weight',
    'alert_font_size', 'alert_font_family', 'alert_font_weight',
    'breadcrumb_font_size', 'breadcrumb_font_family', 'breadcrumb_font_weight',
    'pill_link_font_size', 'pill_link_font_family', 'pill_link_font_weight',
    'tab_link_font_size', 'tab_link_font_family', 'tab_link_font_weight',
    'pagination_font_size', 'pagination_font_family', 'pagination_font_weight',
    'pager_font_size', 'pager_font_family', 'pager_font_weight',

    'rounded_corners', 'content_main_color', 'header_content_color', 'subtext_content_color', 'input_content_color', 'input_bg_color', 'input_border_color', 'input_focus_border_color', 'input_has_error_content_color', 'button_default_content_color', 'button_default_bg_color', 'button_default_border_color', 'button_primary_content_color', 'button_primary_bg_color', 'button_primary_border_color', 'button_success_content_color', 'button_success_bg_color', 'button_success_border_color', 'button_info_content_color', 'button_info_bg_color', 'button_info_border_color', 'button_warning_content_color', 'button_warning_bg_color', 'button_warning_border_color', 'button_danger_content_color', 'button_danger_bg_color', 'button_danger_border_color', 'button_link_content_color', 'divider_color', 'navbar_bg_color', 'navbar_border_color', 'navbar_link_content_color', 'navbar_link_hover_content_color', 'navbar_link_open_content_color', 'navbar_link_open_bg_color', 'navbar_badge_content_color', 'navbar_badge_bg_color', 'navbar_dropdown_link_content_color', 'navbar_dropdown_link_hover_content_color', 'navbar_dropdown_link_hover_background_content_color', 'navbar_dropdown_divider_color', 'navbar_dropdown_background_color', 'navbar_dropdown_border_color', 'modal_backdrop_color', 'modal_bg_color', 'modal_border_color', 'modal_dividers_color', 'panel_user_data_bg_color', 'panel_user_data_border_color', 'panel_user_data_footer_bg_color', 'panel_product_bg_color', 'panel_product_border_color', 'panel_product_footer_bg_color', 'well_bg_color', 'well_border_color', 'rating_star_type', 'rating_star_color', 'rating_star_bg_color', 'label_content_color', 'label_bg_color', 'alert_info_content_color', 'alert_info_bg_color', 'alert_info_border_color', 'alert_danger_content_color', 'alert_danger_bg_color', 'alert_danger_border_color', 'breadcrumb_content_color', 'breadcrumb_bg_color', 'pill_link_content_color', 'pill_link_hover_content_color', 'pill_link_hover_bg_color', 'tab_link_content_color', 'tab_link_hover_content_color', 'tab_link_hover_bg_color', 'tab_link_active_content_color', 'tab_link_active_bg_color', 'tab_border_color', 'pagination_content_color', 'pagination_bg_color', 'pagination_hover_content_color', 'pagination_hover_bg_color', 'pagination_active_content_color', 'pagination_active_bg_color', 'pagination_border_color', 'pager_content_color', 'pager_bg_color', 'pager_border_color', 'product_name_color', 'product_category_color', 'product_manufacturer_color', 'product_price_color', 'product_market_price_color', 'products_filters_position', 'products_count_in_page', 'products_option_columns',

    'products_thumbs_view_show_image', 'products_thumbs_view_show_label', 'products_thumbs_view_show_name', 'products_thumbs_view_show_rating', 'products_thumbs_view_show_price', 'products_thumbs_view_show_market_price', 'products_thumbs_view_show_description', 'products_thumbs_view_show_button_quick_view', 'products_thumbs_view_show_button_compare', 'products_thumbs_view_show_button_buy_now', 'products_thumbs_view_show_button_add_to_cart',
    'products_masonry_view_show_image', 'products_masonry_view_show_label', 'products_masonry_view_show_name', 'products_masonry_view_show_rating', 'products_masonry_view_show_price', 'products_masonry_view_show_market_price', 'products_masonry_view_show_description', 'products_masonry_view_show_button_quick_view', 'products_masonry_view_show_button_compare', 'products_masonry_view_show_button_buy_now', 'products_masonry_view_show_button_add_to_cart',
    'products_cheese_view_show_image', 'products_cheese_view_show_label', 'products_cheese_view_show_name', 'products_cheese_view_show_rating', 'products_cheese_view_show_price', 'products_cheese_view_show_market_price', 'products_cheese_view_show_description', 'products_cheese_view_show_button_quick_view', 'products_cheese_view_show_button_compare', 'products_cheese_view_show_button_buy_now', 'products_cheese_view_show_button_add_to_cart',
    'products_blog_style_view_show_image', 'products_blog_style_view_show_label', 'products_blog_style_view_show_name', 'products_blog_style_view_show_rating', 'products_blog_style_view_show_price', 'products_blog_style_view_show_market_price', 'products_blog_style_view_show_description', 'products_blog_style_view_show_button_quick_view', 'products_blog_style_view_show_button_compare', 'products_blog_style_view_show_button_buy_now', 'products_blog_style_view_show_button_add_to_cart',
    
    'products_list_view_show_image', 'products_list_view_show_label', 'products_list_view_show_name', 'products_list_view_show_rating', 'products_list_view_show_price', 'products_list_view_show_market_price', 'products_list_view_show_description', 'products_list_view_show_button_quick_view', 'products_list_view_show_button_compare', 'products_list_view_show_button_buy_now', 'products_list_view_show_button_add_to_cart',
    'products_quick_view_show_image', 'products_quick_view_show_label', 'products_quick_view_show_name', 'products_quick_view_show_rating', 'products_quick_view_show_category', 'products_quick_view_show_manufacturer','products_quick_view_show_model', 'products_quick_view_show_price', 'products_quick_view_show_market_price', 'products_quick_view_show_description', 'products_quick_view_show_button_compare', 'products_quick_view_show_button_buy_now', 'products_quick_view_show_button_add_to_cart',
    'product_view_show_image', 'product_view_show_label', 'product_view_show_name', 'product_view_show_rating', 'product_view_show_category', 'product_view_show_manufacturer','product_view_show_model', 'product_view_show_price', 'product_view_show_market_price', 'product_view_show_button_compare', 'product_view_show_button_write_review', 'product_view_show_button_buy_now', 'product_view_show_button_add_to_cart', 'product_view_show_description', 'product_view_show_social_buttons', 'product_view_show_parameters', 'product_view_show_shipping_info', 'product_view_show_reviews', 'product_view_show_related_products',

    'product_model_color','product_code_color', 
    
    'product_description_color', 'product_description_font_size', 'product_description_font_family', 'product_description_font_weight', 
    'multiple_product_name_color', 'multiple_product_name_font_size', 'multiple_product_name_font_family', 'multiple_product_name_font_weight', 'multiple_product_price_color', 'multiple_product_price_font_size', 'multiple_product_price_font_family', 'multiple_product_price_font_weight', 'multiple_product_market_price_color', 'multiple_product_market_price_font_size', 'multiple_product_market_price_font_family', 'multiple_product_market_price_font_weight', 'multiple_product_description_color', 'multiple_product_description_font_size', 'multiple_product_description_font_family', 'multiple_product_description_font_weight', 
  );

  $default_values_arr = array('0.9em', '', '', '3em', '', '', '0.8em', '', '', '1em', '', '', '1em', '', '', '1.5em', '', '', '0.9em', '', '', '1.3em', '', '', '0.9em', '', '', '0.9em', '', '', '1em', '', '', '1em', '', '', '1.2em', '0.8em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', 1, '#555555', '#555555', '#999999', '#555555', '#ffffff', '#cccccc', '#66afe9', '#a94442', '#333333', '#ffffff', '#cccccc', '#ffffff', '#428bca', '#357ebd', '#ffffff', '#5cb85c', '#4cae4c', '#ffffff', '#5bc0de', '#46b8da', '#ffffff', '#f0ad4e', '#eea236', '#ffffff', '#d9534f', '#d43f3a', '#428bca', '#eeeeee', '#f8f8f8', '#e7e7e7', '#777777', '#333333', '#555555', '#e7e7e7', '#ffffff', '#d9534f', '#777777', '#ffffff', '#428bca', '#e5e5e5', '#ffffff', '#d9d9d9', '#000000', '#ffffff', '#9f9f9f', '#e5e5e5', '#ffffff', '#dddddd', '#f5f5f5', '#ffffff', '#dddddd', '#f5f5f5', '#f5f5f5', '#e3e3e3', 'star', '#ffcc33', '#dadada', '#ffffff', '#999999', '#31708f', '#d9edf7', '#bce8f1', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#428bca', '#2a6496', '#eeeeee', '#428bca', '#2a6496', '#eeeeee', '#555555', '#ffffff', '#dddddd', '#428bca', '#ffffff', '#2a6496', '#eeeeee', '#ffffff', '#428bca', '#dddddd', '#428bca', '#ffffff', '#dddddd', '#00568d', '#808080', '#808080', '#8d0000', '#808080', 1, 12, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, '#808080', '#808080', '#555555', '1em', '', '', '#00568d', '1.5em', '', '', '#8d0000', '1.3em', '', '', '#808080', '0.9em', '', '', '#555555', '1em', '', '');
  $default = json_encode(array_combine($keys_arr, $default_values_arr));
  
  $theme1_values_arr = array('0.9em', '', '', '3em', '', '', '0.8em', '', '', '1em', '', '', '1em', '', '', '1.5em', '', '', '0.9em', '', '', '1.3em', '', '', '0.9em', '', '', '0.9em', '', '', '1em', '', '', '1em', '', '', '1.2em', '0.8em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', 1, '#555555', '#555555', '#999999', '#555555', '#ffffff', '#cccccc', '#66afe9', '#a94442', '#333333', '#ffffff', '#cccccc', '#ffffff', '#428bca', '#357ebd', '#ffffff', '#5cb85c', '#4cae4c', '#ffffff', '#5bc0de', '#46b8da', '#ffffff', '#f0ad4e', '#eea236', '#ffffff', '#d9534f', '#d43f3a', '#428bca', '#eeeeee', '#f8f8f8', '#e7e7e7', '#777777', '#333333', '#555555', '#e7e7e7', '#ffffff', '#d9534f', '#777777', '#ffffff', '#428bca', '#e5e5e5', '#ffffff', '#d9d9d9', '#000000', '#ffffff', '#9f9f9f', '#e5e5e5', '#ffffff', '#dddddd', '#f5f5f5', '#ffffff', '#dddddd', '#f5f5f5', '#f5f5f5', '#e3e3e3', 'star', '#ffcc33', '#dadada', '#ffffff', '#999999', '#31708f', '#d9edf7', '#bce8f1', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#428bca', '#2a6496', '#eeeeee', '#428bca', '#2a6496', '#eeeeee', '#555555', '#ffffff', '#dddddd', '#428bca', '#ffffff', '#2a6496', '#eeeeee', '#ffffff', '#428bca', '#dddddd', '#428bca', '#ffffff', '#dddddd', '#00568d', '#808080', '#808080', '#8d0000', '#808080', 1, 12, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, '#808080', '#808080', '#555555', '1em', '', '', '#00568d', '1.5em', '', '', '#8d0000', '1.3em', '', '', '#808080', '0.9em', '', '', '#555555', '1em', '', '');
  $theme1 = json_encode(array_combine($keys_arr, $theme1_values_arr));

  $theme2_values_arr = array('0.9em', '', '', '3em', '', '', '0.8em', '', '', '1em', '', '', '1em', '', '', '1.5em', '', '', '0.9em', '', '', '1.3em', '', '', '0.9em', '', '', '0.9em', '', '', '1em', '', '', '1em', '', '', '1.2em', '0.8em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', 1, '#000000', '#000000', '#cccccc', '#cccccc', '#ffffff', '#e0e0e0', '#4cae4c', '#630707', '#333333', '#ffffff', '#cccccc', '#ffffff', '#4cae4c', '#4cae4c', '#ffffff', '#428bca', '#428bca', '0', '0', '0', '0', '0', '0', '0', '0', '0', '#368c36', '#cccccc', '#f8f8f8', '#e0e0e0', '#000000', '#000000', '#555555', '#e0e0e0', '#ffffff', '#4cae4c', '#000000', '#ffffff', '#4cae4c', '#e5e5e5', '#ffffff', '#f8f8f8', '#000000', '#ffffff', '#e0e0e0', '#f8f8f8', '#ffffff', '#e0e0e0', '#f5f5f5', '#ffffff', '#e0e0e0', '#f5f5f5', '#f5f5f5', '#e0e0e0', 'star-empty', '#ffcc33', '#dadada', '#ffffff', '#999999', '#368c36', '#def7de', '#c9f2c9', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#4cae4c', '#4cae4c', '#eeeeee', '#4cae4c', '#4cae4c', '#eeeeee', '#000000', '#ffffff', '#dddddd', '#4cae4c', '#ffffff', '#368c36', '#eeeeee', '#ffffff', '#4cae4c', '#dddddd', '#368c36', '#ffffff', '#dddddd', '#000000', '#808080', '#808080', '#368c36', '#808080', 1, 12, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,  1, 1, 1, 1, 1, 0, 1, 1, 1, '#808080', '#808080', '#000000', '1em', '', '', '#000000', '1.5em', '', '', '#368c36', '1.3em', '', '', '#808080', '0.9em', '', '', '#000000', '1em', '', '');
  $theme2 = json_encode(array_combine($keys_arr, $theme2_values_arr));

  $theme3_values_arr = array('0.9em', '', '', '3em', '', '', '0.8em', '', '', '1em', '', '', '1em', '', '', '1.5em', '', '', '0.9em', '', '', '1.3em', '', '', '0.9em', '', '', '0.9em', '', '', '1em', '', '', '1em', '', '', '1.2em', '0.8em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', 1, '#9c9c9c', '#5c5c5c', '#cccccc', '#cccccc', '#ffffff', '#e0e0e0', '#d9d9d9', '#630707', '#000000', '#ffffff', '#e0e0e0', '#ffffff', '#e6a500', '#d99c00', '#ffffff', '#428bca', '#428bca', '0', '0', '0', '0', '0', '0', '0', '0', '0', '#d99c00', '#e8e5e8', '#f8f8f8', '#e0e0e0', '#000000', '#000000', '#555555', '#e0e0e0', '#ffffff', '#a94442', '#000000', '#ffffff', '#e6a500', '#e5e5e5', '#ffffff', '#f8f8f8', '#000000', '#ffffff', '#e0e0e0', '#f8f8f8', '#ffffff', '#e0e0e0', '#f5f5f5', '#ffffff', '#e0e0e0', '#f5f5f5', '#f5f5f5', '#e0e0e0', 'star-empty', '#6bc6ff', '#e0e0e0', '#ffffff', '#999999', '#428bca', '#d2e8fc', '#b8d8f5', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#e6a500', '#d99c00', '#eeeeee', '#e6a500', '#d99c00', '#eeeeee', '#000000', '#ffffff', '#e0e0e0', '#000000', '#ffffff', '#000000', '#eeeeee', '#ffffff', '#e6a500', '#e0e0e0', '#000000', '#ffffff', '#e0e0e0', '#d49904', '#808080', '#808080', '#000000', '#808080', 1, 12, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,  1, 1, 1, 1, 1, 0, 1, 1, 1, '#808080', '#808080', '#9c9c9c', '1em', '', '', '#d49904', '1.5em', '', '', '#000000', '1.3em', '', '', '#808080', '0.9em', '', '', '#9c9c9c', '1em', '', '');
  $theme3 = json_encode(array_combine($keys_arr, $theme3_values_arr));

  $theme4_values_arr = array('0.9em', '', '', '3em', '', '', '0.8em', '', '', '1em', '', '', '1em', '', '', '1.5em', '', '', '0.9em', '', '', '1.3em', '', '', '0.9em', '', '', '0.9em', '', '', '1em', '', '', '1em', '', '', '1.2em', '0.8em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', 1, '#9c9c9c', '#000000', '#949494', '#cccccc', '#ffffff', '#e0e0e0', '#d9d9d9', '#e60000', '#000000', '#ffffff', '#949494', '#ffffff', '#a80303', '#990303', '#ffffff', '#424242', '#000000', '0', '0', '0', '0', '0', '0', '0', '0', '0', '#990303', '#e8e5e8', '#f8f8f8', '#e0e0e0', '#000000', '#000000', '#555555', '#e0e0e0', '#ffffff', '#a80303', '#000000', '#ffffff', '#a80303', '#e5e5e5', '#ffffff', '#f8f8f8', '#000000', '#ffffff', '#e0e0e0', '#f8f8f8', '#ffffff', '#e0e0e0', '#f5f5f5', '#ffffff', '#e0e0e0', '#f5f5f5', '#f5f5f5', '#e0e0e0', 'star', '#ffd56b', '#e0e0e0', '#ffffff', '#999999', '#428bca', '#d2e8fc', '#b8d8f5', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#a94442', '#990303', '#eeeeee', '#000000', '#878787', '#eeeeee', '#000000', '#ffffff', '#e0e0e0', '#000000', '#ffffff', '#000000', '#eeeeee', '#ffffff', '#000000', '#e0e0e0', '#000000', '#ffffff', '#e0e0e0', '#000000', '#808080', '#808080', '#a94442', '#808080', 1, 12, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, '#808080', '#808080', '#9c9c9c', '1em', '', '', '#000000', '1.5em', '', '', '#a94442', '1.3em', '', '', '#808080', '0.9em', '', '', '#9c9c9c', '1em', '', '');
  $theme4 = json_encode(array_combine($keys_arr, $theme4_values_arr));

  $theme5_values_arr = array('0.9em', '', '', '3em', '', '', '0.8em', '', '', '1em', '', '', '1em', '', '', '1.5em', '', '', '0.9em', '', '', '1.3em', '', '', '0.9em', '', '', '0.9em', '', '', '1em', '', '', '1em', '', '', '1.2em', '0.8em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', '1em', '', '', 1, '#9c9c9c', '#000000', '#949494', '#cccccc', '#ffffff', '#e0e0e0', '#d9d9d9', '#e60000', '#000000', '#f0f0f0', '#949494', '#ffffff', '#45343d', '#402d37', '#ffffff', '#424242', '#000000', '0', '0', '0', '0', '0', '0', '0', '0', '0', '#402d37', '#e8e5e8', '#f8f8f8', '#e0e0e0', '#737373', '#737373', '#555555', '#e0e0e0', '#ffffff', '#a80303', '#000000', '#ffffff', '#45343d', '#e5e5e5', '#ffffff', '#f8f8f8', '#000000', '#ffffff', '#e0e0e0', '#f8f8f8', '#ffffff', '#e0e0e0', '#f5f5f5', '#ffffff', '#e0e0e0', '#f5f5f5', '#f5f5f5', '#e0e0e0', 'star', '#ffd56b', '#e0e0e0', '#ffffff', '#999999', '#428bca', '#d2e8fc', '#b8d8f5', '#a94442', '#f2dede', '#eed3d7', '#cccccc', '#f5f5f5', '#45343d', '#402d37', '#eeeeee', '#000000', '#878787', '#eeeeee', '#45343d', '#f2f2f2', '#e0e0e0', '#000000', '#ffffff', '#000000', '#eeeeee', '#ffffff', '#45343d', '#e0e0e0', '#45343d', '#eeeeee', '#e0e0e0', '#45343d', '#808080', '#808080', '#ab0300', '#808080', 1, 12, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, '#808080', '#808080', '#9c9c9c', '1em', '', '', '#45343d', '1.5em', '', '', '#ab0300', '1.3em', '', '', '#808080', '0.9em', '', '', '#9c9c9c', '1em', '', '');
  $theme5 = json_encode(array_combine($keys_arr, $theme5_values_arr));
  
  $wpdb->query("INSERT INTO `" . $wpdb->prefix . "ecommercewd_themes` (`id`, `name`, `data`, `basic`, `default`) VALUES
    ('', 'Default', '" . $default . "', 1, 0),
    ('', 'Theme 1', '" . $theme1 . "', 0, 1),
    ('', 'Theme 2', '" . $theme2 . "', 0, 0),
    ('', 'Theme 3', '" . $theme3 . "', 0, 0),
    ('', 'Theme 4', '" . $theme4 . "', 0, 0),
    ('', 'Theme 5', '" . $theme5 . "', 0, 0)");

  $countries = array(
    'US' => 'United States',
    'CA' => 'Canada',
    'AF' => 'Afghanistan',
    'AL' => 'Albania',
    'DZ' => 'Algeria',
    'DS' => 'American Samoa',
    'AD' => 'Andorra',
    'AO' => 'Angola',
    'AI' => 'Anguilla',
    'AQ' => 'Antarctica',
    'AG' => 'Antigua and/or Barbuda',
    'AR' => 'Argentina',
    'AM' => 'Armenia',
    'AW' => 'Aruba',
    'AU' => 'Australia',
    'AT' => 'Austria',
    'AZ' => 'Azerbaijan',
    'BS' => 'Bahamas',
    'BH' => 'Bahrain',
    'BD' => 'Bangladesh',
    'BB' => 'Barbados',
    'BY' => 'Belarus',
    'BE' => 'Belgium',
    'BZ' => 'Belize',
    'BJ' => 'Benin',
    'BM' => 'Bermuda',
    'BT' => 'Bhutan',
    'BO' => 'Bolivia',
    'BA' => 'Bosnia and Herzegovina',
    'BW' => 'Botswana',
    'BV' => 'Bouvet Island',
    'BR' => 'Brazil',
    'IO' => 'British lndian Ocean Territory',
    'BN' => 'Brunei Darussalam',
    'BG' => 'Bulgaria',
    'BF' => 'Burkina Faso',
    'BI' => 'Burundi',
    'KH' => 'Cambodia',
    'CM' => 'Cameroon',
    'CV' => 'Cape Verde',
    'KY' => 'Cayman Islands',
    'CF' => 'Central African Republic',
    'TD' => 'Chad',
    'CL' => 'Chile',
    'CN' => 'China',
    'CX' => 'Christmas Island',
    'CC' => 'Cocos (Keeling) Islands',
    'CO' => 'Colombia',
    'KM' => 'Comoros',
    'CG' => 'Congo',
    'CK' => 'Cook Islands',
    'CR' => 'Costa Rica',
    'HR' => 'Croatia (Hrvatska)',
    'CU' => 'Cuba',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'DK' => 'Denmark',
    'DJ' => 'Djibouti',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'TP' => 'East Timor',
    'EC' => 'Ecuador',
    'EG' => 'Egypt',
    'SV' => 'El Salvador',
    'GQ' => 'Equatorial Guinea',
    'ER' => 'Eritrea',
    'EE' => 'Estonia',
    'ET' => 'Ethiopia',
    'FK' => 'Falkland Islands (Malvinas)',
    'FO' => 'Faroe Islands',
    'FJ' => 'Fiji',
    'FI' => 'Finland',
    'FR' => 'France',
    'FX' => 'France, Metropolitan',
    'GF' => 'French Guiana',
    'PF' => 'French Polynesia',
    'TF' => 'French Southern Territories',
    'GA' => 'Gabon',
    'GM' => 'Gambia',
    'GE' => 'Georgia',
    'DE' => 'Germany',
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GR' => 'Greece',
    'GL' => 'Greenland',
    'GD' => 'Grenada',
    'GP' => 'Guadeloupe',
    'GU' => 'Guam',
    'GT' => 'Guatemala',
    'GN' => 'Guinea',
    'GW' => 'Guinea-Bissau',
    'GY' => 'Guyana',
    'HT' => 'Haiti',
    'HM' => 'Heard and Mc Donald Islands',
    'HN' => 'Honduras',
    'HK' => 'Hong Kong',
    'HU' => 'Hungary',
    'IS' => 'Iceland',
    'IN' => 'India',
    'ID' => 'Indonesia',
    'IR' => 'Iran (Republic of Islamic)',
    'IQ' => 'Iraq',
    'IE' => 'Ireland',
    'IL' => 'Israel',
    'IT' => 'Italy',
    'CI' => 'Ivory Coast',
    'JM' => 'Jamaica',
    'JP' => 'Japan',
    'JO' => 'Jordan',
    'KZ' => 'Kazakhstan',
    'KE' => 'Kenya',
    'KI' => 'Kiribati',
    'KP' => 'Democratic People&rsquo;s Republic of Korea',
    'KR' => 'Republic of Korea',
    'XK' => 'Kosovo',
    'KW' => 'Kuwait',
    'KG' => 'Kyrgyzstan',
    'LA' => 'Lao People&rsquo;s Democratic Republic',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LS' => 'Lesotho',
    'LR' => 'Liberia',
    'LY' => 'Libyan Arab Jamahiriya',
    'LI' => 'Liechtenstein',
    'LT' => 'Lithuania',
    'LU' => 'Luxembourg',
    'MO' => 'Macau',
    'MK' => 'Macedonia',
    'MG' => 'Madagascar',
    'MW' => 'Malawi',
    'MY' => 'Malaysia',
    'MV' => 'Maldives',
    'ML' => 'Mali',
    'MT' => 'Malta',
    'MH' => 'Marshall Islands',
    'MQ' => 'Martinique',
    'MR' => 'Mauritania',
    'MU' => 'Mauritius',
    'TY' => 'Mayotte',
    'MX' => 'Mexico',
    'FM' => 'Federated States of Micronesia',
    'MD' => 'Moldova',
    'MC' => 'Monaco',
    'MN' => 'Mongolia',
    'ME' => 'Montenegro',
    'MS' => 'Montserrat',
    'MA' => 'Morocco',
    'MZ' => 'Mozambique',
    'MM' => 'Myanmar',
    'NA' => 'Namibia',
    'NR' => 'Nauru',
    'NP' => 'Nepal',
    'NL' => 'Netherlands',
    'AN' => 'Netherlands Antilles',
    'NC' => 'New Caledonia',
    'NZ' => 'New Zealand',
    'NI' => 'Nicaragua',
    'NE' => 'Niger',
    'NG' => 'Nigeria',
    'NU' => 'Niue',
    'NF' => 'Norfork Island',
    'MP' => 'Northern Mariana Islands',
    'NO' => 'Norway',
    'OM' => 'Oman',
    'PK' => 'Pakistan',
    'PW' => 'Palau',
    'PA' => 'Panama',
    'PG' => 'Papua New Guinea',
    'PY' => 'Paraguay',
    'PE' => 'Peru',
    'PH' => 'Philippines',
    'PN' => 'Pitcairn',
    'PL' => 'Poland',
    'PT' => 'Portugal',
    'PR' => 'Puerto Rico',
    'QA' => 'Qatar',
    'RE' => 'Reunion',
    'RO' => 'Romania',
    'RU' => 'Russian Federation',
    'RW' => 'Rwanda',
    'KN' => 'Saint Kitts and Nevis',
    'LC' => 'Saint Lucia',
    'VC' => 'Saint Vincent and the Grenadines',
    'WS' => 'Samoa',
    'SM' => 'San Marino',
    'ST' => 'Sao Tome and Principe',
    'SA' => 'Saudi Arabia',
    'SN' => 'Senegal',
    'RS' => 'Serbia',
    'SC' => 'Seychelles',
    'SL' => 'Sierra Leone',
    'SG' => 'Singapore',
    'SK' => 'Slovakia',
    'SI' => 'Slovenia',
    'SB' => 'Solomon Islands',
    'SO' => 'Somalia',
    'ZA' => 'South Africa',
    'GS' => 'South Georgia South Sandwich Islands',
    'ES' => 'Spain',
    'LK' => 'Sri Lanka',
    'SH' => 'St. Helena',
    'PM' => 'St. Pierre and Miquelon',
    'SD' => 'Sudan',
    'SR' => 'Suriname',
    'SJ' => 'Svalbarn and Jan Mayen Islands',
    'SZ' => 'Swaziland',
    'SE' => 'Sweden',
    'CH' => 'Switzerland',
    'SY' => 'Syrian Arab Republic',
    'TW' => 'Taiwan',
    'TJ' => 'Tajikistan',
    'TZ' => 'Tanzania, United Republic of',
    'TH' => 'Thailand',
    'TG' => 'Togo',
    'TK' => 'Tokelau',
    'TO' => 'Tonga',
    'TT' => 'Trinidad and Tobago',
    'TN' => 'Tunisia',
    'TR' => 'Turkey',
    'TM' => 'Turkmenistan',
    'TC' => 'Turks and Caicos Islands',
    'TV' => 'Tuvalu',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'AE' => 'United Arab Emirates',
    'GB' => 'United Kingdom',
    'UM' => 'United States minor outlying islands',
    'UY' => 'Uruguay',
    'UZ' => 'Uzbekistan',
    'VU' => 'Vanuatu',
    'VA' => 'Vatican City State',
    'VE' => 'Venezuela',
    'VN' => 'Vietnam',
    'VG' => 'Virigan Islands (British)',
    'VI' => 'Virgin Islands (U.S.)',
    'WF' => 'Wallis and Futuna Islands',
    'EH' => 'Western Sahara',
    'YE' => 'Yemen',
    'YU' => 'Yugoslavia',
    'ZR' => 'Zaire',
    'ZM' => 'Zambia',
    'ZW' => 'Zimbabwe'
  );
  $wde_sample_data['wde_countries'] = array();
  foreach ($countries as $countrie_code => $country_name) {
    $wde_country = wp_insert_term($country_name, 'wde_countries');
    if (!is_wp_error($wde_country)) {
      $term_meta = array();
      $term_meta['code'] = $countrie_code;
      update_option("wde_countries_" . $wde_country['term_id'], $term_meta);
      $wde_sample_data['wde_countries'][] = $wde_country['term_id'];
    }
  }
  add_option('wde_sample_data', $wde_sample_data);
  wde_copy_templates();
  return;
}

function wde_add_to_media_library($img_url, $parent_post_id = 0) {
  $wp_upload_dir = wp_upload_dir();
  $filetype = wp_check_filetype(basename($img_url), null);
  $filename = $wp_upload_dir['path'] . '/' . wp_unique_filename($wp_upload_dir['path'], basename($img_url));
  copy($img_url, $filename);
  $attachment = array(
    'guid'           => $filename, 
    'post_mime_type' => $filetype['type'],
    'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
    'post_content'   => '',
    'post_status'    => 'inherit'
  );

  $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);

  require_once( ABSPATH . 'wp-admin/includes/image.php' );

  $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
  wp_update_attachment_metadata($attach_id, $attach_data);

  return $attach_id;
}
