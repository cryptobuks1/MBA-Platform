$(function () {
    panZoom();
    generateTooltips();
});

function panZoom() {
    $('body').find('.tableview_container').panzoom({
        $zoomIn: $(".zoom-in"),
        $zoomOut: $(".zoom-out"),
        $reset: $(".zoom-reset"),
        startTransform: 'scale(1.0)',
        maxScale: 2.0,
        increment: 0.05,
        disablePan: true,
        // panOnlyWhenZoomed: true,
        // contain: true
    });
}

function generateTooltips() {
    $('body').on('mouseenter', '.tree_icon.with_tooltip:not(.tooltipstered)', function () {
        $(this).tooltipster({
            theme: 'tooltipster-shadow',
            contentAsHTML: true,
            delay: 100,
            interactive: true,
            arrow: false,
            side: ['top', 'bottom'],

        });
        $(this).tooltipster('show');
    });
}