<?php

defined('ABSPATH') || die('Access Denied');

wp_enqueue_script('wde_' . $this->_layout . '_bararrangement');

$arrangement_data = $this->arrangement_data;

$btnThumbsClassActive = $arrangement_data['arrangement'] == 'thumbs' ? 'active' : '';
$btnThumbsChecked = $arrangement_data['arrangement'] == 'thumbs' ? 'checked="checked"' : '';

$btnListClassActive = $arrangement_data['arrangement'] == 'list' ? 'active' : '';
$btnListChecked = $arrangement_data['arrangement'] == 'list' ? 'checked="checked"' : '';
?>
<div class="row">
  <div class="col-sm-12">
    <form name="wd_shop_form_arrangement" action="" method="POST">
      <div class="btn-group btn-group-sm" data-toggle="buttons">
        <!-- btn thumbs -->
        <label class="btn btn-default <?php echo $btnThumbsClassActive; ?>">
          <input type="radio" name="arrangement" value="thumbs" <?php echo $btnThumbsChecked; ?>
                 onchange="wdShop_formArrangement_onArrangementChange(event, this);">
          &nbsp;<span class="glyphicon glyphicon-th"></span>&nbsp;
        </label>
        <!-- btn list -->
        <label class="btn btn-default <?php echo $btnListClassActive; ?>">
          <input type="radio" name="arrangement" value="list" <?php echo $btnListChecked; ?>
                 onchange="wdShop_formArrangement_onArrangementChange(event, this);">
          &nbsp;<span class="glyphicon glyphicon-align-justify"></span>&nbsp;
        </label>
      </div>
    </form>
  </div>
</div>