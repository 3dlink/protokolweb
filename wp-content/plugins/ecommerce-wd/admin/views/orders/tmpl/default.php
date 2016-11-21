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
$list_order_statuses = $lists['order_statuses'];

$pagination = $this->pagination;
$pager_number = 0;

$rows = $this->rows;
?>
<form name="adminForm" id="adminForm" method="post" action="">
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
        <?php echo WDFHTML::wd_ordering('id', $sort_by, $sort_order, __('Order', 'wde')); ?>
        <?php echo WDFHTML::wd_ordering('user_ip_address', $sort_by, $sort_order, __('User IP', 'wde')); ?>
        <th class="col_product_names"><?php _e('Products', 'wde'); ?></th>
        <th class="col_total_price"><?php _e('Total price', 'wde'); ?></th>
        <?php echo WDFHTML::wd_ordering('checkout_date', $sort_by, $sort_order, str_replace(' ', '<br />', __('Checkout date', 'wde'))); ?>
        <?php echo WDFHTML::wd_ordering('date_modified', $sort_by, $sort_order, str_replace(' ', '<br />', __('Date modified', 'wde'))); ?>
        <?php echo WDFHTML::wd_ordering('status_id', $sort_by, $sort_order, __('Order status', 'wde')); ?>
        <th class="col_payment_status"><?php _e('Payment status', 'wde'); ?></th>
        <?php echo WDFHTML::wd_ordering('read', $sort_by, $sort_order, __('Read', 'wde')); ?>
        <th class="col_actions"><?php _e('Actions', 'wde'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($rows) {
        for ($i = 0; $i < count($rows); $i++) {
          $row = $rows[$i];
          $alternate = (!isset($alternate) || $alternate == 'alternate') ? '' : 'alternate';
          ?>
      <tr id="tr_<?php echo $row->id; ?>" class="row<?php echo $row->read; ?> <?php echo $alternate; ?>">
        <td class="col_num">
          <?php echo $pagination->_offset + $i; ?>
        </td>
        <td class="col_checked check-column">
          <input id="cb<?php echo $row->id; ?>" name="cid[]" value="<?php echo $row->id; ?>" type="checkbox" class="wde_check" />
        </td>
        <td class="col_user_name">
          <a href="<?php echo $row->edit_url; ?>" title="<?php _e('Edit order', 'wde'); ?>" alt="<?php _e('Edit order', 'wde'); ?>">
            #<?php echo $row->id; ?>
          </a> <?php _e('by', 'wde'); ?> 
          <?php
          if ($row->user_id != 0) {
            echo WDFHTML::jfbutton_inline($row->user_name, WDFHTML::BUTTON_INLINE_TYPE_GOTO, '', '', 'href="' . $row->user_view_url . '" target="_blank"', WDFHTML::BUTTON_ICON_POS_RIGHT);
            if ($row->user_email) {
              ?>
            <a href="mailto:<?php echo $row->user_email; ?>"><?php echo $row->user_email; ?></a>
              <?php
            }
          }
          else {
            echo $row->user_name . '<br />' . $row->user_email;
          }
          ?>
        </td>
        <td class="col_user_ip_address">
          <?php echo $row->user_ip_address; ?>
        </td>
        <td class="col_product_names">
          <?php echo $row->product_names; ?>
        </td>
        <td class="col_total_price">
          <?php echo $row->total_price_text; ?>
        </td>
        <td class="col_checkout_date">
          <?php echo $row->checkout_date; ?>
        </td>
        <td class="col_date_modified">
          <?php echo $row->date_modified; ?>
        </td>
        <td class="col_order_status">
          <?php
          echo WDFHTML::wd_select('order_status_' . $row->id, $list_order_statuses, 'id', 'name', $row->status_id);
          echo WDFHTML::jfbutton(__('Save', 'wde'), '', '', 'onclick="onBtnUpdateOrderStatusClick(event, this, ' . $row->id . ');"', WDFHTML::BUTTON_COLOR_WHITE, WDFHTML::BUTTON_SIZE_SMALL);
          ?>
        </td>
        <td class="col_payment_status">
          <?php echo $row->payment_data_status; ?>
        </td>
        <td class="col_read">
          <?php echo WDFHTML::icon_boolean_inactive($row->id, $row->read, 'set_as_read', 'set_as_unread', FALSE); ?>
        </td>
        <td class="col_actions">
          <a class="thickbox wde_btn wde_btn_view_payment_data" href="javascript:void(0)" onclick="onBtnPaymentsDataClick(event, this);" data-payment-data-url="<?php echo $row->view_payment_data_url; ?>">
            <img src="<?php echo WD_E_URL; ?>/images/view_payment_data.png" title="<?php _e('View payment data', 'wde'); ?>" alt="<?php _e('View payment data', 'wde'); ?>" />
          </a>
          <a class="wde_btn wde_btn_view" href="<?php echo $row->view_url; ?>">
            <img src="<?php echo WD_E_URL; ?>/images/view_order.png" title="<?php _e('View order', 'wde'); ?>" alt="<?php _e('View order', 'wde'); ?>" />
          </a>
          <a class="wde_btn wde_btn_edit" href="<?php echo $row->edit_url; ?>">
            <img src="<?php echo WD_E_URL; ?>/images/edit.png" title="<?php _e('Edit order', 'wde'); ?>" alt="<?php _e('Edit order', 'wde'); ?>" />
          </a>
          <a class="wde_btn wde_btn_print" target="_blank" href="<?php echo $row->print_url; ?>">
            <img src="<?php echo WD_E_URL; ?>/images/print.png" title="<?php _e('Print', 'wde'); ?>" alt="<?php _e('Print', 'wde'); ?>" />
          </a>
          <a class="wde_btn wde_btn_invoice" onclick="onBtnSendInvoice(event, this)">
            <img src="<?php echo WD_E_URL; ?>/images/invoice.png" title="<?php _e('Send invoice to cusotmer', 'wde'); ?>" alt="<?php _e('Send invoice to cusotmer', 'wde'); ?>" />
          </a>
          <a class="wde_btn wde_btn_delete" onclick="wde_check_one('#cb<?php echo $row->id; ?>');submitform('remove');return false;" href="">
            <img src="<?php echo WD_E_URL; ?>/images/order_delete.png" title="<?php _e('Delete order', 'wde'); ?>" alt="<?php _e('Delete order', 'wde'); ?>" />
          </a>
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
  <input type="hidden" name="option" value="com_<?php echo WDFHelper::get_com_name(); ?>" />
  <input type="hidden" name="controller" value="<?php echo WDFInput::get_controller(); ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>" />
  <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>" />
  <input type="hidden" id="check_all_form" name="select_all_orders" value="0" />
</form>