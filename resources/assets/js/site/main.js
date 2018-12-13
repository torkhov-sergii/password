var AppMain = function() {

    //init form validate for .form_validate
    var initFormValidate = function () {
        $('.form_validate').each(function () {
            $(this).validate({
                ignore: ".ignore",
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-danger');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-danger');
                },
            });
        });
    };

    var initOwl = function () {
        if($('.block-courses__courses-grid.owl-carousel').length > 0) {
            var owl = $('.block-courses__courses-grid.owl-carousel').owlCarousel({
                nav: true,
                responsive:{
                    0:{
                        items: 1
                    },
                    800: {
                        items: 2
                    },
                    1281:{
                        items: 3
                    }
                }
            });

            $('.owl-prev, .owl-next').html('');
        }
    };

    var initAniView = function () {
        // Initialize scroll AniView animations
        $('.page-block').css('opacity', '1');

        //fix fullscreen for google slides
        if($('iframe').length == 0) {
            $('[data-av-animation="fadeInUp"]').AniView({
                animateThreshold: -100
            });
        }
    };

    //ease scroll - плавная прокрутка я якорю
    var initEaseScroll = function () {
        var menu_offset = 80; //прокрутка учитывая высоту фиксированного меню

        $(document).on('click', 'a[href*=\\#]', function(event){
            var hash = this.hash;
            var offset = $(hash).offset();

            if(hash == '#offshores') {
                menu_offset = 100;
            }

            if(hash && offset) {
                event.preventDefault();

                $('.header__services').slideUp();
                $('#navbarCollapse').addClass('collapse').removeClass('show');//slideUp();

                $('html, body').animate({
                    scrollTop: offset.top - menu_offset
                }, 500);
            }
        });

        //ease scroll - after reload page
        if(window.location.hash) {
            // smooth scroll to the anchor id
            $('html, body').animate({
                scrollTop: $(window.location.hash).offset().top - menu_offset
            }, 1000);
        }
    };

    var initPdf = function () {
        setTimeout(function() {
            $('.js__pdf-container').each(function () {
                $(this).find('.js__pdf-content').html($(this).find('.js_pdf-source').html());
            });
        }, 2000);
    };

    return {
        init: function(search_block) {
            //console.log('AppMain inited');

            //initFormValidate();
            initOwl();
            initAniView();
            initEaseScroll();
            initPdf();

            // Miscellaneous
            $('.navigaton-bar-button').click(function() {
                $(this).toggleClass("navigaton-bar-button_open");
                if($('.navigation-bar-menu').hasClass('navigation-bar-menu_open')) {
                    $('.navigation-bar-menu').removeClass('animated slideInRight').addClass('animated slideOutRight');
                    setTimeout(function() {
                        $('.navigation-bar-menu').removeClass('navigation-bar-menu_open');
                    }, 400);
                } else {
                    $('.navigation-bar-menu').removeClass('animated slideOutRight').addClass('animated slideInRight').addClass('navigation-bar-menu_open');
                }
            });

            $('.articles-title-line__navigation-menu-toggler').click(function() {
                $('aside').removeClass('animated slideOutLeft').show().addClass('animated slideInLeft');
            });

            $('.controls__close').click(function() {
                $('aside').removeClass('animated slideInLeft').addClass('animated slideOutLeft');
                setTimeout(function() {
                    $('aside').hide();
                }, 400);
            });
        }
    };
}();

$(document).ready(function() {
    AppMain.init();
});
