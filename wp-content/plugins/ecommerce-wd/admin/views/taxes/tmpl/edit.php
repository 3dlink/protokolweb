<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_default');
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);
wp_enqueue_script('wde_layout_default');
wp_enqueue_script('wde_bootstrap');
wp_enqueue_style('wde_bootstrap');
wp_enqueue_style('wde_admin_main');

$term_id = $this->row;
if ($term_id) {
  $row = get_option("wde_taxes_" . $term_id);
  $tax_rates = $this->tax_rates;
  $edit = TRUE;
}
else {
  $tax_rates = FALSE;
  $edit = FALSE;
}

  if ($tax_rates === FALSE) {
    $tax_rates = array();
    if (isset($row['rate'])) {
      // Add old tax to tax class if it exist.
      $data = array(
        'country' => 0,
        'state' => '',
        'zipcode' => '',
        'city' => '',
        'rate' => $row['rate'],
        'tax_name' => '',
        'priority' => 1,
        'compound' => 0,
        'shipping_rate' => 0,
        'ordering' => 1,
        'tax_id' => $term_id,
      );
      global $wpdb;
      $wpdb->insert($wpdb->prefix . 'ecommercewd_tax_rates', $data);
      $tax_rate = (object) $data;
      $tax_rate->id = $wpdb->insert_id;
      $tax_rates[] = $tax_rate;
    }
  }
  if (isset($_POST['tag-name'])) {
    $tax_rates = array();
  }
  array_push($tax_rates, $this->tax_rates_defaults);
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);
  ?>
  <div class="wde_tooltip"></div>
  <tr>
    <th scope="row" class="wde_tax_rates_label">
      <label><?php _e('Tax rates', 'wde'); ?></label>
    </th>
  </tr>
  <tr>
    <td colspan="2" class="wde_tax_rates">
      <table class="adminlist table table-striped wp-list-table widefat fixed pages">
        <tbody>
         <?php echo WDFHTML::div_import(array("function" => "taxImport", "term_id" => $term_id, "name" => "import")); ?>
          <tr>
            <?php
            if ($edit) {
              ?>
            <td class="btns_container">
              <?php
               echo WDFHTML::jfbutton(__('Export CSV', 'wde'), '', '', 'onclick="taxExport(this);" download="taxRates.csv"');
               echo WDFHTML::jfbutton(__('Import CSV', 'wde'), '', '', 'onclick="jQuery(\'.wde_opacity_popup,.wde_popup_div\').show();"');
              ?>
            </td>
              <?php
            }
            else {
              ?>
            <td>
              <?php _e('Edit tax for more options.', 'wde'); ?>
            </td>
              <?php
            }
            ?>
          </tr>
        </tbody>
      </table>
      <table class="adminlist table table-striped wp-list-table widefat fixed pages wde_tax_class wd_taxes">
        <thead>
          <tr>
            <?php
            if ($edit) {
              ?>
            <?php echo WDFHTML::wd_ordering('ordering', $sort_by, $sort_order); ?>
              <?php
            }
            ?>
            <th class="col_checked manage-column column-cb check-column"><input id="check_all" type="checkbox" style="margin:0;" /></th>
            <th class="col_country"><?php _e('Country', 'wde'); ?></th>
            <?php
            if ($edit) {
              ?>
            <th class="col_state">
              <?php _e('State', 'wde'); ?>
              <span class="wde_info glyphicon glyphicon-info-sign" data-original-title="<?php _e('Semi-colon (;) separate multiple values. Leave blank to apply to all.', 'wde'); ?>"></span>
            </th>
            <th class="col_zipcode">
              <?php _e('ZIP/Postcode', 'wde'); ?>
              <span class="wde_info glyphicon glyphicon-info-sign" data-original-title="<?php _e('Semi-colon (;) separate multiple values. Leave blank to apply to all.', 'wde'); ?>"></span>
            </th>
            <th class="col_city">
              <?php _e('City', 'wde'); ?>
              <span class="wde_info glyphicon glyphicon-info-sign" data-original-title="<?php _e('Semi-colon (;) separate multiple values. Leave blank to apply to all.', 'wde'); ?>"></span>
            </th>
              <?php
            }
            ?>
            <th class="col_rate"><?php _e('Rate %', 'wde'); ?></th>
            <?php
            
              ?>
            <th class="col_name"><?php _e('Name', 'wde'); ?></th>
              <?php
           
            ?>
            <th class="col_priority">
              <?php _e('Priority', 'wde'); ?>
              <span class="wde_info glyphicon glyphicon-info-sign" data-original-title="<?php _e('To define multiple tax rates for a single area you need to specify a different priority per rate.', 'wde'); ?>"></span>
            </th>
            <?php
            if ($edit) {
              ?>
            <th class="col_compound">
              <?php _e('Compound', 'wde'); ?>
              <span class="wde_info glyphicon glyphicon-info-sign" data-original-title="<?php _e('Compound tax rates are applied on top of other tax rates.', 'wde'); ?>"></span>
            </th>
            <th class="col_shipping_rate"><?php _e('Shipping rate %', 'wde'); ?></th>
              <?php
            }
            ?>
          </tr>
        </thead>
        <tbody>	
          <?php
          if ($tax_rates) {
            foreach ($tax_rates as $i => $rate) {
              ?>
          <tr class="<?php echo $rate->id == 'default' ? 'wde_hide' : 'row' . ($i % 2); ?>">
            <?php
            if ($edit) {
              ?>
            <td class="col_ordering">
              <?php echo $this->generate_order_cell_content('', $rate->ordering, 'icon-drag'); ?>
              <input type="hidden" value="<?php echo $i; ?>" name="orders[<?php echo $rate->id; ?>]" />
            </td>
              <?php
            }
            ?>
            <td class="col_checked check-column">
              <input type="checkbox" class="wde_check" id="cb<?php echo $rate->id; ?>" name="cid[<?php echo $rate->id; ?>]" value="<?php echo $rate->id; ?>" />
            </td>
            <td class="col_country">
              <?php echo WDFDb::get_list_countries(TRUE, $rate->country, array('name' => 'countries[' . $rate->id . ']', 'empty_value' => __('All countries', 'wde'))); ?>
            </td>
            <?php
            if ($edit) {
              ?>
            <td class="col_state">
              <input type="text" value="<?php echo $rate->state ?>" name="states[<?php echo $rate->id; ?>]" />
            </td>
            <td class="col_zipcode">
              <input type="text" value="<?php echo $rate->zipcode ?>" name="zipcodes[<?php echo $rate->id; ?>]" />
            </td>
            <td class="col_city">
              <input type="text" value="<?php echo $rate->city ?>" name="cities[<?php echo $rate->id; ?>]" />
            </td>
              <?php
            }
            ?>
            <td class="col_rate">
              <input type="number" step="any" min="0" value="<?php echo $rate->rate ?>" placeholder="0" name="rates[<?php echo $rate->id; ?>]" />
            </td>
            <?php
            
              ?>
            <td class="col_name">
              <input type="text" value="<?php echo $rate->tax_name ?>" name="tax_names[<?php echo $rate->id; ?>]" />
            </td>
              <?php
            
            ?>
            <td class="col_priority">
              <input type="number" step="1" min="0" placeholder="1" value="<?php echo $rate->id == 'default' ? 1 : $rate->priority; ?>" name="priorities[<?php echo $rate->id; ?>]" />
            </td>
            <?php
            if ($edit) {
              ?>
            <td class="col_compound">
              <input type="checkbox" class="checkbox" name="compounds[<?php echo $rate->id ?>]" <?php checked($rate->compound, 1); ?> />
            </td>
            <td class="col_shipping_rate">
              <input type="number" step="any" min="0" value="<?php echo $rate->shipping_rate ?>" placeholder="0" name="shipping_rates[<?php echo $rate->id; ?>]" />	
            </td>
              <?php
            }
            ?>
          </tr>
            <?php
            }
          }
        ?>
        </tbody>
      </table>
      <table class="adminlist table table-striped wp-list-table widefat fixed pages">
        <tbody>
          <tr>
            <td>
              <?php
              echo WDFHTML::jfbutton(__('Insert row', 'wde'), '', '', 'onclick="wde_add_tax_rates_row();"');
              echo WDFHTML::jfbutton(__('Remove selected row(s)', 'wde'), '', '', 'onclick="wde_remove_tax_rates_row();"');
              ?>
              <input type="hidden" name="removed" value="" />
            </td>
          </tr>
        </tbody>
      </table>
      <p class="description"></p>
    </td>
  </tr>
  <script>
    var _wde_admin_url = "<?php echo admin_url(); ?>";
  </script>

