<?php

defined('ABSPATH') || die('Access Denied');

$options = $this->options;
$rows = $this->row;

?>
<div class="container">
<?php
foreach ($rows as $row) {
  ?>
  <div class="wd_shop_panel_product panel panel-default">
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-4">
          <div class="wd_shop_manufacturer_image_container wd_center_wrapper img-thumbnail">
            <div>
              <?php
              if ($row->image != '') {
                ?>
                <a href="<?php echo $row->url; ?>" class="link">
                  <img class="wd_shop_manufacturer_image"
                       src="<?php echo $row->image; ?>"
                       alt="<?php echo $row->name; ?>"
                       title="<?php echo $row->name; ?>" />
                </a>
                <?php
              }
              else {
                ?>
                <div class="wd_shop_manufacturer_no_image">
                    <span class="glyphicon glyphicon-picture"></span><br />
                    <span><?php _e('No Image', 'wde'); ?></span>
                </div>
                <?php
              }
              ?>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="row">
            <div class="col-sm-12 text-left">
              <a href="<?php echo $row->url; ?>" class="wd_shop_manufacturer_name_all">
                <?php echo $row->name; ?>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 text-left">
              <div class="wd_shop_manufacturer_description_all text-justify">
                <?php echo $row->show_info ? $row->description : ''; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
</div>