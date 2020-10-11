jQuery(window).load(function () {

    var currZoom = 1;
    jQuery("#tree_div").css(
            {
//                'width': $("#tree_div").width(),
                'zoom': currZoom,
                'MozTransform': 'scale(' + currZoom + ',' + currZoom + ')',
                'transform-origin': '0 0'
            });


    jQuery(".zoomIn").click(function () {

        currZoom += 0.1;

        currZoom = Math.round(currZoom * 100) / 100;
        jQuery('#tree_div').css(
                {
//                    'width': $("#tree_div").width(),
                    'zoom': currZoom,
                    'MozTransform': 'scale(' + currZoom + ',' + currZoom + ')',
                    'transform-origin': '0 0'
                });
    });

    jQuery(".zoomOff").click(function () {

        currZoom = 1;
        jQuery("#tree_div").css(
                {
//                    'width': $("#tree_div").width(),
                    'zoom': currZoom,
                    'MozTransform': 'scale(' + currZoom + ',' + currZoom + ')',
                    'transform-origin': '0 0'
                });
    });

    jQuery(".zoomOut").click(function () {

        if (currZoom - 0.1) {
            currZoom -= 0.1;

            currZoom = Math.round(currZoom * 100) / 100;

            jQuery('#tree_div').css(
                    {
//                        'width': $("#tree_div").width(),
                        'zoom': currZoom,
                        'MozTransform': 'scale(' + currZoom + ',' + currZoom + ')',
                        'transform-origin': '0 0'
                    });
        }
    });

});

