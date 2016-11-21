<?php

defined('ABSPATH') || die('Access Denied');

// WD js
wp_print_scripts('jquery');

// WD css
wp_print_styles('dashicons');
wp_print_styles('wp-admin');
wp_print_styles('buttons');
wp_print_styles('wp-auth-check');

$controller = WDFInput::get_controller();
wde_register_ajax_scripts($controller);

// css
wp_print_styles('wde_layout_explore');
wp_print_styles('wde_' . $controller . '_' . $this->_layout);

// js
wp_print_scripts('wde_view');
wp_print_scripts('wde_layout_explore');
wp_print_scripts('wde_' . $controller . '_' . $this->_layout);

$currencies_data = $this->currencies_data;
$paymnet_name = WDFInput::get('payment');
?>
<form class="wp-core-ui" name="adminForm" id="adminForm" action="" method="post">
  <table class="adminlist table table-striped widefat fixed pages">
    <thead>
      <tr>
        <th colspan="2">
          <?php _e(strtoupper($paymnet_name) . "Paypal-supported currencies", 'wde'); ?>
        </th>
      </tr>
      <tr>
        <th class="col_key">
          <?php _e("Currency", 'wde'); ?>
        </th>
        <th class="col_value">
          <?php _e("Currency code", 'wde'); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $_currency_data = $currencies_data[$paymnet_name];
      $currencies = $_currency_data->currencies;
      foreach ($currencies as $currency_code => $currency_data) {
        $alternate = (!isset($alternate) || $alternate == 'alternate') ? '' : 'alternate';
        $star = "";
        if ($currency_data[2] == 1) {
          $star = " *";
        }
        ?>
      <tr class="<?php echo $alternate; ?>">
        <td class="col_key">
          <a onclick="insertCurrencyData('<?php echo $currency_data[0]; ?>', '<?php echo $currency_code; ?>', '<?php echo $currency_data[1]; ?>')">
            <?php echo $currency_data[0] . $star; ?>
          </a>
        </td>
        <td class="col_value">
          <?php echo $currency_code; ?>
        </td>
      </tr>
        <?php 
      }
      ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php _e(strtoupper($paymnet_name) . '* This currency is supported as a payment currency and a currency balance for in-country PayPal accounts only.', 'wde'); ?>
        </td>
      </tr>
    </tfoot>
  </table>
</form>
<script>
  var _callback = "<?php echo WDFInput::get('callback'); ?>";
</script>
<?php
die();