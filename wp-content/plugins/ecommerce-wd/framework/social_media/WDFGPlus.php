<?php

defined('ABSPATH') || die('Access Denied');

class WDFGPlus {
  
  /**
   * Generate google plus +1 button
   *
   * @param    $url    string    url to plus
   * @param    $options    array    options
   *
   * @return    string    html content
   */
  public static function plus_button($url = '', $options = null) {
    // if ($url == '') {
        // $url = WDFUrl::get_self_url();
    // }
    $this_options = array('size' => 'medium', 'annotation' => 'inline', 'width' => '300',);
    if ($options != null) {
        $this_options = array_merge($this_options, $options);
    }
    ob_start();
    ?>
    <div
        class="g-plusone"
        data-size="<?php echo $this_options['size'] ?>"
        data-annotation="<?php echo $this_options['annotation'] ?>"
        data-width="<?php echo $this_options['width'] ?>"
        data-href="<?php echo $url; ?>">
    </div>
    <?php
    return ob_get_clean();
  }

  /**
   * render google plus elements
   */
  public static function render() {
    ?>
    <script type="text/javascript">
      (function () {
          var po = document.createElement('script');
          po.type = 'text/javascript';
          po.async = true;
          po.src = 'https://apis.google.com/js/platform.js';
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(po, s);
      })();
    </script>
  <?php
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}