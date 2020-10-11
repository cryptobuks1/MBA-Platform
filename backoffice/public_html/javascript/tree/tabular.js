var root_user_name = $('#root_user_name').val();
var tree_url = $('#tree_url').val();

var UITreeview = function () {
    //function to initiate jquery.dynatree
    var runTreeView = function () {
        //External data 
        $("#tabular_tree").dynatree({
            initAjax: {
                url: tree_url + root_user_name
            },
            onLazyRead: function (node) {
                node.appendAjax({
                    url: tree_url + root_user_name
                });
            },
            onActivate: function (node) {
                node.appendAjax({
                    url: tree_url + node.data.id
                });
            },
            onDeactivate: function (node) {
                $("#echoActive").text("-");
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function () {
            runTreeView();
        }
    };
}();

$(function () {
    ValidateSearchMember.init();
    tabularTreeView();
});

function tabularTreeView() {
    $('.tabular_tree').fancytree({
        selectMode: 3,
        source: {
            url: tree_url + root_user_name,
            debugDelay: 500
        },
        lazyLoad: function (event, data) {
            var node = data.node;
            data.result = {
                url: tree_url + node.data.id,
                debugDelay: 300
            }
        },
        click: function (e, data) {
            data.node.toggleExpanded();
        },
        extensions: ["glyph"],
        glyph: {
            preset: "awesome4",
            map: {
                expanderLazy: '',
                doc: 'fa-user',
                docOpen: 'fa-user',
            }
        },
    });
}