$(function() {
    $(document).on('click','a[data-toggle="modal"]',showModal);
    $(document).on('click','button.close[data-dismiss="modal"]',closeModal);
});

function showModal(event) {
    event.preventDefault();
    var route = $(this).attr("href");
    $.ajax({
        url : route,
        type: "get",
        success: function(html) {
            $('.modal').replaceWith($(html));
        }
    });
}

function closeModal(){
    let html = document.createElement("div");
    $(html).addClass('modal').attr('tabidex',-1);
    $('.modal').replaceWith($(html));
}