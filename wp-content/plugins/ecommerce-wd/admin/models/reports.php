<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdModelReports extends EcommercewdModel {
	public function get_report_view_data() {
		$date_range = $this->get_date_range();	
		$row_report_data = $this->get_report_row($date_range->start_date, $date_range->end_date);
		
		$row_report_data->start_date = $date_range->start_date;
		$row_report_data->end_date = $date_range->end_date;
		$row_report_data->json_data = $this->get_reports_json_data();
		$row_report_data->currency = $this->get_currency($date_range->start_date, $date_range->end_date);
		
		return $row_report_data;
	}

	public function get_reports_data_array() {
		$date_range = $this->get_date_range();	
		$current_date = strtotime($date_range->start_date);
		$end_date = strtotime($date_range->end_date);
		$counter = 'day';
		$monthly = false;
		$date_format = "Y-m-d";
		
		if ($date_range->number_of_months > 12 || $date_range->tab_index == 'year') {
			$counter = 'month';
			$monthly = true;
			$date_format = "Y-m";
		}

		$row_end_date = $current_date;		
		if ($monthly == true) {
			$row_end_date = strtotime(date("Y-m-d", $current_date) . " +1 month");
		}

		$reports_data_array = array();
		while ($current_date <= $end_date) {
			$report_data = $this->get_report_row(date("Y-m-d", $current_date), date("Y-m-d", $row_end_date));
			$report_data->date = date($date_format,$current_date);
			$reports_data_array[] = $report_data;
			$current_date = strtotime(date("Y-m-d", $current_date) . " +1 " . $counter);
			$row_end_date = strtotime(date("Y-m-d", $row_end_date) . " +1 " . $counter);
		}
		return $reports_data_array;
	}

	public function get_date_range() {	
		$type = WDFInput::get('tab_index');
		switch($type){
			case "year":
				$start_date = date('Y-01-01');
				$end_date = date('Y-m-d');
			break;
			case "last_month":
				$start_date = date("Y-m-01",strtotime("-1 month"));
				$end_date = date("Y-m-t",strtotime("-1 month"));
			break;
			case "this_month":
				$start_date = date("Y-m-01");
				$end_date = date("Y-m-d");
			break;
			case "last_week":
				$start_date = date("Y-m-d",strtotime("-7 days"));
				$end_date = date("Y-m-d");
			break;
			case "custom":
				$start_date = WDFInput::get("start_date") ? WDFInput::get("start_date") : date('Y-m-d');
				$end_date = WDFInput::get("end_date") ? WDFInput::get("end_date") : date('Y-m-d');
			break;
			default:
				$start_date = date('Y-01-01');
				$end_date = date('Y-m-d');
			break;			
		}
		$number_of_days = strtotime($end_date) - strtotime($start_date);
		$number_of_days = ceil($number_of_days/(60*60*24));
		$number_of_months = ceil($number_of_days/30);
		
		$date_range = new Stdclass();
		$date_range->start_date = $start_date; 
		$date_range->end_date = $end_date; 
		$date_range->number_of_days = $number_of_days; 
		$date_range->number_of_months = $number_of_months; 
		$date_range->tab_index = $type == "" ? "year" : $type;
		
		return $date_range;
	}

	public function get_report_row($start_date, $end_date) {
    global $wpdb;
    $query = 'SELECT SUM(T_ORDER_PRODUCTS.total_price) AS total_seals';
    $query .= ', SUM(T_ORDER_PRODUCTS.total_shipping_price) + SUM(T_ORDERS.shipping_method_price) AS total_shipping_seals';
    $query .= ', COUNT(*) AS orders_count';
    $query .= ', SUM(T_ORDER_PRODUCTS.order_product_count) AS items_count';
    $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_orders AS T_ORDERS';
    $query .= ' LEFT JOIN ( SELECT order_id, SUM(product_price*product_count) AS total_price, SUM(shipping_method_price) AS total_shipping_price, SUM(product_count) AS order_product_count FROM ' . $wpdb->prefix . 'ecommercewd_orderproducts GROUP BY order_id) AS T_ORDER_PRODUCTS ON T_ORDER_PRODUCTS.order_id = T_ORDERS.id';
    $query .= ' WHERE DATE_FORMAT(T_ORDERS.checkout_date,"%Y-%m-%d") BETWEEN  "' . $start_date . '" AND "' . $end_date . '"';
    $results = $wpdb->get_results($query);
    $row = $results[0];
		$row->items_count = $row->items_count ? $row->items_count : 0;
		$type = WDFInput::get('tab_index');	
		$date_range = $this->get_date_range();

		$number_of_days = $date_range->number_of_days; 
		$number_of_months = $date_range->number_of_months; 
		switch($type){
			case "year":
				$row->average_sales = ($number_of_months != 0) ? round($row->total_seals / $number_of_months, 2) : $row->total_seals;
				$row->average_type = "monthly";
			break;
			case "last_month":
			case "last_week":	
			case "this_month":
				$row->average_sales = ($number_of_days != 0) ? round($row->total_seals / $number_of_days, 2) : $row->total_seals;
				$row->average_type = "daily";
			break;		
			case "custom":				
				if ($number_of_months > 12) {
					$row->average_sales = $row->total_seals/$number_of_months;
					$row->average_type = "monthly";
				}
				else {
					$row->average_sales = ($number_of_days != 0) ? round($row->total_seals / $number_of_days, 2) : $row->total_seals;
					$row->average_type = "daily";
			
				}		
			break;
			default:													
				$row->average_sales = ($number_of_months != 0) ? round($row->total_seals / $number_of_months, 2) : $row->total_seals;
				$row->average_type = "monthly";
			break;			
		}
		return $row;
	}

	public function get_currency($start_date, $end_date) {
    global $wpdb;
    $query = 'SELECT currency_id';
    $query .= ', COUNT(*)';
    $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_orders AS T_ORDERS';
    $query .= ' WHERE DATE_FORMAT(T_ORDERS.checkout_date,"%Y-%m-%d") BETWEEN  "' . $start_date . '" AND "' . $end_date . '"';
    $query .= ' GROUP BY currency_id';
    $currencies = $wpdb->get_results($query);
    $currency_code = (count($currencies) == 1) ?  WDFDb::get_row('currencies', '`id`' . ' = ' .$currencies[0]->currency_id) : WDFDb::get_row('currencies', '`default`' . ' = 1');
		return $currency_code;
	}

	private function get_reports_json_data() {
		$reports_data_array = $this->get_reports_data_array();
		$date_range = $this->get_date_range();
    $model_options = WDFHelper::get_model('options');
    $options = $model_options->get_options();
    $decimals = $options['initial_values']['option_show_decimals'] == 1 ? 2 : 0;

		$row = $this->get_report_row($date_range->start_date, $date_range->end_date);

		$reports_chart_data = array();

		$reports_chart_data['total_seals'] = array();
		$reports_chart_data['total_shipping_seals'] = array();
		$reports_chart_data['orders_count'] = array();
		$reports_chart_data['items_count'] = array();
		foreach ($reports_data_array as $key => $report_data) {
			$reports_chart_data['total_seals'][] = array(strtotime(date('Ymd', strtotime($report_data->date))) . '000', $report_data->total_seals ? $report_data->total_seals : 0);
			$reports_chart_data['total_shipping_seals'][] = array(strtotime(date('Ymd', strtotime($report_data->date))) . '000', $report_data->total_shipping_seals ? $report_data->total_shipping_seals : 0);
			$reports_chart_data['orders_count'][] = array(strtotime(date('Ymd', strtotime($report_data->date))) . '000',$report_data->orders_count ? (int)$report_data->orders_count : 0);
			$reports_chart_data['items_count'][] = array(strtotime(date('Ymd', strtotime($report_data->date))) . '000',$report_data->items_count ? (int) $report_data->items_count : 0);
		}

		$reports_chart_data['start_date'] = strtotime( date( 'Ymd', strtotime( $date_range->start_date ) ) ) . '000';
		$reports_chart_data['end_date'] = strtotime( date( 'Ymd', strtotime( $date_range->end_date ) ) ) . '000';
		$reports_chart_data['average_sales'] = (float)$row->average_sales;
		
		if ($row->average_type == "monthly") {		
			$reports_chart_data['barwidth'] = 60 * 60 * 24 * 7 * 4 * 1000;
		}
		else {			
			$reports_chart_data['barwidth'] = 60 * 60 * 24 * 1000;
		}

		$reports_chart_data_json = json_encode($reports_chart_data);
		return $reports_chart_data_json;
	}
}