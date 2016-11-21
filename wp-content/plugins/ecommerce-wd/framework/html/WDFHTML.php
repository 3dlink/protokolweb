<?php

defined('ABSPATH') || die('Access Denied');

class WDFHTML {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  const BUTTON_SIZE_SMALL = 'jfbutton_size_small';
  const BUTTON_SIZE_MEDIUM = 'jfbutton_size_medium';
  const BUTTON_SIZE_BIG = 'jfbutton_size_big';

  const BUTTON_COLOR_BLUE = 'jfbutton_color_blue';
  const BUTTON_COLOR_GREEN = 'jfbutton_color_green';
  const BUTTON_COLOR_RED = 'jfbutton_color_red';
  const BUTTON_COLOR_WHITE = 'jfbutton_color_white';
  const BUTTON_COLOR_YELLOW = 'jfbutton_color_yellow';

  const BUTTON_ICON_POS_LEFT = 'jfbutton_icon_pos_left';
  const BUTTON_ICON_POS_RIGHT = 'jfbutton_icon_pos_right';


  const BUTTON_INLINE_TYPE_ADD = 'add';
  const BUTTON_INLINE_TYPE_REMOVE = 'remove';
  const BUTTON_INLINE_TYPE_MOVE_UP = 'move_up';
  const BUTTON_INLINE_TYPE_MOVE_DOWN = 'move_down';
  const BUTTON_INLINE_TYPE_GOTO = 'goto';


  const WD_BS_RATER_STAR_TYPE_STAR = "star";
  const WD_BS_RATER_STAR_TYPE_STAR_EMPTY = "star-empty";


  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  public static function jffont_size($id = '', $class = '', $attributes = '', $value = '') {
    $element = '<span>' . __('Size', 'wde') . ':</span><br /><span>';
    $element .= '<input type="text" name="' . $id . '" id="' . $id . '" value="' . $value . '" class="' . $class . '" ' . $attributes . ' />';
    $element .= '</span>';
    return WDFTextUtils::remove_new_line_chars($element);
  }

  public static function jffont_family($id = '', $class = '', $attributes = '', $value = 'inherit') {
    $font_families = array(
      'inherit' => __('Inherit', 'wde'),
      'arial' => 'Arial',
      'lucida grande' => 'Lucida grande',
      'segoe ui' => 'Segoe ui',
      'tahoma' => 'Tahoma',
      'trebuchet ms' => 'Trebuchet ms',
      'verdana' => 'Verdana',
      'cursive' =>'Cursive',
      'fantasy' => 'Fantasy',
      'monospace' => 'Monospace',
      'serif' => 'Serif',
    );
    $element = '<span>' . __('Style', 'wde') . ':</span><br /><span>';
    $element .= '<select class="' . $class . '" ' . $attributes . ' id="' . $id . '" name="' . $id . '">';
    foreach ($font_families as $key => $ffamily) {
      $element .= '<option value="' . $key . '" ' . (($value == $key) ? 'selected="selected"' : '') . '>' . $ffamily . '</option>';
    }
    $element .= '</select></span>';
    return WDFTextUtils::remove_new_line_chars($element);
  }

  public static function jffont_weight($id = '', $class = '', $attributes = '', $value = 'inherit') {
    $font_weights = array(
      'inherit' => __('Inherit', 'wde'),
      'lighter' => __('Lighter', 'wde'),
      'normal' => __('Normal', 'wde'),
      'bold' => __('Bold', 'wde'),
      'bolder' => __('Bolder', 'wde'),
    );
    $element = '<span>' . __('Weight', 'wde') . ':</span><br /><span>';
    $element .= '<select id="' . $id . '" name="' . $id . '" class="' . $class . '" ' . $attributes . '>';
    foreach ($font_weights as $key => $fweight) {
      $element .= '<option value="' . $key . '" ' . (($value == $key) ? 'selected="selected"' : '') . '>' . $fweight . '</option>';
    }
    $element .= '</select>';
    $element .= '</span>';
    return WDFTextUtils::remove_new_line_chars($element);
  }

  public static function jfbutton($text = '', $id = '', $class = '', $attributes = '', $color = self::BUTTON_COLOR_BLUE, $size = self::BUTTON_SIZE_MEDIUM, $icon = '', $icon_pos = self::BUTTON_ICON_POS_LEFT) {
    wp_print_styles('wde_buttons');
    $attr_id = $id == '' ? '' : ' id="' . $id . '" ';
    $attr_class = ' class="jfbutton ' . $color . ' ' . $size . ' ' . $class . '"';
    $text = $text == '' ? '' : '<span>' . $text . '</span>';
    $img = $icon == '' ? '' : '<span><img src="' . $icon . '" /></span>';
    $separator = ($text != '') && ($img != '') ? '&nbsp;' : '';
    $content = $icon_pos == self::BUTTON_ICON_POS_LEFT ? $img . $separator . $text : $text . $separator . $img;
    $element = '<a ' . $attr_id . $attr_class . ' ' . $attributes . '>' . $content . '</a>';
    return WDFTextUtils::remove_new_line_chars($element);
  }

  public static function jfbutton_inline($text, $type, $id = '', $class = '', $attributes = '', $icon_pos = self::BUTTON_ICON_POS_LEFT) {
    wp_print_styles('wde_buttons');
    $text = $text == '' ? '' : '<span>' . $text . '</span>';
    $icon = '<span class="jfbutton_inline_icon jfbutton_inline_icon_' . $type . '"></span>';
    $html = $icon_pos == self::BUTTON_ICON_POS_LEFT ? $icon . '&nbsp;' . $text : $text . '&nbsp;' . $icon;
    $button = '<a id="' . $id . '" class="jfbutton_inline ' . $type . ' ' . $class . '" ' . $attributes . '>' . $html . '</a>';
    return $button;
  }

  public static function jf_color_picker($id = '', $class = '', $initial_color = '#000000', $pickerShowHandler = '', $pickerHideHandler = '', $colorChangeHandler = '') {
    wp_print_styles('wde_color_picker');
    wp_print_scripts('wde_color_picker');

    $class = explode(' ', $class);
    $class[] = 'wd_shop_color_picker';

    ob_start();
    ?>
    <div id="<?php echo $id; ?>" class="<?php echo implode(' ', $class) ?>"
         pickerShowHandler="<?php echo $pickerShowHandler; ?>"
         pickerHideHandler="<?php echo $pickerHideHandler; ?>"
         colorChangeHandler="<?php echo $colorChangeHandler; ?>">
        <span class="wd_shop_color_picker_color_box"></span>
        <input type="text"
               name="<?php echo $id; ?>"
               class="wd_shop_color_picker_input"
               value="<?php echo $initial_color; ?>">
    </div>
    <?php
    $color_picker = WDFTextUtils::remove_html_spaces(ob_get_clean());
    return $color_picker;
  }

  public static function jf_thumb_box($id, $is_multi = false, $uploads_tab_index = 'images', $hidden_field_id = 'image') {
    wp_print_styles('wde_thumb_box');
    wp_print_scripts('wde_thumb_box');

    $class = $is_multi ? 'jf_thumb_box jf_thumb_box_multi' : 'jf_thumb_box';
    switch($uploads_tab_index){
      case 'images':
        $button_text = $is_multi == true ? __('Add images', 'wde') : __('Add images', 'wde');
        break;
      case 'videos':
        $button_text = __('Add videos', 'wde');
        break;
      case 'downloadable_files':
        $button_text = __('Add files', 'wde');
        break;							
    }

    ob_start(); ?>
    <div id="<?php echo $id; ?>" class="<?php echo $class ?>">
    <?php
    if ($uploads_tab_index == 'images') {
      ?>
      <div class="jf_thumb_box_items_container jf_thumb_box_items_container_iamges">
        <span class="jf_thumb_box_item template">
          <a>
            <img class="jf_thumb_box_item_image" src="" alt="<?php _e('Change thumbnail', 'wde'); ?>"/>
          </a>
          <?php echo self::jfbutton_inline('', self::BUTTON_INLINE_TYPE_REMOVE, '', 'jf_thumb_box_item_btn_remove'); ?>
        </span>
      </div>
      <?php 
    }			
    elseif ($uploads_tab_index == 'videos') {
      ?>
      <div class="jf_thumb_box_items_container jf_thumb_box_items_container_ordering">
        <table class="jf_thumb_box_item template" width="50%">
          <tbody>
            <tr>
              <td width="1%">
                <i class="hasTooltip icon-drag" title="" data-original-title=""></i>
              </td>
              <td>
                <span class="jf_thumb_box_item_video" >	</span>								
              </td>
              <td width="1%">
                <?php echo self::jfbutton_inline('', self::BUTTON_INLINE_TYPE_REMOVE, '', 'jf_thumb_box_item_btn_remove'); ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>			
      <?php
    }
    echo self::jfbutton($button_text, '', 'jf_thumb_box_btn_add jf_thumb_box_btn_add_' . $uploads_tab_index, '', self::BUTTON_COLOR_BLUE, self::BUTTON_SIZE_SMALL); ?>
    </div>
    <script>
      var _jfThumbBoxCurrentObj;
      var _jfThumbBoxCurrentIndex;
      var _jfThumbBoxCurrentReplaceItem;
      var url_root = "<?php $upload_dir = wp_upload_dir(); echo $upload_dir['baseurl']; ?>";
      function jfThumbBoxOpenFileManager(thumbBoxObj, index, replaceThumb, fmTabIndex, event) {
        
        _jfThumbBoxCurrentObj = thumbBoxObj;
        _jfThumbBoxCurrentIndex = index == undefined ? _jfThumbBoxCurrentObj.getUploadUrls().length : index;

        _jfThumbBoxCurrentReplaceItem = replaceThumb == true ? true : false;     
        
        wde_media_uploader(fmTabIndex, _jfThumbBoxCurrentObj, event);
        return false;
      }
      function jfThumbBoxAddUploadsHandler(uploads, fmTabIndex) {
        if (_jfThumbBoxCurrentObj == null) {
          return;
        }
        if (_jfThumbBoxCurrentReplaceItem == true) {
          _jfThumbBoxCurrentObj.removeThumbAt(_jfThumbBoxCurrentIndex);
        }
        // uploads.reverse();
        for (var i = 0; i < uploads.length; i++) {
          _jfThumbBoxCurrentObj.addThumbAt(uploads[i], _jfThumbBoxCurrentIndex, fmTabIndex/*uploads[i]['fmTabIndexUnchanged']*/);
        }
      }
      function wde_media_uploader(library_type, _jfThumbBoxCurrentObj, e) {
        var multiple = _jfThumbBoxCurrentObj._isMulti;
        var id = _jfThumbBoxCurrentObj._thumbBoxContainer.parent().find("input").attr("id");
        var container_id = _jfThumbBoxCurrentObj._thumbBoxContainer.attr("id");
        library_type = library_type.replace('s', '');
        var custom_uploader;
        e.preventDefault();
        // If the uploader object has already been created, reopen the dialog.
        if (custom_uploader) {
          custom_uploader.open();
          // return;
        }
        // Extend the wp.media object.
        custom_uploader = wp.media.frames.file_frame = wp.media({
          title: 'Choose ' + library_type + (multiple ? 's' : ''),
          library : { type : library_type},
          button: { text: 'Insert'},
          multiple: multiple
        });
        // When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
          attachment = custom_uploader.state().get('selection').toJSON();
          jfThumbBoxAddUploadsHandler(attachment, library_type + 's');
          jQuery('#' + id).val(window["_" + container_id].getUploadIds());
        });
        // Open the uploader dialog.
        custom_uploader.open();
      }
    </script>
    <?php
    $thumb_box = WDFTextUtils::remove_html_spaces(ob_get_clean());
    return $thumb_box;
  }

  public static function jf_tag_box($id, $width = '', $height = '') {
    wp_print_styles('wde_tag_box');
    wp_print_scripts('wde_tag_box');

    $width = is_numeric($width) == true ? $width . 'px' : $width;
    $height = is_numeric($height) == true ? $height . 'px' : $height;
    $style = ($width == 0) && ($height == 0) ? '' : 'style="width: ' . $width . '; height: ' . $height . ';"';
    ob_start();
    ?>
    <div id="<?php echo $id; ?>" class="jf_tag_box" <?php echo $style ?>>
      <span class="jf_tag_box_item template">
        <span class="jf_tag_box_item_name"></span>
        <span class="jf_tag_box_item_divider">&nbsp;</span>
        <span class="jf_tag_box_item_btn">&nbsp;</span>
      </span>
    </div>
    <?php
    $tag_box = WDFTextUtils::remove_html_spaces(ob_get_clean());
    return $tag_box;
  }

  public static function jf_bs_rater($id, $class, $attributes, $initial_rating, $is_active, $rating_url, $msg, $tooltips_disabled = false, $stars_count = 5, $star_size = '20px', $star_type = self::WD_BS_RATER_STAR_TYPE_STAR, $star_color = '#ffcc33', $star_bg_color = '#dadada', $module = "") {   
    // css and js
    wp_enqueue_style('wde_star_rater');
    wp_enqueue_script('wde_star_rater');
    $classes = explode(' ', $class);
    $classes[] = 'wd_bs_rater';
    if ($is_active == true) {
      $classes[] = 'active';
    }

    $star_bg_styles = array();
    $star_bg_styles[] = 'font-size: ' . $star_size;
    $star_bg_styles[] = 'background-color: ' . self::adjust_brightness($star_bg_color, -50);
    $star_bg_styles[] = 'text-shadow: 0px 1px 0px ' . $star_bg_color;
    $star_bg_styles[] = 'color: ' . $star_bg_color . '\9';

    $star_styles = array();
    $star_styles[] = 'font-size: ' . $star_size;
    $star_styles[] = 'color: ' . $star_color;
    $star_styles[] = 'text-shadow: 0px 1px 0px ' . self::adjust_brightness($star_color, -50);

    $star_hitter_styles = array();
    $star_hitter_styles[] = 'font-size: ' . $star_size;

    ob_start();
    ?>
    <div id="<?php echo $id; ?>"
         class="<?php echo implode(' ', $classes); ?>"
         rating="<?php echo $initial_rating ? $initial_rating : ''; ?>"
         ratingurl="<?php echo $rating_url; ?>"
         msg="<?php echo $msg; ?>"
         tooltipsdisabled="<?php echo $tooltips_disabled == true ? 'true' : 'false'; ?>"
        <?php echo $attributes; ?>>
      <ul class="wd_bs_rater_stars_list">
        <?php
        for ($i = 0; $i < $stars_count; $i++) {
          ?>
          <li>
            <span class="wd_star_background glyphicon glyphicon-<?php echo $star_type; ?> "
                  style="<?php echo implode(';', $star_bg_styles); ?>; position: absolute; background-color: transparent\0/;"></span>
            <span class="wd_star_color glyphicon glyphicon-<?php echo $star_type; ?> "
                  style="<?php echo implode(';', $star_styles); ?>; position: absolute"></span>
            <span class="wd_star_hitter glyphicon glyphicon-<?php echo $star_type; ?> "
                  style="<?php echo implode(';', $star_hitter_styles); ?>; position: relative; visibility: hidden"></span>
          </li>
        <?php
        }
        ?>
      </ul>
    </div>
    <script>		
      var WD_TEXT_RATING = "<?php echo ( $module == "" ) ?  __('Rating', 'wde') :  WDFText::get_mod('SR_RATING',$module); ?>:"
      var WD_TEXT_NOT_RATED = "<?php echo ( $module == "" ) ?  __('Not yet rated', 'wde') : WDFText::get_mod('SR_NOT_YET_RATED',$module); ?>"
      var WD_TEXT_RATE = "<?php echo ( $module == "" ) ?  __('Rate', 'wde') : WDFText::get_mod('SR_RATE',$module); ?>"
      var WD_TEXT_PLEASE_WAIT = "<?php echo( $module == "" ) ?  __('Please wait', 'wde') : WDFText::get_mod('SR_PLEASE_WAIT',$module); ?>"
      var WD_TEXT_FAILED_TO_RATE = "<?php echo ( $module == "" ) ?  __('Failed to rate', 'wde') : WDFText::get_mod('SR_FAILED_TO_RATE',$module);  ?>"
    </script>
    <?php
    $star_rater = WDFTextUtils::remove_html_spaces(ob_get_clean());
    return $star_rater;
  }

  public static function jf_tree_generator($id, $width = '', $height = '') {
    wp_print_styles('wde_tree_generator');
    wp_print_scripts('wde_tree_generator');
    $width = is_numeric($width) == true ? $width . 'px' : $width;
    $height = is_numeric($height) == true ? $height . 'px' : $height;
    $style = ($width == 0) && ($height == 0) ? '' : 'style="width: ' . $width . '; height: ' . $height . ';"';
    ob_start(); ?>
    <div id="<?php echo $id; ?>" class="jf_tree_generator" <?php echo $style ?>>
        <div class="jf_tree_generator_item template">
            <span class="jf_tree_generator_item_head">
                <span class="jf_tree_generator_item_head_btn jf_tree_generator_item_head_btn_open">&nbsp;</span>
                <span class="jf_tree_generator_item_head_btn jf_tree_generator_item_head_btn_close">&nbsp;</span>
                <span class="jf_tree_generator_item_head_icon_empty">&nbsp;</span>
                <span class="jf_tree_generator_item_head_divider">&nbsp;</span>
                <span class="jf_tree_generator_item_head_name"></span>
            </span>

            <div class="jf_tree_generator_item_children_container">
            </div>
        </div>
    </div>
    <?php
    $tree_generator = WDFTextUtils::remove_html_spaces(ob_get_clean());
    return $tree_generator;
  }

  public static function icon_boolean_inactive($id, $state = 1, $active_action = 'publish', $deactive_action = 'unpublish', $disabled = FALSE, $active_image = 'publish', $deactive_image = 'unpublish') {
    ob_start();
    if ($state) {
      $state_image = $active_image;
      $action = $deactive_action;
    }
    else {
      $state_image = $deactive_image;
      $action = $active_action;
    }
    if (!$disabled) {
      ?>
    <a onclick="wde_check_one('#cb<?php echo $id; ?>'); submitform('<?php echo $action; ?>'); return false;" href="">
      <?php
    }
    ?>
      <img src="<?php echo WD_E_URL . '/images/' . $state_image . '.png'; ?>" />
    <?php
    if (!$disabled) {
      ?>
    </a>
      <?php
    }
    return ob_get_clean();
  }

	public static function jf_show_image_wp($image_url, $title = "") {
		$image = "";
		if ($image_url != '') {
			$image = '<img src="'.$image_url.'" title="'.$title.'" alt="'.$title.'" width="50px"/>';
		}
		else {
			$image='<div class="no_image">
						<span class="glyphicon glyphicon-picture" title="'.$title.'"></span>
						<span class="no_image_text">'. __('No Image', 'wde').'</span>
					</div>';	
		}
		
		return $image;
	}
  
	public static function jf_show_image($images, $title = "") {
		$images = WDFJson::decode($images);
		$image = "";
		if ( $images != array()) {
			$image = '<img src="'.$images[0].'" title="'.$title.'" alt="'.$title.'" width="50px"/>';
		}
		else {
			$image='<div class="no_image">
						<span class="glyphicon glyphicon-picture" title="'.$title.'"></span>
						<span class="no_image_text">'. __('No Image', 'wde').'</span>
					</div>';	
		}
		
		return $image;
	}
	
	public static function jf_module_box($id) {
    wp_print_styles('wde_module_box');
    wp_print_scripts('wde_module_box');
    ob_start();
    ?>
    <div id="<?php echo $id; ?>" class="jf_module_box sortable" >
      <span class="jf_module_box_item template">				
        <span class="jf_module_box_item_name"></span>
        <span class="jf_module_box_item_btn">&nbsp;</span>
        <span class="jf_module_box_item_id"></span>
      </span>
			<span class="jf_module_box_item_all"></span>
    </div>
    <?php
    $module_box = WDFTextUtils::remove_html_spaces(ob_get_clean());
    return $module_box;
  }

	public static function get_hidden_fields($array) {
    $string = "";
    foreach ($array as $key => $value) {
      if ($value) {
        $string .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
      }
    }
    return $string;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  private static function adjust_brightness($hex, $steps) {
    // steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }

    // get decimal values
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // adjust number of steps and keep it inside 0 to 255
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#' . $r_hex . $g_hex . $b_hex;
  }

  public static function wd_editor($id, $value, $cols = 50, $rows = 5) {
    ob_start();
    if (user_can_richedit()) {
      wp_editor($value, $id, array('teeny' => FALSE, 'textarea_name' => $id, 'media_buttons' => FALSE, 'textarea_rows' => $rows));
    }
    else {
    ?>
    <textarea cols="<?php echo $cols; ?>" rows="<?php echo $rows; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>" style="resize:vertical">
      <?php echo $value; ?>
    </textarea>
    <?php
    }
    return ob_get_clean();
  }

  public static function wd_radio($id, $value, $yes, $no, $class = '', $attr = '') {
    ob_start();
    ?>
    <input <?php echo $attr; ?> type="radio" class="inputbox <?php echo $class; ?>" id="<?php echo $id; ?>0" name="<?php echo $id; ?>" <?php echo (($value) ? '' : 'checked="checked"'); ?> value="0" />
    <label class="wde_label" for="<?php echo $id; ?>0"><?php echo $no; ?></label>
    <input <?php echo $attr; ?> type="radio" class="inputbox <?php echo $class; ?>" id="<?php echo $id; ?>1" name="<?php echo $id; ?>" <?php echo (($value) ? 'checked="checked"' : ''); ?> value="1" />
    <label class="wde_label" for="<?php echo $id; ?>1"><?php echo $yes; ?></label>
    <?php
    return ob_get_clean();
  }

  public static function wd_message($message_id) {
    if (isset($_POST['option']) && $_POST['option'] == 'del_mes') {
      return;
    }
    if ($message_id) {
      $message = '';
      switch($message_id) {
        case 1: {
          $message = __("The changes are saved.", 'wde');
          $type = 'updated';
          break;
        }
        case 2: {
          $message = __("The items are saved.", 'wde');
          $type = 'updated';
          break;
        }
        case 3: {
          $message = __("The items are successfully deleted.", 'wde');
          $type = 'updated';
          break;
        }
        case 4: {
          $message = __("Failed to delete items.", 'wde');
          $type = 'error';
          break;
        }
        case 7: {
          $message = __("The item is successfully set as default.", 'wde');
          $type = 'updated';
          break;
        }
        case 8: {
          $message = __("The item is successfully set to read.", 'wde');
          $type = 'updated';
          break;
        }
        case 9: {
          $message = __("The item is successfully set to unread.", 'wde');
          $type = 'updated';
          break;
        }
        case 10: {
          $message = __("The item is successfully published.", 'wde');
          $type = 'updated';
          break;
        }
        case 11: {
          $message = __("The items are successfully published.", 'wde');
          $type = 'updated';
          break;
        }
        case 12: {
          $message = __("The item is successfully unpublished.", 'wde');
          $type = 'updated';
          break;
        }
        case 13: {
          $message = __("The items are successfully unpublished.", 'wde');
          $type = 'updated';
          break;
        }
        case 14: {
          $message = __("The ordering is successfully saved.", 'wde');
          $type = 'updated';
          break;
        }
        case 15: {
          $message = __("You must select at least one item.", 'wde');
          $type = 'error';
          break;
        }
        case 16: {
          $message = __("The invoice is sent successfully.", 'wde');
          $type = 'updated';
          break;
        }
        case 17: {
          $message = __("The invoice is not sent.", 'wde');
          $type = 'error';
          break;
        }
        case 18: {
          $message = __("The order status is updated. Email sent successfully.", 'wde');
          $type = 'updated';
          break;
        }
        case 19: {
          $message = __("The order status is updated. Failed to sent email.", 'wde');
          $type = 'updated';
          break;
        }
        case 20: {
          $message = __("Failed to update order status.", 'wde');
          $type = 'error';
          break;
        }
        case 21: {
          $message = __("The order status hasn't changed.", 'wde');
          $type = 'updated';
          break;
        }
        case 22: {
          $message = __("Failed to save changes.", 'wde');
          $type = 'error';
          break;
        }
        case 23: {
          $message = __("Rating is changed successfully.", 'wde');
          $type = 'updated';
          break;
        }
        case 24: {
          $message = __("Rating hasn't changed.", 'wde');
          $type = 'updated';
          break;
        }
        case 25: {
          $message = __("Choose one item.", 'wde');
          $type = 'error';
          break;
        }
        case 26: {
          $message = __("Failed to update default item.", 'wde');
          $type = 'error';
          break;
        }
        case 27: {
          $message = __("Default item is set successfully.", 'wde');
          $type = 'updated';
          break;
        }
        case 28: {
          $message = __("You can't delete default item.", 'wde');
          $type = 'error';
          break;
        }
        case 29: {
          $message = __("You can't delete basic item.", 'wde');
          $type = 'error';
          break;
        }
        case 30: {
          $message = __("File doesn't exist.", 'wde');
          $type = 'error';
          break;
        }
        case 31: {
          $message = __("Template successfully created.", 'wde');
          $type = 'updated';
          break;
        }
        case 32: {
          $message = __("Failed.", 'wde');
          $type = 'error';
          break;
        }
        case 33: {
          $message = __("Template couldn't be empty.", 'wde');
          $type = 'error';
          break;
        }
        case 34: {
          $message = __("Templates successfully created.", 'wde');
          $type = 'updated';
          break;
        }
        case 35: {
          $message = __("Template couldn't be created.", 'wde');
          $type = 'error';
          break;
        }
        case 36: {
          $message = __("You must manually insert the code to display the item.", 'wde');
          $type = 'error';
          break;
        }
      }
      if ($message) {
        ob_start();
        ?>
        <div class="<?php echo $type; ?> below-h2">
          <p>
            <strong><?php echo $message; ?></strong>
          </p>
        </div>
        <?php
        $message = ob_get_clean();
      }
      return $message;
    }
  }

  public static function wd_ordering($id, $sort_by, $sort_order, $text) {
    ob_start();
    $order_class = 'manage-column column-title sorted ' . $sort_order;
    ?>
    <th class="sortable col_<?php echo $id; ?> <?php if ($sort_by == $id) { echo $order_class; } ?>">
      <a onclick="tableOrdering('<?php echo $id; ?>', '<?php echo ($sort_by == $id && $sort_order == 'asc') ? 'desc' : 'asc'; ?>', '');return false;" href="" title="<?php _e('Click to sort by this item', 'wde'); ?>">
        <span><?php echo $text; ?></span><span class="sorting-indicator"></span>
      </a>
    </th>
    <?php
    return ob_get_clean();
  }

  public static function wd_select($id, $values, $value_field, $text_field, $current_value, $attr = '') {
    ob_start();
    ?>
    <select id="<?php echo $id; ?>" name="<?php echo $id; ?>" <?php echo $attr; ?>>
      <?php foreach ($values as $val) { ?>
      <option value="<?php echo $val[$value_field]; ?>" <?php echo ($val[$value_field] == $current_value ? 'selected="selected"' : ''); ?>><?php echo $val[$text_field]; ?></option>
      <?php } ?>
    </select>
    <?php
    return ob_get_clean();
  }

  public static function wd_date($id, $value, $date_format = '%Y-%m-%d', $attr = '') {
    ob_start();
    wp_print_scripts('wde_calendar');
    wp_print_scripts('wde_calendar_function');
    wp_print_styles('wde_calendar-jos');
    ?>
    <input id="<?php echo $id; ?>" <?php echo $attr; ?> type="text" value="<?php echo $value; ?>" name="<?php echo $id; ?>" />
    <input class="button wde_button" type="reset" onclick="return showCalendar('<?php echo $id; ?>','<?php echo $date_format; ?>');" value="..." />
    <?php
    return ob_get_clean();
  }

  public static function wd_radio_list($id, $values, $value_field, $text_field, $current_value, $attr = '', $parent_class = '', $disable_options = array()) {
    ob_start();
    $disabled = '';
    ?>
    <div class="controls">
    <?php foreach ($values as $val) { 
      if (in_array($val->$value_field, $disable_options)) {
        $disabled = 'disabled="disabled" title="' . __("This option is disabled in free version.", "wde") .  '"';
      }
      else {
        $disabled = '';
      }
      ?>
      <label for="<?php echo $id . $val->$value_field; ?>" <?php echo $disabled; ?> id="<?php echo $id . $val->$value_field; ?>-lbl" class="wde_label radio <?php echo $parent_class; ?>">        
        <input <?php echo $attr; ?> <?php echo $disabled; ?> type="radio" name="<?php echo $id; ?>" id="<?php echo $id . $val->$value_field; ?>" value="<?php echo $val->$value_field; ?>" <?php echo ($val->$value_field == $current_value ? 'checked="checked"' : ''); ?> /><?php echo $val->$text_field; ?>
      </label>
    <?php } ?>
    </div>
    <?php
    return ob_get_clean();
  }

  public static function wd_bs_container_start() {
      for ($i = 1; $i < 13; $i++) {
          echo '<div id="wd_shop_container_' . $i . '">';
      }
      echo '<div id="wd_shop_container">';
  }

  public static function wd_bs_container_end() {
      for ($i = 1; $i < 14; $i++) {
          echo '</div>';
      }
  }

  public static function no_items($title) {
    $title = ($title != '') ? strtolower($title) : 'items';
    ob_start();
  ?><tr class="no-items">
      <td class="colspanchange" colspan="0"><?php echo sprintf(__('No %s found.', 'wde'), $title); ?></td>
    </tr><?php
    return ob_get_clean();
  }

  public static function non_commercial() {
    ob_start();
    ?>
    <div class="wde_non_commercial"><?php _e("This feature is disabled for the non-commercial version.", "wde"); ?></div>
    <?php
    return ob_get_clean();
  }

  public static function wde_filters_inputs($data, $form_name = 'wd_shop_main_form') {
    global $wde_product_search_inputs_created;
    if (!$wde_product_search_inputs_created) {
      $search_data = $data["search_data"];
      $filters_data = $data["filters_data"];
      $arrangement_data = $data["arrangement_data"];
      $sort_data = $data["sort_data"];
      $pagination = $data["pagination"];
      ob_start();
      ?>
      <form name="<?php echo $form_name; ?>" action="<?php echo $data['all_products_page_url']; ?>" method="POST">
        <input type="hidden" name="product_id" value="">
        <input type="hidden" name="product_count" value="">
        <input type="hidden" name="product_parameters_json" value="">

        <input type="hidden" name="search_name" value="<?php echo $search_data['name']; ?>">
        <input type="hidden" name="search_category_id" value="<?php echo $search_data['category_id']; ?>">

        <input type="hidden" name="filter_filters_opened" value="<?php echo $filters_data['filters_opened']; ?>">
        <input type="hidden" name="filter_manufacturer_ids"
               value="<?php echo implode(',', $filters_data['manufacturer_ids']); ?>">
        <input type="hidden" name="filter_price_from" value="<?php echo $filters_data['price_from']; ?>">
        <input type="hidden" name="filter_price_to" value="<?php echo $filters_data['price_to']; ?>">
        <input type="hidden" name="filter_date_added_range" value="<?php echo $filters_data['date_added_range']; ?>">
        <input type="hidden" name="filter_minimum_rating" value="<?php echo $filters_data['minimum_rating']; ?>">
        <input type="hidden" name="filter_tags" value="<?php echo implode(',', $filters_data['tags']); ?>">

        <input type="hidden" name="arrangement" value="<?php echo $arrangement_data['arrangement']; ?>">

        <input type="hidden" name="sort_by" value="<?php echo $sort_data['sort_by']; ?>">
        <input type="hidden" name="sort_order" value="<?php echo $sort_data['sort_order']; ?>">

        <input type="hidden" name="pagination_limit_start" value="<?php //echo $pagination->limitstart; ?>">
        <input type="hidden" name="pagination_limit" value="<?php //echo $pagination->limit; ?>">
      </form>
      <?php
      $wde_product_search_inputs_created++;
      return ob_get_clean();
    }
  }

  public static function div_import($args = array("function" => "taxImport", "term_id" => 0, "name" => "import")) {
    ob_start();
    ?>
    <div class="wde_opacity_popup" onclick="jQuery('.wde_opacity_popup').hide();jQuery('.wde_popup_div').hide();"></div>
    <div class="wde_popup_div">
        <input type="file" name="fileupload" id="fileupload" />
        <input class="button-secondary" type="button" onclick="if(wde_getfileextension(document.getElementById('fileupload').value, '<?php _e("Sorry, you are not allowed to upload this type of file.", 'wde'); ?>', '<?php _e("Choose file.", 'wde'); ?>') ){<?php echo $args["function"]; ?>(<?php echo $args["term_id"]; ?>);} else return false;"  value="<?php _e(ucfirst($args["name"]), 'wde'); ?>" name="<?php echo $args["name"]; ?>" />
        <input type="button" class="button-secondary" onclick="jQuery('.wde_popup_div').hide();jQuery('.wde_opacity_popup').hide(); return false;" value="<?php _e("Cancel", 'wde'); ?>" />
        <div class="spider_description"><?php _e("Choose file (use .csv format).", 'wde'); ?></div>
    </div>
    <?php
    return ob_get_clean();
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}