<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdView extends WDFAdminViewBase {
  public function display($tpl = null) {
    wp_enqueue_style('wde_toolbar_icons');
    ?>
    <script>
      var COM_NAME = "<?php echo WDFHelper::get_com_name(); ?>";
      var CONTROLLER = "<?php echo WDFInput::get_controller(); ?>";
      var TASK = "<?php echo WDFInput::get_task(); ?>";
    </script>
    <?php
    // For ordering save.
    if (WDFInput::get_task() == NULL) {
      ?>
      <script> _ordering_ajax_url = "<?php echo add_query_arg(array('action' => 'wde_ajax', 'page' => 'wde_' . WDFInput::get_controller(), 'task' => 'save_order'), admin_url('admin-ajax.php'));?>"</script>
      <?php
    }
    parent::display($tpl);
  }
}