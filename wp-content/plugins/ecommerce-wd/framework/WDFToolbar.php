<?php

class WDFToolbar {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private static $initialized = FALSE;
  
  private static $instances = array();

  public static $item_name = '';

  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public static function title($title = '', $image) {
    self::$item_name = $title;
    self::init();
    $image = preg_replace('#\.[^.]*$#', '', $image);
    ?>
    <div class="pagetitle icon-48-<?php echo $image; ?>">
      <h2><?php echo $title; ?></h2>
    </div>
    <?php
  }

  public static function addNew() {
    self::init();
    ?>
    <a class="add-new-h2" href="<?php echo WDFUrl::get_admin_url() . 'admin.php?page=wde_' . WDFInput::get_controller() . '&task=add'; ?>"><?php _e('Add new', 'wde'); ?></a>
    <?php
  }

  public static function addButton($func, $title = '', $href = '') {
    $btn = new StdClass();
    $btn->func = $func;
    $btn->title = $title ? $title : $func; 
    $btn->href = $href; 
    array_push(self::$instances, $btn);
    return TRUE;
  }

  public static function addToolbar() {
    self::init();
    $btns = self::$instances;
    ?>
    <div class="buttons_div">
    <?php
    if (!empty($btns)) {
      foreach ($btns as $btn) {
        if ( $btn->func == 'select_all' ) {
          ?>
          <a id="check_all_btn" class="button-secondary wde_buttons">
            <input type="checkbox" id="check_all_items" />
            <?php echo ucfirst($btn->title); ?>
          </a>
          <?php
        }
        else {
          if (!$btn->href) {
            $javascript = "submitform('" . $btn->func . "'); return false;";
            if ( $btn->func == "remove" || $btn->func == "remove_keep_default_and_basic" || $btn->func == "remove_keep_default" ) {
              $javascript = "wde_delete('" . $btn->func . "', '" . addslashes(__('Are you sure you want to delete selected items?', 'wde')) . "', '" . addslashes(__('You must select at least one item.', 'wde')) . "');";
            }
            else if ( $btn->func == "export" ) {
              $javascript = "alert('This option is disabled in free version')";
            }
            ?>
            <input class="<?php echo $btn->func == "export" ? 'disabled-btn' : ''; ?> button-secondary wde_buttons" type="submit" value="<?php echo ucfirst($btn->title); ?>" onclick="<?php echo $javascript; ?>" />
            <?php
          }
          else {
            ?>
            <a onclick="wde_add_checked_ids(jQuery(this))" class="button-secondary wde_buttons" href="<?php echo $btn->href; ?>"><?php echo ucfirst($btn->title); ?></a>
            <?php
          }
        }
      }
    }
    ?>
    </div>
    <?php
  }
  
  public static function init() {
    if (!self::$initialized) {
      wp_enqueue_style('wde_toolbar_icons');
      self::$initialized = TRUE;
    }
  }
}