<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout);

$options = $this->options;
?>
<div class="container">
  <div class="row">
    <div>
      <div class="wd_shop_panel_user_data panel panel-default">
        <div class="panel-body">
          <h3 class="wd_shop_header"><?php _e('Log in', 'wde'); ?></h3>
          <form name="loginform" class="form-horizontal" role="form" id="loginform"
                action="<?php echo wp_login_url(WDFPath::add_pretty_query_args(get_permalink($options->option_usermanagement_page), $options->option_endpoint_edit_user_account, '1', FALSE)); ?>"
                method="POST">
            <div class="form-group">
              <label for="user_login" class="col-sm-4 control-label">
                <?php _e('Username', 'wde'); ?>:
              </label>
              <div class="col-sm-8">
                <input type="text"
                       name="log"
                       id="user_login" 
                       onkeydown="wd_shop_submit_form(event);"
                       class="wd_shop_required_field form-control"
                       placeholder="<?php _e('Username', 'wde'); ?>" />
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="col-sm-4 control-label">
                <?php _e('Password', 'wde'); ?>:
              </label>
              <div class="col-sm-8">
                <input type="password"
                       name="pwd"
                       id="user_pass" 
                       onkeydown="wd_shop_submit_form(event);"
                       class="wd_shop_required_field form-control"
                       placeholder="<?php _e('Password', 'wde'); ?>" />
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                <div class="checkbox">
                  <label>
                    <?php _e('Remember me', 'wde'); ?>
                    <input type="checkbox" name="rememberme" id="rememberme" />
                  </label>
                </div>
              </div>
            </div>
            <input type="hidden" name="redirect_to" value="<?php echo WDFInput::get('redirect_url', WDFUrl::get_referer_url()); ?>" />
          </form>
          <div class="wd_shop_alert_incorrect_data alert alert-danger hidden">
            <p><?php _e('Fill username password', 'wde'); ?></p>
          </div>
        </div>
        <div class="panel-footer text-right">
          <div class="btn-group">
            <?php
            if (get_option('users_can_register')) {
              ?>
            <a href="<?php echo wp_registration_url(); ?>" class="btn btn-default">
              <?php _e('Register', 'wde', 'wde'); ?>
            </a>
              <?php
            }
            ?>
            <a href="#" class="btn btn-primary" onclick="wdShop_onBtnLoginClick(event, this); return false;">
              <?php _e('Login', 'wde'); ?>
            </a>
          </div>
        </div>
      </div>
      <div>
        <p class="text-right">
          <a href="<?php echo wp_lostpassword_url(); ?>" class="link"><?php _e('Forgot password', 'wde'); ?></a>
        </p>
      </div>
    </div>
  </div>
</div>