var AppwWsiwyg = function () {

    //special styles for img like img-popup...
    /* https://github.com/DiemenDesign/summernote-image-shapes */
    var initCustomImageButtons = function() {
        (function (factory) {
            if (typeof define === 'function' && define.amd) {
                define(['jquery'],factory)
            } else if (typeof module === 'object' && module.exports) {
                module.exports = factory(require('jquery'));
            } else {
                factory(window.jQuery)
            }
        }
        (function ($) {
            $.extend(true,$.summernote.lang, {
                'en-US': {
                    imageShapes: {
                        tooltip: 'Image Shapes',
                        //tooltipShapeOptions: ['Popup', 'Responsive', 'Rounded', 'Circle', 'Thumbnail', 'None']
                        tooltipShapeOptions: ['Popup', 'None']
                    }
                }
            });
            $.extend($.summernote.options, {
                imageShapes: {
                    icon: '<i class="note-icon-picture"/>',
                    /* Must keep the same order as in lang.imageAttributes.tooltipShapeOptions */
                    shapes: ['img-popup', 'img-responsive', 'img-rounded', 'img-circle', 'img-thumbnail', '']
                }
            });
            $.extend($.summernote.plugins, {
                'imageShapes': function(context) {
                    var ui        = $.summernote.ui,
                        $editable = context.layoutInfo.editable,
                        options   = context.options,
                        lang      = options.langInfo;
                    context.memo('button.imageShapes', function() {
                        var button = ui.buttonGroup([
                            ui.button({
                                className: 'dropdown-toggle',
                                contents: options.imageShapes.icon + '&nbsp;&nbsp;<span class="caret"></span>',
                                tooltip: lang.imageShapes.tooltipShape,
                                data: {
                                    toggle: 'dropdown'
                                }
                            }),
                            ui.dropdown({
                                className: 'dropdown-shape',
                                items: lang.imageShapes.tooltipShapeOptions,
                                click: function (e) {
                                    e.preventDefault();
                                    var $button = $(e.target);
                                    var $img    = $($editable.data('target'));
                                    var index   = $.inArray(
                                        $button.data('value'),
                                        lang.imageShapes.tooltipShapeOptions
                                    );
                                    $.each(options.imageShapes.shapes, function (index,value) {
                                        $img.removeClass(value);

                                        if ( $img.parent().hasClass( 'img__wrapper' ) ) {
                                            $img.parents('.img-popup').find('i').remove();
                                        }
                                        if ( $img.parent().hasClass( 'img__wrapper' ) ) {
                                            $img.unwrap();
                                        }
                                        if ( $img.parent().hasClass( value ) ) {
                                            $img.unwrap();
                                        }
                                    });
                                    if(options.imageShapes.shapes[index]) {
                                        $img.wrap( "<div class='"+options.imageShapes.shapes[index]+"'></div>" );
                                        $img.wrap( "<div class='img__wrapper'></div>" );
                                        $img.parent('.img__wrapper').append('<i></i>');
                                    }
                                    $img.addClass(options.imageShapes.shapes[index]);
                                    context.invoke('editor.afterCommand');
                                }
                            })
                        ]);
                        return button.render();
                    });
                }
            });
        }));
    };

    //custom test button
    var HelloButton = function (context) {
        var ui = $.summernote.ui;

        // create button
        var button = ui.button({
            contents: '<i class="fa fa-child"/> Hello',
            //tooltip: 'hello',
            click: function () {
                // invoke insertText method with 'hello' on editor module.
                context.invoke('editor.insertText', 'hello');
            }
        });

        return button.render();   // return button as jquery object
    };

    var sendFile = function (file, editor, welEditable) {
        var id_for_trumbowyg_upload = $('#id_for_trumbowyg_upload').val();

        data = new FormData();
        data.append("file", file);
        $.ajax({
            data: data,
            type: "POST",
            url: urlPrefix + '/api/admin/upload_file/' + id_for_trumbowyg_upload,
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                $('.input_wysiwyg').summernote("editor.insertImage", url, 'filename');
            }
        });
    };

    //факедитор
    var initWysiwyg = function () {
        $('.input_wysiwyg').summernote({
            styleTags: [
                'p','h1', 'h2', 'h3', 'h4',
                //tag всегда должен быть p
                { title: 'hightlight', tag: 'p', value: 'h4', className: 'text__hightlight'},
                { title: 'quote', tag: 'p', value: 'h5' , className: 'text__quote'},
                { title: 'attention (blue)', tag: 'p', value: 'h6' , className: 'text__attention'},
                { title: 'attention (green)', tag: 'p', value: 'h6' , className: 'text__attention m__green'},
                { title: 'attention (orange)', tag: 'p', value: 'h6' , className: 'text__attention m__orange'},
                { title: 'attention (gray)', tag: 'p', value: 'h6' , className: 'text__attention m__gray'},
                //'p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
            ],
            'toolbar': [
                //['mybutton', ['hello']],
                ['style', ['style']],
                ['cleaner',['cleaner']], // The Button
                //['font', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                ['font', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough']],
                //['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', /*'video',*/ 'hr']],
                ['view', ['fullscreen', 'codeview']],
                //['help', ['help']],
            ],
            tooltip: false,
            height: 600,
            'airMode': false,
            'prettifyHtml': true,
            'codemirror': {
                'mode' : 'default',
                'lineWrapping' : true,
                'lineNumbers': 'true',
                'theme': 'monokai',
            },
            callbacks: {
                onImageUpload: function(files, editor, welEditable) {
                    sendFile(files[0], editor, welEditable);
                },
                onInit: function() {
                    //$('.ui-helper-hidden-accessible').remove();
                    $('.note-toolbar-wrapper').removeAttr('style');
                }
            },
            popover: {
                image: [
                    ['custom', ['imageShapes']],
                    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                    //['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                ],
            },
            buttons: {
                hello: HelloButton
            },
            cleaner:{
                action: 'button', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                newline: '<br>', // Summernote's default is to use '<p><br></p>'
                notStyle: 'position:absolute;top:0;left:0;', // Position of Notification
                icon: '<i class="note-icon-eraser">super clean</i>',
                keepHtml: true, // Remove all Html formats
                keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>','<i>', '<a>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>', '<img>', '<div>'], // If keepHtml is true, remove all tags except these
                keepClasses: true, // Remove Classes
                badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
                badAttributes: ['style', 'start'], // Remove attributes from remaining tags
                limitChars: 0, // 0/false|# 0/false disables option
                limitDisplay: 'none', // text|html|both
                limitStop: false // true/false
            }
        });
    };

    return {
        init: function () {
            initCustomImageButtons();
            initWysiwyg();
        }
    };

}();

jQuery(document).ready(function() {
    if ($('.input_wysiwyg').length){
        AppwWsiwyg.init();
    }
});