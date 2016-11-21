<?php

defined('ABSPATH') || die('Access Denied');

class WDFAdminViewBase {
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
    public function getModel() {
        return $this->model;
    }

    public function display( $tpl = null ) {
        $controller = WDFInput::get_controller('ecommercewd');
        $tpl = $tpl != null ? $tpl : "default";
        
        require WD_E_DIR . '/admin/views/' . $controller . '/tmpl/' . $tpl . '.php';
    }


    public function generate_filters($filter_items) {
      if (empty($filter_items) == true) {
        return '';
      }
      ob_start();
      ?>
      <div class="alignleft actions">
        <?php
        foreach ($filter_items as $filter_item) {
          if ($filter_item->input_type == 'hidden') {
            continue;
          }
          ?>
        <label for="<?php echo $filter_item->input_name; ?>"><?php echo $filter_item->input_label; ?>:</label>
          <?php
          switch ($filter_item->input_type) {
            case 'select':
              echo WDFHTML::wd_select($filter_item->input_name, $filter_item->values_list, $filter_item->values_list_prop_value, $filter_item->values_list_prop_text, $filter_item->value, 'class="searchable"');
              break;
            case 'date':
              echo WDFHTML::wd_date($filter_item->input_name, $filter_item->value, '%Y-%m-%d', 'class="searchable wde_date_input"');
              break;
            default:
              ?>
              <input type="<?php echo $filter_item->input_type; ?>"
               name="<?php echo $filter_item->input_name; ?>"
               id="<?php echo $filter_item->input_name; ?>"
               class="searchable"
               value="<?php echo $filter_item->value; ?>" />
              <?php
              break;
          }
        }
        ?>                    
        <a class="button" onclick="onBtnSearchClick(event, this);"><span><?php _e('Go', 'wde'); ?></span></a>
        <a class="button" onclick="onBtnResetClick(event, this);"><span><?php _e('Reset', 'wde'); ?></span></a>
      </div>
      <?php
      $filters = ob_get_clean();
      return $filters;
    }

    public function generate_order_cell_content($i, $ordering, $class_name) {		
		$data_original_title = $class_name == 'icon-disable-drag' ?  __('Please sort by order to enable reordering', 'wde') : '';
        ob_start();
        ?>
        <i class="hasTooltip <?php echo $class_name; ?>" title="<?php echo $data_original_title;?>" data-original-title="<?php echo $data_original_title;?>"></i>
        <input type="hidden"
               name="order[]"
               value="<?php echo $ordering; ?>" />
         
        <?php
        $content = ob_get_clean();
        return $content;
    }

    public function generate_pager($count_items, $pager_number, $page_number = 1, $form_id = "adminForm", $items_per_page = 20) {
      ob_start();
      $items_per_page = WDFSession::get_pagination_limit();
      if ($count_items) {
        if ($count_items % $items_per_page) {
          $items_county = ($count_items - $count_items % $items_per_page) / $items_per_page + 1;
        }
        else {
          $items_county = ($count_items - $count_items % $items_per_page) / $items_per_page;
        }
      }
      else {
        $items_county = 1;
      }
      if (!$pager_number) {
      ?>
      <script type="text/javascript">
        var items_county = <?php echo $items_county; ?>;
        function spider_page(x, y) {
          switch (y) {
            case 1:
              if (x >= items_county) {
                document.getElementById('page_number').value = items_county;
              }
              else {
                document.getElementById('page_number').value = x + 1;
              }
              break;
            case 2:
              document.getElementById('page_number').value = items_county;
              break;
            case -1:
              if (x == 1) {
                document.getElementById('page_number').value = 1;
              }
              else {
                document.getElementById('page_number').value = x - 1;
              }
              break;
            case -2:
              document.getElementById('page_number').value = 1;
              break;
            default:
              document.getElementById('page_number').value = 1;
          }
          jQuery("form[name=adminForm] input[name=option]").val('del_mes');
          document.getElementById('<?php echo $form_id; ?>').submit();
        }
        function check_enter_key(that, e) {
          var key_code = (e.keyCode ? e.keyCode : e.which);
          if (key_code == 13) { /*Enter keycode*/
            if (jQuery(that).val() >= items_county) {
             document.getElementById('page_number').value = items_county;
            }
            else {
             document.getElementById('page_number').value = jQuery(that).val();
            }
            document.getElementById('<?php echo $form_id; ?>').submit();
            return true;
          }
          return true;
        }
      </script>
        <?php
      }
      ?>
      <div class="tablenav-pages">
        <span class="displaying-num">
          <?php
          if ($count_items != 0) {
            echo sprintf(_n('%s item', '%s items', $count_items, 'wde'), $count_items);
          }
          ?>
        </span>
        <?php
        if ($count_items > $items_per_page) {
          $first_page = "first-page";
          $prev_page = "prev-page";
          $next_page = "next-page";
          $last_page = "last-page";
          if ($page_number == 1) {
            $first_page = "first-page disabled";
            $prev_page = "prev-page disabled";
            $next_page = "next-page";
            $last_page = "last-page";
          }
          if ($page_number >= $items_county) {
            $first_page = "first-page ";
            $prev_page = "prev-page";
            $next_page = "next-page disabled";
            $last_page = "last-page disabled";
          }
        ?>
        <span>
          <a class="<?php echo $first_page; ?>" title="<?php _e('Go to the first page', 'wde'); ?>" href="javascript:spider_page(<?php echo $page_number; ?>,-2);">&laquo;</a>
          <a class="<?php echo $prev_page; ?>" title="<?php _e('Go to the previous page', 'wde'); ?>" href="javascript:spider_page(<?php echo $page_number; ?>,-1);">&lsaquo;</a>
          <span class="paging-input">
            <span class="total-pages">
            <input class="current-page" id="current_page" name="current_page" value="<?php echo $page_number; ?>" onkeypress="return check_enter_key(this, event)" title="<?php _e('Go to the page', 'wde'); ?>" type="text" size="1" />
          </span> <?php _e('Of', 'wde'); ?> 
          <span class="total-pages">
              <?php echo $items_county; ?>
            </span>
          </span>
          <a class="<?php echo $next_page ?>" title="<?php _e('Go to the next page', 'wde'); ?>" href="javascript:spider_page(<?php echo $page_number; ?>,1);">&rsaquo;</a>
          <a class="<?php echo $last_page ?>" title="<?php _e('Go to the last page', 'wde'); ?>" href="javascript:spider_page(<?php echo $page_number; ?>,2);">&raquo;</a>
        </span>
          <?php
        }
        ?>
      </div>
      <?php
      if (!$pager_number) {
        ?>
      <input type="hidden" id="page_number" name="page_number" value="<?php echo ((isset($_POST['page_number'])) ? (int) $_POST['page_number'] : 1); ?>" />
      <input type="hidden" id="search_or_not" name="search_or_not" value="<?php echo ((isset($_POST['search_or_not'])) ? esc_html($_POST['search_or_not']) : ''); ?>"/>
        <?php
      }
      $content = ob_get_clean();
      return $content;
    }
    
    public function generate_message() {
      wp_nonce_field('wde_nonce', 'wde_nonce');
      return WDFHTML::wd_message(WDFInput::get('msg'));
    }
}