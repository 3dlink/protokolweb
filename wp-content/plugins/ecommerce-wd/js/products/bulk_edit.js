jQuery(document).ready(function () {
  jQuery("[class^='tax_input_wde_'").each(function () {
    if (!jQuery(this).hasClass("tax_input_wde_tag")) {
      jQuery(this).parent().remove();
    }
  });
  jQuery('#bulk_edit').on('click', function() {
		var bulk_row = jQuery('#bulk-edit');
		var post_ids = new Array();
		bulk_row.find('#bulk-titles').children().each( function() {
			post_ids.push(jQuery(this).attr('id').replace(/^(ttle)/i, ''));
		});
		var wde_discounts = bulk_row.find('[name="wde_discounts"]').val();
		var wde_taxes = bulk_row.find('[name="wde_taxes"]').val();
		var wde_shippingmethods = bulk_row.find('[name="wde_shippingmethods"]:checked').map(function () {return this.value;}).get().join(",");
		var wde_shippingmethods_remove = bulk_row.find('[name="wde_shippingmethods_remove"]:checked').val();

		var nonce_wde = bulk_row.find('[name="nonce_wde"]').val();

		jQuery.ajax({
			url: ajaxurl, // Defined by WordPress.
			type: 'POST',
			async: false,
			cache: false,
			data: {
				action: 'save_bulk_edit_wde_products', // The name of WP AJAX function.
				post_ids: post_ids,
				wde_discounts: wde_discounts,
				wde_taxes: wde_taxes,
				wde_shippingmethods: wde_shippingmethods,
				wde_shippingmethods_remove: wde_shippingmethods_remove,
        nonce_wde: nonce_wde,
			}
		});
	});
});