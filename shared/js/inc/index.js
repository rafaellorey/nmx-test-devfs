$(function () {
    $('.row .img-responsive').on('load', function () {}).each(
            function (i) {
                if (this.complete) {
                    var item = $('<div class="item"></div>');
                    var itemDiv = $(this).parents('div');
                    var title = $(this).parent('a').attr("title");

                    item.attr("title", title);
                    $(itemDiv.html()).appendTo(item);
                    item.appendTo('.carousel-inner');
                    if (i === 0) { // set first item active
                        item.addClass('active');
                    }
                }
            });
    
    $('#btns-vistas button.btn-lg').on('click', function (e) {
        $('#btns-vistas button.btn-lg').removeClass('btn-success');
        $('#btns-vistas button.btn-lg').addClass('btn-default');
        //
        $(this).removeClass('btn-default');
        $(this).addClass('btn-success');
        var show = $(this).data('show');
        if(show){
            $('.vistas').hide();
            $('#'+show).show();
            if(show === 'carrusel'){
                $('#homeCarousel').carousel();
            }else{
                $('#homeCarousel').carousel('pause');
            }
        }
    });   
});