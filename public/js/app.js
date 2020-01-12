$(function() {
    $('.nav-btn').on('click', function() {
        if ($(this).children('.fas').hasClass('fa-bars')) {
            $('.nav-tab').addClass('nav-tab-active');
        } else if ($(this).children('.fas').hasClass('fa-times')) {
            $('.nav-tab').removeClass('nav-tab-active');
        }
    });

    $('a').on('click', animateScroll);

    $(document).on('submit', '#contact', sendConctactMessage);

    $(document).on('change','#booking_timeLine, #booking_quantity', setBookingQuantity);
   //$(':radio[name="booking[timeLine]"]').change(setBookingQuantity);
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

function animateScroll(){
    var curentAnchor = $(this).attr('href');
    var speed = 1500;
    var topHref = $(curentAnchor).offset().top;
    $('html, body').animate( { scrollTop: topHref}, speed);
}

function sendConctactMessage(e){
    e.preventDefault();
    var $form = $(e.currentTarget);
    $.ajax({
        url: $form.attr('action'),
        method: 'POST',
        data: $form.serialize()
    })
    .done(function(flash) {
        $( ".flashes" ).append(flash);
        $("#contact").trigger('reset');
    });
}
function setBookingQuantity() {
    var form = $(this).closest('form');
    var route = Routing.generate("booking",{'id': form.data('id')});
    $.ajax({
        url : route,
        type: form.attr('method'),
        data : form.serialize(),
        success: function(html) {
            form.replaceWith($(html).find('form'));
        }
    });
}