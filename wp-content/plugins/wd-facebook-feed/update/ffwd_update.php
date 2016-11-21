<?php
/**
* @param version without first '1' or '2'
*
*/

function ffwd_update_diff($new_v, $old_v = 0.0){
	global $wpdb;


	if(version_compare($old_v,'1.0.2','<')) {
		$wpdb->query("ALTER TABLE " . $wpdb->prefix . "wd_fb_option ADD `access_token` varchar(255) NOT NULL DEFAULT ''");

	}

	if(version_compare($old_v,'1.0.3','<')) {
		$wpdb->query("ALTER TABLE " . $wpdb->prefix . "wd_fb_info ADD `event_order`  tinyint(4) NOT NULL DEFAULT 0");
		$wpdb->query("ALTER TABLE " . $wpdb->prefix . "wd_fb_info ADD `upcoming_events`  tinyint(4) NOT NULL DEFAULT 0");

	}


}

