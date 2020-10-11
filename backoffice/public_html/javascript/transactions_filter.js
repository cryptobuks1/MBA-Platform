$(function () {
    $('.dropdown_filter').dropdownFilter({
        remote: true,
        remote_url: $('.section-dropdown-filter').data('remote'),
        clear: true,
        clear_txt: $('.section-dropdown-filter').data('clear')
    });
});
