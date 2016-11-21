<?php

defined('ABSPATH') || die('Access Denied');

class WDE_Setup_Wizard {

  private $steps  = array();

  private $plugin_name = 'Ecommerce WD';
  private $prefix = 'wde';
  private $plugin_url = WD_E_URL;
  private $plugin_dir = WD_E_DIR;
  private $plugin_site_url = 'https://web-dorado.com/';
  private $plugin_image = '/images/toolbar_icons/checkout_48.png';
  private $plugin_js = '/js/wizard.js';
  private $plugin_css = '/css/wizard.css';
  private $plugin_version = WD_E_VERSION;
  private $redirect_url = 'edit.php?post_type=wde_products';

  public function __construct() {
    add_action('admin_menu', array($this, 'admin_menus'));
    add_action('admin_init', array($this, 'setup_wizard'));
	}

  public function admin_menus() {
		add_dashboard_page('', '', 'manage_options', $this->prefix . '_setup', array($this, 'setup_wizard'));
	}

  public function setup_wizard() {
		if (!isset($_GET['page']) || $this->prefix . '_setup' !== $_GET['page']) {
			return;
		}
    if (isset($_POST['wizard_save']) && $_POST['wizard_save'] == 1) {
			$this->save();
		}
    flush_rewrite_rules();
		$this->steps = array(
			'base' => array(
				'name'    =>  __('General options', $this->prefix),
				'view'    => array($this, 'wc_base_options'),
				'handler' => array($this, 'wc_setup_pages_save')
			),
			'checkout' => array(
				'name'    =>  __( 'Checkout', $this->prefix),
				'view'    => array($this, 'wc_checkout'),
				'handler' => array($this, 'wc_setup_locale_save')
			),
			'payments' => array(
				'name'    =>  __('Payments', $this->prefix),
				'view'    => array($this, 'wc_payments'),
				'handler' => array($this, 'wc_setup_shipping_taxes_save'),
			),
			'email' => array(
				'name'    =>  __('Email options', $this->prefix),
				'view'    => array($this, 'wc_email_options'),
				'handler' => array($this, 'wc_setup_payments_save'),
			),
			'finish' => array(
				'name'    =>  __('Final', $this->prefix),
				'view'    => array($this, 'wc_finish'),
				'handler' => ''
			)
		);

		wp_register_script($this->prefix . '_jquery.validate', $this->plugin_url . '/js/jquery.validate.js', array('jquery'), $this->plugin_version);
		wp_register_script($this->prefix . '_jquery.steps', $this->plugin_url . '/js/jquery.steps.js', array('jquery', $this->prefix . '_jquery.validate'), $this->plugin_version);
		wp_register_script($this->prefix . '_wizard', $this->plugin_url . $this->plugin_js, array($this->prefix . '_jquery.steps'), $this->plugin_version);
    wp_localize_script($this->prefix . '_wizard', 'wizard_params', array(
			'finish' => __('Finish', $this->prefix),
			'next' => __('Next', $this->prefix),
			'previous' => __('Previous', $this->prefix),
		));
    wp_localize_script($this->prefix . '_jquery.validate', 'wizard_params', array(
			'email_verify' => __('Please enter a valid email address.', $this->prefix)
		));

    wp_register_style($this->prefix . '_wizard', $this->plugin_url . $this->plugin_css, array(), $this->plugin_version);
    wp_register_style($this->prefix . '_layout_edit', $this->plugin_url . '/css/layout_edit.css', array(), $this->plugin_version);

		$this->setup_wizard_header();
		$this->setup_wizard_steps();
		$this->setup_wizard_footer();
		exit;
	}

  public function setup_wizard_header() {
		?>
		<!DOCTYPE html>
		<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
		<head>
			<title><?php echo $this->plugin_name . __(' setup wizard', $this->prefix); ?></title>
			<?php wp_print_scripts($this->prefix . '_wizard'); ?>
			<?php wp_print_styles($this->prefix . '_wizard'); ?>
			<?php do_action('admin_print_styles'); ?>
			<?php do_action('admin_head'); ?>
		</head>
		<body class="<?php echo $this->prefix; ?>-setup wp-core-ui">
      <div class="header">
        <span class="logo">
          <a href="<?php echo $this->plugin_site_url; ?>">
            <img src="<?php echo $this->plugin_url . $this->plugin_image; ?>" alt="<?php echo $this->plugin_name; ?>" title="<?php echo $this->plugin_name; ?>" />
          </a>
          <h1>
            <?php echo sprintf(__('Welcome to %s!', $this->prefix), $this->plugin_name); ?>
          </h1>
        </span>
        <p><?php echo _e('In this quick wizard we\'ll help you with the basic configurations.', $this->prefix); ?><a href="<?php echo esc_url(admin_url()); ?>" class="button button-large"><?php _e('Skip Wizard', $this->prefix); ?></a></p>
      </div>
		<?php
	}

	public function setup_wizard_footer() {
    ?>
			</body>
		</html>
		<?php
	}

  public function setup_wizard_steps() {
		$steps = $this->steps;
		?>
    <form action="#" method="POST">
      <div class="wizard clearfix">
        <?php
        foreach ($steps as $step_key => $step) {
          ?>
          <h3><?php echo $step['name']; ?></h3>
          <section>
            <?php call_user_func($step['view']); ?>
          </section>
          <?php
        }
        ?>
      </div>
      <?php wp_nonce_field('nonce_' . $this->prefix, 'nonce_' . $this->prefix); ?>
      <input type="hidden" id="wizard_save" name="wizard_save" value="" />
    </form>
		<?php
	}

  public function wc_base_options($initial_values = array()) {
    $initial_values['currency'] = 0;
    $initial_values['sign_position'] = 0;
    $initial_values['weight_unit'] = 'kg';
    $initial_values['dimensions_unit'] = 'cm';
    $initial_values['option_show_decimals'] = 1;

    $currencies = WDFDb::get_rows('currencies');
    foreach ($currencies as $currencies) {
      $list_currencies[] = array('value' => $currencies->id, 'text' => $currencies->name);
      if ($currencies->default == 1) {
        $initial_values['currency'] = $currencies->id;
      }
    }

    $list_value_sign_positions = array();
    $list_value_sign_positions[] = (object)array('value' => '0', 'text' => __('Left', $this->prefix));
    $list_value_sign_positions[] = (object)array('value' => '1', 'text' => __('Right', $this->prefix));

    $list_dimensions_units = array();
    $list_dimensions_units[] = array('value' => 'm', 'text' => 'm');
    $list_dimensions_units[] = array('value' => 'cm', 'text' => 'cm');
    $list_dimensions_units[] = array('value' => 'mm', 'text' => 'mm');
    $list_dimensions_units[] = array('value' => 'in', 'text' => 'in');
    $list_dimensions_units[] = array('value' => 'yd', 'text' => 'yd');

    $list_weight_units = array();
    $list_weight_units[] = array('value' => 'kg', 'text' => 'kg');
    $list_weight_units[] = array('value' => 'g', 'text' => 'g');
    $list_weight_units[] = array('value' => 'lbs', 'text' => 'lbs');
    $list_weight_units[] = array('value' => 'oz', 'text' => 'oz');
    ?>
		<table class="adminlist table">
      <tbody>
        <tr>
          <th class="col_key" scope="row">
            <label for="currency"><?php _e('Currency', $this->prefix); ?>:</label>
          </th>
          <td class="col_value">
            <?php echo WDFHTML::wd_select('currency', $list_currencies, 'value', 'text', $initial_values['currency']); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="sign_position"><?php _e('Sign position', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio_list('sign_position', $list_value_sign_positions, 'value', 'text', $initial_values['sign_position']); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="weight_unit"><?php _e('Weight unit', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">   
            <?php echo WDFHTML::wd_select('weight_unit', $list_weight_units, 'value', 'text', $initial_values['weight_unit']); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="dimensions_unit"><?php _e('Dimensions unit', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_select('dimensions_unit', $list_dimensions_units, 'value', 'text', $initial_values['dimensions_unit']); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="option_show_decimals"><?php _e('Display price with decimals', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('option_show_decimals', $initial_values['option_show_decimals'], __('Yes', $this->prefix), __('No', $this->prefix)); ?>
          </td>
        </tr>
      </tbody>
    </table>
    <?php
	}

  public function wc_checkout($initial_values = array()) {
    $initial_values['checkout_enable_checkout'] = 1;
    $initial_values['checkout_allow_guest_checkout'] = 0;
    $initial_values['checkout_redirect_to_cart_after_adding_an_item'] = 0;
    $initial_values['option_include_discount_in_price'] = 1;
    $initial_values['option_include_tax_in_price'] = 1;
    ?>
		<table class="adminlist table">
      <tbody>
        <tr>
          <td class="col_key">
            <label for="checkout_enable_checkout"><?php _e('Enable checkout', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('checkout_enable_checkout', $initial_values['checkout_enable_checkout'], __('Yes', $this->prefix), __('No', $this->prefix)); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="checkout_allow_guest_checkout"><?php _e('Allow guest checkout', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('checkout_allow_guest_checkout', $initial_values['checkout_allow_guest_checkout'], __('Yes', $this->prefix), __('No', $this->prefix)); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="checkout_redirect_to_cart_after_adding_an_item"><?php _e('Redirect to cart after adding an item', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('checkout_redirect_to_cart_after_adding_an_item', $initial_values['checkout_redirect_to_cart_after_adding_an_item'], __('Yes', $this->prefix), __('No', $this->prefix)); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="option_include_discount_in_price"><?php echo  __('Include discount in price', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('option_include_discount_in_price', $initial_values['option_include_discount_in_price'], __('Yes', $this->prefix), __('No', $this->prefix)); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="option_include_tax_in_price"><?php echo  __('Include tax in price', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('option_include_tax_in_price', $initial_values['option_include_tax_in_price'], __('Yes', $this->prefix), __('No', $this->prefix)); ?>
          </td>
        </tr>
      </tbody>
    </table>
    <?php
	}

  public function wc_payments($initial_values = array()) {
    $initial_values['without_online_payment'] = 1;
    $initial_values['paypal'] = 1;
    $initial_values['paypal_mode'] = 0;
    $initial_values['paypal_email'] = '';

    $list_value_paypal_mode = array();
    $list_value_paypal_mode[] = (object) array('value' => 0, 'text' => __('Sandbox', $this->prefix));
    $list_value_paypal_mode[] = (object) array('value' => 1, 'text' => __('Production', $this->prefix));
    ?>
		<table class="adminlist table">
      <tbody>
        <tr>
          <td class="col_key">
            <label for="without_online_payment"><?php _e('Without online payment', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('without_online_payment', $initial_values['without_online_payment'], __('Yes', $this->prefix), __('No', $this->prefix)); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="paypal"><?php _e('Paypal', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('paypal', $initial_values['paypal'], __('Yes', $this->prefix), __('No', $this->prefix), 'state_change', 'onchange="state_change(this)"'); ?>
          </td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td class="col_key">
            <label for="paypal_mode"><?php _e('Checkout mode', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio_list('paypal_mode', $list_value_paypal_mode, 'value', 'text', $initial_values['paypal_mode']); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="paypal_email"><?php _e('Paypal Email', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <input type="text" class="email" name="paypal_email" value="<?php echo $initial_values['paypal_email']; ?>" id="paypal_email" />
          </td>
        </tr>
      </tbody>
    </table>
    <?php
	}

  public function wc_email_options($initial_values = array()) {
    $admin_data = get_userdata(1);
    $admin_email = $admin_data->user_email;
    $initial_values['admin_email_enable'] = 1;
    $initial_values['admin_email'] = $admin_email;
    $initial_values['user_email_enable'] = 1;
    $initial_values['from_mail'] = $admin_email;

    $list_value_paypal_mode = array();
    $list_value_paypal_mode[] = (object) array('value' => 0, 'text' => __('Sandbox', $this->prefix));
    $list_value_paypal_mode[] = (object) array('value' => 1, 'text' => __('Production', $this->prefix));
    ?>
		<table class="adminlist table">
      <tbody>
        <tr>
          <td class="col_key">
            <label><?php _e('Send Email to Administrator', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('admin_email_enable', $initial_values['admin_email_enable'], __('Yes', $this->prefix), __('No', $this->prefix)); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="admin_email"><?php _e('Administrator Email From', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <input type="text" class="email" name="admin_email" id="admin_email" value="<?php echo $initial_values['admin_email']; ?>" />
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label><?php _e('Send Email to Customer', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <?php echo WDFHTML::wd_radio('user_email_enable', $initial_values['user_email_enable'], __('Yes', $this->prefix), __('No', $this->prefix)); ?>
          </td>
        </tr>
        <tr>
          <td class="col_key">
            <label for="from_mail"><?php _e('Customer Email From', $this->prefix); ?>:</label>
          </td>
          <td class="col_value">
            <input type="text" class="email" name="from_mail" id="from_mail" value="<?php echo $initial_values['from_mail']; ?>" />
          </td>
        </tr>
      </tbody>
    </table>
    <?php
	}

  public function wc_finish() {
    ?>
    <h1><?php _e('Congratulations! Your Store Is Ready Now.', $this->prefix); ?></h1><br />
    <h3><p><?php _e('Your Are Ready To Launch Your E-commerce.', $this->prefix); ?></p></h3>
    <h3><p><?php _e('Click the blue button below to finalize the wizard.', $this->prefix); ?></p></h3>
    <?php
	}

  public function save() {
    check_admin_referer('nonce_' . $this->prefix, 'nonce_' . $this->prefix);
    $currency = isset($_POST['currency']) ? (int) esc_html(stripslashes($_POST['currency'])) : 1;
    $sign_position = isset($_POST['sign_position']) ? (int) esc_html(stripslashes($_POST['sign_position'])) : 0;
    $without_online_payment = isset($_POST['without_online_payment']) ? (int) esc_html(stripslashes($_POST['without_online_payment'])) : 1;
    $paypal = isset($_POST['paypal']) ? (int) esc_html(stripslashes($_POST['paypal'])) : 1;
    $paypal_mode = isset($_POST['paypal_mode']) ? (int) esc_html(stripslashes($_POST['paypal_mode'])) : 0;
    $paypal_email = isset($_POST['paypal_email']) ? esc_html(stripslashes($_POST['paypal_email'])) : '';

    $options = array();
    $options['weight_unit'] = isset($_POST['weight_unit']) ? esc_html(stripslashes($_POST['weight_unit'])) : 'kg';
    $options['dimensions_unit'] = isset($_POST['dimensions_unit']) ? esc_html(stripslashes($_POST['dimensions_unit'])) : 'cm';
    $options['option_show_decimals'] = isset($_POST['option_show_decimals']) ? (int) esc_html(stripslashes($_POST['option_show_decimals'])) : 1;
    $options['checkout_enable_checkout'] = isset($_POST['checkout_enable_checkout']) ? (int) esc_html(stripslashes($_POST['checkout_enable_checkout'])) : 1;
    $options['checkout_allow_guest_checkout'] = isset($_POST['checkout_allow_guest_checkout']) ? (int) esc_html(stripslashes($_POST['checkout_allow_guest_checkout'])) : 0;
    $options['checkout_redirect_to_cart_after_adding_an_item'] = isset($_POST['checkout_redirect_to_cart_after_adding_an_item']) ? (int) esc_html(stripslashes($_POST['checkout_redirect_to_cart_after_adding_an_item'])) : 0;
    $options['option_include_discount_in_price'] = isset($_POST['option_include_discount_in_price']) ? (int) esc_html(stripslashes($_POST['option_include_discount_in_price'])) : 1;
    $options['option_include_tax_in_price'] = isset($_POST['option_include_tax_in_price']) ? (int) esc_html(stripslashes($_POST['option_include_tax_in_price'])) : 1;
    $options['admin_email_enable'] = isset($_POST['admin_email_enable']) ? (int) esc_html(stripslashes($_POST['admin_email_enable'])) : 1;
    $options['admin_email'] = isset($_POST['admin_email']) ? esc_html(stripslashes($_POST['admin_email'])) : '';
    $options['user_email_enable'] = isset($_POST['user_email_enable']) ? (int) esc_html(stripslashes($_POST['user_email_enable'])) : 1;
    $options['from_mail'] = isset($_POST['from_mail']) ? esc_html(stripslashes($_POST['from_mail'])) : '';

    global $wpdb;
    $wpdb->update($wpdb->prefix . 'ecommercewd_currencies', array('default' => 0), array('default' => 1));
    $wpdb->update($wpdb->prefix . 'ecommercewd_currencies', array('default' => 1, 'sign_position' => $sign_position), array('id' => $currency));
    $wpdb->update($wpdb->prefix . 'ecommercewd_payments', array('published' => $without_online_payment), array('short_name' => 'without_online_payment'));
    $paypal_options_json = $wpdb->get_var('SELECT `options` FROM ' . $wpdb->prefix . 'ecommercewd_payments WHERE short_name="paypalstandard"');
    $paypal_options = json_decode($paypal_options_json);
    $paypal_options->mode = $paypal_mode;
    $paypal_options->paypal_email = $paypal_email;
    $wpdb->update($wpdb->prefix . 'ecommercewd_payments', array('published' => $paypal, 'options' => json_encode($paypal_options)), array('short_name' => 'paypalstandard'));

    $option_names = $wpdb->get_col('SELECT name FROM ' . $wpdb->prefix . 'ecommercewd_options');
    $option_keys = array_keys($options);
    foreach ($option_names as $option_name) {
      if (in_array($option_name, $option_keys)) {
        $wpdb->update($wpdb->prefix . 'ecommercewd_options', array('value' => $options[$option_name]), array('name' => $option_name));
      }
    }

    wp_redirect(esc_url(admin_url($this->redirect_url)));
    exit();
  }
}

new WDE_Setup_Wizard();