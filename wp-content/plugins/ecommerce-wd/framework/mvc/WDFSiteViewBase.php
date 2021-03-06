<?php

defined('ABSPATH') || die('Access Denied');

class WDFSiteViewBase {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////

    protected $active_menu_params;

    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////

    public function __construct($model) {
      $this->model = $model;
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////

    public function display($params) {
      $controller = $params['type'];
      // $task = $params['layout'];
      if ($controller != 'theme') {
        $task = WDFInput::get_task();
      }
      $task = isset($task) ? $task : $params['layout'];
      // $task = $params['layout'];
      require WD_E_DIR . '/frontend/views/' . $controller . '/tmpl/' . $task . '.php';
    }

    public function getModel() {
      return $this->model;
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function activate_current_menu() {
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}