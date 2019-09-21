$(function() {
    $('.nav-btn').on('click', function() {
        if ($(this).children('.fas').hasClass('fa-bars')) {
            $('.nav-tab').addClass('nav-tab-active');
        } else if ($(this).children('.fas').hasClass('fa-times')) {
            $('.nav-tab').removeClass('nav-tab-active');
        }
    });
    
    setClassPicture();
    $(document).on('scroll', setClassPicture);

});

function setClassPicture() {
    const limit = $(window).height() * 0.45;
    $('.slide-column').each(function() {
        if ($(this).offset().top - $(window).scrollTop() < limit) {
            $(this).find('.picture-left').removeClass('picture-left').addClass('slide-to-right');
            $(this).find('.picture-right').removeClass('picture-right').addClass('slide-to-left');
        };
    });
    console.log($('.pictue-left, .picture-right').length);
    if ($('.picture-left, .picture-right').length == 0) {
        $(document).off('scroll', setClassPicture);
    }
}