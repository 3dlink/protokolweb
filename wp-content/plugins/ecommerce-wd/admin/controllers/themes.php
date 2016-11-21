<?php
defined('ABSPATH') || die('Access Denied');

class EcommercewdControllerThemes extends EcommercewdController {
  public function __construct() {
    parent::__construct();
  }

  public function edit_basic() {
    parent::display();
  }

  public function apply() {
    $row = $this->store_input_in_row();
    WDFHelper::redirect('', 'edit', $row->id, 'tab_index=' . WDFInput::get('tab_index'), 1);
  }

  public function save2copy() {
    WDFInput::set('id', '');
    WDFInput::set('basic', 0);
    WDFInput::set('default', 0);

    $this->prepare_checkboxes_for_save();

    $row = $this->store_input_in_row();
    WDFHelper::redirect('', 'edit', $row->id, 'tab_index=' . WDFInput::get('tab_index'), 1);
  }

  public function save2new() {
    $this->prepare_checkboxes_for_save();

    $row = $this->store_input_in_row();
    WDFHelper::redirect('', 'add', '', '', 1);
  }

  protected function store_input_in_row() {
    $this->prepare_checkboxes_for_save();
    $row = parent::store_input_in_row();
    $this->store_json_data($row->id);
    return $row;
  }

  private function store_json_data($id) {
    $fields_arr = array(
      'main_font_size', 'main_font_family', 'main_font_weight',
      'header_font_size', 'header_font_family', 'header_font_weight',
      'subtext_font_size', 'subtext_font_family', 'subtext_font_weight',
      'input_font_size', 'input_font_family', 'input_font_weight',
      'button_font_size', 'button_font_family', 'button_font_weight',
      'product_name_font_size', 'product_name_font_family', 'product_name_font_weight',
      'product_procreator_font_size', 'product_procreator_font_family', 'product_procreator_font_weight',
      'product_price_font_size', 'product_price_font_family', 'product_price_font_weight',
      'product_market_price_font_size', 'product_market_price_font_family', 'product_market_price_font_weight',
      'product_code_font_size', 'product_code_font_family', 'product_code_font_weight',
      'navbar_badge_font_size', 'navbar_badge_font_family', 'navbar_badge_font_weight',
      'navbar_dropdown_link_font_size', 'navbar_dropdown_link_font_family', 'navbar_dropdown_link_font_weight',
      'rating_star_font_size',
      'label_font_size', 'label_font_family', 'label_font_weight',
      'alert_font_size', 'alert_font_family', 'alert_font_weight',
      'breadcrumb_font_size', 'breadcrumb_font_family', 'breadcrumb_font_weight',
      'pill_link_font_size', 'pill_link_font_family', 'pill_link_font_weight',
      'tab_link_font_size', 'tab_link_font_family', 'tab_link_font_weight',
      'pagination_font_size', 'pagination_font_family', 'pagination_font_weight',
      'pager_font_size', 'pager_font_family', 'pager_font_weight',
      
      'rounded_corners', 'content_main_color', 'header_content_color', 'subtext_content_color', 'input_content_color', 'input_bg_color', 'input_border_color', 'input_focus_border_color', 'input_has_error_content_color', 'button_default_content_color', 'button_default_bg_color', 'button_default_border_color', 'button_primary_content_color', 'button_primary_bg_color', 'button_primary_border_color', 'button_success_content_color', 'button_success_bg_color', 'button_success_border_color', 'button_info_content_color', 'button_info_bg_color', 'button_info_border_color', 'button_warning_content_color', 'button_warning_bg_color', 'button_warning_border_color', 'button_danger_content_color', 'button_danger_bg_color', 'button_danger_border_color', 'button_link_content_color', 'divider_color', 'navbar_bg_color', 'navbar_border_color', 'navbar_link_content_color', 'navbar_link_hover_content_color', 'navbar_link_open_content_color', 'navbar_link_open_bg_color', 'navbar_badge_content_color', 'navbar_badge_bg_color', 'navbar_dropdown_link_content_color', 'navbar_dropdown_link_hover_content_color', 'navbar_dropdown_link_hover_background_content_color', 'navbar_dropdown_divider_color', 'navbar_dropdown_background_color', 'navbar_dropdown_border_color', 'modal_backdrop_color', 'modal_bg_color', 'modal_border_color', 'modal_dividers_color', 'panel_user_data_bg_color', 'panel_user_data_border_color', 'panel_user_data_footer_bg_color', 'panel_product_bg_color', 'panel_product_border_color', 'panel_product_footer_bg_color', 'well_bg_color', 'well_border_color', 'rating_star_type', 'rating_star_color', 'rating_star_bg_color', 'label_content_color', 'label_bg_color', 'alert_info_content_color', 'alert_info_bg_color', 'alert_info_border_color', 'alert_danger_content_color', 'alert_danger_bg_color', 'alert_danger_border_color', 'breadcrumb_content_color', 'breadcrumb_bg_color', 'pill_link_content_color', 'pill_link_hover_content_color', 'pill_link_hover_bg_color', 'tab_link_content_color', 'tab_link_hover_content_color', 'tab_link_hover_bg_color', 'tab_link_active_content_color', 'tab_link_active_bg_color', 'tab_border_color', 'pagination_content_color', 'pagination_bg_color', 'pagination_hover_content_color', 'pagination_hover_bg_color', 'pagination_active_content_color', 'pagination_active_bg_color', 'pagination_border_color', 'pager_content_color', 'pager_bg_color', 'pager_border_color', 'product_name_color', 'product_category_color', 'product_manufacturer_color', 'product_price_color', 'product_market_price_color', 'products_filters_position', 'products_count_in_page', 'products_option_columns', 'product_description_color', 'product_description_font_size', 'product_description_font_family', 'product_description_font_weight', 
      'multiple_product_name_color', 'multiple_product_name_font_size', 'multiple_product_name_font_family', 'multiple_product_name_font_weight', 'multiple_product_price_color', 'multiple_product_price_font_size', 'multiple_product_price_font_family', 'multiple_product_price_font_weight', 'multiple_product_market_price_color', 'multiple_product_market_price_font_size', 'multiple_product_market_price_font_family', 'multiple_product_market_price_font_weight', 'multiple_product_description_color', 'multiple_product_description_font_size', 'multiple_product_description_font_family', 'multiple_product_description_font_weight', 
      'product_model_color','product_code_color',
    );
    $datas = array(
      'products_thumbs_view' => __('Thumbnail view', 'wde'),
      'products_masonry_view' => __('Masonry view', 'wde'),
      'products_cheese_view' => __('Cheese view', 'wde'),
      'products_blog_style_view' => __('Blog style view', 'wde'),
      'products_list_view' => __('List view', 'wde'),
      'products_quick_view' => __('Quick view', 'wde'),
      'product_view' => __('Product view', 'wde'),
    );
    $data_options = array(
      '_show_image' => array('name' => __('Image', 'wde'), 'disabled' => array()),
      '_show_label' => array('name' => __('Label', 'wde'), 'disabled' => array()),
      '_show_name' => array('name' => __('Name', 'wde'), 'disabled' => array()),
      '_show_rating' => array('name' => __('Rating', 'wde'), 'disabled' => array()),
      '_show_category' => array('name' => __('Category', 'wde'), 'disabled' => array('products_thumbs_view', 'products_masonry_view', 'products_cheese_view', 'products_blog_style_view', 'products_list_view')),
      '_show_manufacturer' => array('name' => __('Manufacturer', 'wde'), 'disabled' => array('products_thumbs_view', 'products_masonry_view', 'products_cheese_view', 'products_blog_style_view', 'products_list_view')),
      '_show_model' => array('name' => __('Model', 'wde'), 'disabled' => array('products_thumbs_view', 'products_masonry_view', 'products_cheese_view', 'products_blog_style_view', 'products_list_view')),
      '_show_price' => array('name' => __('Price', 'wde'), 'disabled' => array()),
      '_show_market_price' => array('name' => __('Market price', 'wde'), 'disabled' => array()),
      '_show_description' => array('name' => __('Description', 'wde'), 'disabled' => array()),
      '_show_button_quick_view' => array('name' => __('Quick view button', 'wde'), 'disabled' => array('products_quick_view', 'product_view')),
      '_show_button_compare' => array('name' => __('Compare button', 'wde'), 'disabled' => array()),
      '_show_button_write_review' => array('name' => __('Write review button', 'wde'), 'disabled' => array('products_thumbs_view', 'products_masonry_view', 'products_cheese_view', 'products_blog_style_view', 'products_list_view', 'products_quick_view')),
      '_show_button_buy_now' => array('name' => __('Buy now button', 'wde'), 'disabled' => array()),
      '_show_button_add_to_cart' => array('name' => __('Add to cart button', 'wde'), 'disabled' => array()),
      '_show_social_buttons' => array('name' => __('Social buttons', 'wde'), 'disabled' => array('products_thumbs_view', 'products_masonry_view', 'products_cheese_view', 'products_blog_style_view', 'products_list_view', 'products_quick_view')),
      '_show_parameters' => array('name' => __('Parameters', 'wde'), 'disabled' => array('products_thumbs_view', 'products_masonry_view', 'products_cheese_view', 'products_blog_style_view', 'products_list_view', 'products_quick_view')),
      '_show_shipping_info' => array('name' => __('Shipping info', 'wde'), 'disabled' => array('products_thumbs_view', 'products_masonry_view', 'products_cheese_view', 'products_blog_style_view', 'products_list_view', 'products_quick_view')),
      '_show_reviews' => array('name' => __('Reviews', 'wde'), 'disabled' => array('products_thumbs_view', 'products_masonry_view', 'products_cheese_view', 'products_blog_style_view', 'products_list_view', 'products_quick_view')),
      '_show_related_products' => array('name' => __('Related products', 'wde'), 'disabled' => array('products_thumbs_view', 'products_masonry_view', 'products_cheese_view', 'products_blog_style_view', 'products_list_view', 'products_quick_view')),
    );
    foreach ($datas as $key => $dat) {
      foreach ($data_options as $option_key => $option) {
        if (!in_array($key, $option['disabled'])) {
          $fields_arr[] = $key . $option_key;
        }
      }
    }
    $data = array();
    foreach ($fields_arr as $field) {
      $data[$field] = WDFInput::get($field, '');
    }
    global $wpdb;
    $wpdb->update($wpdb->prefix . 'ecommercewd_themes', array('data' => json_encode($data)), array('id' => $id));
  }

  private function prepare_checkboxes_for_save() {
    $checkboxes = array(
      'products_thumbs_view_show_image', 'products_thumbs_view_show_label', 'products_thumbs_view_show_name', 'products_thumbs_view_show_rating', 'products_thumbs_view_show_price', 'products_thumbs_view_show_market_price', 'products_thumbs_view_show_description', 'products_thumbs_view_show_button_quick_view', 'products_thumbs_view_show_button_compare', 'products_thumbs_view_show_button_buy_now', 'products_thumbs_view_show_button_add_to_cart',
      'products_list_view_show_image', 'products_list_view_show_label', 'products_list_view_show_name', 'products_list_view_show_rating', 'products_list_view_show_price', 'products_list_view_show_market_price', 'products_list_view_show_description', 'products_list_view_show_button_quick_view', 'products_list_view_show_button_compare', 'products_list_view_show_button_buy_now', 'products_list_view_show_button_add_to_cart',
      'products_quick_view_show_image', 'products_quick_view_show_label', 'products_quick_view_show_name', 'products_quick_view_show_rating', 'products_quick_view_show_category', 'products_quick_view_show_manufacturer', 'products_quick_view_show_price', 'products_quick_view_show_market_price', 'products_quick_view_show_description', 'products_quick_view_show_button_compare', 'products_quick_view_show_button_buy_now', 'products_quick_view_show_button_add_to_cart',
      'product_view_show_image', 'product_view_show_label', 'product_view_show_name', 'product_view_show_rating', 'product_view_show_category', 'product_view_show_manufacturer', 'product_view_show_price', 'product_view_show_market_price', 'product_view_show_button_compare', 'product_view_show_button_write_review', 'product_view_show_button_buy_now', 'product_view_show_button_add_to_cart', 'product_view_show_description', 'product_view_show_social_buttons', 'product_view_show_parameters', 'product_view_show_shipping_info', 'product_view_show_reviews', 'product_view_show_related_products');
    foreach ($checkboxes as $checkbox) {
      WDFInput::set($checkbox, WDFInput::get($checkbox, 0, 'int'));
    }
  }
}