<?php

defined('ABSPATH') || die('Access Denied');
 
class WDFFb {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private static $inited;

  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  /**
   * Init fb
   *
   * @param    $app_id    string    fb application id
   */
  public static function init($app_id = '', $img_url = '') {
    if (self::$inited != true) {
      ?>
      <script>
        jQuery("head").append()
      </script>
      <div id="fb-root"></div>
      <script>
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1<?php echo $app_id != '' ? '&appId=' . $app_id : ''; ?>";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>
      <?php
    }
  }

  /**
   * Generate like button
   *
   * @param    $url    string    url to like (current page url by default)
   * @param    $img    string    img url to show when shared
   *
   * @return    string    html content
   */
  public static function like_button($url = '', $img = '') {
    // if ($url == '') {
        // $url = WDFUrl::get_self_url();
    // }
    // if ($img != '') {
        // WDFDocument::set_meta_property('og:image', urlencode($img));
    // }
    ob_start();
    ?>
    <div class="fb-like"
         data-href="<?php echo $url; ?>"
         data-layout="button_count"
         data-action="like"
         data-show-faces="false"
         data-share="false">
    </div>
    <?php
    return ob_get_clean();
  }

  /**
   * comments box
   *
   * @param    $url    string    url to tweet
   * @param    $options    array    options
   *
   * @return    string    html content
   */
  public static function comments($url = '', $options = null) {
    $this_options = array('num_posts' => 5, 'color_scheme' => 'dark', 'order_by' => 'time', 'width' => 550);
    if ($options != null) {
      $this_options = array_merge($this_options, $options);
    }
    ob_start();
    ?>
    <div
        class="fb-comments"
        data-href="<?php echo $url; ?>"
        data-numposts="<?php echo $this_options['num_posts']; ?>"
        data-order-by="<?php echo $this_options['order_by']; ?>"
        data-colorscheme="<?php echo $this_options['color_scheme']; ?>"
        data-width="<?php echo $this_options['width']; ?>">
    </div>
    <?php
    return ob_get_clean();
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}