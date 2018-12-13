var AppMain = function () {

    //инит любой DataTable в админке
    var initDataTable = function () {
        $('.table_sort').DataTable({
            //"ajax": "/admin/ajax/users/get",
            //"columns": [
            //    { "data": "email" }
            //],
            "order": [[ 0, "asc" ]], //сортировка по колонке
            stateSave: false, //сохранять в куки состояние таблицы
            "lengthMenu": [[10, 50, 200, -1], [10, 50, 200, "All"]],
            //"language": {
            //    "lengthMenu": "Показать _MENU_ записей на странице",
            //    "info": "Страница _PAGE_ из _PAGES_",
            //    "paginate": {
            //        "previous": "Предыдущая",
            //        "next": "Следующая"
            //    },
            //    "search": "Поиск по любому полю _INPUT_ "
            //},
            "fnReload": function () {
                //alert(1);
            },
            "fnDrawCallback": function () {
                //alert(2);
            },
            "fnInitComplete": function () {
                //alert(3);
            },
            "fnInfoCallback": function () {
                //alert(4);
            },
            "fnRowCallback": function () {
                //alert(5);
            },
            //"aoColumns": [null, null, { "sType": "natural" }, null, null, null]
        });
    };

    //main DataTable - get server side
    var initMainServerSide = function () {
        $(".main_server_side").each(function() {
            var $this = $(this);
            var $category = $this.data('category');
            var $url = $this.data('url');

            if($category) {
                var drawDataTable = $this.DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": $url,
                        "type": "POST",
                        "data": {category:$category}
                    },
                    pageLength: length,
                    "lengthMenu": [[10, 50, 200, -1], [10, 50, 200, "All"]],
                    "order": [[ 0, "desc" ]], //сортировка по колонке
                    columns: [
                        {data: 'id'},
                        {data: 'name', "searchable": true},
                        {data: 'created_at'},
                        {data: 'user'},
                        {data: 'status'},
                        //{data: 'location', "searchable": false},
                        //{data: 'status'},
                        {data: 'option', orderable: false, searchable: false, className: "text-right text-nowrap"},
                    ],
                });
            }
        });
    };

    //fix bootstrap tabs
    var initTabs = function () {
        if ($('.nav-tabs').length){
            // show active tab on reload
            if (location.hash !== '') {
                $('a[href="' + location.hash + '"]').tab('show');
            }
            else {
                //show first tab
                $(".nav-tabs >li:first-child").addClass("active");
                $(".tab-content >div:first-child").addClass("active");
            }

            // remember the hash in the URL without jumping
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                if(history.pushState) {
                    history.pushState(null, null, '#'+$(e.target).attr('href').substr(1));
                } else {
                    location.hash = '#'+$(e.target).attr('href').substr(1);
                }
            });
        }
    };

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

    //init DateTame for .form_date
    var initDateTame = function () {
        $('.form_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            orientation: "top right",
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        });
    };

    //дублировать поле файла или фото
    var initAddMoreImagesOrFiles = function () {
        if ($('.b-add-more-files, .b-add-more-images').length){
            $('.b-add-more-files, .b-add-more-images').each(function () {
                var max_fields      = 10; //maximum input boxes allowed
                var wrapper         = $(this).find("#input_fields_wrap"); //Fields wrapper
                var add_button      = $(this).find("#add_field_button"); //Add button ID
                var name            = $(this).data("name"); //name
                var x = 1; //initlal text box count

                if(!name) {
                    if($(this).hasClass('b-add-more-files')) name = 'files';
                    if($(this).hasClass('b-add-more-images')) name = 'images';
                    console.log('ADD NAME: <div class="b-add-more-files/images" data-name="files">');
                }

                $(add_button).click(function(e){ //on add input button click
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        if(x == 1) $(wrapper).append('<div><input type="file" name="'+name+'[]"/></div>');
                        else $(wrapper).append('<div><input type="file" name="'+name+'[]"/><button type="button" class="remove_button btn btn-danger btn-xs">remove</button></div>'); //add input box

                        x++; //text box increment
                    }
                });

                $(wrapper).on("click",".remove_button", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                });

                $(add_button).click();
            });
        }
    };

    //ajax удаление фото
    var initAjaxImageRemove = function () {
        if ($('.b-images').length){
            $(document).ready(function() {
                $('.b-images .remove_button').on('click', function(){
                    var file_id = $(this).data('id');
                    var parent_div = $(this).parent('div');

                    $.ajax({
                        url: urlPrefix + '/api/admin/image/'+file_id+'/destroy',
                        type: 'POST',
                        data: { },
                        success: function(data) {
                            $(parent_div).hide();
                        }
                    });
                });
            });
        }
    };

    //ajax обновление alt фото
    var initAjaxImageUpdateAlt = function () {
        $('.b-images .update_alt_button').on('click', function(){
            var thisButton = $(this);
            var image_id = thisButton.data('id');
            var image_alt = $('#alt_'+image_id).val();

            $( ".image-container .fa" ).remove();
            thisButton.before('<i class="fa fa-refresh"></i>');
            $.ajax({
                url: urlPrefix + '/api/admin/image/'+image_id+'/update_alt',
                type: 'POST',
                data: {alt: image_alt},
                success: function(data) {
                    $( ".image-container .fa" ).remove();
                    thisButton.before('<i class="fa fa-check"></i>');
                }
            });
        });
    };

    //ajax удаление файлов
    var initAjaxFileRemove = function () {
        if ($('.b-files').length){
            $(document).ready(function() {
                $('.b-files .remove_button').on('click', function(){
                    var file_id = $(this).data('id');
                    var parent_div = $(this).parent('div');

                    $.ajax({
                        url: urlPrefix + '/api/admin/file/'+file_id+'/destroy',
                        type: 'POST',
                        data: { },
                        success: function(data) {
                            $(parent_div).hide();
                        }
                    });
                });
            });
        }
    };

    //ajax подгружалка превьюшки
    var initAjaxUploadPreview = function () {
        if ($('.b-fileuploader-crop').length){
            $('.b-fileuploader-crop').each(function () {
                var crop_coords;
                var fileuploader = $(this).find("#fileuploader_crop");
                var button_crop = $(this).find("#button_crop");
                var popup_fileuploader_crop = $(this).find("#popup_fileuploader_crop");
                var popup_fileuploader_crop_crop_image = $(popup_fileuploader_crop).find("#crop_image");
                var object_type = fileuploader.data('object');
                var object_id = fileuploader.data('object_id');
                var aspect_ratio = fileuploader.data('aspect_ratio');
                var image_type = fileuploader.data('image_type');
                var aspect_ratio_arr;
                var jcrop_api;

                if(aspect_ratio !== 0) {
                    aspect_ratio_arr = aspect_ratio.split(':');
                    aspect_ratio = aspect_ratio_arr[0]/aspect_ratio_arr[1];
                }

                //подгрузить
                $(fileuploader).find('.fileuploader_crop_container').uploadFile({
                    url: urlPrefix + "/api/admin/image_upload",
                    fileName:"preview",
                    dragDrop:false,
                    multiple:false,
                    sequential:true, //последовательно
                    sequentialCount:1, //кол-во потоков
                    acceptFiles:"image/*",
                    allowedTypes:"jpg,jpeg,png,gif",
                    //maxFileCount:1,
                    maxFileSize:5000*1024,
                    formData: {'object_type':object_type, 'object_id':object_id, 'image_type':image_type},
                    showPreview:false,
                    //previewHeight: "100px",
                    //previewWidth: "100px",
                    nestedForms: false, //зашибенная штука - все формы в конце body и не мешают вложениям форма в форме
                    statusBarWidth:270,
                    showStatusAfterSuccess: false,
                    onSuccess:function(files,data,xhr,pd) {
                        //console.log(JSON.stringify(files));
                        //console.log(JSON.stringify(data));
                        //console.log(JSON.stringify(xhr));
                        //console.log(JSON.stringify(pd));

                        startCrop(data);
                    },
                    afterUploadAll:function(obj) { },
                    dragDropStr: "<span><b>Перетащите фото сюда</b></span>",
                    uploadStr:"" //текст - "Добавить фото"
                });

                //кропнуть
                $(button_crop).on('click', function() {
                    if(button_crop.hasClass('disabled')) return;

                    if(crop_coords) {
                        img_url = $(popup_fileuploader_crop_crop_image).attr('src');

                        $.ajax({
                            url: urlPrefix + '/api/admin/image_crop',
                            type: 'POST',
                            data: { crop_coords: crop_coords, img_url: img_url },
                            success: function(data) {
                                $(popup_fileuploader_crop).modal('hide');
                                $(fileuploader).css("background-image","url("+img_url+"?random="+ new Date().getTime());
                                $(fileuploader).find('img').attr("src",img_url+"?random="+ new Date().getTime()).show();
                                crop_coords = '';
                            }
                        });
                    }
                    else {
                        img_url = $(popup_fileuploader_crop_crop_image).attr('src');
                        $(popup_fileuploader_crop).modal('hide');

                        $(fileuploader).css("background-image","url("+img_url+"?random="+ new Date().getTime());
                        $(fileuploader).find('img').attr("src",img_url+"?random="+ new Date().getTime()).show();
                    }
                });

                //инциализировать кропалку
                function startCrop(url) {
                    if(jcrop_api) $(popup_fileuploader_crop_crop_image).data('Jcrop').destroy();

                    $(popup_fileuploader_crop_crop_image).attr('src',url);
                    $(popup_fileuploader_crop).modal('show');

                    //jcrop_api.setImage(url);

                    //кропалка
                    jcrop_api = $(popup_fileuploader_crop_crop_image).Jcrop({
                        onChange: checkCoords,
                        onSelect: checkCoords,
                        //setSelect: [0,0,150,150],
                        aspectRatio: aspect_ratio,
                        boxWidth: 500, //ограничивает макс размер фотки при кропе
                        boxHeight: 500 //ограничивает макс размер фотки при кропе
                    });

                    //setTimeout(function(){
                    //    jcrop_api.setSelect([0,0,10000,0]);
                    //}, 500);
                }

                function checkCoords(c) {
                    crop_coords = c;
                    button_crop.removeClass('disabled').removeClass('default');
                }
            });

            function realImgDimension(img) {
                var i = new Image();
                i.src = img.src;
                return {
                    naturalWidth: i.width,
                    naturalHeight: i.height
                };
            }
        }
    };

    //галочки связей элементов
    var initAjaxRelates = function() {
        $('.relate_checkbox').on('click', function () {
            var id1 = $(this).data('id1');
            var id2 = $(this).data('id2');
            var action = $(this).is(':checked');

            $.ajax({
                url: urlPrefix + '/api/admin/relate',
                type: 'POST',
                data: {id1: id1, id2: id2, action: action},
                success: function(data) {
                }
            });
        });
    };

    //теги
    var initTags = function () {
        $.fn.extend({
            select2_sortable: function(params){
                var select = $(this);
                $(select).select2(params);
                var ul = $(select).next(".select2-container").first("ul.select2-selection__rendered");
                ul.sortable({
                    placeholder : "ui-state-highlight",
                    forcePlaceholderSize: true,
                    items       : "li:not(.select2-search__field)",
                    tolerance   : "pointer",
                    stop        : function() {
                        $( $(ul).find(".select2-selection__choice").get().reverse() ).each(function() {
                            //console.log(this);
                            var title = $(this).attr("title");
                            var option = $(select).find( "option:contains(" + title + ")" );
                            //console.log(option);
                            $(select).prepend(option);
                        });
                    }
                });
            }
        });

        //select2 - выпадающий селект с тегами
        $(".js__select2").each(function() {
            var table = $(this).data('table');
            var type_id = $(this).data('type_id');
            var parent_id = $(this).data('parent_id');
            var allow_custom = $(this).data('custom');

            $(this).select2_sortable({
                tags: allow_custom,
                placeholder: "Please Select",
                allowClear: false,
                multiple: true,
                //minimumInputLength: 2,
                delay: 250, // wait 250 milliseconds before triggering the request
                ajax: {
                    multiple: true,
                    type: "POST",
                    url: urlPrefix + '/api/admin/tags',
                    data: function (params) {
                        return {
                            table: table,
                            type_id: type_id,
                            parent_id: parent_id,
                            q: params.term
                        }
                    },
                    dataType: 'json',
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    processResults: function (data) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.items
                        };
                    }
                },
            });
        });
    };

    //сменить автора статьи
    var initChangeAuthor = function () {
        if ($('.js__change-author').length){
            $('.js__change-author').on('click', function(){
                $(this).parents('.b__author').find('.author__wrapper').slideUp();
                $(this).parents('.b__author').find('.author__change').slideDown();
            });
        }
    };

    var initRemoveImage = function () {
        $('.js__remove-image').on('click', function(){
            var image_id = $(this).data('id');

            if(confirm('Delete? Are you sure?')) {
                $.ajax({
                    url: urlPrefix + '/api/admin/image/'+image_id+'/destroy',
                    type: 'POST',
                    data: { },
                    success: function(data) {
                        location.reload();
                    }
                });
            };
        });
    };

    return {
        init: function () {
            initDataTable();
            initMainServerSide();
            initTabs();
            initFormValidate();
            initDateTame();
            initAddMoreImagesOrFiles();
            initAjaxImageRemove();
            initAjaxImageUpdateAlt();
            initAjaxFileRemove();
            initAjaxUploadPreview();
            initAjaxRelates();
            initTags();
            initChangeAuthor();
            initRemoveImage();
        }
    };

}();

jQuery(document).ready(function() {
    AppMain.init();
});