<?php
class MWDViewGoptions_mwd {
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
		$mwd_settings = get_option('mwd_settings');
		$public_key = isset($mwd_settings['public_key']) ? $mwd_settings['public_key'] : '';
		$private_key = isset($mwd_settings['private_key']) ? $mwd_settings['private_key'] : '';
		?>
		<div class="mwd-user-manual">
			This section allows you to edit global options.
			<a style="color: blue; text-decoration: none;" target="_blank" href="https://web-dorado.com/wordpress-mailchimpwd-guid/custom-fields.html">Read More in User Manual</a>
		</div>
		<div class="mwd-upgrade-pro">
			<a target="_blank" href="https://web-dorado.com/products/wordpress-mailchimp-wd.html">
				<div class="mwd-upgrade-img">
					UPGRADE TO PRO VERSION
					<span></span>
				</div>
			</a>
		</div>
		<div class="mwd-clear"></div>
		<form class="wrap" method="post" action="admin.php?page=goptions_mwd" style="width:99%;">
			<?php wp_nonce_field('nonce_mwd', 'nonce_mwd'); ?>
			<div class="mwd-page-header">
				<div class="mwd-page-title">
					MailChimp Global Options
				</div>
				<div class="mwd-page-actions">
					<button class="mwd-button save-button small" onclick="if (mwd_check_required('title', 'Title')) {return false;}; mwd_set_input_value('task', 'save');">
						<span></span>
						Save
					</button>
				</div>
			</div>
			<table style="border-spacing: 3px; border-collapse: separate; clear:both;">
				<tbody>
					<tr>
						<td>
							<label for="public_key">Recaptcha Public Key </label>
						</td>
						<td>
							<input type="text" id="public_key" name="public_key" value="<?php echo $public_key; ?>" style="width:250px;" />
						</td>
						<td rowspan="2">
							<a href="https://www.google.com/recaptcha/admin#list" target="_blank">Get ReCaptcha</a>
						</td>
					</tr>
					<tr>
						<td>
							<label for="private_key">Recaptcha Private Key </label>
						</td>
						<td>
							<input type="text" id="private_key" name="private_key" value="<?php echo $private_key; ?>" style="width:250px;" />
						</td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" id="task" name="task" value=""/>
		</form>
		<?php
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
