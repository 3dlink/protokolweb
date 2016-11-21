<?php

class MWDViewFormswindow {
	////////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                             //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constants                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Variables                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	private $model;


	////////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor                                                           //
	////////////////////////////////////////////////////////////////////////////////////////
	public function __construct($model) {
		$this->model = $model;
	}
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	public function display() {
		$rows = $this->model->get_form_data();
		?>
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>MailChimp WD</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
			<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
			<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
			<?php wp_print_scripts('jquery'); ?>
			<base target="_self">
		</head>
		<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" dir="ltr" class="forceColors">
			<div class="tabs" role="tablist" tabindex="-1">
				<ul>
					<li id="display_tab" class="current" role="tab" tabindex="0">
						<span>
							<a href="javascript:mcTabs.displayTab('display_tab','display_panel');" onMouseDown="return false;" tabindex="-1">Forms</a>
						</span>
					</li>
				</ul>
			</div>
			<style>
			.tabs a {
				padding: 2px;
				font-size: 12px;
				display: inline-block;
			}
			
			.panel_wrapper {
				height: 220px !important;
			}
			
			.panel_wrapper select {
			    width: 230px;
				text-align: left;
				padding: 4px;
				font-size: 13px;
			}
			.smaller_font {
				font-size: 12px !important;
				vertical-align: middle; 
				text-align: left;
			}
			.smaller_font ul li {
				display: flex !important;
			}
			.smaller_font ul {
				margin: 0 !important;
			}
			.no-form{
				padding: 10px;
				font-size: 15px;
				color: red;
			}
			</style>
			<div class="panel_wrapper">
				<div id="display_panel" class="panel current">
					<?php if($rows){ ?>
					<table>
						<tr>
							<td style="vertical-align: middle; text-align: left;">Select a Form</td>
							<td style="vertical-align: middle; text-align: left;">
								<select name="mailchimp_form_id" id="mailchimp_form_id">
									<option value="- Select Form -" selected="selected">- Select a Form -</option>
									<?php foreach ($rows as $row) { ?>
										<option value="<?php echo $row->id; ?>"><?php echo $row->title.' (ID '.$row->id.')'; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
					</table>
					<?php } else { ?>
						<div class="no-form">You have not yet created 'embedded' type form.</div>
					<?php } ?>
				</div>
			</div>
			<?php if($rows){ ?>
			<div class="mceActionPanel">
				<div style="float: right;">
					<input type="submit" id="insert" name="insert" value="Insert" onClick="mwd_insert_shortcode();"/>
				</div>
			</div>
			<?php } ?>
			<script type="text/javascript">
			var short_code = get_params("mwd-mailchimp");
			if (short_code) {
				document.getElementById("mailchimp_form_id").value = short_code['id'];
			}
        
			function get_params(module_name) {
				var selected_text = tinyMCE.activeEditor.selection.getContent();
				var module_start_index = selected_text.indexOf("[" + module_name);
				var module_end_index = selected_text.indexOf("]", module_start_index);
				var module_str = "";
				if ((module_start_index == 0) && (module_end_index > 0)) {
					module_str = selected_text.substring(module_start_index + 1, module_end_index);
				}
				else {
					return false;
				}
				var params_str = module_str.substring(module_str.indexOf(" ") + 1);
				var key_values = params_str.split(" ");
				var short_code_attr = new Array();
				for (var key in key_values) {
					var short_code_index = key_values[key].split('=')[0];
					var short_code_value = key_values[key].split('=')[1];
					short_code_value = short_code_value.substring(1, short_code_value.length - 1);
					short_code_attr[short_code_index] = short_code_value;
				}
				return short_code_attr;
			}
			function mwd_insert_shortcode() {
				if (document.getElementById('mailchimp_form_id').value == '- Select Form -') {
					tinyMCEPopup.close();
				}
				else {
					var tagtext;
					tagtext = '[mwd-mailchimp id="' + document.getElementById('mailchimp_form_id').value + '"]';
					window.tinyMCE.execCommand('mceInsertContent', false, tagtext);
					tinyMCEPopup.close();
				}
			}
			</script>
		</body>
		</html>
		<?php
		die();
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
}