<?php

defined('ABSPATH') || die('Access Denied');

// WD js
wp_print_scripts('jquery');
?>
<script>
  var _callback = "<?php echo WDFInput::get('callback'); ?>";
  var _treeData = JSON.parse("<?php echo addslashes(stripslashes(WDFJson::encode($this->tree_data, 256))); ?>");
  var _opened = "<?php echo WDFInput::get('opened'); ?>";
  var _disabledNodeId = <?php echo WDFInput::get('disabled_node_id', 0, 'int'); ?>;
  var _disabledNodeAndChildrenId = <?php echo WDFInput::get('disabled_node_and_children_id', 0, 'int'); ?>;
  var _selectedNodeId = <?php echo WDFInput::get('selected_node_id', 0, 'int'); ?>;
</script>
<?php
echo WDFHTML::jf_tree_generator('tree_generator');
// js
wp_print_scripts('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

die();