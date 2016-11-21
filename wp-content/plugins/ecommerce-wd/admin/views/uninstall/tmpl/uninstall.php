<?php
defined('ABSPATH') || die('Access Denied');

$deactivate_url = wp_nonce_url('plugins.php?action=deactivate&amp;plugin=' . WD_E_PLUGIN_NAME . '/ecommerce-wd.php', 'deactivate-plugin_' . WD_E_PLUGIN_NAME . '/ecommerce-wd.php');
?><div class="spider_message">
  <div class="wd_error">
    <p><?php _e('The plugin database tables, posts and taxanomies successfully deleted.', 'wde'); ?></p>
  </div>
</div>
<form name="adminForm" id="adminForm" action="" method="post">
  <div class="wrap">
    <h2><?php _e('Uninstall ecommerce wd', 'wde'); ?></h2>
    <p><strong><a href="<?php echo $deactivate_url; ?>"><?php _e('Click here', 'wde'); ?></a> <?php _e('To finish the uninstallation and ecommerce will be deactivated automatically.', 'wde'); ?></strong></p>
    <input id="task" name="task" type="hidden" value="" />
  </div>
</form>
