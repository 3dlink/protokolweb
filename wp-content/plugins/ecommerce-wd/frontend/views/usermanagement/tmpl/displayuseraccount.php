<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);

$user_data = $this->user_data;
$options = $this->options;

?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <?php require WD_E_DIR . '/frontend/views/products/tmpl/displayproducts_bartop.php'; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="wd_shop_panel_user_data panel panel-default">
        <div class="panel-body">
          <h3 class="wd_shop_header">
            <?php _e('Billing Data', 'wde'); ?>
          </h3>
          <dl class="dl-horizontal">
            <?php
            if (is_array($user_data["billing_fields_list"])) {
              foreach ($user_data["billing_fields_list"] as $data) {
                if ($data["required"] > 0) {
                  ?>
                  <dt><p><?php echo $data["label"]; ?>:</p></dt>
                  <dd><p><?php echo $data["value"]; ?></p></dd>
                  <?php
                }
              }
            }
            ?>
          </dl>
        </div>
        <div class="panel-body">
          <h3 class="wd_shop_header">
            <?php _e('Shipping Data', 'wde'); ?>
          </h3>
          <dl class="dl-horizontal">
            <?php
            if (is_array($user_data["shipping_fields_list"])) {
              foreach ($user_data["shipping_fields_list"] as $data) {
                if ($data["required"] > 0) {
                  ?>
                  <dt><p><?php echo $data["label"]; ?>:</p></dt>
                  <dd><p><?php echo $data["value"]; ?></p></dd>
                  <?php
                }
              }
            }
            ?>
          </dl>
        </div>
        <div class="panel-footer text-right">
          <div class="btn-group">
            <a href="<?php echo WDFPath::add_pretty_query_args(get_permalink($options->option_usermanagement_page), $options->option_endpoint_edit_user_account, '1', FALSE); ?>"
               class="btn btn-primary">
              <?php _e('Edit data', 'wde'); ?>
            </a>
            <a href="<?php echo wp_logout_url(get_permalink($options->option_usermanagement_page)); ?>" class="btn btn-default">
              <?php _e('Logout', 'wde'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>