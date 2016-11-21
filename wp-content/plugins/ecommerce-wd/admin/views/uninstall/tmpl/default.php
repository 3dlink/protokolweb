<?php

defined('ABSPATH') || die('Access Denied');

// js
wp_enqueue_script('wde_view');

global $wpdb;
$prefix = $wpdb->prefix;
?>
<form name="adminForm" id="adminForm" action="" method="post">
  <?php wp_nonce_field('wd_ecommerce uninstall');?>
    <div class="wrap">
      <p>
        <?php _e('Deactivating ecommerce WordPress plugin does not remove any data that may have been created, to completely remove this plugin, you can uninstall it here.', 'wde'); ?>
      </p>
      <p style="color: red;">
        <strong><?php _e('warning', 'wde'); ?>:</strong>
        <?php _e('Once uninstalled, this can\'t be undone, you should use a database backup plugin of Wordpress to back up all the data first.', 'wde'); ?>        
      </p>
      <?php if (get_option('wde_sample_data')) { ?>
      <p>
        <?php _e('If you want to remove the sample data press this button.', 'wde'); ?>
        <input type="submit" value="<?php _e('Remove sample data', 'wde'); ?>" class="button-primary" onclick="submitform('remove_sample_data')"; />
      </p>
      <?php } ?>
      <p style="color: red">
        <strong><?php _e('The following database tables,custom posts and taxonomy terms will be deleted', 'wde'); ?>:</strong>
      </p>
      <table class="widefat">
        <thead>
          <tr>
            <th><?php _e('Database table', 'wde'); ?></th>
          </tr>
        </thead>
        <tr>
          <td valign="top">
            <ol>
                <li><?php echo $prefix; ?>ecommercewd_currencies</li>
                <li><?php echo $prefix; ?>ecommercewd_options</li>
                <li><?php echo $prefix; ?>ecommercewd_orderproducts</li>
                <li><?php echo $prefix; ?>ecommercewd_orders</li>
                <li><?php echo $prefix; ?>ecommercewd_orderstatuses</li>
                <li><?php echo $prefix; ?>ecommercewd_parametertypes</li>
                <li><?php echo $prefix; ?>ecommercewd_payments</li>
                <li><?php echo $prefix; ?>ecommercewd_ratings</li>
                <li><?php echo $prefix; ?>ecommercewd_themes</li>
                <li><?php echo $prefix; ?>ecommercewd_tools</li>
                <li><?php echo $prefix; ?>ecommercewd_tax_rates</li>
            </ol>
          </td>
        </tr>
        <thead>
          <tr>
            <th><?php _e('Custom posts', 'wde'); ?></th>
          </tr>
        </thead>
        <tr>
          <td valign="top">
            <ol>
                <li>wde_products</li>
                <li>wde_manufacturers</li>
            </ol>
          </td>
        </tr>
        <thead>
          <tr>
            <th><?php _e('Custom taxonomies', 'wde'); ?></th>
          </tr>
        </thead>
        <tr>
          <td valign="top">
            <ol>
                <li>wde_categories</li>
                <li>wde_countries</li>
                <li>wde_discounts</li>
                <li>wde_labels</li>
                <li>wde_parameters</li>
                <li>wde_shippingmethods</li>
                <li>wde_tag</li>
                <li>wde_taxes</li>
            </ol>
          </td>
        </tr>
      </table>
      <p style="text-align: center;">
        <?php _e('Do you really want to uninstall ecommerce wd?', 'wde'); ?>
      </p>
      <p style="text-align: center;">
        <input type="checkbox" name="Ecommerce WD" id="check_yes" value="yes" />&nbsp;<label for="check_yes"><?php _e('Yes', 'wde'); ?></label>
      </p>
      <p style="text-align: center;">
        <input type="submit" value="<?php _e('Uninstall', 'wde'); ?>" class="button-primary" onclick="if (check_yes.checked) { 
                                                                                  if (confirm('<?php echo addslashes(__('You are about to uninstall ecommerce from wordpress. This action is not reversible.', 'wde')); ?>')) {
                                                                                      submitform('uninstall');
                                                                                  } else {
                                                                                      return false;
                                                                                  }
                                                                                }
                                                                                else {
                                                                                  return false;
                                                                                }" />
      </p>
    </div>
    <input id="task" name="task" type="hidden" value="" />
</form>