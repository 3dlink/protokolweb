<?php
/**
 * Plugin Name: MailChimp WD
 * Plugin URI: https://web-dorado.com/products/wordpress-mailchimp-wd.html
 * Description: MailChimp WD is a functional plugin developed to create MailChimp subscribe/unsubscribe forms and manage lists from your WordPress site.
 * Version: 1.0.3
 * Author: WebDorado
 * Author URI: https://web-dorado.com/
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

define('MWD_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('MWD_URL', plugins_url(plugin_basename(dirname(__FILE__))));
define('MWD_MAIN_FILE', plugin_basename(__FILE__));
$upload_dir = wp_upload_dir();
$MWD_UPLOAD_DIR = str_replace(ABSPATH, '', $upload_dir['basedir']) . '/wd-mailchimp';

function mwd_options_panel() {
	add_menu_page('MailChimp WD', 'MailChimp WD', 'manage_options', 'manage_mwd', 'mailchimp_wd', MWD_URL . '/images/mailchimp_wd.png', 80);

	$manage_page = add_submenu_page('manage_mwd', 'MailChimp WD', 'MailChimp WD', 'manage_options', 'manage_mwd', 'mailchimp_wd');
	add_action('admin_print_styles-' . $manage_page, 'mwd_manage_styles');
	add_action('admin_print_scripts-' . $manage_page, 'mwd_manage_scripts');

	$manage_lists = add_submenu_page('manage_mwd', 'Lists', 'Lists', 'manage_options', 'manage_lists', 'mailchimp_wd');
	add_action('admin_print_styles-' . $manage_lists, 'mwd_manage_styles');
	add_action('admin_print_scripts-' . $manage_lists, 'mwd_manage_scripts');

	$manage_forms = add_submenu_page('manage_mwd', 'Forms', 'Forms', 'manage_options', 'manage_forms', 'mailchimp_wd');
	add_action('admin_print_styles-' . $manage_forms, 'mwd_manage_styles');
	add_action('admin_print_scripts-' . $manage_forms, 'mwd_manage_scripts');

	$submissions_page = add_submenu_page('manage_mwd', 'Submissions', 'Submissions', 'manage_options', 'submissions', 'mailchimp_wd');
	add_action('admin_print_styles-' . $submissions_page, 'mwd_submissions_styles');
	add_action('admin_print_scripts-' . $submissions_page, 'mwd_submissions_scripts');

	$themes_page = add_submenu_page('manage_mwd', 'Themes', 'Themes', 'manage_options', 'themes', 'mailchimp_wd');
	add_action('admin_print_styles-' . $themes_page, 'mwd_manage_styles');
	add_action('admin_print_scripts-' . $themes_page, 'mwd_manage_scripts');

	$global_options_page = add_submenu_page('manage_mwd', 'Global Options', 'Global Options', 'manage_options', 'goptions_mwd', 'mailchimp_wd');
	add_action('admin_print_styles-' . $global_options_page, 'mwd_manage_styles');
	add_action('admin_print_scripts-' . $global_options_page, 'mwd_manage_scripts');

	$blocked_ips_page = add_submenu_page('manage_mwd', 'Blocked IPs', 'Blocked IPs', 'manage_options', 'blocked_ips', 'mailchimp_wd');
	add_action('admin_print_styles-' . $blocked_ips_page, 'mwd_manage_styles');
	add_action('admin_print_scripts-' . $blocked_ips_page, 'mwd_manage_scripts');

	add_submenu_page('manage_mwd', 'Featured Plugins', 'Featured Plugins', 'manage_options', 'mwd_featured_plugins', 'mwd_featured');
	add_submenu_page('manage_mwd', 'Featured Themes', 'Featured Themes', 'manage_options', 'mwd_featured_themes', 'mwd_featured');

	$uninstall_page = add_submenu_page('manage_mwd', 'Uninstall', 'Uninstall', 'manage_options', 'uninstall', 'mailchimp_wd');
	add_action('admin_print_styles-' . $uninstall_page, 'mwd_manage_styles');
	add_action('admin_print_scripts-' . $uninstall_page, 'mwd_manage_scripts');

}
add_action('admin_menu', 'mwd_options_panel');

function mailchimp_wd() {
	if (function_exists('current_user_can')) {
		if (!current_user_can('manage_options')) {
			die('Access Denied');
		}
	}
	else {
		die('Access Denied');
	}
	require_once(MWD_DIR . '/includes/mwd_library.php');
	$page = MWD_Library::get('page');

	if (($page != '') && (($page == 'manage_mwd') || ($page == 'goptions_mwd') || ($page == 'manage_lists') || ($page == 'manage_forms') || ($page == 'submissions') || ($page == 'themes') || ($page == 'mwd_featured_plugins') || ($page == 'mwd_featured_themes') || ($page == 'uninstall') || ($page == 'Formswindow') || ($page == 'blocked_ips'))) {
		require_once (MWD_DIR . '/admin/controllers/MWDController' . ucfirst(strtolower($page)) . '.php');
		$controller_class = 'MWDController' . ucfirst(strtolower($page));
		$controller = new $controller_class();
		$controller->execute();
	}
}

function mwd_featured() {
	if (function_exists('current_user_can')) {
		if (!current_user_can('manage_options')) {
			die('Access Denied');
		}
	}
	else {
		die('Access Denied');
	}
	require_once(MWD_DIR . '/includes/mwd_library.php');
	$page = MWD_Library::get('page');
	require_once(MWD_DIR . '/featured/'.$page.'.php');

	wp_register_style('mwd_featured', MWD_URL . '/featured/style.css', array(), get_option("mwd_version"));
	wp_print_styles('mwd_featured');
	$page();
}

function updates_mwd() {
	if (function_exists('current_user_can')) {
		if (!current_user_can('manage_options')) {
			die('Access Denied');
		}
	}
	else {
		die('Access Denied');
	}
	require_once(MWD_DIR . '/featured/updates.php');
	wp_register_style('mwd_featured', MWD_URL . '/featured/style.css', array(), get_option("mwd_version"));
	wp_print_styles('mwd_featured');
}


add_action('wp_ajax_manage_mwd', 'mwd_ajax');
add_action('wp_ajax_helper', 'mwd_ajax'); //Mailchimp params
add_action('wp_ajax_ListsGenerete_csv', 'mwd_ajax');
add_action('wp_ajax_conditions', 'mwd_ajax');  //conditions

add_action('wp_ajax_get_stats', 'mailchimp_wd'); //Show statistics
add_action('wp_ajax_view_submits', 'mailchimp_wd'); //Show statistics
add_action('wp_ajax_FormsGenerete_csv', 'mwd_ajax'); // Export csv.
add_action('wp_ajax_FormsSubmits', 'mwd_ajax'); // Export csv.
add_action('wp_ajax_FormsGenerete_xml', 'mwd_ajax'); // Export xml.
add_action('wp_ajax_FormsPreview', 'mwd_ajax');
add_action('wp_ajax_Formswdcaptcha', 'mwd_ajax'); // Generete captcha image and save it code in session.
add_action('wp_ajax_nopriv_Formswdcaptcha', 'mwd_ajax'); // Generete captcha image and save it code in session for all users.
add_action('wp_ajax_Formswdmathcaptcha', 'mwd_ajax'); // Generete math captcha image and save it code in session.
add_action('wp_ajax_nopriv_Formswdmathcaptcha', 'mwd_ajax'); // Generete math captcha image and save it code in session for all users.
add_action('wp_ajax_paypal_info', 'mwd_ajax'); // Paypal info in submissions page.
add_action('wp_ajax_formeditcountry', 'mwd_ajax'); // Open country list.
add_action('wp_ajax_product_option', 'mwd_ajax'); // Open product options on add paypal field.
add_action('wp_ajax_submitter_ip', 'mailchimp_wd'); // Open ip in submissions.
add_action('wp_ajax_show_matrix', 'mwd_ajax'); // Edit matrix in submissions.

add_action('wp_ajax_checkpaypal', 'mwd_ajax'); // Notify url from Paypal Sandbox.
add_action('wp_ajax_nopriv_checkpaypal', 'mwd_ajax'); // Notify url from Paypal Sandbox for all users.
add_action('wp_ajax_select_interest_groups', 'mwd_ajax'); // select data from db.
add_action('wp_ajax_Formswindow', 'mwd_ajax');

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	require_once( 'includes/mwd_admin_class.php' );
	include_once('includes/mwd_notices_class.php');
	add_action( 'plugins_loaded', array( 'MWD_Admin', 'get_instance' ) );
}

function mwd_ajax() {
	require_once(MWD_DIR . '/includes/mwd_library.php');
	$page = MWD_Library::get('action');
	if ($page != 'Formswdcaptcha' && $page != 'Formswdmathcaptcha' && $page != 'checkpaypal') {
		if (function_exists('current_user_can')) {
			if (!current_user_can('manage_options')) {
				die('Access Denied');
			}
		}
		else {
			die('Access Denied');
		}
	}

	if ($page != '') {
		require_once (MWD_DIR . '/admin/controllers/MWDController' . ucfirst($page) . '.php');
		$controller_class = 'MWDController' . ucfirst($page);
		$controller = new $controller_class();
		$controller->execute();
	}
}

function mwd_ajax_frontend() {
	require_once(MWD_DIR . '/includes/mwd_library.php');
	$page = MWD_Library::get('action');
	$task = MWD_Library::get('task');

	if (function_exists('current_user_can')) {
		if (!current_user_can('manage_options')) {
			die('Access Denied');
		}
	}
	else {
		die('Access Denied');
	}

	if ($page != '') {
		require_once (MWD_DIR . '/frontend/controllers/MWDController' . ucfirst($page) . '.php');
		$controller_class = 'MWDController' . ucfirst($page);
		$controller = new $controller_class();
		$controller->$task();
	}
}

function mwd_add_button($buttons) {
	array_push($buttons, "MWD_mce");
	return $buttons;
}

function mwd_register($plugin_array) {
	$url = MWD_URL . '/js/mwd_editor_button.js';
	$plugin_array["MWD_mce"] = $url;
	return $plugin_array;
}

add_filter('mce_external_plugins', 'mwd_register');
add_filter('mce_buttons', 'mwd_add_button', 0);
function mwd_admin_ajax() { ?>
	<script>
		var forms_admin_ajax = '<?php echo add_query_arg(array('action' => 'Formswindow'), admin_url('admin-ajax.php')); ?>';
		var plugin_url = '<?php echo MWD_URL; ?>';
		var content_url = '<?php echo content_url() ?>';
		var admin_url = '<?php echo admin_url('admin.php'); ?>';
		var nonce_mwd = '<?php echo wp_create_nonce('nonce_mwd') ?>';
	</script>
	<?php
}
add_action('admin_head', 'mwd_admin_ajax');

function mwd_output_buffer() {
	ob_start();
}
add_action('init', 'mwd_output_buffer');


add_shortcode('mwd-mailchimp', 'mwd_shortcode');
function mwd_shortcode($attrs) {
	ob_start();
	MWD_load_forms($attrs, 'embedded');
	return str_replace(array("\r\n", "\n", "\r"), '', ob_get_clean());
}

if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
	add_action('wp_footer', 'MWD_load_forms');
	add_action('wp_enqueue_scripts', 'mwd_front_end_scripts');
}

function MWD_load_forms($params = array(), $type = '') {
	$form_id = isset($params['id']) ? (int)$params['id'] : 0;
	require_once(MWD_DIR . '/includes/mwd_library.php');
	require_once (MWD_DIR . '/frontend/controllers/MWDControllerForms.php');
	$controller = new MWDControllerForms();
	$form = $controller->execute($form_id, $type);
	echo $form;
	return;
}

add_shortcode('mwd_optin_confirmation', 'mwd_optin_confirmation');
function mwd_optin_confirmation() {
	require_once(MWD_DIR . '/includes/mwd_library.php');
	require_once(MWD_DIR . '/frontend/controllers/MWDControllerCustom.php');
    $controller_class = 'MWDControllerCustom';
    $controller = new $controller_class();
    $controller->execute('optin_confirmation');
}

add_shortcode('mwd_unsubscribe', 'mwd_unsubscribe_shortcode');
function mwd_unsubscribe_shortcode() {
	require_once(MWD_DIR . '/includes/mwd_library.php');
	require_once(MWD_DIR . '/frontend/controllers/MWDControllerCustom.php');
    $controller_class = 'MWDControllerCustom';
    $controller = new $controller_class();
    $controller->execute('unsubscribe');
}

if (class_exists('WP_Widget')) {
	require_once(MWD_DIR . '/admin/controllers/MWDControllerWidget.php');
	add_action('widgets_init', create_function('', 'return register_widget("MWDControllerWidget");'));
}


function mwd_activate() {
	$version = get_option("mwd_version");
	$new_version = '1.0.3';
	if (!$version) {
		require_once MWD_DIR . "/includes/mwd_insert.php";
		mwd_insert();
		add_option('mwd_version', $new_version);
		add_option('mwd_pro', 'no');
		add_option('mwd_api_key', '');
		add_option('mwd_api_validation', 'invalid_api');
		add_option('mwd_settings', array('public_key' => '', 'private_key' => ''));
	}
	else {
		if (version_compare(substr($version,2), substr($new_version,2), '<')) {
			require_once MWD_DIR . "/includes/mwd_update.php";
			mwd_update($version);
		}	
		
		update_option('mwd_version', $new_version);
		update_option('mwd_pro', 'no');
	}
}

function mwd_del_trans() {
	delete_transient('mwd_update_check');
}
register_activation_hook(__FILE__, 'mwd_activate');
register_activation_hook(__FILE__, 'mwd_del_trans');

if (!isset($_GET['action']) || $_GET['action'] != 'deactivate') {
	add_action('admin_init', 'mwd_activate');
}

function mwd_deactivate() {
	/* delete_option('mwd_api_key');
	update_option('mwd_api_validation', 'invalid_api'); */
}
register_deactivation_hook(__FILE__, 'mwd_deactivate');


/* back-end styles */
function mwd_manage_styles() {
	wp_admin_css('thickbox');
	wp_enqueue_style('mwd-mailchimp', MWD_URL . '/css/mwd-mailchimp.css', array(), get_option("mwd_version"));
	wp_enqueue_style('mwd-forms', MWD_URL . '/css/mwd-forms.css', array(), get_option("mwd_version"));
	wp_enqueue_style('mwd-bootstrap', MWD_URL . '/css/mwd-bootstrap.css', array(), get_option("mwd_version"));
	wp_enqueue_style('jquery-ui', MWD_URL . '/css/jquery-ui-1.10.3.custom.css');
	wp_enqueue_style('jquery-ui-spinner', MWD_URL . '/css/jquery-ui-spinner.css');
	wp_enqueue_style('mwd-style', MWD_URL . '/css/style.css', array(), get_option("mwd_version"));
	wp_enqueue_style('mwd-colorpicker', MWD_URL . '/css/spectrum.css', array(), get_option("mwd_version"));
	wp_enqueue_style('mwd-font-awesome', MWD_URL . '/css/frontend/font-awesome/font-awesome.css', array(), get_option("mwd_version"));
}

/* back-end scripts */
function mwd_manage_scripts() {
	wp_enqueue_script('thickbox');
	global $wp_scripts;

	if (isset($wp_scripts->registered['jquery'])) {
		$jquery = $wp_scripts->registered['jquery'];
		if (!isset($jquery->ver) OR version_compare($jquery->ver, '1.8.2', '<')) {
			wp_deregister_script('jquery');
			wp_register_script('jquery', FALSE, array('jquery-core', 'jquery-migrate'), '1.10.2' );
		}
	}

	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-widget');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-spinner');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-effects-shake');
	wp_enqueue_script('mwd-colorpicker', MWD_URL . '/js/spectrum.js', array(), get_option("mwd_version"));

	wp_enqueue_script('mwd_mailchimp', MWD_URL . '/js/mwd_mailchimp.js', array(), get_option("mwd_version"));
	wp_enqueue_script('forms_admin', MWD_URL . '/js/forms_admin.js', array(), get_option("mwd_version"));
	wp_enqueue_script('forms_manage', MWD_URL . '/js/forms_manage.js', array(), get_option("mwd_version"));
	wp_enqueue_media();
}

function mwd_submissions_styles() {
	wp_admin_css('thickbox');
	wp_enqueue_style('mwd-forms', MWD_URL . '/css/mwd-forms.css', array(), get_option("mwd_version"));
	wp_enqueue_style('mwd-mailchimp', MWD_URL . '/css/mwd-mailchimp.css', array(), get_option("mwd_version"));
	wp_enqueue_style('mwd-bootstrap', MWD_URL . '/css/mwd-bootstrap.css', array(), get_option("mwd_version"));
	wp_enqueue_style('jquery-ui', MWD_URL . '/css/jquery-ui-1.10.3.custom.css', array(), '1.10.3');
	wp_enqueue_style('jquery-ui-spinner', MWD_URL . '/css/jquery-ui-spinner.css', array(), '1.10.3');
	wp_enqueue_style('jquery.fancybox', MWD_URL . '/js/fancybox/jquery.fancybox.css', array(), '2.1.5');
	wp_enqueue_style('mwd-style', MWD_URL . '/css/style.css', array(), get_option("mwd_version"));
}

function mwd_submissions_scripts() {
	wp_enqueue_script('thickbox');
	global $wp_scripts;
	if (isset($wp_scripts->registered['jquery'])) {
		$jquery = $wp_scripts->registered['jquery'];
		if (!isset($jquery->ver) OR version_compare($jquery->ver, '1.8.2', '<')) {
			wp_deregister_script('jquery');
			wp_register_script('jquery', FALSE, array('jquery-core', 'jquery-migrate'), '1.10.2' );
		}
	}
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'jquery-ui-progressbar' );
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-widget');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-spinner');
	wp_enqueue_script('jquery-ui-mouse');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');

	wp_enqueue_script('forms_admin', MWD_URL . '/js/forms_admin.js', array(), get_option("mwd_version"));
	wp_enqueue_script('forms_manage', MWD_URL . '/js/forms_manage.js', array(), get_option("mwd_version"));
	wp_enqueue_script('mwd_submissions', MWD_URL . '/js/mwd_submissions.js', array(), get_option("mwd_version"));

	wp_enqueue_script('mwd_main_frontend', MWD_URL . '/js/mwd_main_frontend.js', array(), get_option("mwd_version"));
	wp_localize_script('mwd_main_frontend', 'mwd_objectL10n', array('plugin_url' => MWD_URL));
	wp_enqueue_script('jquery.fancybox.pack', MWD_URL . '/js/fancybox/jquery.fancybox.pack.js', array(), '2.1.5');

}

function mwd_front_end_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-widget');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-spinner');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-effects-shake');

	wp_enqueue_style('jquery-ui', MWD_URL . '/css/jquery-ui-1.10.3.custom.css');
	wp_enqueue_style('jquery-ui-spinner', MWD_URL . '/css/jquery-ui-spinner.css');
	wp_enqueue_style('mwd-mailchimp-frontend', MWD_URL . '/css/frontend/mwd-mailchimp-frontend.css', array(), get_option("mwd_version"));
	wp_enqueue_style('mwd-font-awesome', MWD_URL . '/css/frontend/font-awesome/font-awesome.css', array(), get_option("mwd_version"));
	wp_enqueue_style('mwd-animate', MWD_URL . '/css/frontend/mwd-animate.css', array(), get_option("mwd_version"));
	wp_enqueue_script('jelly.min', MWD_URL . '/js/jelly.min.js');
	wp_enqueue_script('file-upload-frontend', MWD_URL . '/js/file-upload-frontend.js');

	wp_enqueue_script('mwd_main_frontend', MWD_URL . '/js/mwd_main_frontend.js', array(), get_option("mwd_version"));
	wp_localize_script('mwd_main_frontend', 'mwd_objectL10n', array('plugin_url' => MWD_URL));

	require_once(MWD_DIR . '/includes/mwd_library.php');
	$google_fonts = MWD_Library::mwd_get_google_fonts();
	$fonts = implode("|", str_replace(' ', '+', $google_fonts));
	wp_enqueue_style('wds_googlefonts', 'https://fonts.googleapis.com/css?family=' . $fonts . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic', null, null);
}

function mwd_language_load() {
	load_plugin_textdomain('mwd-text', FALSE, basename(dirname(__FILE__)) . '/languages');
}
add_action('init', 'mwd_language_load');

?>
