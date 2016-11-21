<?php

defined('ABSPATH') || die('Access Denied');

// WD js
wp_print_scripts('jquery');
// WD css
wp_print_styles('dashicons');
wp_print_styles('wp-admin');
wp_print_styles('buttons');
wp_print_styles('wp-auth-check');

$controller = WDFInput::get_controller();
wde_register_ajax_scripts($controller);

// css
wp_print_styles('wde_layout_explore');
wp_print_styles('wde_' . $controller . '_' . $this->_layout);
// js
wp_print_scripts('wde_view');
wp_print_scripts('wde_layout_explore');
wp_print_scripts('wde_' . $controller . '_' . $this->_layout);

$filter_items = $this->filter_items;
$sort_data = $this->sort_data;
$sort_by = $sort_data['sort_by'];
$sort_order = $sort_data['sort_order'];
$pagination = $this->pagination;
$pager_number = 0;

$rows = $this->rows;
?>
<form class="wp-core-ui" name="adminForm" id="adminForm" action="" method="post">
  <table class="adminlist table table-striped">
    <tbody>
      <tr>
        <td class="btns_container">
          <?php echo WDFHTML::jfbutton(__('Select', 'wde'), '', '', 'onclick="onBtnSelectClick(event, this);"'); ?>
        </td>
      </tr>
    </tbody>
  </table>
  <?php echo $this->generate_message(); ?>
  <div class="tablenav top">
    <?php
    echo $this->generate_filters($filter_items);
    echo $this->generate_pager($pagination->_count, $pager_number++, WDFSession::get_pagination_start());
    ?>
  </div>
  <table class="adminlist table table-striped widefat fixed pages">
    <thead>
      <th class="col_num">#</th>
      <th class="col_checked manage-column column-cb check-column table_small_col"><input id="check_all" type="checkbox" style="margin:0;" /></th>
      <?php echo WDFHTML::wd_ordering('id', $sort_by, $sort_order, __('ID', 'wde')); ?>
      <?php echo WDFHTML::wd_ordering('title', $sort_by, $sort_order, __('Title', 'wde')); ?>
      <th class="col_category_title"><?php _e('Category', 'wde'); ?></th>
      <?php echo WDFHTML::wd_ordering('published', $sort_by, $sort_order, __('Published', 'wde')); ?>
    </thead>
    <tbody>
      <?php
      if ($rows) {
        for ($i = 0; $i < count($rows); $i++) {
          $row = $rows[$i];
          $alternate = (!isset($alternate) || $alternate == 'alternate') ? '' : 'alternate';
          ?>
      <tr class="row<?php echo $i % 2; ?> <?php echo $alternate; ?>"
          itemId="<?php echo $row->id; ?>"
          itemTitle="<?php echo esc_attr($row->title); ?>">
        <td class="col_num">
          <?php echo $pagination->_offset + $i; ?>
        </td>
        <td class="col_checked check-column">
          <input id="cb<?php echo $row->id; ?>" name="cid[]" value="<?php echo $row->id; ?>" type="checkbox" class="wde_check" />
        </td>
        <td class="col_id">
          <?php echo $row->id; ?>
        </td>
        <td class="col_title">
          <label for="cb<?php echo $row->id; ?>"><?php echo $row->title; ?></label>
        </td>
        <td class="col_category_title">
            <?php echo $row->category_title; ?>
        </td>
        <td class="col_published">
          <?php echo WDFHTML::icon_boolean_inactive($row->id, $row->published, 'publish', 'unpublish', TRUE); ?>
        </td>
      </tr>
          <?php
        }
      }
      else {
        echo WDFHTML::no_items(WDFToolbar::$item_name);
      }
      ?>
    </tbody>
  </table>
  <div class="tablenav top">
    <?php echo $this->generate_pager($pagination->_count, $pager_number++, WDFSession::get_pagination_start()); ?>
  </div>
  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>"/>
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>"/>
  <input type="hidden" name="task" value="explore"/>
  <input type="hidden" name="boxchecked" value=""/>
  <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>"/>
  <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>"/>
</form>
<script>
  var _selectedIds = ("<?php echo WDFInput::get('selected_ids'); ?>").split(",");
  var _callback = "<?php echo WDFInput::get('callback'); ?>";
</script>
<?php
die();