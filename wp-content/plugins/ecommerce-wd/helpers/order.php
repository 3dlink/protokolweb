<?php
 
defined('ABSPATH') || die('Access Denied');

class EcommercewdOrder {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

	public static function print_order($row){
		echo self::get_order_html($row);
	}

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
	private static function get_order_html($row) {
    // To not change query argument.
    if (strpos($row->payment_method, 'paypal') === 0) {
      $row->payment_method = str_replace('paypal', 'paypal_', $row->payment_method);
    }
		ob_start();
		echo '<style>
        #wd_shop_container,
        .store table,
        h1,
        .address p {
          margin: 0px !important;
        }
				table tr td {
					font-size: 16px;
				}
				h1 {
					text-align: right;
					text-transform: uppercase;
					color: #CCCCCC;
					font-size: 24px;
					font-weight: normal;
					padding-bottom: 5px;
					border-bottom: 1px solid #CDDDDD;
				}
				.store {
					width: 100%;
					margin-bottom: 20px;
					border: 1px solid #fff;
				}
				.store tr td {
					border: 1px solid #fff;
				}
        .address td {
          width: 50%;
          vertical-align: top;
        }
				.address,
        .product {
					width: 100%;
					margin-bottom: 20px;
					border-top: 1px solid #CDDDDD;
					border-right: 1px solid #CDDDDD;
					border-collapse: collapse;
				}
				.address td,
        .product td {
					border-left: 1px solid #CDDDDD;
					border-bottom: 1px solid #CDDDDD;
					padding: 5px;
					height: 32px;
					
				}
        .product_name {
          width: 40%;
        }
        .product_count,
        .product_price,
        .product_discount,
        .product_tax,
        .product_shipping,
        .product_subtotal {
          width: ' . ($row->shipping_type == 'per_order' ? 12 : 10) . '%;
        }
        .heading {
          vertical-align: middle;
        }
				.heading td {
					background: #E7EFEF;
				}
        .text-right {
          text-align: right;
        }
			</style>
      <div>
				<h1>' . __('Invoice', 'wde') . '</h1>
				<table class="store">
					<tr>
						<td></td>
						<td align="right">
							<table>
								<tr>
									<td><b>' . __('Date addeed', 'wde') . '</b></td>
									<td>' . date("Y-m-d", strtotime($row->checkout_date)) . '</td>
								</tr>
								<tr>
									<td><b>' . __('Order id', 'wde') . '</b></td>
									<td>' . $row->id . '</td>
                </tr>
								<tr>
									<td><b>'.__('Invoice number', 'wde').'</b></td>
									<td>' . date('Ymd') . $row->id . '</td>
								</tr>
								<tr>
									<td><b>' . __('Payment method', 'wde') . '</b></td>
									<td>' . ucwords(str_replace('_', ' ', $row->payment_method)) . '</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table class="address">
					<tr class="heading">
						<td>' . __('To', 'wde') . '</td>
						<td>' . __('Ship to', 'wde') . '</td>
					</tr>	
					<tr>
						<td>
              ' . (($row->billing_data_first_name || $row->billing_data_middle_name || $row->billing_data_last_name) ? '<p>' . esc_html($row->billing_data_first_name) . ' ' . esc_html($row->billing_data_middle_name) . ' ' . esc_html($row->billing_data_last_name) . '</p>' : '') . '
              ' . ($row->billing_data_email ? '<p>' . esc_html($row->billing_data_email) . '</p>' : '') . '
							' . ($row->billing_data_address ? '<p>' . esc_html($row->billing_data_address) . '</p>' : '') . '
							' . ($row->billing_data_city ? '<p>' . esc_html($row->billing_data_city) . '</p>' : '') . '
							' . ($row->billing_data_state ? '<p>' . esc_html($row->billing_data_state) . '</p>' : '') . '
							' . ($row->billing_data_zip_code ? '<p>' . esc_html($row->billing_data_zip_code) . '</p>' : '') . '
							' . (($row->billing_data_city || $row->billing_data_state || $row->billing_data_zip_code) ? '<p>' . esc_html($row->billing_data_city) . ' ' . esc_html($row->billing_data_state) . ' ' . esc_html($row->billing_data_zip_code) . '</p>' : '') . '
							' . ($row->billing_data_country ? '<p>' . esc_html($row->billing_data_country) . '</p>' : '') . '
							' . ($row->billing_data_phone ? '<p>' . esc_html($row->billing_data_phone) . '</p>' : '') . '
							' . ($row->billing_data_fax ? '<p>' . esc_html($row->billing_data_fax) . '</p>' : '') . '
						</td>
						<td>
							' . (($row->shipping_data_first_name || $row->shipping_data_middle_name || $row->shipping_data_last_name) ? '<p>' . esc_html($row->shipping_data_first_name) . ' ' . esc_html($row->shipping_data_middle_name) . ' ' . esc_html($row->shipping_data_last_name) . '</p>' : '') . '
              ' . ($row->shipping_data_address ? '<p>' . esc_html($row->shipping_data_address) . '</p>' : '') . '
              ' . (($row->shipping_data_city || $row->shipping_data_state || $row->shipping_data_zip_code) ? '<p>' . esc_html($row->shipping_data_city) . ' ' . esc_html($row->shipping_data_state) . ' ' . esc_html($row->shipping_data_zip_code) . '</p>' : '') . '
              ' . ($row->shipping_data_country ? '<p>' . esc_html($row->shipping_data_country) . '</p>' : '') . '
						</td>
					</tr>
				</table>
				<table class="product">
					<tr class="heading">
						<td>' . __('Product', 'wde') . '</td>
						<td>' . __('Quantity', 'wde') . '</td>
						<td>' . __('Price', 'wde') . '</td>
						<td>' . __('Discount', 'wde') . '</td>
						<td>' . __('Tax', 'wde') . '</td>' . 
						($row->shipping_type == 'per_order' ? '' : '<td>' . __('Shipping', 'wde') . '</td>') . 
						'<td>' . __('Sub-Total', 'wde') . '</td>
					</tr>';
        if (isset($row->product_rows)) {
          foreach ($row->product_rows as $product) {
            echo '<tr>
                <td class="product_name">' . $product->product_name . '</td>
                <td class="product_count text-right">' . $product->product_count . '</td>
                <td class="product_price text-right">' . $product->price_text . '</td>
                <td class="product_discount text-right">' . $product->discount_rate . '</td>
                <td class="product_tax text-right">' . $product->tax_price_text . '</td>' . 
                ($row->shipping_type == 'per_order' ? '' : '<td class="product_shipping text-right">' . $product->shipping_method_price_text . '</td>') . 
                '<td class="product_subtotal text-right">' . $product->subtotal_text . '</td>
              </tr>';
          }
        }
        if ($row->shipping_type == 'per_order' && $row->shipping_method_price > 0) {
          echo '<tr>
                <td colspan="' . ($row->shipping_type == 'per_order' ? '5' : '6') . '" class="text-right">' . __('Shipping', 'wde') . ':</td>
                <td class="text-right">' . $row->total_shipping_price_text . '</td>
              </tr>';
        }
				if ($row->total_price_text) {
          echo '<tr>
						<td colspan="' . ($row->shipping_type == 'per_order' ? '5' : '6') . '" class="text-right">' . __('Total', 'wde') . ':</td>
						<td class="text-right">' . $row->total_price_text . '</td>
					</tr>';
        }
        echo '</table>
			</div>';
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////	
}