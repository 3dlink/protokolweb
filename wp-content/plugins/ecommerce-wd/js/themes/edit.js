


////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
  // dropdown
  jQuery("[data-toggle=bs_dropdown]").parent().on("hide.bs.dropdown", function () {
    return false;
  });
  jQuery("[data-toggle=bs_dropdown]").bs_dropdown('toggle');

  new WdBsStarRater(jQuery(".preview_rating_stars"));

  updateRoundCorners();
  initColors();
  jQuery("#wd_shop_container input[onchange^=onFontChange]").each(function () {
    jQuery(this).trigger("onchange");
  });
});

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////

function onFontChange(prefix, preview) {
  var size = jQuery("#" + prefix + "_font_size").val();
  var family = jQuery("#" + prefix + "_font_family").val();
  var weight = jQuery("#" + prefix + "_font_weight").val();
  if (size) {
    jQuery(preview).css({
      fontSize: size
    });
  }
  else {
    jQuery(preview).css({
      fontSize: 'inherit'
    });
  }
  preview = preview.replace("glyphicon", "");
  if (family && preview.indexOf("glyphicon") == -1) {
    jQuery(preview).css({
      fontFamily: family
    });
  }
  if (weight) {
    jQuery(preview).css({
      fontWeight: weight
    });
  }
}

function initColors() {
    // content main color
    updateContentMainColors();

    // header
    updateHeaderColors();
    // subtext
    updateSubtextColors();

    // input
    updateInputColors();

    // buttons
    updateButtonColors('default');
    updateButtonColors('primary');
    updateButtonColors('success');
    /*updateButtonColors('info');
     updateButtonColors('warning');
     updateButtonColors('danger');*/
    updateButtonLinkColors();

    // divider
    updateDividerColors();

    // navbar
    updateNavbarColors();

    // modal
    updateModalColors();

    // panel user data
    updatePanelUserDataColors();

    // panel product
    updatePanelProductColors();

    // well
    updateWellColors();

    // rating stars
    updateRatingStarsColors();

    // label
    updateLabelColors();

    // alerts
    updateAlertColors();

    // breadcrumb
    updateBreadcrumbColors();

    // pills
    // updatePillsColors();

    // tabs
    updateTabsColors();

    // pagination
    updatePaginationColors();

    // pager
    updatePagerColors();

    // product
    updateProductColors();

    // product
    updateMultipleProductColors();
}

function updateRoundCorners() {
    var roundCorners = jQuery("form[name=adminForm] input[name=rounded_corners]:checked").val() == 1 ? true : false;
    if (roundCorners == true) {
        jQuery(".col_preview #wd_shop_container *").removeClass("wd_no_round_corners");
    } else {
        jQuery(".col_preview #wd_shop_container *").addClass("wd_no_round_corners");
    }
}

function updateContentMainColors() {
    var jq_preview_bs_containers = jQuery(".preview_text");
    jq_preview_bs_containers.css("color", adminFormGet("content_main_color"));
}

function updateHeaderColors() {
    var jq_header = jQuery(".preview_header");
    var color = adminFormGet("header_content_color");
    var borderColorRgb = hexToRgb(color);
    var strBorderColor = "rgba(" + borderColorRgb["r"] + ", " + borderColorRgb["g"] + ", " + borderColorRgb["b"] + ", 0.15" + ")";
    jq_header.css("color", color);
    jq_header.css("borderColor", strBorderColor);
}

function updateSubtextColors() {
    var jq_subtext = jQuery(".preview_subtext");
    jq_subtext.css("color", adminFormGet("subtext_content_color"));
}

function updateInputColors() {
    var jq_input = jQuery(".preview_form_group:not(.has-error) .form-control");
    var jq_addon = jQuery(".preview_form_group:not(.has-error) .input-group-addon");

    jq_input.off("focus");
    jq_input.off("blur");

    jQuery(this).css("-webkit-box-shadow", "none");
    jQuery(this).css("box-shadow", "none");

    var contentColor = adminFormGet("input_content_color");
    var bgColor = adminFormGet("input_bg_color");
    var borderColor = adminFormGet("input_border_color");
    var focusBorderColor = adminFormGet("input_focus_border_color");
    var focusBorderColorRgba = hexToRgb(focusBorderColor);
    var strFocusBorderColorRgba = "rgba(" + focusBorderColorRgba["r"] + ", " + focusBorderColorRgba["g"] + ", " + focusBorderColorRgba["b"] + ", 0.6";
    var addonContentColor = darkenColor(borderColor, 20);
    var addonBgColor = lightenColor(borderColor, 35);
    var addonBorderColor = borderColor;

    jq_input.css({color: contentColor, backgroundColor: bgColor, borderColor: borderColor});
    jq_input.on("focus", function () {
        jQuery(this).css("borderColor", focusBorderColor);
        jQuery(this).css("-webkit-box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px " + strFocusBorderColorRgba);
        jQuery(this).css("box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px " + strFocusBorderColorRgba);
    });
    jq_input.on("blur", function () {
        jQuery(this).css("borderColor", borderColor);
        jQuery(this).css("-webkit-box-shadow", "none");
        jQuery(this).css("box-shadow", "none");
    });
    jq_addon.css({color: addonContentColor, backgroundColor: addonBgColor, borderColor: addonBorderColor});

    // has error
    var jq_inputHasError = jQuery(".preview_form_group.has-error .form-control");
    var jq_addonHasError = jQuery(".preview_form_group.has-error .input-group-addon");

    jq_inputHasError.off("focus");
    jq_inputHasError.off("blur");

    jQuery(this).css("-webkit-box-shadow", "none");
    jQuery(this).css("box-shadow", "none");

    var hasErrorContentColor = adminFormGet("input_has_error_content_color");
    var hasErrorBorderColor = hasErrorContentColor;
    var hasErrorFocusBorderColor = darkenColor(hasErrorContentColor, 15);
    var hasErrorFocusBorderColorRgba = hexToRgb(hasErrorFocusBorderColor);
    var strHasErrorFocusBorderColorRgba = "rgba(" + hasErrorFocusBorderColorRgba["r"] + ", " + hasErrorFocusBorderColorRgba["g"] + ", " + hasErrorFocusBorderColorRgba["b"] + ", 0.6";
    var hasErrorAddonContentColor = darkenColor(hasErrorBorderColor, 20);
    var hasErrorAddonBgColor = lightenColor(hasErrorBorderColor, 35);
    var hasErrorAddonBorderColor = hasErrorBorderColor;

    jq_inputHasError.css({color: hasErrorContentColor, backgroundColor: bgColor, borderColor: hasErrorBorderColor});
    jq_inputHasError.on("focus", function () {
        jQuery(this).css("borderColor", hasErrorFocusBorderColor);
        jQuery(this).css("-webkit-box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px " + strHasErrorFocusBorderColorRgba);
        jQuery(this).css("box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px " + strHasErrorFocusBorderColorRgba);
    });
    jq_inputHasError.on("blur", function () {
        jQuery(this).css("borderColor", hasErrorBorderColor);
        jQuery(this).css("-webkit-box-shadow", "none");
        jQuery(this).css("box-shadow", "none");
    });
    jq_addonHasError.css({color: hasErrorAddonContentColor, backgroundColor: hasErrorAddonBgColor, borderColor: hasErrorAddonBorderColor});
}

function updateButtonColors(type) {
    var jq_button = jQuery(".preview_button_" + type);

    jq_button.off("mouseenter");
    jq_button.off("mouseleave");

    var contentColor = adminFormGet("button_" + type + "_content_color");
    var bgColor = adminFormGet("button_" + type + "_bg_color");
    var borderColor = adminFormGet("button_" + type + "_border_color");

    jq_button.css("color", contentColor);
    jq_button.css("backgroundColor", bgColor);
    jq_button.css("borderColor", borderColor);
    jq_button.on("mouseenter", function () {
        jQuery(this).css("backgroundColor", darkenColor(bgColor, 8));
        jQuery(this).css("borderColor", darkenColor(borderColor, 12));
    });
    jq_button.on("mouseleave", function () {
        jQuery(this).css("backgroundColor", bgColor);
        jQuery(this).css("borderColor", borderColor);
    });
}

function updateButtonLinkColors() {
    var jq_button = jQuery(".preview_button_link");

    jq_button.off("mouseenter");
    jq_button.off("mouseleave");

    var contentColor = adminFormGet("button_link_content_color");

    jq_button.css("color", contentColor);
    jq_button.on("mouseenter", function () {
        jQuery(this).css("color", darkenColor(contentColor, 15));
    });
    jq_button.on("mouseleave", function () {
        jQuery(this).css("color", contentColor);
    });
}

function updateDividerColors() {
    var jq_divider = jQuery(".preview_divider");
    jq_divider.css("backgroundColor", adminFormGet("divider_color"));
}

function updateNavbarColors() {
    var jq_navbar = jQuery(".preview_navbar");

    jq_navbar.find("a").off("mouseenter");
    jq_navbar.find("a").off("mouseleave");

    var bgColor = adminFormGet("navbar_bg_color");
    var borderColor = adminFormGet("navbar_border_color");
    var linkContentColor = adminFormGet("navbar_link_content_color");
    var linkHoverContentColor = adminFormGet("navbar_link_hover_content_color");
    var linkOpenContentColor = adminFormGet("navbar_link_open_content_color");
    var linkOpenBgColor = adminFormGet("navbar_link_open_bg_color");
    var badgeContentColor = adminFormGet("navbar_badge_content_color");
    var badgeBgColor = adminFormGet("navbar_badge_bg_color");
    var dropdownLinkContentColor = adminFormGet("navbar_dropdown_link_content_color");
    var dropdownLinkHoverContentColor = adminFormGet("navbar_dropdown_link_hover_content_color");
    var dropdownLinkHoverBackgroundContentColor = adminFormGet("navbar_dropdown_link_hover_background_content_color");
    var dropdownDividerColor = adminFormGet("navbar_dropdown_divider_color");
    var dropdownBackgroundColor = adminFormGet("navbar_dropdown_background_color");
    var dropdownBorderColor = adminFormGet("navbar_dropdown_border_color");

    jq_navbar.css("backgroundColor", bgColor);
    jq_navbar.css("borderColor", borderColor);
    jq_navbar.find(".navbar-nav > li:not(.open) > a").css("color", linkContentColor);
    jq_navbar.find(".navbar-nav > li:not(.open) > a").on("mouseenter", function () {
        jQuery(this).css("color", linkHoverContentColor);
    });
    jq_navbar.find(".navbar-nav > li:not(.open) > a").on("mouseleave", function () {
        jQuery(this).css("color", linkContentColor);
    });
    jq_navbar.find(".navbar-nav > li.open > a").css({color: linkOpenContentColor, backgroundColor: linkOpenBgColor});
    jq_navbar.find(".navbar-nav > li.open > a .caret").css({borderTopColor: linkOpenContentColor, borderBottomColor: linkOpenContentColor});
    jq_navbar.find(".badge").css({color: badgeContentColor, backgroundColor: badgeBgColor});
    jq_navbar.find(".bs_dropdown-menu").css({backgroundColor: dropdownBackgroundColor, borderColor: dropdownBorderColor});
    jq_navbar.find(".bs_dropdown-menu > li > a").css({color: dropdownLinkContentColor, backgroundColor: "transparent"});
    jq_navbar.find(".bs_dropdown-menu > li > a").on("mouseenter", function () {
        jQuery(this).css({color: dropdownLinkHoverContentColor, backgroundColor: dropdownLinkHoverBackgroundContentColor});
        jQuery(this).find(".caret").css({borderTopColor: dropdownLinkHoverContentColor, borderBottomColor: dropdownLinkHoverContentColor});
    });
    jq_navbar.find(".bs_dropdown-menu > li > a").on("mouseleave", function () {
        jQuery(this).css({color: dropdownLinkContentColor, backgroundColor: "transparent"});
        jQuery(this).find(".caret").css({borderTopColor: dropdownLinkContentColor, borderBottomColor: dropdownLinkContentColor});
    });
    jq_navbar.find(".bs_dropdown-menu > li.divider").css({backgroundColor: dropdownDividerColor});
}

function updateModalColors() {
    var jq_modal = jQuery(".preview_modal");

    var backdropColor = adminFormGet("modal_backdrop_color");
    var bgColor = adminFormGet("modal_bg_color");
    var borderColor = adminFormGet("modal_border_color");
    var dividersColor = adminFormGet("modal_dividers_color");

    jq_modal.find(".modal-backdrop").css("backgroundColor", backdropColor);
    jq_modal.find(".modal-content").css({backgroundColor: bgColor, borderColor: borderColor});
    jq_modal.find(".modal-header, .modal-footer").css("borderColor", dividersColor);
}

function updatePanelUserDataColors() {
    var jq_panel = jQuery(".preview_panel_user_data");

    var bgColor = adminFormGet("panel_user_data_bg_color");
    var borderColor = adminFormGet("panel_user_data_border_color");
    var footerBgColor = adminFormGet("panel_user_data_footer_bg_color");

    jq_panel.css({backgroundColor: bgColor, borderColor: borderColor});
    jq_panel.find(".panel-footer").css({backgroundColor: footerBgColor, borderColor: borderColor});
}

function updatePanelProductColors() {
    var jq_panel = jQuery(".preview_panel_product");

    var bgColor = adminFormGet("panel_product_bg_color");
    var borderColor = adminFormGet("panel_product_border_color");
    var footerBgColor = adminFormGet("panel_product_footer_bg_color");

    jq_panel.css({backgroundColor: bgColor, borderColor: borderColor});
    jq_panel.find(".panel-footer").css({backgroundColor: footerBgColor, borderColor: borderColor});
}

function updateWellColors() {
    var jq_well = jQuery(".preview_well");

    var bgColor = adminFormGet("well_bg_color");
    var borderColor = adminFormGet("well_border_color");

    jq_well.css({backgroundColor: bgColor, borderColor: borderColor});
}

function updateRatingStarsColors() {
    var jq_ratingStarContainers = jQuery(".preview_rating_stars .wd_bs_rater_stars_list li");

    var starColor = adminFormGet("rating_star_color");
    var starBgColor = adminFormGet("rating_star_bg_color");

    jq_ratingStarContainers.children(".wd_star_background").css({backgroundColor: darkenColor(starBgColor, 20), textShadow: starBgColor + " 0px 1px 0px"});
    jq_ratingStarContainers.children(".wd_star_color").css({color: starColor, textShadow: darkenColor(starColor, 20) + " 0px 1px 0px"});
}

function updateLabelColors() {
    var jq_labelContainer = jQuery(".preview_label");
    var jq_labels = jq_labelContainer.find(".label");

    var contentColor = adminFormGet("label_content_color");
    var bgColor = adminFormGet("label_bg_color");

    jq_labels.css({color: contentColor, backgroundColor: bgColor});
}

function updateAlertColors() {
    var jq_alertInfo = jQuery(".preview_alert_info");

    var infoContentColor = adminFormGet("alert_info_content_color");
    var infoBgColor = adminFormGet("alert_info_bg_color");
    var infoBorderColor = adminFormGet("alert_info_border_color");

    jq_alertInfo.css({color: infoContentColor, backgroundColor: infoBgColor, borderColor: infoBorderColor});

    var jq_alertDanger = jQuery(".preview_alert_danger");

    var dangerContentColor = adminFormGet("alert_danger_content_color");
    var dangerBgColor = adminFormGet("alert_danger_bg_color");
    var dangerBorderColor = adminFormGet("alert_danger_border_color");

    jq_alertDanger.css({color: dangerContentColor, backgroundColor: dangerBgColor, borderColor: dangerBorderColor});
}

function updateBreadcrumbColors() {
    var jq_breadcrumbContainer = jQuery(".preview_breadcrumb");
    var jq_breadcrumbContent = jq_breadcrumbContainer.find("li");

    var contentColor = adminFormGet("breadcrumb_content_color");
    var bgColor = adminFormGet("breadcrumb_bg_color");

    jq_breadcrumbContent.css({color: contentColor});
    jq_breadcrumbContainer.css({backgroundColor: bgColor});
}

function updatePillsColors() {
    var jq_pillLinks = jQuery(".preview_pills li a");

    jq_pillLinks.off("mouseenter");
    jq_pillLinks.off("mouseleave");

    var contentColor = adminFormGet("pill_link_content_color");
    var hoverContentColor = adminFormGet("pill_link_hover_content_color");
    var hoverBgColor = adminFormGet("pill_link_hover_bg_color");

    jq_pillLinks.css({color: contentColor, background: "transparent"});
    jq_pillLinks.on("mouseenter", function () {
        jQuery(this).css({color: hoverContentColor, backgroundColor: hoverBgColor});
    });
    jq_pillLinks.on("mouseleave", function () {
        jQuery(this).css({color: contentColor, background: "transparent"});
    });
}

function updateTabsColors() {
    var jq_tabs = jQuery(".preview_tabs");
    var jq_tab_inactive_links = jq_tabs.find("li:not(.active) a");
    var jq_tab_active_links = jq_tabs.find("li.active a");

    jq_tab_inactive_links.off("mouseenter");
    jq_tab_inactive_links.off("mouseleave");

    var contentColor = adminFormGet("tab_link_content_color");
    var hoverContentColor = adminFormGet("tab_link_hover_content_color");
    var hoverBgColor = adminFormGet("tab_link_hover_bg_color");
    var activeContentColor = adminFormGet("tab_link_active_content_color");
    var activeBgColor = adminFormGet("tab_link_active_bg_color");
    var borderColor = adminFormGet("tab_border_color");

    jq_tab_inactive_links.css({color: contentColor, background: "transparent", borderColor: "transparent", borderBottomColor: borderColor});
    jq_tab_inactive_links.on("mouseenter", function () {
        jQuery(this).css({color: hoverContentColor, backgroundColor: hoverBgColor});
    });
    jq_tab_inactive_links.on("mouseleave", function () {
        jQuery(this).css({color: contentColor, background: "transparent"});
    });
    jq_tab_active_links.css({color: activeContentColor, background: activeBgColor, borderColor: borderColor, borderBottomColor: "transparent"});
    jq_tabs.css("borderBottomColor", borderColor);
}

function updatePaginationColors() {
    var jq_tab_inactive_links = jQuery(".preview_pagination li:not(.active, .disabled) a");
    var jq_tab_active_links = jQuery(".preview_pagination li.active a");
    var jq_tab_disabled_links = jQuery(".preview_pagination li.disabled a");

    jq_tab_inactive_links.off("mouseenter");
    jq_tab_inactive_links.off("mouseleave");

    var contentColor = adminFormGet("pagination_content_color");
    var contentBgColor = adminFormGet("pagination_bg_color");
    var hoverContentColor = adminFormGet("pagination_hover_content_color");
    var hoverBgColor = adminFormGet("pagination_hover_bg_color");
    var activeContentColor = adminFormGet("pagination_active_content_color");
    var activeBgColor = adminFormGet("pagination_active_bg_color");
    var borderColor = adminFormGet("pagination_border_color");

    jq_tab_inactive_links.css({color: contentColor, background: contentBgColor, borderColor: borderColor});
    jq_tab_inactive_links.on("mouseenter", function () {
        jQuery(this).css({color: hoverContentColor, backgroundColor: hoverBgColor});
    });
    jq_tab_inactive_links.on("mouseleave", function () {
        jQuery(this).css({color: contentColor, background: contentBgColor});
    });
    jq_tab_active_links.css({color: activeContentColor, background: activeBgColor, borderColor: "transparent"});
    jq_tab_disabled_links.css({color: contentColor, background: contentBgColor, borderColor: borderColor});
}

function updatePagerColors() {
    var jq_pager_links = jQuery(".preview_pager li a");

    jq_pager_links.off("mouseenter");
    jq_pager_links.off("mouseleave");

    var contentColor = adminFormGet("pager_content_color");
    var bgColor = adminFormGet("pager_bg_color");
    var borderColor = adminFormGet("pager_border_color");

    jq_pager_links.css("color", contentColor);
    jq_pager_links.css("backgroundColor", bgColor);
    jq_pager_links.css("borderColor", borderColor);
    jq_pager_links.on("mouseenter", function () {
        jQuery(this).css("color", darkenColor(contentColor, 15));
        jQuery(this).css("backgroundColor", darkenColor(bgColor, 8));
    });
    jq_pager_links.on("mouseleave", function () {
        jQuery(this).css("color", contentColor);
        jQuery(this).css("backgroundColor", bgColor);
    });
}

function updateProductColors() {
    var jq_productContainer = jQuery(".preview_product");

    var nameColor = adminFormGet("product_name_color");
    var categoryColor = adminFormGet("product_category_color");
    var manufacturerColor = adminFormGet("product_manufacturer_color");
    var marketPriceColor = adminFormGet("product_market_price_color");
    var priceColor = adminFormGet("product_price_color");
    var codeColor = adminFormGet("product_code_color");
    var modelColor = adminFormGet("product_model_color");
    var descriptionColor = adminFormGet("product_description_color");

    jq_productContainer.find(".product_name").css("color", nameColor);
    jq_productContainer.find(".product_category").css("color", categoryColor);
    jq_productContainer.find(".product_manufacturer").css("color", manufacturerColor);
    jq_productContainer.find(".product_model").css("color", modelColor);
    jq_productContainer.find(".product_codes").css("color", codeColor);
    jq_productContainer.find(".product_market_price").css("color", marketPriceColor);
    jq_productContainer.find(".product_price").css("color", priceColor);
    jq_productContainer.find(".product_description").css("color", descriptionColor);
}

function updateMultipleProductColors() {
    var jq_productContainer = jQuery(".preview_multiple_product");

    var nameColor = adminFormGet("multiple_product_name_color");
    var marketPriceColor = adminFormGet("multiple_product_market_price_color");
    var priceColor = adminFormGet("multiple_product_price_color");
    var descriptionColor = adminFormGet("multiple_product_description_color");

    jq_productContainer.find(".multiple_product_name").css("color", nameColor);
    jq_productContainer.find(".multiple_product_market_price").css("color", marketPriceColor);
    jq_productContainer.find(".multiple_product_price").css("color", priceColor);
    jq_productContainer.find(".multiple_product_description").css("color", descriptionColor);
}


////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
function onTabActivated(currentTabIndex) {
  adminFormSet("tab_index", currentTabIndex);
}

function onRoundCornersChange(event, obj) {
  updateRoundCorners();
}

function onColorChange(jq_picker, color) {
    var id = jq_picker.attr("id");
    switch (id) {
        // content main color
        case "content_main_color":
            updateContentMainColors();
            break;
        // header
        case "header_content_color":
            updateHeaderColors();
            break;
        // subtext
        case "subtext_content_color":
            updateSubtextColors();
            break;

        // input
        case "input_content_color":
        case "input_bg_color":
        case "input_border_color":
        case "input_focus_border_color":
        case "input_has_error_content_color":
            updateInputColors();
            break;

        // buttons
        case "button_default_content_color":
        case "button_default_bg_color":
        case "button_default_border_color":
            updateButtonColors('default');
            break;
        case "button_primary_content_color":
        case "button_primary_bg_color":
        case "button_primary_border_color":
            updateButtonColors('primary');
            break;
        case "button_success_content_color":
        case "button_success_bg_color":
        case "button_success_border_color":
            updateButtonColors('success');
            break;
        case "button_info_content_color":
        case "button_info_bg_color":
        case "button_info_border_color":
            updateButtonColors('info');
            break;
        case "button_warning_content_color":
        case "button_warning_bg_color":
        case "button_warning_border_color":
            updateButtonColors('warning');
            break;
        case "button_danger_content_color":
        case "button_danger_bg_color":
        case "button_danger_border_color":
            updateButtonColors('danger');
            break;
        case "button_link_content_color":
            updateButtonLinkColors();
            break;

        // divider
        case "divider_color":
            updateDividerColors();
            break;

        // navbar
        case "navbar_bg_color":
        case "navbar_border_color":
        case "navbar_link_content_color":
        case "navbar_link_hover_content_color":
        case "navbar_link_open_content_color":
        case "navbar_link_open_bg_color":
        case "navbar_badge_content_color":
        case "navbar_badge_bg_color":
        case "navbar_dropdown_link_content_color":
        case "navbar_dropdown_link_hover_content_color":
        case "navbar_dropdown_link_hover_background_content_color":
        case "navbar_dropdown_divider_color":
        case "navbar_dropdown_background_color":
        case "navbar_dropdown_border_color":
            updateNavbarColors();
            break;

        // modal
        case "modal_backdrop_color":
        case "modal_bg_color":
        case "modal_border_color":
        case "modal_dividers_color":
            updateModalColors();
            break;

        // panel user data
        case "panel_user_data_bg_color":
        case "panel_user_data_border_color":
        case "panel_user_data_footer_bg_color":
            updatePanelUserDataColors();
            break;

        // panel product
        case "panel_product_bg_color":
        case "panel_product_border_color":
        case "panel_product_footer_bg_color":
            updatePanelProductColors();
            break;

        // well
        case "well_bg_color":
        case "well_border_color":
            updateWellColors();
            break;

        // rating stars
        case "rating_star_color":
        case "rating_star_bg_color":
            updateRatingStarsColors();
            break;

        // label
        case "label_content_color":
        case "label_bg_color":
            updateLabelColors();
            break;

        // alerts
        case "alert_info_content_color":
        case "alert_info_bg_color":
        case "alert_info_border_color":
        case "alert_danger_content_color":
        case "alert_danger_bg_color":
        case "alert_danger_border_color":
            updateAlertColors();
            break;

        //breadcrumb
        case "breadcrumb_content_color":
        case "breadcrumb_bg_color":
            updateBreadcrumbColors();
            break;

        // pills
        case "pill_link_content_color":
        case "pill_link_hover_content_color":
        case "pill_link_hover_bg_color":
            updatePillsColors();
            break;

        // tabs
        case "tab_link_content_color":
        case "tab_link_hover_content_color":
        case "tab_link_hover_bg_color":
        case "tab_link_active_content_color":
        case "tab_link_active_bg_color":
        case "tab_border_color":
            updateTabsColors();
            break;

        // pagination
        case "pagination_content_color":
        case "pagination_bg_color":
        case "pagination_hover_content_color":
        case "pagination_hover_bg_color":
        case "pagination_active_content_color":
        case "pagination_active_bg_color":
        case "pagination_border_color":
            updatePaginationColors();
            break;

        // pager
        case "pager_content_color":
        case "pager_bg_color":
        case "pager_border_color":
            updatePagerColors();
            break;

        // product
        case "product_name_color":
        case "product_category_color":
        case "product_manufacturer_color":
        case "product_price_color":
        case "product_market_price_color":
        case "product_model_color":
        case "product_code_color":
        case "product_description_color":
            updateProductColors();
            break;

        // multiple products
        case "multiple_product_name_color":
        case "multiple_product_price_color":
        case "multiple_product_market_price_color":
        case "multiple_product_description_color":
            updateMultipleProductColors();
            break;
    }
}

function onStarTypeChange(event, obj) {
    var currentType = jQuery("form[name=adminForm] input[name=rating_star_type]:checked").val();

    var jq_ratingStarSpans = jQuery(".preview_rating_stars .glyphicon");
    jq_ratingStarSpans.removeClass("glyphicon-star-empty");
    jq_ratingStarSpans.removeClass("glyphicon-star");
    jq_ratingStarSpans.addClass("glyphicon-" + currentType);
}
