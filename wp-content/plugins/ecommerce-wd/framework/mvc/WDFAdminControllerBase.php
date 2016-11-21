<?php

defined('ABSPATH') || die('Access Denied');

class WDFAdminControllerBase {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  protected static $default_view = 'ecommercewd';

  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function execute($task = null, $attrs = null) {
    $task = $task != null ? $task : "display";
    $nonce_exclude = array('display', 'view', 'add', 'edit', 'explore', 'uninstall', 'cancel', 'printorder', 'paymentdata', 'send_invoice');
    // if (!in_array($task, $nonce_exclude)) {
      // if (!isset($_POST['wde_nonce']) || !wp_verify_nonce($_POST['wde_nonce'], 'wde_nonce')) {
        // die(__('Sorry, your nonce did not verify.', 'wde'));
      // }
    // }
    if (method_exists($this, $task)) {
      $this->$task(null, $attrs);
    }
  }

  public function display($task = null, $attrs = null) {
    $controller = WDFInput::get_controller(self::$default_view);

    require_once WD_E_DIR . "/admin/models/" . $controller . ".php";
    $model_class = ucfirst(WDFHelper::get_com_name()) . 'Model' . ucfirst($controller);
    $model = new $model_class();

    require_once WD_E_DIR . "/admin/views/" . $controller . "/view.php";
    $view_class = ucfirst(WDFHelper::get_com_name()) . 'View' . ucfirst($controller);
    $view = new $view_class($model);
    $task = $task != null ? $task : WDFInput::get_task();
    echo $view->display($task, $attrs);
  }

  public function printorder() {
    $this->display();
  }

  public function paymentdata() {
    $this->display();
  }

  public function uninstall() {
    $this->display();
  }

  public function remove_sample_data() {
    $this->display();
  }
  
  public function explore() {
    WDFInput::set('tmpl', 'component');
    $this->display();
  }

  public function view() {
    $this->display();
  }

  public function add() {
    $this->display('edit');
  }

  public function add_refresh() {
    $this->display('edit');
  }

  public function edit($task = null, $attrs = null) {
    $this->display($task, $attrs);
  }

  public function edit_refresh() {
    $this->display('edit');
  }

  public function make_default() {
    $message_id = '';
    $checked_ids = WDFInput::get_checked_ids();
    if (count($checked_ids) != 1) {
      WDFHelper::redirect('', '', '', '', 25);
    }
    $checked_id = $checked_ids[0];
    global $wpdb;
    $table_name = $wpdb->prefix . 'ecommercewd_' . WDFInput::get_controller();
    $failed = false;

    // set default = 1 for checked item
    $wpdb->update($table_name, array('default' => 0), array('default' => 1));
    if ($wpdb->last_error) {
      $failed = true;
      echo $wpdb->last_error;
      $message_id = 26;
    }
    else {
      $wpdb->update($table_name, array('default' => 1), array('id' => $checked_id));
      if ($wpdb->last_error) {
        $failed = true;
        echo $wpdb->last_error;
        $message_id = 26;
      }
    }

    if ($failed == false) {
      $message_id = 27;
    }
    WDFHelper::redirect('', '', '', '', $message_id);
  }

  public function publish() {
    $saved = WDFDb::set_checked_rows_data('', 'published', 1);
    $message_id = $saved !== FALSE ? 11 : 22;
    WDFHelper::redirect('', '', '', '', $message_id);
  }
  
  public function unpublish() {
    $saved = WDFDb::set_checked_rows_data('', 'published', 0);
    $message_id = $saved !== FALSE ? 13 : 22;
    WDFHelper::redirect('', '', '', '', $message_id);
  }

  public function remove() {
    $removed = WDFDb::remove_checked_rows();
    $message_id = $removed ? 3 : 4;
    WDFHelper::redirect('', '', '', '', $message_id);
  }

  public function remove_keep_default() {
    $message_id = '';
    $ids = WDFInput::get_checked_ids();
    // prevent from removing default item
    $contain_default_items = false;
    $default_item_rows =  WDFDb::get_rows('', '`default` = 1');
    foreach ($default_item_rows as $default_item_row) {
      $index_of_default_item_id = array_search($default_item_row->id, $ids);
      if ($index_of_default_item_id !== false) {
        $contain_default_items = true;
        unset($ids[$index_of_default_item_id]);
        $ids = array_values($ids);
      }
    }
    if ($contain_default_items == true) {
      $message_id = 28;
    }

    // remove items
    if ((empty($ids) == false) && (WDFDb::remove_rows('', $ids) == false)) {
      $message_id = 4;
    }

    WDFHelper::redirect('', '', '', '', $message_id);
  }

  public function remove_keep_default_and_basic() {
    $message_id = '';
    $ids = WDFInput::get_checked_ids();
    // prevent from removing default item
    $contain_default_items = false;
    $default_item_rows = WDFDb::get_rows('', '`default` = 1');
    foreach ($default_item_rows as $default_item_row) {
      $index_of_default_item_id = array_search($default_item_row->id, $ids);
      if ($index_of_default_item_id !== false) {
        $contain_default_items = true;
        unset($ids[$index_of_default_item_id]);
        $ids = array_values($ids);
      }
    }

    if ($contain_default_items == true) {
      $message_id = 28;
    }

    // prevent from removing basic item
    $contain_basic_items = false;
    $basic_item_rows = WDFDb::get_rows('', '`basic` = 1');
    foreach ($basic_item_rows as $basic_item_row) {
      $index_of_basic_item_id = array_search($basic_item_row->id, $ids);
      if ($index_of_basic_item_id !== false) {
        $contain_basic_items = true;
        unset($ids[$index_of_basic_item_id]);
        $ids = array_values($ids);
      }
    }
    if ($contain_basic_items == true) {
      $message_id = 29;
    }
    // remove items
    if ((empty($ids) == false) && (WDFDb::remove_rows('', $ids) == false)) {
      $message_id = 4;
    }
    WDFHelper::redirect('', '', '', '', $message_id);
  }

  public function save_order() {
    WDFDb::save_ordering();
  }

  public function apply() {
    $row = $this->store_input_in_row();
    WDFHelper::redirect('', 'edit', $row->id, '', 1);
  }

  public function save() {
    $this->store_input_in_row();
    WDFHelper::redirect('', '', '', '', 2);
  }

  public function save2new() {
    $this->store_input_in_row();
    WDFHelper::redirect('', 'add', '', '', 1);
  }

  public function cancel() {
    WDFHelper::redirect();
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  protected function store_input_in_row() {
    $table_name = WDFInput::get_controller();
    $row = WDFDb::get_table_instance($table_name);
    if (property_exists($row, 'ordering')) {
      global $wpdb;
      $query = 'SELECT `ordering`';
      $query .= ' FROM ' . $wpdb->prefix . 'ecommercewd_' . $table_name;
      $query .= ' ORDER BY `ordering` DESC';
      $max_ordering = intval($wpdb->get_results($query));

      WDFInput::set('ordering', $max_ordering + 1);
    }
    $row = WDFDb::store_input_in_row();
    return $row;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}