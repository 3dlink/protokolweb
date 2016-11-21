

jQuery(document).ready(function () {
    // init color pickers
    jQuery('.wd_shop_color_picker').each(function () {
        var jq_colorPicker = jQuery(this);
        var jq_colorPickerColorBox = jq_colorPicker.find(".wd_shop_color_picker_color_box");
        var jq_colorPickerInput = jq_colorPicker.find(".wd_shop_color_picker_input");

        var showHandler = jq_colorPicker.attr("pickerShowHandler");
        var hideHandler = jq_colorPicker.attr("pickerHideHandler");
        var changeHandler = jq_colorPicker.attr("colorChangeHandler");

        jq_colorPicker.colpick({
            flat: false,
            layout: "full",
            submit: 0,
            colorScheme: "light",
            submitText: "",
            color: "",
            showEvent: "click",
            click: true,
            onBeforeShow: function () {
                jq_colorPickerInput.colpickSetColor(jq_colorPickerInput.val());
            },
            onShow: function () {
                if (window[showHandler]) {
                    window[showHandler](jq_colorPicker, jq_colorPickerInput.val());
                }
            },
            onHide: function () {
                if (window[hideHandler]) {
                    window[hideHandler](jq_colorPicker, jq_colorPickerInput.val());
                }
            },
            onChange: function (hsb, hex, rgb, fromSetColor) {
                if (!fromSetColor) {
                    jq_colorPickerInput.val('#' + hex);

                    jq_colorPickerColorBox.css('background-color', '#' + hex);
                    if (window[changeHandler]) {
                        window[changeHandler](jq_colorPicker, jq_colorPickerInput.val());
                    }
                }
            },
            onSubmit: function (hsb, hex, rgb) {
            }
        });

        jq_colorPickerInput.keyup(function () {
            var color = jq_colorPickerInput.val();
            if (color.charAt(0) != '#') {
                color = '#' + color;
            }
            color = color.substr(0, 7);
            while (color.length < 7) {
                color += '0';
            }
            jq_colorPicker.colpickSetColor(color);
            jq_colorPickerColorBox.css('background-color', color);
            if (window[changeHandler]) {
                window[changeHandler](jq_colorPicker, jq_colorPickerInput.val());
            }
        }).blur(function () {
            var color = jq_colorPickerInput.val();
            if (color.charAt(0) != '#') {
                color = '#' + color;
            }
            color = color.substr(0, 7);
            while (color.length < 7) {
                color += '0';
            }
            jq_colorPickerInput.val(color);
            jq_colorPicker.colpickSetColor(color);
        });

        // init
        var color = jq_colorPickerInput.val();
        jq_colorPicker.colpickSetColor(color);
        jq_colorPickerColorBox.css('background-color', color);
    });
});


/*
 colpick Color Picker
 Copyright 2013 Jose Vargas. Licensed under GPL license. Based on Stefan Petre's Color Picker www.eyecon.ro, dual licensed under the MIT and GPL licenses

 For usage and examples: colpick.com/plugin
 */

(function (jQuery) {
    var colpick = function () {
        var
            tpl = '<div class="colpick"><div class="colpick_color"><div class="colpick_color_overlay1"><div class="colpick_color_overlay2"><div class="colpick_selector_outer"><div class="colpick_selector_inner"></div></div></div></div></div><div class="colpick_hue"><div class="colpick_hue_arrs"><div class="colpick_hue_larr"></div><div class="colpick_hue_rarr"></div></div></div><div class="colpick_new_color"></div><div class="colpick_current_color"></div><div class="colpick_hex_field"><div class="colpick_field_letter">#</div><input type="text" maxlength="6" size="6" /></div><div class="colpick_rgb_r colpick_field"><div class="colpick_field_letter">R</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_rgb_g colpick_field"><div class="colpick_field_letter">G</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_rgb_b colpick_field"><div class="colpick_field_letter">B</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_hsb_h colpick_field"><div class="colpick_field_letter">H</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_hsb_s colpick_field"><div class="colpick_field_letter">S</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_hsb_b colpick_field"><div class="colpick_field_letter">B</div><input type="text" maxlength="3" size="3" /><div class="colpick_field_arrs"><div class="colpick_field_uarr"></div><div class="colpick_field_darr"></div></div></div><div class="colpick_submit"></div></div>',
            defaults = {
                showEvent: 'click',
                onShow: function () {
                },
                onBeforeShow: function () {
                },
                onHide: function () {
                },
                onChange: function () {
                },
                onSubmit: function () {
                },
                colorScheme: 'light',
                color: '3289c7',
                livePreview: true,
                flat: false,
                layout: 'full',
                submit: 1,
                submitText: 'OK',
                height: 156
            },
        //Fill the inputs of the plugin
            fillRGBFields = function (hsb, cal) {
                var rgb = hsbToRgb(hsb);
                jQuery(cal).data('colpick').fields
                    .eq(1).val(rgb.r).end()
                    .eq(2).val(rgb.g).end()
                    .eq(3).val(rgb.b).end();
            },
            fillHSBFields = function (hsb, cal) {
                jQuery(cal).data('colpick').fields
                    .eq(4).val(Math.round(hsb.h)).end()
                    .eq(5).val(Math.round(hsb.s)).end()
                    .eq(6).val(Math.round(hsb.b)).end();
            },
            fillHexFields = function (hsb, cal) {
                jQuery(cal).data('colpick').fields.eq(0).val(hsbToHex(hsb));
            },
        //Set the round selector position
            setSelector = function (hsb, cal) {
                jQuery(cal).data('colpick').selector.css('backgroundColor', '#' + hsbToHex({h: hsb.h, s: 100, b: 100}));
                jQuery(cal).data('colpick').selectorIndic.css({
                    left: parseInt(jQuery(cal).data('colpick').height * hsb.s / 100, 10),
                    top: parseInt(jQuery(cal).data('colpick').height * (100 - hsb.b) / 100, 10)
                });
            },
        //Set the hue selector position
            setHue = function (hsb, cal) {
                jQuery(cal).data('colpick').hue.css('top', parseInt(jQuery(cal).data('colpick').height - jQuery(cal).data('colpick').height * hsb.h / 360, 10));
            },
        //Set current and new colors
            setCurrentColor = function (hsb, cal) {
                jQuery(cal).data('colpick').currentColor.css('backgroundColor', '#' + hsbToHex(hsb));
            },
            setNewColor = function (hsb, cal) {
                jQuery(cal).data('colpick').newColor.css('backgroundColor', '#' + hsbToHex(hsb));
            },
        //Called when the new color is changed
            change = function (ev) {
                var cal = jQuery(this).parent().parent(), col;
                if (this.parentNode.className.indexOf('_hex') > 0) {
                    cal.data('colpick').color = col = hexToHsb(fixHex(this.value));
                    fillRGBFields(col, cal.get(0));
                    fillHSBFields(col, cal.get(0));
                } else if (this.parentNode.className.indexOf('_hsb') > 0) {
                    cal.data('colpick').color = col = fixHSB({
                        h: parseInt(cal.data('colpick').fields.eq(4).val(), 10),
                        s: parseInt(cal.data('colpick').fields.eq(5).val(), 10),
                        b: parseInt(cal.data('colpick').fields.eq(6).val(), 10)
                    });
                    fillRGBFields(col, cal.get(0));
                    fillHexFields(col, cal.get(0));
                } else {
                    cal.data('colpick').color = col = rgbToHsb(fixRGB({
                        r: parseInt(cal.data('colpick').fields.eq(1).val(), 10),
                        g: parseInt(cal.data('colpick').fields.eq(2).val(), 10),
                        b: parseInt(cal.data('colpick').fields.eq(3).val(), 10)
                    }));
                    fillHexFields(col, cal.get(0));
                    fillHSBFields(col, cal.get(0));
                }
                setSelector(col, cal.get(0));
                setHue(col, cal.get(0));
                setNewColor(col, cal.get(0));
                cal.data('colpick').onChange.apply(cal.parent(), [col, hsbToHex(col), hsbToRgb(col)], tpl);
            },
        //Change style on blur and on focus of inputs
            blur = function (ev) {
                jQuery(this).parent().removeClass('colpick_focus');
            },
            focus = function () {
                jQuery(this).parent().parent().data('colpick').fields.parent().removeClass('colpick_focus');
                jQuery(this).parent().addClass('colpick_focus');
            },
        //Increment/decrement arrows functions
            downIncrement = function (ev) {
                ev.preventDefault ? ev.preventDefault() : ev.returnValue = false;
                var field = jQuery(this).parent().find('input').focus();
                var current = {
                    el: jQuery(this).parent().addClass('colpick_slider'),
                    max: this.parentNode.className.indexOf('_hsb_h') > 0 ? 360 : (this.parentNode.className.indexOf('_hsb') > 0 ? 100 : 255),
                    y: ev.pageY,
                    field: field,
                    val: parseInt(field.val(), 10),
                    preview: jQuery(this).parent().parent().data('colpick').livePreview
                };
                jQuery(document).mouseup(current, upIncrement);
                jQuery(document).mousemove(current, moveIncrement);
            },
            moveIncrement = function (ev) {
                ev.data.field.val(Math.max(0, Math.min(ev.data.max, parseInt(ev.data.val - ev.pageY + ev.data.y, 10))));
                if (ev.data.preview) {
                    change.apply(ev.data.field.get(0), [true]);
                }
                return false;
            },
            upIncrement = function (ev) {
                change.apply(ev.data.field.get(0), [true]);
                ev.data.el.removeClass('colpick_slider').find('input').focus();
                jQuery(document).off('mouseup', upIncrement);
                jQuery(document).off('mousemove', moveIncrement);
                return false;
            },
        //Hue slider functions
            downHue = function (ev) {
                ev.preventDefault ? ev.preventDefault() : ev.returnValue = false;
                var current = {
                    cal: jQuery(this).parent(),
                    y: jQuery(this).offset().top
                };
                current.preview = current.cal.data('colpick').livePreview;
                jQuery(document).mouseup(current, upHue);
                jQuery(document).mousemove(current, moveHue);

                change.apply(
                    current.cal.data('colpick')
                        .fields.eq(4).val(parseInt(360 * (current.cal.data('colpick').height - (ev.pageY - current.y)) / current.cal.data('colpick').height, 10))
                        .get(0),
                    [current.preview]
                );
            },
            moveHue = function (ev) {
                change.apply(
                    ev.data.cal.data('colpick')
                        .fields.eq(4).val(parseInt(360 * (ev.data.cal.data('colpick').height - Math.max(0, Math.min(ev.data.cal.data('colpick').height, (ev.pageY - ev.data.y)))) / ev.data.cal.data('colpick').height, 10))
                        .get(0),
                    [ev.data.preview]
                );
                return false;
            },
            upHue = function (ev) {
                fillRGBFields(ev.data.cal.data('colpick').color, ev.data.cal.get(0));
                fillHexFields(ev.data.cal.data('colpick').color, ev.data.cal.get(0));
                jQuery(document).off('mouseup', upHue);
                jQuery(document).off('mousemove', moveHue);
                return false;
            },
        //Color selector functions
            downSelector = function (ev) {
                ev.preventDefault ? ev.preventDefault() : ev.returnValue = false;
                var current = {
                    cal: jQuery(this).parent(),
                    pos: jQuery(this).offset()
                };
                current.preview = current.cal.data('colpick').livePreview;

                jQuery(document).mouseup(current, upSelector);
                jQuery(document).mousemove(current, moveSelector);

                change.apply(
                    current.cal.data('colpick').fields
                        .eq(6).val(parseInt(100 * (current.cal.data('colpick').height - (ev.pageY - current.pos.top)) / current.cal.data('colpick').height, 10)).end()
                        .eq(5).val(parseInt(100 * (ev.pageX - current.pos.left) / current.cal.data('colpick').height, 10))
                        .get(0),
                    [current.preview]
                );
            },
            moveSelector = function (ev) {
                change.apply(
                    ev.data.cal.data('colpick').fields
                        .eq(6).val(parseInt(100 * (ev.data.cal.data('colpick').height - Math.max(0, Math.min(ev.data.cal.data('colpick').height, (ev.pageY - ev.data.pos.top)))) / ev.data.cal.data('colpick').height, 10)).end()
                        .eq(5).val(parseInt(100 * (Math.max(0, Math.min(ev.data.cal.data('colpick').height, (ev.pageX - ev.data.pos.left)))) / ev.data.cal.data('colpick').height, 10))
                        .get(0),
                    [ev.data.preview]
                );
                return false;
            },
            upSelector = function (ev) {
                fillRGBFields(ev.data.cal.data('colpick').color, ev.data.cal.get(0));
                fillHexFields(ev.data.cal.data('colpick').color, ev.data.cal.get(0));
                jQuery(document).off('mouseup', upSelector);
                jQuery(document).off('mousemove', moveSelector);
                return false;
            },
        //Submit button
            clickSubmit = function (ev) {
                var cal = jQuery(this).parent();
                var col = cal.data('colpick').color;
                cal.data('colpick').origColor = col;
                setCurrentColor(col, cal.get(0));
                cal.data('colpick').onSubmit(col, hsbToHex(col), hsbToRgb(col), cal.data('colpick').el);
            },
        //Show/hide the color picker
            show = function (ev) {
                var cal = jQuery('#' + jQuery(this).data('colpickId'));
                cal.data('colpick').onBeforeShow.apply(this, [cal.get(0)]);
                var pos = jQuery(this).offset();
                var top = pos.top + this.offsetHeight;
                var left = pos.left;
                var viewPort = getViewport();
                if (left + 346 > viewPort.l + viewPort.w) {
                    left -= 346;
                }
                cal.css({left: left + 'px', top: top + 'px'});
                if (cal.data('colpick').onShow.apply(this, [cal.get(0)]) != false) {
                    cal.show();
                }
                //Hide when user clicks outside
                jQuery('html').mousedown({cal: cal}, hide);
                cal.mousedown(function (ev) {
                    ev.stopPropagation();
                })
            },
            hide = function (ev) {
                if (ev.data.cal.data('colpick').onHide.apply(this, [ev.data.cal.get(0)]) != false) {
                    ev.data.cal.hide();
                }
                jQuery('html').off('mousedown', hide);
            },
            getViewport = function () {
                var m = document.compatMode == 'CSS1Compat';
                return {
                    l: window.pageXOffset || (m ? document.documentElement.scrollLeft : document.body.scrollLeft),
                    w: window.innerWidth || (m ? document.documentElement.clientWidth : document.body.clientWidth)
                };
            },
        //Fix the values if the user enters a negative or high value
            fixHSB = function (hsb) {
                return {
                    h: Math.min(360, Math.max(0, hsb.h)),
                    s: Math.min(100, Math.max(0, hsb.s)),
                    b: Math.min(100, Math.max(0, hsb.b))
                };
            },
            fixRGB = function (rgb) {
                return {
                    r: Math.min(255, Math.max(0, rgb.r)),
                    g: Math.min(255, Math.max(0, rgb.g)),
                    b: Math.min(255, Math.max(0, rgb.b))
                };
            },
            fixHex = function (hex) {
                var len = 6 - hex.length;
                if (len > 0) {
                    var o = [];
                    for (var i = 0; i < len; i++) {
                        o.push('0');
                    }
                    o.push(hex);
                    hex = o.join('');
                }
                return hex;
            },
            restoreOriginal = function () {
                var cal = jQuery(this).parent();
                var col = cal.data('colpick').origColor;
                cal.data('colpick').color = col;
                fillRGBFields(col, cal.get(0));
                fillHexFields(col, cal.get(0));
                fillHSBFields(col, cal.get(0));
                setSelector(col, cal.get(0));
                setHue(col, cal.get(0));
                setNewColor(col, cal.get(0));
            };
        return {
            init: function (opt) {
                opt = jQuery.extend({}, defaults, opt || {});
                //Set color
                if (typeof opt.color == 'string') {
                    opt.color = hexToHsb(opt.color);
                } else if (opt.color.r != undefined && opt.color.g != undefined && opt.color.b != undefined) {
                    opt.color = rgbToHsb(opt.color);
                } else if (opt.color.h != undefined && opt.color.s != undefined && opt.color.b != undefined) {
                    opt.color = fixHSB(opt.color);
                } else {
                    return this;
                }

                //For each selected DOM element
                return this.each(function () {
                    //If the element does not have an ID
                    if (!jQuery(this).data('colpickId')) {
                        var options = jQuery.extend({}, opt);
                        options.origColor = opt.color;
                        //Generate and assign a random ID
                        var id = "collorpicker_" + jQuery(this).find("input").attr("name");
                        jQuery(this).data('colpickId', id);
                        //Set the tpl's ID and get the HTML
                        var cal = jQuery(tpl).attr('id', id);
                        //Add class according to layout
                        cal.addClass('colpick_' + options.layout + (options.submit ? '' : ' colpick_' + options.layout + '_ns'));
                        //Add class if the color scheme is not default
                        if (options.colorScheme != 'light') {
                            cal.addClass('colpick_' + options.colorScheme);
                        }
                        //Setup submit button
                        cal.find('div.colpick_submit').html(options.submitText).click(clickSubmit);
                        //Setup input fields
                        options.fields = cal.find('input').change(change).blur(blur).focus(focus);
                        cal.find('div.colpick_field_arrs').mousedown(downIncrement).end().find('div.colpick_current_color').click(restoreOriginal);
                        //Setup hue selector
                        options.selector = cal.find('div.colpick_color').mousedown(downSelector);
                        options.selectorIndic = options.selector.find('div.colpick_selector_outer');
                        //Store parts of the plugin
                        options.el = this;
                        options.hue = cal.find('div.colpick_hue_arrs');
                        huebar = options.hue.parent();
                        //Paint the hue bar
                        var UA = navigator.userAgent.toLowerCase();
                        var isIE = navigator.appName === 'Microsoft Internet Explorer';
                        var IEver = isIE ? parseFloat(UA.match(/msie ([0-9]{1,}[\.0-9]{0,})/)[1]) : 0;
                        var ngIE = ( isIE && IEver < 10 );
                        var stops = ['#ff0000', '#ff0080', '#ff00ff', '#8000ff', '#0000ff', '#0080ff', '#00ffff', '#00ff80', '#00ff00', '#80ff00', '#ffff00', '#ff8000', '#ff0000'];
                        if (ngIE) {
                            var i, div;
                            for (i = 0; i <= 11; i++) {
                                div = jQuery('<div></div>').attr('style', 'height:8.333333%; filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=' + stops[i] + ', endColorstr=' + stops[i + 1] + '); -ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=' + stops[i] + ', endColorstr=' + stops[i + 1] + ')";');
                                huebar.append(div);
                            }
                        } else {
                            stopList = stops.join(',');
                            huebar.attr('style', 'background:-webkit-linear-gradient(top center,' + stopList + '); background:-moz-linear-gradient(top center,' + stopList + '); background:linear-gradient(to bottom,' + stopList + '); ');
                            huebar.css({'background': 'linear-gradient(to bottom,' + stopList + ')'});
                            huebar.css({'background': '-moz-linear-gradient(top,' + stopList + ')'});
                        }
                        cal.find('div.colpick_hue').mousedown(downHue);
                        options.newColor = cal.find('div.colpick_new_color');
                        options.currentColor = cal.find('div.colpick_current_color');
                        //Store options and fill with default color
                        cal.data('colpick', options);
                        fillRGBFields(options.color, cal.get(0));
                        fillHSBFields(options.color, cal.get(0));
                        fillHexFields(options.color, cal.get(0));
                        setHue(options.color, cal.get(0));
                        setSelector(options.color, cal.get(0));
                        setCurrentColor(options.color, cal.get(0));
                        setNewColor(options.color, cal.get(0));
                        //Append to body if flat=false, else show in place
                        if (options.flat) {
                            cal.appendTo(this).show();
                            cal.css({
                                position: 'relative',
                                display: 'block'
                            });
                        } else {
                            cal.appendTo(document.body);
                            jQuery(this).on(options.showEvent, show);
                            cal.css({
                                position: 'absolute'
                            });
                        }
                    }
                });
            },
            //Shows the picker
            showPicker: function () {
                return this.each(function () {
                    if (jQuery(this).data('colpickId')) {
                        show.apply(this);
                    }
                });
            },
            //Hides the picker
            hidePicker: function () {
                return this.each(function () {
                    if (jQuery(this).data('colpickId')) {
                        jQuery('#' + jQuery(this).data('colpickId')).hide();
                    }
                });
            },
            //Sets a color as new and current (default)
            setColor: function (col, setCurrent) {
                setCurrent = (typeof setCurrent === "undefined") ? 1 : setCurrent;
                if (typeof col == 'string') {
                    col = hexToHsb(col);
                } else if (col.r != undefined && col.g != undefined && col.b != undefined) {
                    col = rgbToHsb(col);
                } else if (col.h != undefined && col.s != undefined && col.b != undefined) {
                    col = fixHSB(col);
                } else {
                    return this;
                }
                return this.each(function () {
                    if (jQuery(this).data('colpickId')) {
                        var cal = jQuery('#' + jQuery(this).data('colpickId'));
                        cal.data('colpick').color = col;
                        cal.data('colpick').origColor = col;
                        fillRGBFields(col, cal.get(0));
                        fillHSBFields(col, cal.get(0));
                        fillHexFields(col, cal.get(0));
                        setHue(col, cal.get(0));
                        setSelector(col, cal.get(0));

                        setNewColor(col, cal.get(0));
                        cal.data('colpick').onChange.apply(cal.parent(), [col, hsbToHex(col), hsbToRgb(col), 1]);
                        if (setCurrent) {
                            setCurrentColor(col, cal.get(0));
                        }
                    }
                });
            }
        };
    }();
    //Color space convertions
    var hexToRgb = function (hex) {
        var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
        return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
    };
    var hexToHsb = function (hex) {
        return rgbToHsb(hexToRgb(hex));
    };
    var rgbToHsb = function (rgb) {
        var hsb = {h: 0, s: 0, b: 0};
        var min = Math.min(rgb.r, rgb.g, rgb.b);
        var max = Math.max(rgb.r, rgb.g, rgb.b);
        var delta = max - min;
        hsb.b = max;
        hsb.s = max != 0 ? 255 * delta / max : 0;
        if (hsb.s != 0) {
            if (rgb.r == max) hsb.h = (rgb.g - rgb.b) / delta;
            else if (rgb.g == max) hsb.h = 2 + (rgb.b - rgb.r) / delta;
            else hsb.h = 4 + (rgb.r - rgb.g) / delta;
        } else hsb.h = -1;
        hsb.h *= 60;
        if (hsb.h < 0) hsb.h += 360;
        hsb.s *= 100 / 255;
        hsb.b *= 100 / 255;
        return hsb;
    };
    var hsbToRgb = function (hsb) {
        var rgb = {};
        var h = Math.round(hsb.h);
        var s = Math.round(hsb.s * 255 / 100);
        var v = Math.round(hsb.b * 255 / 100);
        if (s == 0) {
            rgb.r = rgb.g = rgb.b = v;
        } else {
            var t1 = v;
            var t2 = (255 - s) * v / 255;
            var t3 = (t1 - t2) * (h % 60) / 60;
            if (h == 360) h = 0;
            if (h < 60) {
                rgb.r = t1;
                rgb.b = t2;
                rgb.g = t2 + t3
            }
            else if (h < 120) {
                rgb.g = t1;
                rgb.b = t2;
                rgb.r = t1 - t3
            }
            else if (h < 180) {
                rgb.g = t1;
                rgb.r = t2;
                rgb.b = t2 + t3
            }
            else if (h < 240) {
                rgb.b = t1;
                rgb.r = t2;
                rgb.g = t1 - t3
            }
            else if (h < 300) {
                rgb.b = t1;
                rgb.g = t2;
                rgb.r = t2 + t3
            }
            else if (h < 360) {
                rgb.r = t1;
                rgb.g = t2;
                rgb.b = t1 - t3
            }
            else {
                rgb.r = 0;
                rgb.g = 0;
                rgb.b = 0
            }
        }
        return {r: Math.round(rgb.r), g: Math.round(rgb.g), b: Math.round(rgb.b)};
    };
    var rgbToHex = function (rgb) {
        var hex = [
            rgb.r.toString(16),
            rgb.g.toString(16),
            rgb.b.toString(16)
        ];
        jQuery.each(hex, function (nr, val) {
            if (val.length == 1) {
                hex[nr] = '0' + val;
            }
        });
        return hex.join('');
    };
    var hsbToHex = function (hsb) {
        return rgbToHex(hsbToRgb(hsb));
    };

    jQuery.fn.extend({
        colpick: colpick.init,
        colpickHide: colpick.hidePicker,
        colpickShow: colpick.showPicker,
        colpickSetColor: colpick.setColor
    });
    jQuery.extend({
        colpickRgbToHex: rgbToHex,
        colpickRgbToHsb: rgbToHsb,
        colpickHsbToHex: hsbToHex,
        colpickHsbToRgb: hsbToRgb,
        colpickHexToHsb: hexToHsb,
        colpickHexToRgb: hexToRgb
    });
})(jQuery)