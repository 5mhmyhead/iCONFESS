$(function() {

    $(document).on('click', '.sidebar-link[data-category]', function() {
        $('.sidebar-link[data-category]').removeClass('active');
        $(this).addClass('active');
    });

    $(document).on('click', '.sidebar-link[data-sort]', function() {
        $('.sidebar-link[data-sort]').removeClass('active');
        $(this).addClass('active');
    });
});