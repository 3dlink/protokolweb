<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);

$form_fields = $this->form_fields;
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
    <div class="col-lg-12 col-lg-offset-0">
      <div class="wd_shop_panel_user_data panel panel-default">
        <div class="panel-body">
            <h3 class="wd_shop_header">
              <?php _e('Edit data', 'wde'); ?>
            </h3>
            <form name="wd_shop_form_update_data"
                  class="form-horizontal"
                  role="form"
                  action="<?php echo add_query_arg('task', 'updateuserdata', get_permalink($options->option_usermanagement_page)); ?>"
                  method="POST">
              <?php
              if (is_array($form_fields)) {
                foreach ($form_fields as $form_section_name => $form_section_fields) {
                  ?>
                  <h3 class="wd_shop_header">
                    <?php _e($form_section_name == 'billing_fields_list' ? 'Billing data' : 'Shipping data', 'wde'); ?>
                  </h3>
                  <?php
                  foreach ($form_section_fields as $form_field_number => $form_field) {
                    if ($form_field['required'] > 0) {
                      $form_group_class = 'form-group';
                      $form_group_class .= $form_field['has_error'] == true ? ' has-error' : '';

                      $field_class = 'form-control';
                      $field_class .= $form_field['required'] == 2 ? ' wd_shop_required_field' : '';
                      switch ($form_field['type']) {
                          case 'select':
                              ?>
                              <div class="<?php echo $form_group_class; ?>">
                                  <label for="<?php echo $form_field['id']; ?>"
                                         class="col-md-4 control-label">
                                      <?php echo $form_field['label']; ?>:
                                      <?php if ($form_field['required'] == 2) { ?>
                                          <span class="wd_star">*</span>
                                      <?php } ?>
                                  </label>

                                  <div class="col-md-8">
                                      <?php
                                      echo WDFHtml::wd_select($form_field['id'], $form_field['options'], 'id', 'name', isset($user_data[$form_section_name][$form_field_number]["value"]) == true ? $user_data[$form_section_name][$form_field_number]["value"] : '', 'class="' . $field_class . '"');
                                      ?>
                                  </div>
                              </div>
                              <?php
                              break;
                          default:
                              ?>
                                  <div class="<?php echo $form_group_class; ?>">
                                      <label for="<?php echo $form_field['id']; ?>"
                                             class="col-md-4 control-label">
                                          <?php echo $form_field['label']; ?>:
                                          <?php if ($form_field['required'] == 2) { ?>
                                              <span class="wd_star">*</span>
                                          <?php } ?>
                                      </label>

                                      <div class="col-md-8">
                                          <input type="<?php echo $form_field['type']; ?>"
                                                 name="<?php echo $form_field['id']; ?>"
                                                 id="<?php echo $form_field['id']; ?>"
                                                 class="<?php echo $field_class; ?>"
                                                 placeholder="<?php echo $form_field['label']; ?>"
                                                 value="<?php echo isset($user_data[$form_section_name][$form_field_number]["value"]) == true ? $user_data[$form_section_name][$form_field_number]["value"] : ''; ?>">
                                      </div>
                                  </div>
                              <?php
                              break;
                      }
                    }
                  }
                }
              }
              ?>
            </form>
            <div class="wd_shop_alert_incorrect_data alert alert-danger hidden">
              <p><?php _e('This field is required', 'wde') ?></p>
            </div>
        </div>
        <div class="panel-footer text-right">
          <div class="btn-group">
            <a href="<?php echo get_permalink($options->option_usermanagement_page); ?>" class="btn btn-default">
              <?php _e('Back', 'wde'); ?>
            </a>
            <a class="btn btn-primary" onclick="wdShop_onBtnUpdateUserDataClick(event, this); return false;">
              <?php _e('Update data', 'wde'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>