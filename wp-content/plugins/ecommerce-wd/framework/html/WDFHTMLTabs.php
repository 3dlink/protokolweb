<?php

defined('ABSPATH') || die('Access Denied');

class WDFHTMLTabs {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private static $tabs_name;
  private static $start_tab;
  private static $on_active;


  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public static function startTabs($name, $start_tab = '', $on_active = '', $twelve_div = TRUE, $base_bootstrap = FALSE) {
    self::$tabs_name = $name;
    self::$start_tab = $start_tab;
    self::$on_active = $on_active;
    wp_print_scripts('wde_bootstrap');
    if ($base_bootstrap) {
      wp_print_styles('wde_base_bootstrap');
    }
    else {
      wp_print_styles('wde_bootstrap');
    }
    if ($twelve_div) {
      WDFHTML::wd_bs_container_start();
    }
    echo '<ul id="' . $name . 'Tabs" class="nav nav-tabs">';
  }

  public static function startTab($tab_name, $tab_label) {
    $active_tab = WDFInput::get('tab_index');
    $active_subtab = WDFInput::get('subtab_index');
    $class = '';
    if ($active_tab == $tab_name || $active_subtab == $tab_name) {
      $class = ' class="active"';
    }
    echo '<li' . $class . '><a href="#' . $tab_name . '" data-toggle="tab">' . $tab_label . '</a></li>';
  }

  public static function endTabs() {
    echo '</ul>';
  }
  
  public static function startTabsContent($name = '') {
    if (!$name) {
      $name = self::$tabs_name;
    }
    echo '<div class="tab-content" id="' . $name . 'Content">';
  }

  public static function startTabContent($tab_name) {
    $active_tab = WDFInput::get('tab_index');
    $active_subtab = WDFInput::get('subtab_index');
    $class = '';
    if ($active_tab == $tab_name || $active_subtab == $tab_name) {
      $class = ' active';
    }
    echo '<div id="' . $tab_name . '" class="tab-pane' . $class . '">';
  }

  public static function endTabContent() {
    echo '</div>';
  }    
  
  public static function endTabsContent() {
    echo '</div>';
  }
  
  public static function scripts($name = '', $twelve_div = TRUE, $onactive = '') {
    if (!$name) {
      $name = self::$tabs_name;
    }
    if (!$onactive) {
      $onactive = self::$on_active;
    }
    ?>
    <script>
      jQuery(document).ready(function () {
        // activate first tab if there is no active tab
        var hasActiveTab = false
        jQuery("#<?php echo $name; ?>Tabs>li").each(function (event) {
          if (jQuery(this).hasClass("active")) {
            hasActiveTab = true;
          }
        });
        if (hasActiveTab == false) {
          var jq_firstTab = jQuery(jQuery("#<?php echo $name; ?>Tabs>li <?php echo self::$start_tab ? "a[href='#" . self::$start_tab . "']" : "a[data-toggle=tab]"; ?>")[0]);
          if (!jq_firstTab.length) {
            jq_firstTab = jQuery(jQuery("#<?php echo $name; ?>Tabs>li a[data-toggle=tab]")[0]);
          }
          jq_firstTab.tab("show");
        }
        // on tab activate
        jQuery("#<?php echo $name; ?>Tabs>li a[data-toggle=tab]").on("click", function (event) {
          var href = jQuery(this).attr("href");
          var currentTabIndex = href.substr(1);
          <?php echo $onactive; ?>(currentTabIndex);
        });
      });
    </script>
    <?php
    if ($twelve_div) {
      WDFHTML::wd_bs_container_end();
    }
    self::$tabs_name = null;
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