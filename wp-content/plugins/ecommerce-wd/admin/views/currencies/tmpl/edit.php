<?php
defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);
// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

$row = $this->row;

$list_value_sign_positions = array();
$list_value_sign_positions[] = (object)array('value' => '0', 'text' => __('Left', 'wde'));
$list_value_sign_positions[] = (object)array('value' => '1', 'text' => __('Right', 'wde'));

$currencies_data = $this->currencies_data;

?>
<form name="adminForm" id="adminForm" action="" method="post">
  <?php echo $this->generate_message(); ?>
  <table class="adminlist table">
    <tbody>
      <!-- name -->
      <tr>
        <td class="col_key">
          <label for="name"><?php _e('Name', 'wde'); ?>:</label>
          <span class="star">*</span>
        </td>
        <td class="col_value">
          <input type="text"
                 name="name"
                 id="name"
                 class="required_field"
                 value="<?php echo $row->name; ?>"
                 onKeyPress="return disableEnterKey(event);"/>
        </td>
      </tr>
      <!-- code -->
      <tr>
        <td class="col_key">
          <label for="code"><?php _e('Code', 'wde'); ?>:</label>
          <span class="star">*</span>
        </td>
        <td class="col_value">
          <input type="text"
                 name="code"
                 id="code"
                 class="required_field"
                 value="<?php echo $row->code; ?>"
                 onKeyPress="return disableEnterKey(event);"/>
        </td>
      </tr>
      <!-- sign -->
      <tr>
        <td class="col_key">
          <label for="sign"><?php _e('Sign', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <input type="text"
                 name="sign"
                 id="sign"
                 value="<?php echo $row->sign; ?>"
                 onKeyPress="return disableEnterKey(event);"/>
        </td>
      </tr>
      <!-- sign position -->
      <tr>
        <td class="col_key">
          <label for="sign_position"><?php _e('Sign position', 'wde'); ?>:</label>
        </td>
        <td class="col_value">
          <?php echo WDFHTML::wd_radio_list('sign_position', $list_value_sign_positions, 'value', 'text', $row->sign_position); ?>
        </td>
      </tr>
    </tbody>
    <tbody>
      <?php
      foreach ($currencies_data as $currency_data) {
        ?>
      <tr>
        <td class="btn_select_container" colspan="2">
          <?php echo WDFHTML::jfbutton($currency_data->text, '', 'thickbox', 'onclick="onBtnSelectCurrencyClick(event, this,\''.$currency_data->payment_name.'\' );"'); ?>
        </td>
      </tr>
      <?php
    }
    ?>
    </tbody>
  </table>
  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>" />
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
</form>
<script>
  var _wde_admin_url = "<?php echo admin_url(); ?>";
</script>