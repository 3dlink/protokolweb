<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerTemplates extends EcommercewdController {
  private static $path;
  private static $theme_name;

  public function __construct() {
    self::$path = wde_get_template();
    $theme = wp_get_theme();
    self::$theme_name = $theme->template;
  }

  public function reset() {
    $task = WDFInput::get('task');
    $this->perform($task);
  }

  public function copy() {
    $task = WDFInput::get('task');
    $this->perform($task);
  }

  public function perform($task) {
    $message_id = self::make_folder();
    $type = WDFInput::get('tab_index', 'products');
    // $path = self::$path . DS . $type . '_' . self::$theme_name . '.php';
    $path = wde_get_template($type);
    if ($task == 'reset') {
      $source = str_replace('_' . self::$theme_name . '.php', '_backup.php', $path);
    }
    else {
      $source = self::get_theme_template($type);
    }
    if (file_exists($source)) {
      $success = copy($source, $path);
      if ($success === FALSE) {
        $message_id = 32;
      }
      $message_id = 31;
    }
    else {
      $message_id = 30;
    }
    WDFHelper::redirect('', '', '', 'tab_index=' . $type, $message_id);
  }

  public function save() {
    $message_id = self::make_folder();
    $type = WDFInput::get('tab_index', 'products');
    $code = isset($_POST[$type . '_code']) ? stripcslashes($_POST[$type . '_code']) : '';
    if ($code) {
      // $path = self::$path . DS . $type . '_' . self::$theme_name . '.php';
      $path = wde_get_template($type);
      if (file_exists($path)) {
        $handle = fopen($path, 'w');
        $success = fwrite($handle, $code);
        fclose($handle);
        if ($success === FALSE) {
          $message_id = 32;
        }
        $message_id = 31;
      }
      else {
        $message_id = 30;
      }
    }
    else {
      $message_id = 33;
    }

    WDFHelper::redirect('', '', '', 'tab_index=' . $type, $message_id);
  }

  public static function get_theme_template($type) {
    /* Category templates hierarchy.
     *  1.category-slug.php
     *  2.category-ID.php
     *  3.category.php
     *  4.archive.php
     *  5.index.php
     */
    /* Custom post type templates hierarchy.
     *  1.archive-{post_type}.php
     *  2.single-{post_type}.php
     *  3.single.php
     *  4.index.php
     */
    $theme_dir = str_replace(array('/', '\\'), DS, get_template_directory() . '/');
    $source = $theme_dir . ($type == 'category' ? 'category' : 'single') . '.php';
    if (!file_exists($source)) {
      $source = $theme_dir . 'archive.php';
    }

    if ($type == 'categories') {
      $source = self::check_file(array('category', 'archive', 'index'), $theme_dir);
    }
    else {
      $source = self::check_file(array('single', 'index'), $theme_dir);
    }
    return $source;
  }

  public static function check_file($templates, $theme_dir) {
    foreach ($templates as $template) {
      $file = $theme_dir . $template . '.php';
      if (file_exists($file)) {
        return $file;
      }
    }
    return '';
  }

  public function generate_templates() {
    $type = WDFInput::get('tab_index', 'products');
    self::copy_templates(FALSE, array($type));
  }

  public static function copy_templates($auto = FALSE, $types = array('products', 'manufacturers', 'categories')) {
    $message_id = self::make_folder();
    if ($auto) {
      return;
    }
    foreach ($types as $type) {
      $source = self::get_theme_template($type);
      if (file_exists($source)) {
        $start_with = 'get_template_part';
        $end_with = '\);';
        $handle = fopen($source, 'r');
        $content = fread($handle, filesize($source));
        fclose($handle);
        // If content exists.
        if ($content !== FALSE && strpos($content, $start_with) !== FALSE) {
          if ($type == 'products') {
            $replacement = "wde_front_end(array('product_id' => get_the_ID(), 'type' => 'products', 'layout' => 'displayproduct'), TRUE);";
          }
          elseif ($type == 'manufacturers') {
            $replacement = "wde_front_end(array('manufacturer_id' => get_the_ID(), 'type' => 'manufacturers', 'layout' => 'displaymanufacturer'));";
          }
          elseif ($type == 'categories') {
            $replacement = "wde_front_end(array('type' => 'categories', 'layout' => 'displaycategory'));";
          }
          $new_content = preg_replace('/' . $start_with . '.*' . $end_with . '/', $replacement, $content);
          // If content changed.
          if ($new_content != NULL && $new_content != $content) {
            // Remove comments.
            $new_content = preg_replace('/comments_template\(.*\);/', '', $new_content);
            // Remove category title, description.
            $new_content = preg_replace('/the_archive_title\(.*\);/', '', $new_content);
            $new_content = preg_replace('/the_archive_description\(.*\);/', '', $new_content);
            $new_content = preg_replace('/<header(?s).*<\/header>/', '', $new_content);
            // $path = self::$path . DS . $type . '_' . self::$theme_name . '.php';
            $path = wde_get_template($type);
            if (!file_exists($path) || !$auto) {
              $success = copy($source, $path);
              if ($success !== FALSE) {
                $handle = fopen($path, 'w');
                $success = fwrite($handle, $new_content);
                fclose($handle);
                if ($success === FALSE) {
                  $message_id = 32;
                }
                $message_id = 31;
              }
              else {
                $message_id = 35;
              }
            }
          }
          else {
            $message_id = 32;
          }
        }
        else {
          $message_id = 35;
        }
      }
    }
    if (!$auto) {
      WDFHelper::redirect('', '', '', 'tab_index=' . WDFInput::get('tab_index', 'products'), $message_id);
    }
  }

  // Create external folder and copy template files from internal directory for templates if not exist.
  public static function make_folder() {
    $message_id = '';
    $templates_external_folder = str_replace(array('/', '\\'), DS, WP_PLUGIN_DIR . DS . WD_E_PLUGIN_NAME . '-templates');
    if (!is_dir($templates_external_folder)) {
      $source = self::$path;
      if (file_exists($source)) {
        function recurse_copy($src, $dst) {
          $dir = opendir($src);
          $success = @mkdir($dst, 0777);
          if ($success) {
            while(FALSE !== ($file = readdir($dir))) {
              if (($file != '.') && ($file != '..')) {
                if (is_dir($src . DS . $file)) {
                  $success = recurse_copy($src . DS . $file, $dst . DS . $file);
                }
                else {
                  $copied = copy($src . DS . $file, $dst . DS . $file);
                  if (!$copied) {
                    $success = FALSE;
                  }
                }
              }
            }
          }
          closedir($dir);
          return $success;
        }
        $success = recurse_copy($source, $templates_external_folder);
        if ($success) {
          self::$path = $templates_external_folder;
        }
        else {
          $message_id = 32;
        }
      }
      else {
        $message_id = 32;
      }
    }
    else {
      $types = array('products', 'manufacturers', 'categories');
      $source = str_replace(array('/', '\\'), DS, WD_E_DIR . '/frontend/views/templates');
      $dst = $templates_external_folder;
      $success = TRUE;
      foreach ($types as $type) {
        if (!file_exists($dst . DS . $type . '_backup.php')) {
          $copied = copy($source . DS . $type . '_backup.php', $dst . DS . $type . '.php');
          $backup_copied = copy($source . DS . $type . '_backup.php', $dst . DS . $type . '_backup.php');
          if (!$copied || !$backup_copied) {
            $success = FALSE;
          }
        }
      }
      if ($success) {
        $message_id = 31;
      }
      else {
        $message_id = 32;
      }
    }
    return $message_id;
  }
}