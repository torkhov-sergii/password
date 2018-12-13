var AppImageZoom = function() {

    return {
        init: function() {
            //console.log('AppImageZoom inited');

            $('.img-popup i').on('click', function() {
                $('.modal-window_image-zoom .modal-window_image')
                    .attr('src', $(this).siblings('img').attr('src'));
                $('.modal-window_image-zoom').fadeIn();
            });

            $('.modal-window .modal-window__close').on('click', function() {
                $('.modal-window_image-zoom').fadeOut();
                setTimeout(function(){
                    $('.modal-window_image-zoom .modal-window_image').attr('src', '');
                }, 200);
            });
        }
    };
}();

$(document).ready(function() {
    if($('.img-popup i').length > 0) {
        AppImageZoom.init();
    }
});
