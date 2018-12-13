var AppSubscribe = function() {

    return {
        init: function() {
            //console.log('AppSubscribe inited');

            $('#email-subscribe').validate({
                ignore: ".ignore",
                submitHandler: function (form) {
                    $('.m-subscription').fadeIn();

                    var email = $(form).find('.form-subscribe__input').val();

                    $(form).find('.form-subscribe__input').val('');

                    $('.m-subscription').find('.input_email').val(email);
                }
            });
        }
    };
}();

$(document).ready(function() {
    if($('#email-subscribe').length > 0) {
        AppSubscribe.init();
    }
});
