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
if ($sort_by == 'ordering' && $sort_order == 'asc') {
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
      <?php echo WDFHTML::wd_ordering('ordering', $sort_by, $sort_order); ?>
      <th class="col_num">#</th>
      <th class="col_checked manage-column column-cb check-column"><input id="check_all" type="checkbox" style="margin:0;" /></th>
      <?php echo WDFHTML::wd_ordering('id', $sort_by, $sort_order, __('ID', 'wde')); ?>
      <?php echo WDFHTML::wd_ordering('name', $sort_by, $sort_order, __('Name', 'wde')); ?>
      <th class="col_image"></th>
      <?php echo WDFHTML::wd_ordering('published', $sort_by, $sort_order, __('Published', 'wde')); ?>
      <th class="col_edit"><?php _e('Edit', 'wde'); ?></th>
    </thead>
    <tbody>
      <?php
      if ($rows) {
        for ($i = 0; $i < count($rows); $i++) {
          $row = $rows[$i];
          $alternate = (!isset($alternate) || $alternate == 'alternate') ? '' : 'alternate';
          ?>
          <tr id="tr_<?php echo $row->id; ?>" class="row<?php echo $i % 2; ?> <?php echo $alternate; ?>" <?php echo ($row->short_name == 'paypalexpress') ? 'onclick="alert(\'' . addslashes(__("You can't edit this payment system in free version.", 'wde')) . '\')"' : ''; ?>>
            <td class="col_ordering">
              <?php
              if ($row->short_name == 'paypalexpress') {
                ?><span class="wde_pro_btn">Paid</span><?php
              }
              else {
                echo $this->generate_order_cell_content($i, $row->ordering, $class_name);
              } ?>
            </td>
            <td class="col_num">
              <?php echo $pagination->_offset + $i; ?>
            </td>
            <td class="col_checked check-column">
              <?php if ($row->short_name != 'paypalexpress') { ?>
              <input id="cb<?php echo $row->id; ?>" name="cid[]" value="<?php echo $row->id; ?>" type="checkbox" class="wde_check" />
              <?php } ?>
            </td>
            <td class="col_id"><?php echo $row->id; ?></td>
            <td class="col_name">
              <?php
              if ($row->short_name == 'paypalexpress') {
                echo $row->name;
              }
              else {
                ?><a href="<?php echo $row->edit_url; ?>" title="<?php _e('Edit', 'wde'); ?>"><?php echo $row->name; ?></a><?php
              } ?>
            </td>
            <td class="col_image">
              <?php if ($row->short_name != 'without_online_payment') { ?>
              <img src="<?php echo WD_E_URL . '/images/payments/' . $row->base_name . '.png' ;?>" width="75" />
              <?php } ?>	
            </td>
            <td class="col_published">
              <?php if ($row->short_name != 'paypalexpress') { ?>
              <?php echo WDFHTML::icon_boolean_inactive($row->id, $row->published, 'publish', 'unpublish', FALSE); ?>
              <?php } ?>
            </td>
            <td class="col_edit">
              <?php if ($row->short_name != 'paypalexpress') { ?>
              <a href="<?php echo $row->edit_url; ?>" title="<?php _e('Edit', 'wde'); ?>">
              <?php } ?>
                <?php _e('Edit', 'wde'); ?>
              <?php if ($row->short_name != 'paypalexpress') { ?>
              </a>
              <?php } ?>
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
  <input type="hidden" name="task" value=""/>
  <input type="hidden" name="boxchecked" value=""/>
  <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>"/>
  <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>"/>
</form>