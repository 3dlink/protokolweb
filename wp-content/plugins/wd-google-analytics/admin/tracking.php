<?php
$custom_dimensions = $gawd_client->get_custom_dimensions_tracking();
$gawd_settings = get_option('gawd_settings');
require_once(GAWD_DIR . '/gawd_class.php');
$domain = GAWD::get_domain(esc_html(get_option('siteurl')));
$all_users = get_users();
$compare_users = array();
foreach ($all_users as $user) {
    $compare_users[] = $user->user_nicename;
}
$gawd_user_data = get_option('gawd_user_data');
$ua_code = $gawd_user_data['default_webPropertyId'];



$cross_domain_list = '';
if (isset($gawd_settings['enable_cross_domain']) && isset($gawd_settings['cross_domains']) && $gawd_settings['cross_domains'] != '' && $gawd_settings['enable_cross_domain'] != '') {
    $cross_domain_list = $gawd_settings['cross_domains'];
}
$gawd_outbound = isset($gawd_settings['gawd_outbound']) ? $gawd_settings['gawd_outbound'] : '';

?>


<script>
<?php if ('on' == $gawd_settings['gawd_tracking_enable']) { ?>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', '<?php echo $ua_code ?>', 'auto', {'siteSpeedSampleRate': '<?php echo isset($gawd_settings['site_speed_rate']) ? $gawd_settings['site_speed_rate'] : 1; ?>' <?php echo $cross_domain_list != '' ? ",'allowLinker' : true" : ""; ?>});
    <?php if ($cross_domain_list != '') { ?>
            ga('require', 'linker');
            ga('linker:autoLink', [' <?php echo $cross_domain_list; ?>']);
    <?php }; ?>

    <?php if (isset($gawd_settings['gawd_anonymize']) && 'on' == $gawd_settings['gawd_anonymize']) : ?>
            ga('set', 'anonymizeIp', true);
        <?php
    endif;
    if ($custom_dimensions != "no_custom_dimensions_exist") {
        foreach ($custom_dimensions as $custom_dimension) {
            $optname = 'gawd_custom_dimension_' . str_replace(' ', '_', $custom_dimension['name']);
            if ($gawd_settings[$optname] == 'on') {
                switch ($custom_dimension['name']) {
                    case 'Logged in': {
                            if (GAWD_google_client::gawd_cd_logged_in()) {
                                echo "ga('set', 'dimension" . $custom_dimension['id'] . "', '" . GAWD_google_client::gawd_cd_logged_in() . "');\n";
                            }
                            break;
                        }
                    case 'Post type': {
                            if (GAWD_google_client::gawd_cd_post_type()) {
                                echo "ga('set', 'dimension" . $custom_dimension['id'] . "', '" . GAWD_google_client::gawd_cd_post_type() . "');\n";
                            }
                            break;
                        }
                    case 'Author': {
                            if (GAWD_google_client::gawd_cd_author()) {
                                echo "ga('set', 'dimension" . $custom_dimension['id'] . "', '" . GAWD_google_client::gawd_cd_author() . "');\n";
                            }
                            break;
                        }
                    case 'Category': {
                            if (GAWD_google_client::gawd_cd_category()) {
                                echo "ga('set', 'dimension" . $custom_dimension['id'] . "', '" . GAWD_google_client::gawd_cd_category() . "');\n";
                            }
                            break;
                        }
                    case 'Published Month': {
                            if (GAWD_google_client::gawd_cd_published_month()) {
                                echo "ga('set', 'dimension" . $custom_dimension['id'] . "', '" . GAWD_google_client::gawd_cd_published_month() . "');\n";
                            }
                            break;
                        }
                    case 'Published Year': {
                            if (GAWD_google_client::gawd_cd_published_year()) {
                                echo "ga('set', 'dimension" . $custom_dimension['id'] . "', '" . GAWD_google_client::gawd_cd_published_year() . "');\n";
                            }
                            break;
                        }
                    case 'Tags': {
                            if (GAWD_google_client::gawd_cd_tags()) {
                                echo "ga('set', 'dimension" . $custom_dimension['id'] . "', '" . GAWD_google_client::gawd_cd_tags() . "');\n";
                            }
                            break;
                        }
                    default: break;
                }
            }
        }
    }
    ?>
        ga('send', 'pageview');
<?php } ?>
    jQuery(document).ready(function () {
        jQuery(window).load(function () {
<?php if (isset($gawd_settings['gawd_file_formats']) && $gawd_settings['gawd_file_formats'] != '') { ?>
                //Track Downloads
                jQuery('a').filter(function () {
                    return this.href.match(/.*\.(<?php echo esc_js($gawd_settings['gawd_file_formats']); ?>)(\?.*)?$/);
                }).click(function (e) {
                    ga('send', 'event', 'download', 'click', this.href<?php
    if (isset($gawd_settings['exclude_events']) && $gawd_settings['exclude_events']) {
        echo ", {'nonInteraction': 1}";
    }
    ?>);
                });

                //Track Mailto
                jQuery('a[href^="mailto"]').click(function (e) {
                    ga('send', 'event', 'email', 'send', this.href<?php
    if (isset($gawd_settings['exclude_events']) && $gawd_settings['exclude_events']) {
        echo ", {'nonInteraction': 1}";
    }
    ?>);
                });
  <?php } 
      if($gawd_outbound != ''){
        if (isset($domain) && $domain ) { ?>
                      //Track Outbound Links
                      jQuery('a[href^="http"]').filter(function () {
                          if (!this.href.match(/.*\.(<?php echo esc_js(isset($gawd_settings['gawd_file_formats']) && $gawd_settings['gawd_file_formats'] != ''); ?>)(\?.*)?$/)) {
                              if (this.href.indexOf('<?php echo $domain; ?>') == -1) {
                                  return this.href
                              }
                              ;
                          }
                      }).click(function (e) {
                          ga('send', 'event', 'outbound', 'click', this.href<?php
          if (isset($gawd_settings['exclude_events']) && $gawd_settings['exclude_events']) {
              echo ", {'nonInteraction': 1}";
          }
          ?>);
         });
    <?php } ?>
      <?php } ?>
        });
    });

</script>