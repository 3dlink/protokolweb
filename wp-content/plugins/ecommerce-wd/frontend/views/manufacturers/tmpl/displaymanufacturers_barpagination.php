<?php

defined('ABSPATH') || die('Access Denied');

$pagination = $this->pagination;

if ($pagination->total > 1) {
?>
<div class="wd_shop_bar_pagination row">
  <div class="col-sm-12">
    <form name="wd_shop_form_pagination" class="form-horizontal" action="" method="POST">
      <div class="row">
        <!-- pages -->
        <div class="col-md-8 text-center">
            <ul class="wd_shop_pagination pagination pagination-sm">
              <?php
              $page_class = $pagination->current == $pagination->start ? 'disabled' : '';
              $page_on_click = $pagination->current == $pagination->start ? '' : 'wdShop_formPagination_onPageClick(event, this, ' . $pagination->limit * ($pagination->current - 2) . ');';
              ?>
              <li class="<?php echo $page_class; ?>">
                <a href="#" onclick="<?php echo $page_on_click; ?> return false;">&laquo;</a>
              </li>
              <?php
              for ($i = $pagination->start; $i <= $pagination->stop; $i++) {
                $page_class = $i == $pagination->current ? 'active' : '';
                $page_on_click = 'wdShop_formPagination_onPageClick(event, this, ' . $pagination->limit * ($i - 1) . ');';
                ?>
              <li class="<?php echo $page_class; ?>">
                <a href="#" onclick="<?php echo $page_on_click; ?> return false;">
                  <?php echo $i; ?>
                </a>
              </li>
                <?php
              }
              $page_class = $pagination->current == $pagination->stop ? 'disabled' : '';
              $page_on_click = $pagination->current == $pagination->stop ? '' : 'wdShop_formPagination_onPageClick(event, this, ' . $pagination->limit * ($pagination->current) . ');';
              ?>
              <li class="<?php echo $page_class; ?>">
                <a href="#" onclick="<?php echo $page_on_click; ?> return false;">&raquo;</a>
              </li>
            </ul>
          <input type="hidden" name="page_number" />
        </div>
        <!-- items per page -->
        <div class="col-md-4 text-center">
          <?php
          $limit_12_selected = $pagination->limit == 12 ? 'selected="selected"' : '';
          $limit_24_selected = $pagination->limit == 24 ? 'selected="selected"' : '';
          $limit_36_selected = $pagination->limit == 36 ? 'selected="selected"' : '';
          _e('Items per page', 'wde') . ':';
          ?>
          <select name="items_per_page" class="form-control input-sm"
                  onchange="wdShop_formPagination_onItemsPerPageChange(event, this);">
              <option value="12" <?php echo $limit_12_selected; ?>>12</option>
              <option value="24" <?php echo $limit_24_selected; ?>>24</option>
              <option value="36" <?php echo $limit_36_selected; ?>>36</option>
          </select>
        </div>
      </div>
    </form>
  </div>
</div>
<?php
}
?>