<?php

defined('ABSPATH') || die('Access Denied');

$search_data = $this->search_data;
$pagination = $this->pagination;

?>
<form name="wd_shop_main_form" action="#" method="POST">
  <input type="hidden" name="search_name" value="<?php echo $search_data['name']; ?>" />
  <input type="hidden" name="pagination_limit_start" value="<?php echo $pagination->limitstart; ?>" />
  <input type="hidden" name="pagination_limit" value="<?php echo $pagination->limit; ?>" />
</form>