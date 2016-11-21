<?php
 
defined('ABSPATH') || die('Access Denied');

// css
wp_enqueue_style('wde_layout_' . $this->_layout);
wp_enqueue_style('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

// js
wp_enqueue_script('wde_view');
wp_enqueue_script('wde_layout_' . $this->_layout);
wp_enqueue_script('wde_' . WDFInput::get_controller() . '_' . $this->_layout);

$filter_items = $this->filter_items;
$sort_data = $this->sort_data;
$sort_by = $sort_data['sort_by'];
$sort_order = $sort_data['sort_order'];
$lists = $this->lists;
$list_ratings = $lists['ratings'];
$pagination = $this->pagination;
$pager_number = 0;

$rows = $this->rows;
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
        <th class="col_num">#</th>
        <th class="col_checked manage-column column-cb check-column"><input id="check_all" type="checkbox" style="margin:0;" /></th>
        <?php echo WDFHTML::wd_ordering('id', $sort_by, $sort_order, __('ID', 'wde')); ?>
        <?php echo WDFHTML::wd_ordering('user_name', $sort_by, $sort_order, __('User', 'wde')); ?>
        <?php echo WDFHTML::wd_ordering('user_ip_address', $sort_by, $sort_order, __('User IP', 'wde')); ?>
        <th><?php _e('Product', 'wde'); ?></th>
        <?php echo WDFHTML::wd_ordering('rating', $sort_by, $sort_order, __('Rating', 'wde')); ?>
        <?php echo WDFHTML::wd_ordering('date', $sort_by, $sort_order, __('Rating Date', 'wde')); ?>
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
        <td class="col_num">
          <?php echo $pagination->_offset + $i; ?>
        </td>
        <td class="col_checked check-column">
          <input id="cb<?php echo $row->id; ?>" name="cid[]" value="<?php echo $row->id; ?>" type="checkbox" class="wde_check" />
        </td>
        <td class="col_id">
          <?php echo $row->id; ?>
        </td>
        <td class="col_user_name">
          <?php
          if ($row->user_id != 0) {
              echo WDFHTML::jfbutton_inline($row->user_name, WDFHTML::BUTTON_INLINE_TYPE_GOTO, '', '', 'href="' . $row->user_view_url . '" target="_blank"', WDFHTML::BUTTON_ICON_POS_RIGHT);
          } else {
              echo $row->user_name;
          }
          ?>
        </td>
        <td class="col_user_ip_address">
          <?php echo $row->user_ip_address; ?>
        </td>
        <td class="col_product_name">
          <?php echo $row->product_name; ?>
        </td>
        <td class="col_rating">
          <?php
          echo WDFHTML::wd_select('rating_' . $row->id, $list_ratings, 'value', 'text', $row->rating);
          echo WDFHTML::jfbutton(__('Save', 'wde'), '', '', 'onclick="onBtnUpdateRatingClick(event, this, ' . $row->id . ');"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL);
          ?>
        </td>
        <td class="col_date">
          <?php echo $row->date; ?>
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