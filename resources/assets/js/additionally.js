

//show spin loading
jQuery.fn.extend({
    showLoading: function() {
        var over = '<div id="overlay"><i class="fa fa-spinner fa-pulse"></i></div>';
        jQuery(over).appendTo(this);
    },
    hideLoading: function() {
        this.find('#overlay').remove();
    }
});

$(document).ready(function() {
    //ajax отправка форм
    $(".form_ajax").each(function(e){
        var url = $(this).data('url');
        var renew = $(this).data('renew');
        var modal_content = $(this).parents('.form-content');
        var first = $(this).parents('.form-content').find('.form-content-first');
        var last = $(this).parents('.form-content').find('.form-content-last');

        $(this).validate({
            ignore: ".ignore",
            submitHandler: function (form) {
                //var formData = new FormData();
                //formData.append( 'file_attach', $('input[name=file]')[0].files[0]);

                var formData = new FormData($(form)[0]); //для отправки файлов ajax

                $.ajax({
                    url: urlPrefix + url,
                    method: 'POST',
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    //data: jQuery(form).serialize() ,
                    data: formData,
                    beforeSend: function(data) {
                        modal_content.showLoading();
                    },
                    complete: function(data) {
                        modal_content.hideLoading();
                        first.slideUp(600);
                        last.slideDown(600);

                        if(renew == 1) {
                            setTimeout(function () {
                                $("#add_more_file_container").show(); //скрыть добавлялку файлов
                                first.slideDown(600);
                                last.slideUp(600);
                                jQuery(':input',modal_content).not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
                                $('.m-subscription').fadeOut();
                            }, 4000);
                        }
                    }
                });
            },
            success: function(label) {
                if($(label).attr('id') == 'email-error') {
                    $(label).parents('form').find('.button').removeClass('button_grey').addClass('button_orange');
                }
            },
        });
    });
});