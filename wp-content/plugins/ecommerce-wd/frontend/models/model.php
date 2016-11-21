<?php

defined('ABSPATH') || die('Access Denied');

class EcommercewdModel extends WDFSiteModelBase {
  
  public function enqueue_message($msg, $type) { // success | info | warning | danger
    $messages = isset($_SESSION['wde_frontend_messages']) ? $_SESSION['wde_frontend_messages'] : array();
    $messages[$msg] = $type;      
    $_SESSION['wde_frontend_messages'] = $messages;
  }
  
  public function get_messages() {
    $messages = isset($_SESSION['wde_frontend_messages']) ? $_SESSION['wde_frontend_messages'] : array();
    $_SESSION['wde_frontend_messages'] = array();
    return $messages;
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