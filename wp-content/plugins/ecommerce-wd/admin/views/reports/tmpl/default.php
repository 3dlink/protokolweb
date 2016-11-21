<?php
 
defined('ABSPATH') || die('Access Denied');

// css
wp_print_styles('wde_layout_' . $this->_layout);
wp_print_styles('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_print_scripts('wde_view');
wp_print_scripts('wde_layout_' . $this->_layout);
wp_print_scripts('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

wp_print_scripts('wde_jquery.flot');
wp_print_scripts('wde_jquery.flot.pie');
wp_print_scripts('wde_jquery.flot.resize');
wp_print_scripts('wde_jquery.flot.stack');
wp_print_scripts('wde_jquery.flot.time');

$report_data  = $this->report_data;
$decimals = $this->decimals;
$default_currency = $this->row_default_currency;
?>
<form name="adminForm" id="adminForm" action="" method="post">
  <?php
  WDFHTMLTabs::startTabs('reports', WDFInput::get('tab_index', 'year'), 'onTabActivated');
  WDFHTMLTabs::startTab('year', __('Year', 'wde'));
  WDFHTMLTabs::startTab('last_month', __('Last month', 'wde'));
  WDFHTMLTabs::startTab('this_month', __('This month', 'wde'));
  WDFHTMLTabs::startTab('last_week', __('Last week', 'wde'));
  WDFHTMLTabs::startTab('custom', __('Custom', 'wde'));
  WDFHTMLTabs::endTabs();

  WDFHTMLTabs::startTabsContent();
	if (WDFInput::get('tab_index') == "custom") {
    ?>
		<div class="date-range">
			<table class="adminlist table-striped search_table">
				<tbody>
					<tr>
						<td><label for="start_date"><?php _e('Date from', 'wde'); ?>:</label></td>
						<td><?php echo WDFHTML::wd_date('start_date', WDFInput::get("start_date"), '%Y-%m-%d', 'class="inputbox"'); ?></td>
						<td><label for="end_date"><?php _e('Date to', 'wde'); ?>:</label></td>
						<td><?php echo WDFHTML::wd_date('end_date', WDFInput::get("end_date"), '%Y-%m-%d', 'class="inputbox"'); ?></td>
						<td><?php echo WDFHTML::jfbutton(__('Go', 'wde'), '', '', 'onclick="onTabActivated(\'custom\');"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?></td>
						<td><?php echo WDFHTML::jfbutton(__('Reset', 'wde'), '', '', 'onclick="document.getElementById(\'start_date\').value=\'\';document.getElementById(\'end_date\').value=\'\';onTabActivated(\'custom\');"', WDFHTML::BUTTON_COLOR_BLUE, WDFHTML::BUTTON_SIZE_SMALL); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
    <?php 
	}
  WDFHTMLTabs::startTabContent(WDFInput::get('tab_index', 'year'));
	if ($default_currency !== NULL) {
    if ($report_data->start_date || $report_data->end_date ) {
      ?>
    <table class="adminlist table report">
      <tbody>
        <!-- sales in this period -->
        <tr class="wd_reports_row">
          <td width="1%" class="type type-color-sales">
          </td>
          <td  width="2%">
            <input type="checkbox" checked="checked" id="total_seals" class="wd-chart" value="total_seals" onclick="wd_ShopGetCharts();" />
          </td>
          <td class="col_key">
            <label  for="total_seals">
              <?php _e('Sales in this period', 'wde'); ?>:
            </label>
          </td>
          <td class="col_value">
            <?php echo WDFText::wde_number_format($report_data->total_seals, $decimals)." ".$default_currency->code; ?>
          </td>
        </tr>
        <!-- average monthly sales -->
        <tr class="wd_reports_row">
          <td width="1%" class="type type-color-average">
          </td>					
          <td  width="2%">
            <input type="checkbox" checked="checked" id="average_sales" class="wd-chart" value="average_sales" onclick="wd_ShopGetCharts();" />
          </td>					
          <td class="col_key">
            <label for="average_sales">
              <?php echo $report_data->average_type == "monthly" ? __('Average monthly sales', 'wde') : __('Average daily sales', 'wde'); ?>:
            </label>
          </td>
          <td class="col_value">
            <?php echo WDFText::wde_number_format($report_data->average_sales, $decimals)." ".$default_currency->code; ?>
          </td>					
        </tr>
        <!-- orders placed -->
        <tr class="wd_reports_row">
          <td width="1%" class="type type-color-orders">
          </td>					
          <td  width="2%">
            <input type="checkbox" checked="checked" id="orders_count" class="wd-chart" value="orders_count" onclick="wd_ShopGetCharts();" />
          </td>					
          <td class="col_key">
            <label for="orders_count">
              <?php _e('Orders placed', 'wde'); ?>:
            </label>
          </td>
          <td class="col_value">
            <?php echo $report_data->orders_count; ?>
          </td>
        </tr>	
        <!-- items purchased -->
        <tr class="wd_reports_row">
          <td width="1%" class="type type-color-items">
          </td>					
          <td  width="2%">
            <input type="checkbox" checked="checked" class="wd-chart" id="items_count" value="items_count" onclick="wd_ShopGetCharts();" />
          </td>					
          <td class="col_key">
            <label for="items_count" >
              <?php _e('Items purchased', 'wde'); ?>:
            </label>
          </td>
          <td class="col_value">
            <?php echo $report_data->items_count; ?>
          </td>					
        </tr>
        <!-- charged for shipping -->
        <tr class="wd_reports_row">
          <td width="1%" class="type type-color-shipping">
          </td>						
          <td  width="2%">
            <input type="checkbox" checked="checked" class="wd-chart" id="total_shipping_seals" value="total_shipping_seals" onclick="wd_ShopGetCharts();" />
          </td>					
          <td class="col_key">
            <label for="total_shipping_seals">
              <?php _e('Charged for shipping', 'wde'); ?>:
            </label>
          </td>
          <td class="col_value">
            <?php echo WDFText::wde_number_format($report_data->total_shipping_seals, $decimals)." ".$default_currency->code; ?>
          </td>				
        </tr>				
      </tbody>
    </table>
      <?php 
    }
    ?>
    <div id="placeholder_wrapper">
      <div id="placeholder" class="chart-placeholder main"></div>
    </div>
    <script type="text/javascript">
      var report_data = jQuery.parseJSON('<?php echo $report_data->json_data;?>');
      var default_currency_code = '<?php echo $default_currency->code;?>';
      var wdShop_urlCheckChart = '<?php echo add_query_arg(array('page' => 'wde_reports', 'task' => 'select_chart'), admin_url('admin.php')); ?>';
      var wdShop_totalSales = "<?php echo (float) $report_data->total_seals ? WDFText::wde_number_format($report_data->total_seals, $decimals) : 0; ?>";
      var wdShop_itemsCount = <?php echo (int) $report_data->items_count ? $report_data->items_count : 0; ?>;
      var wdShop_decimals = <?php echo (int) $decimals; ?>;
      wd_Shop_drawReportChart();
    </script>
    <?php
	}
	else {
		_e('The selected range contains more than one currency. Thus it is not possible to generate a report.', 'wde');
	}
  WDFHTMLTabs::endTabContent();
  WDFHTMLTabs::endTabsContent();

  WDFHTMLTabs::scripts();
	?>
  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>" />
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="tab_index" value="<?php echo WDFInput::get('tab_index', 'year'); ?>" />
</form>