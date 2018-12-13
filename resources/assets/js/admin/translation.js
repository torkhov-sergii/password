var AppTranslation = function () {

    var popup_input = $('#translation_modal .js__value');
    var button_save = $('#translation_modal .js__save');
    var button_close = $('#translation_modal .js__close');
    var string = null;
    var id = null;
    var value = null;
    var locale = null;
    var group = null;
    var key = null;

    var initSting = function () {

        $('.js__string').on('click',function () {
            string = $(this);
            id = $(this).data('id');
            value = $(this).data('value');
            locale = $(this).data('locale');
            group = $(this).data('group');
            key = $(this).data('key');

            popup_input.val(value);
        });
    };

    var initSave = function () {
        $(button_save).on('click',function () {
            $.ajax({
                url: urlPrefix + '/api/admin/translations/update',
                type: 'POST',
                data: {
                    id: id,
                    value: popup_input.val(),
                    locale: locale,
                    group: group,
                    key: key,
                },
                success: function(data) {
                    var value = popup_input.val();

                    if(!value) value = 'empty';
                    //popup_input.val(value);
                    $(string).html(value);
                    button_close.click();
                }
            });
        });
    };

    var initChouseGroup = function () {
        $('.group-select').on('change', function(){
            var group = $(this).val();
            var redirect = $(this).find("option:selected").attr('data-url')
            window.location.href = redirect;
        });
    };

    return {
        init: function () {
            initSting();
            initSave();
            initChouseGroup();
        }
    };

}();

jQuery(document).ready(function() {
    if ($('.p-translations').length){
        AppTranslation.init();
    }
});



// $(function () {
//     $('.translate_all').on('click', function () {
//         var translateTo = $(this).data('lang');
//
//         $.ajax({
//             url: urlPrefix + '/ajax/translate_all',
//             type: 'POST',
//             data: {translate_to: translateTo},
//             success: function(data) {
//                 //alert('Done!');
//                 location.reload();
//             }
//         });
//     });
// });

// //translation manager
// $(document).ready(function($) {
//     //портит все нахрен!
//     // $.ajaxSetup({
//     //     beforeSend: function(xhr, settings) {
//     //         var csrfToken = $('#csrfToken').val();
//     //         settings.data += "&_token=" + csrfToken;
//     //     }
//     // });
//
//     $('.editable').editable({
//         //mode: 'inline'
//     }).on('hidden', function(e, reason){
//         var locale = $(this).data('locale');
//         if(reason === 'save'){
//             $(this).removeClass('status-0').addClass('status-1');
//         }
//         /*
//          if(reason === 'save' || reason === 'nochange') {
//          var $next = $(this).closest('tr').next().find('.editable.locale-'+locale);
//          setTimeout(function() {
//          $next.editable('show');
//          }, 300);
//          }*/
//     });
//
//     //$('.editable').editable().on('hidden', function(e, reason){
//     //    var locale = $(this).data('locale');
//     //    if(reason === 'save'){
//     //        $(this).removeClass('status-0').addClass('status-1');
//     //    }
//     //    /*
//     //     if(reason === 'save' || reason === 'nochange') {
//     //     var $next = $(this).closest('tr').next().find('.editable.locale-'+locale);
//     //     setTimeout(function() {
//     //     $next.editable('show');
//     //     }, 300);
//     //     }*/
//     //});
//
//     $('.group-select').on('change', function(){
//         var group = $(this).val();
//         var redirect = $(this).find("option:selected").attr('data-url')
//         window.location.href = redirect;
//     });
//
//     $("a.delete-key").click(function(event){
//         event.preventDefault();
//         var row = $(this).closest('tr');
//         var url = $(this).attr('href');
//         var id = row.attr('id');
//         $.post( url, {id: id}, function(){
//             row.remove();
//         } );
//     });
//
//     $('.form-import').on('ajax:success', function (e, data) {
//         $('div.success-import strong.counter').text(data.counter);
//         $('div.success-import').slideDown();
//     });
//
//     $('.form-find').on('ajax:success', function (e, data) {
//         $('div.success-find strong.counter').text(data.counter);
//         $('div.success-find').slideDown();
//     });
//
//     $('.form-publish').on('submit', function (event, data) {
//         event.preventDefault();
//         var thisForm = $(this);
//         $.post( thisForm.attr('action'), function(){
//             $('div.success-publish').slideDown();
//         } );
//
//     });
// });