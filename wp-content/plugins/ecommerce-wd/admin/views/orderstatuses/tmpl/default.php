<?php

defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);

// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);

$filter_items = $this->filter_items;
$sort_data = $this->sort_data;
$sort_by = $sort_data['sort_by'];
$sort_order = $sort_data['sort_order'];
$pagination = $this->pagination;
$pager_number = 0;

$rows = $this->rows;

$class_name = 'icon-disable-drag';
if( $sort_by == 'ordering' && $sort_order == 'asc' ){
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('wde_jquery-ordering');
	$class_name = 'icon-drag';
}

$enable_ordering = $sort_by == 'ordering' ? true : false;
?>
<form name="adminForm" id="adminForm" action="" method="post">
  <?php echo $this->generate_message(); ?>
  <div class="tablenav top">
    <?php
    echo $this->generate_filters($filter_items);
    echo $this->generate_pager($pagination->_count, $pager_number++, WDFSession::get_pagination_start());
    ?>
  </div>
  <table class="adminlist table table-striped wp-list-table widefat fixed pages">
    <thead>
      <tr>
        <?php echo WDFHTML::wd_ordering('ordering', $sort_by, $sort_order); ?>
        <th class="col_num">#</th>
        <th class="col_checked manage-column column-cb check-column"><input id="check_all" type="checkbox" style="margin:0;" /></th>
        <?php echo WDFHTML::wd_ordering('id', $sort_by, $sort_order, __('ID', 'wde')); ?>
        <?php echo WDFHTML::wd_ordering('name', $sort_by, $sort_order, __('Name', 'wde')); ?>
        <?php echo WDFHTML::wd_ordering('default', $sort_by, $sort_order, __('Default', 'wde')); ?>
        <?php echo WDFHTML::wd_ordering('published', $sort_by, $sort_order, __('Published', 'wde')); ?>
        <th class="col_edit"><?php _e('Edit', 'wde'); ?></th>
        <th class="col_delete"><?php _e('Delete', 'wde'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($rows) {
        for ($i = 0; $i < count($rows); $i++) {
          $row = $rows[$i];
          $alternate = (!isset($alternate) || $alternate == 'alternate') ? '' : 'alternate';
          ?>
      <tr id="tr_<?php echo $row->id; ?>" class="row<?php echo $i % 2; ?> <?php echo $alternate; ?>">
        <td class="col_ordering">
          <?php echo $this->generate_order_cell_content($i, $row->ordering, $class_name); ?>
        </td>
        <td class="col_num">
          <?php echo $pagination->_offset + $i; ?>
        </td>
        <td class="col_checked check-column">
          <input id="cb<?php echo $row->id; ?>" name="cid[]" value="<?php echo $row->id; ?>" type="checkbox" class="wde_check" />
        </td>
        <td class="col_id">
          <?php echo $row->id; ?>
        </td>
        <td class="col_name">
          <a href="<?php echo $row->edit_url; ?>"><?php echo $row->name; ?></a>
        </td>
        <td class="col_default">
          <?php echo WDFHTML::icon_boolean_inactive($row->id, $row->default, 'make_default', '', $row->default, 'default', 'notdefault'); ?>
        </td>
        <td class="col_published">
          <?php echo WDFHTML::icon_boolean_inactive($row->id, $row->published, 'publish', 'unpublish', FALSE); ?>
        </td>
        <td class="col_edit"><a href="<?php echo $row->edit_url; ?>" title="<?php _e('Edit ', 'wde'); ?>"><?php _e('Edit ', 'wde'); ?></a></td>
        <td class="col_delete"><a onclick="wde_check_one('#cb<?php echo $row->id; ?>');submitform('remove');return false;" href=""><?php _e('Delete', 'wde'); ?></a></td>
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
  <input type="hidden" name="task" value=""/>
  <input type="hidden" name="boxchecked" value="0"/>
  <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>"/>
  <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>"/>
</form>