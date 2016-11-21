jQuery(function() {
	jQuery( ".adminlist tbody" ).sortable({
		axis: 'y',
		opacity: 0.8,
		handle: ".col_ordering",
		update: function( event, ui ) {
      cids = [];
      jQuery.each( jQuery('[name="cid[]"]'), function( key, value ) {
        cids.push(jQuery(this).val());
      });
      jQuery.each( jQuery('td.col_num'), function( key, value ) {
        jQuery(this).html(key + 1);
      });
      jQuery.ajax({
        type: 'POST',
        url: _ordering_ajax_url,
        data: { "cid": JSON.stringify(cids), "wde_nonce": jQuery("input[name=wde_nonce]").val() },
        complete: function () {}
      });
		}
	});
});