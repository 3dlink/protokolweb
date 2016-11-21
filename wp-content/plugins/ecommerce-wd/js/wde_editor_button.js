(function () {
  tinymce.create('tinymce.plugins.wde_mce', {
    init:function (ed, url) {
      var c = this;
      c.url = url;
      c.editor = ed;
      ed.addCommand('mcewde_mce', function () {
        ed.windowManager.open({
          file: wde_admin_ajax,
          width: 800 + ed.getLang('wde_mce.delta_width', 0),
          height: 550 + ed.getLang('wde_mce.delta_height', 0),
          inline: 1
        }, {
          plugin_url:url
        });
        var e = ed.selection.getNode(), d = wp.media.gallery, f;
        if (typeof wp === "undefined" || !wp.media || !wp.media.gallery) {
          return;
        }
        if (e.nodeName != "IMG" || ed.dom.getAttrib(e, "class").indexOf("wde_shortcode") == -1) {
          return;
        }
        f = d.edit("[" + ed.dom.getAttrib(e, "data-title") + "]");
      });
      ed.addButton('wde_mce', {
        cmd: 'mcewde_mce',
        image: url + '/../images/wd_ecommerce.png'
      });
      ed.onMouseDown.add(function (d, f) {
        if (f.target.nodeName == "IMG" && d.dom.hasClass(f.target, "wde_none_selectable")) {
          return;
        }
        else if (f.target.nodeName == "IMG" && d.dom.hasClass(f.target, "wde_shortcode")) {
          var g = tinymce.activeEditor;
          g.wpGalleryBookmark = g.selection.getBookmark("simple");
          g.execCommand("mcewde_mce");
        }
      });
      ed.onBeforeSetContent.add(function (d, e) {
        e.content = c._do_wde(e.content)
      });
      ed.onPostProcess.add(function (d, e) {
        if (e.get) {
          e.content = c._get_wde(e.content)
        }
      })
    },
    _do_wde:function (ed) {
      return ed.replace(/\[wde([^\]]*)\]/g, function (d, c) {
        var wde_image = "";
        var wde_class = "wde_none_selectable";
        var wde_title = "";
        if (ed.indexOf('type="products"') != -1) {
          wde_image = "products_48";
          wde_class = "wde_shortcode";
          wde_title = "Products";
        }
        else if (ed.indexOf('type="categories"') != -1) {
          wde_image = 'categories_48';
          wde_class = "wde_shortcode";
          wde_title = "Categories";
        }
        else if (ed.indexOf('type="manufacturers"') != -1) {
          wde_image = 'manufacturers_48';
          wde_class = "wde_shortcode";
          wde_title = "Manufacturers";
        }
        else if (ed.indexOf('type="checkout"') != -1) {
          wde_image = 'checkout_48';
          wde_title = "Checkout";
        }
        else if (ed.indexOf('type="orders"') != -1) {
          wde_image = 'orders_48';
          wde_title = "Orders";
        }
        else if (ed.indexOf('type="shoppingcart"') != -1) {
          wde_image = 'shopping_cart_48';
          wde_title = "Shopping cart";
        }
        else if (ed.indexOf('type="systempages"') != -1) {
          wde_image = 'system_pages_48';
          wde_title = "System pages";
        }
        else if (ed.indexOf('type="useraccount"') != -1) {
          wde_image = 'users_48';
          wde_title = "User account";
        }
        else if (ed.indexOf('type="usermanagement"') != -1) {
          wde_image = 'user_management_48';
          wde_title = "User management";
        }
        return '<img src="' + wde_plugin_url + '/images/toolbar_icons/' + wde_image + '.png" class="' + wde_class + ' mceItem" data-title="wde' + tinymce.DOM.encode(c) + '" title="' + wde_title + '" />';
      });
    },
    _get_wde:function (b) {
      function ed(c, d) {
        d = new RegExp(d + '="([^"]+)"', "g").exec(c);
        return d ? tinymce.DOM.decode(d[1]) : "";
      }
      return b.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function (e, d) {
        var c = ed(d, "class");
        if (c.indexOf("wde_shortcode") != -1 || c.indexOf("wde_none_selectable") != -1) {
          return "<p>[" + tinymce.trim(ed(d, "data-title")) + "]</p>";
        }
        return e;
      })
    }
  });
  tinymce.PluginManager.add('wde_mce', tinymce.plugins.wde_mce);
})();