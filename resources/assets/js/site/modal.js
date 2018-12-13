var AppModal = function() {

    return {
        init: function() {
            //close modal if click close
            $('.modal .modal__close').on('click', function() {
                $('.modal').fadeOut();
            });

            //close modal if click outside
            $('.modal').mouseup(function(e) {
                var container = $(".modal__dialog");

                // if the target of the click isn't the container nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0)
                {
                    $('.modal').fadeOut();
                }
            });
        }
    };
}();

$(document).ready(function() {
    if($('.modal').length > 0) {
        AppModal.init();
    }
});
