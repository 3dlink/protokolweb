<?php
class MWDControllerUninstall {
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
	public function __construct() {
	}
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	public function execute() {
		$task = ((isset($_POST['task'])) ? esc_html(stripslashes($_POST['task'])) : '');
		if (method_exists($this, $task)) {
			check_admin_referer('nonce_mwd', 'nonce_mwd');
			$this->$task();
		}
		else {
			$this->display();
		}
	}

	public function display() {
		require_once MWD_DIR . "/admin/models/MWDModelUninstall.php";
		$model = new MWDModelUninstall();

		require_once MWD_DIR . "/admin/views/MWDViewUninstall.php";
		$view = new MWDViewUninstall($model);
		$view->display();
	}

	public function mwd_uninstall() {
		require_once MWD_DIR . "/admin/models/MWDModelUninstall.php";
		$model = new MWDModelUninstall();

		require_once MWD_DIR . "/admin/views/MWDViewUninstall.php";
		$view = new MWDViewUninstall($model);
		$view->mwd_uninstall();
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