



////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
TreeGenerator.NODE_CLICKED = "nodeClicked";


////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
TreeGenerator.OPEN_CLOSE_DURATION = 100;


////////////////////////////////////////////////////////////////////////////////////////
// Constructor                                                                        //
////////////////////////////////////////////////////////////////////////////////////////
function TreeGenerator(treeContainer, treeData) {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    var thisObj = this;

    this._treeData = treeData;
    this._treeContainer = treeContainer;
    this._treeItemTemplate = jQuery(this._treeContainer).find(".template")[0];


    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    this.drawTree = function (nodeData, parent) {
        var onBtnOpenClick = thisObj.onBtnOpenClick;
        var onBtnCloseClick = thisObj.onBtnCloseClick;
        var onNodeNameClick = thisObj.onNodeNameClick;

        if (!nodeData) {
            nodeData = thisObj._treeData;
            parent = thisObj._treeContainer;
        }

        //create node
        var node = jQuery(thisObj._treeItemTemplate).clone();
        jQuery(parent).append(node);

        jQuery(node).removeClass("template");
        jQuery(node).attr("node_id", nodeData.id);
        jQuery(node).attr("node_name", nodeData.name);
        var nodeHead = jQuery(node).find(".jf_tree_generator_item_head")[0];
        var btnOpen = jQuery(nodeHead).find(".jf_tree_generator_item_head_btn_open")[0];
        var btnClose = jQuery(nodeHead).find(".jf_tree_generator_item_head_btn_close")[0];
        var iconEmpty = jQuery(nodeHead).find(".jf_tree_generator_item_head_icon_empty")[0];
        if (nodeData.children.length > 0) {
            jQuery(btnOpen).click(function (event) {
                onBtnOpenClick(event, this);
            });
            jQuery(btnClose).click(function (event) {
                onBtnCloseClick(event, this);
            });
            jQuery(btnClose).hide(0).css("display", "none");
            jQuery(iconEmpty).hide(0).css("display", "none");
        } else {
            jQuery(btnOpen).hide(0).css("display", "none");
            jQuery(btnClose).hide(0).css("display", "none");
        }
        var nodeName = jQuery(nodeHead).find(".jf_tree_generator_item_head_name")[0];
        jQuery(nodeName).html(nodeData.name);
        jQuery(nodeName).on("click", onNodeNameClick);
        //node children
        var childDatas = nodeData.children;
        var childrenContainer = jQuery(node).find(".jf_tree_generator_item_children_container")[0];
        for (var i = 0; i < childDatas.length; i++) {
            var childData = childDatas[i];
            thisObj.drawTree(childData, childrenContainer);
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    this.onBtnOpenClick = function (event, obj) {
        var nodeObj = jQuery(obj).closest(".jf_tree_generator_item");
        thisObj.openNode(nodeObj);
    }

    this.onBtnCloseClick = function (event, obj) {
        var nodeObj = jQuery(obj).closest(".jf_tree_generator_item");
        thisObj.closeNode(nodeObj);
    }

    this.onNodeNameClick = function (event) {
        var nodeObj = jQuery(this).closest(".jf_tree_generator_item");
        var nodeId = jQuery(nodeObj).attr("node_id");
        var nodeName = jQuery(nodeObj).attr("node_name");
        var nodeData = {};
        nodeData.id = nodeId;
        nodeData.name = nodeName;
        jQuery(thisObj).trigger(TreeGenerator.NODE_CLICKED, nodeData);
    }


    this.drawTree();
    this.closeAllNodes(0);
}

////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
TreeGenerator.prototype.getNodeById = function (nodeId, duration) {
    var nodeObj = jQuery(this._treeContainer).find(".jf_tree_generator_item[node_id=" + nodeId + "]")[0];
    return nodeObj;
}

TreeGenerator.prototype.openNode = function (nodeObj, duration) {
    if (!duration) {
        duration = TreeGenerator.OPEN_CLOSE_DURATION;
    }

    var nodeChildrenContainer = jQuery(nodeObj).children(".jf_tree_generator_item_children_container");
    if (jQuery(nodeChildrenContainer).children().length > 0) {
        jQuery(nodeObj).addClass("opened");

        var head = jQuery(nodeObj).children(".jf_tree_generator_item_head");
        var btnOpen = jQuery(head).find(".jf_tree_generator_item_head_btn_open");
        jQuery(btnOpen).hide(0).css("display", "none");
        var btnClose = jQuery(head).find(".jf_tree_generator_item_head_btn_close");
        jQuery(btnClose).show(0);
        jQuery(nodeChildrenContainer).show(duration);
    }

    var parentNode = jQuery(nodeObj).parent().closest(".jf_tree_generator_item");
    if (parentNode.length > 0) {
        this.openNode(parentNode);
    }
}

TreeGenerator.prototype.closeNode = function (nodeObj, duration) {
    if (duration == undefined) {
        duration = TreeGenerator.OPEN_CLOSE_DURATION;
    }

    var nodeChildrenContainer = jQuery(nodeObj).find(".jf_tree_generator_item_children_container")[0];
    if (jQuery(nodeChildrenContainer).children().length > 0) {
        jQuery(nodeObj).removeClass("opened");

        var head = jQuery(nodeObj).children(".jf_tree_generator_item_head");
        var btnOpen = jQuery(head).find(".jf_tree_generator_item_head_btn_open");
        jQuery(btnOpen).show(0);
        var btnClose = jQuery(head).find(".jf_tree_generator_item_head_btn_close");
        jQuery(btnClose).hide(0).css("display", "none");
        var nodeChildrenContainer = jQuery(nodeObj).children(".jf_tree_generator_item_children_container");
        jQuery(nodeChildrenContainer).hide(duration).css("display", "none");
    }
}

TreeGenerator.prototype.openAllNodes = function (duration) {
    var thisObject = this;
    jQuery(this._treeContainer).find(".jf_tree_generator_item").each(function () {
        thisObject.openNode(this, duration);
    });
}

TreeGenerator.prototype.closeAllNodes = function (duration) {
    var thisObject = this;
    jQuery(this._treeContainer).find(".jf_tree_generator_item").each(function () {
        thisObject.closeNode(this, duration);
    });
}

TreeGenerator.prototype.selectNode = function (nodeObj, showNode, duration) {
    if (showNode == undefined) {
        showNode = true;
    }

    jQuery(this._treeContainer).find(".jf_tree_generator_item").each(function () {
        var nodeHead = jQuery(this).find(".jf_tree_generator_item_head")[0];
        var nodeName = jQuery(nodeHead).find(".jf_tree_generator_item_head_name")[0];
        jQuery(nodeName).removeClass("selected_node");
    });

    var nodeHead = jQuery(nodeObj).find(".jf_tree_generator_item_head")[0];
    var nodeName = jQuery(nodeHead).find(".jf_tree_generator_item_head_name")[0];
    jQuery(nodeName).addClass("selected_node");

    if (showNode == true) {
        this.openNode(this.getParentNode(nodeObj), duration);
    }
}

TreeGenerator.prototype.disableNode = function (nodeObj, disableChildren) {
    var thisObj = this;

    if (disableChildren == undefined) {
        disableChildren = false;
    }

    var elementsToDisable = jQuery(nodeObj);
    if (disableChildren == true) {
        var childrenContainer = jQuery(nodeObj).find(".jf_tree_generator_item_children_container")[0];
        elementsToDisable = jQuery(elementsToDisable).add(jQuery(childrenContainer).find(".jf_tree_generator_item"));
    }

    jQuery(elementsToDisable).each(function () {
        var nodeHead = jQuery(this).find(".jf_tree_generator_item_head")[0];
        var nodeName = jQuery(nodeHead).find(".jf_tree_generator_item_head_name")[0];
        jQuery(nodeName).off("click", thisObj.onNodeNameClick);
        jQuery(nodeName).addClass("disabled_node");
    });
}


TreeGenerator.prototype.getParentNode = function (nodeObj) {
    return jQuery(jQuery(nodeObj).parent()).closest(".jf_tree_generator_item");
}


////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////