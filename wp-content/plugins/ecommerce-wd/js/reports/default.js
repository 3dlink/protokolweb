

////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
var main_chart;
var charts = ['total_seals','total_shipping_seals','orders_count','items_count','average_sales'];
function wd_Shop_drawReportChart() {
	function showTooltip(x, y, contents) {
		jQuery('<div id="report-tooltip">' + contents + '</div>').css({
			position: 'absolute',
			display: 'none',
			top: y - 35,
			left: x + 10,
			padding: '5px',
			'background-color': '#000',
			'color':'#fff',
			'border-radius':'4px',
			'font-size':'9px',
			'opacity':'0.7'
		}).appendTo("body").fadeIn(200);
  }

	var previousPoint = null;
  jQuery("#placeholder").bind("plothover", function (event, pos, item) {
    if (item) {
      if (previousPoint != item.dataIndex) {
        previousPoint = item.dataIndex;

        jQuery("#report-tooltip").remove();
        var x = item.datapoint[0].toFixed(wdShop_decimals),
            y = item.datapoint[1].toFixed(wdShop_decimals);

        showTooltip(item.pageX, item.pageY, y + ' ' + default_currency_code);
      }
    }
    else {
      jQuery("#report-tooltip").remove();
      previousPoint = null;
    }
  });

	var drawGraph = function( highlight ) {
		var items_count = {
								data: report_data.items_count,
								color: '#DFE6EB',
								bars: { fillColor: '#DFE6EB', fill: true, show: true, lineWidth: 0, barWidth: report_data.barwidth * 0.5, align: 'center' },
								shadowSize: 0,
								hoverable: false
							};
							
		var orders_count = {
								data: report_data.orders_count,
								color: '#CBD8E0',
								bars: { fillColor: '#CBD8E0', fill: true, show: true, lineWidth: 0, barWidth: report_data.barwidth * 0.5, align: 'center' },
								shadowSize: 0,
								hoverable: false
							};
							
		var average_sales = {
								data: [ [report_data.start_date, report_data.average_sales  ], [ report_data.end_date, report_data.average_sales ] ],
								yaxis: 2,
								color: '#4497CF',
								points: { show: false },
								lines: { show: true, lineWidth: 2, fill: false },
								shadowSize: 0,
								hoverable: false
							};
								
		var	total_shipping_seals = {
										data: report_data.total_shipping_seals,
										yaxis: 2,
										color: '#1abc9c',
										points: { show: true, radius: 5, lineWidth: 3, fillColor: '#fff', fill: true },
										lines: { show: true, lineWidth: 4, fill: false },
										shadowSize: 0
									};	

		var total_seals = {
								data: report_data.total_seals,
								yaxis: 2,
								color: '#0e639d',
								points: { show: true, radius: 5, lineWidth: 3, fillColor: '#fff', fill: true },
								lines: { show: true, lineWidth: 4, fill: false },
								shadowSize: 0
						    };
		var	series = [];

		if (charts.length == 0) {
			series = [items_count,orders_count,average_sales,total_shipping_seals,total_seals];
		}
		else {
			if (charts.indexOf('items_count') > -1) {
				series.push(items_count);
			}
			if (charts.indexOf('orders_count') > -1) {
				series.push(orders_count);
			}
			if (charts.indexOf('average_sales') > -1) {
				series.push(average_sales);
			}
			if (charts.indexOf('total_shipping_seals') > -1) {
				series.push(total_shipping_seals);
			}
			if (charts.indexOf('total_seals') > -1) {
        series.push(total_seals);
			}		
		}

		if (charts.indexOf('items_count') == -1 && charts.indexOf('orders_count') == -1 && charts.length > 0) {
			var ycolor = '#d4d9dc';
		}
		else {
			var ycolor = 'transparent';
		}
		main_chart = jQuery.plot(
			jQuery('.chart-placeholder.main'),
			series,
			{
				legend: {
					show: false
				},
				grid: {
					color: '#aaa',
					borderColor: 'transparent',
					borderWidth: 0,
					hoverable: true
				},
				xaxes: [ {
					color: '#aaa',
					position: "bottom",
					tickColor: 'transparent',
					mode: "time",
					timeformat: "%d %b",
					monthNames: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
					tickLength: 1,
					minTickSize: [1, "day"],
					font: {
						color: "#aaa"
					}
				} ],
				yaxes: [
					{
						min: 0,
						minTickSize: 1,
						tickDecimals: 0,
						color: '#d4d9dc',
						font: { color: "#aaa" }
					},
					{
						position: "right",
						min: 0,
						tickDecimals: 2,
						alignTicksWithAxis: 1,
						color: ycolor,
						font: { color: "#aaa" }
					}
				],
			}
		);

		jQuery('.chart-placeholder').resize();
	}
	drawGraph();
}

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onTabActivated(currentTabIndex) {
  adminFormSet("tab_index", currentTabIndex);
  adminFormSet("task", "");
	adminFormSubmit();
}

function wd_ShopGetCharts() {
	charts = [];
	jQuery('.wd-chart:checked').each(function() {
		charts.push(jQuery(this).val());
	});
	wd_Shop_drawReportChart();
}