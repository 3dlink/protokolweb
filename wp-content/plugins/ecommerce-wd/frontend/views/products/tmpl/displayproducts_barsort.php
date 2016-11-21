<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout . '_barsort');

$sortables_list = $this->sortables_list;
$sort_data = $this->sort_data;

$sort_order_icon_class = $sort_data['sort_order'] == 'asc' ? 'glyphicon-sort-by-attributes' : 'glyphicon-sort-by-attributes-alt';
$btn_sort_order = $sort_data['sort_order'] == 'asc' ? 'desc' : 'asc';

if (empty($sortables_list) == false) {
  ?>
  <div class="row">
    <div class="col-sm-12">
      <form name="wd_shop_form_sort" action="" method="POST">
        <div class="input-group input-group-sm">
          <!-- sort by -->
          <?php echo WDFHTML::wd_select('sort_by', $sortables_list, 'value', 'text', $sort_data['sort_by'], 'class="form-control" onchange="wdShop_formSort_onSortByChange(event, this);"'); ?>
          <!-- sort order -->
          <span class="input-group-btn">
            <a class="btn btn-default"
               onclick="wdShop_formSort_onBtnSortOrderClick(event, this, '<?php echo $btn_sort_order; ?>'); return false;">
                &nbsp;<span class="glyphicon <?php echo $sort_order_icon_class; ?>"></span>&nbsp;
            </a>
          </span>
        </div>
      </form>
    </div>
  </div>
  <?php
}