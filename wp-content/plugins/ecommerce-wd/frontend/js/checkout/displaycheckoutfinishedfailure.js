function onWDShop_pagerBtnClick(event, obj) {
  wdShop_mainForm_setAction(jQuery(obj).attr("href"));
  wdShop_mainForm_submit();
}