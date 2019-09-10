$(function() {
    $('.nav-btn').on('click', function() {
        console.warn($(this).children('.fas').hasClass('fa-bars'));
        if ($(this).children('.fas').hasClass('fa-bars')) {
            $('.nav-tab').addClass('nav-tab-active');
            $(this).children('.fas').removeClass('fa-bars').addClass('fa-times');
        } else if ($(this).children('.fas').hasClass('fa-times')) {
            $('.nav-tab').removeClass('nav-tab-active');
            $(this).children('.fas').removeClass('fa-times').addClass('fa-bars');
        }
    });
});