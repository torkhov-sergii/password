var AppLocations = function () {

    var zoom = 3; //default
    var lat = 48.858250; //default
    var lng = 2.294496; //default
    var map; //карта
    var geocoder; //геокодер
    //var tormozilka_geocode; //поиск адреса с задежкой
    var last_address = '';
    var markersArray = []; //массив маркеров на карте
    var marker = ''; //активный маркер
    var geocoder_location = {'lat':'','lng':'','city':'','country':'','postal':''}; //геокодер сохраняет сюда найденный адресс

    var $html = {
        'map': $('#js__locations-map'), //div нашей карты - locations_map
        'fields_wrapper': $('.js__locations__fields-wrapper'), //fields wrapper
        'manually_fields': $('.js__item__manually-fields'), //поля мануального ввода адреса
    };

    var isMarkerDraggable = $html.map.data('is_marker_draggable');
    var isManuallyEnabled = 0;

    var initMap = function () {
        map = new google.maps.Map($html.map[0], {zoom: zoom, center: { lat: lat, lng: lng } });

        geocoder = new google.maps.Geocoder();

        placeMarkersFromJson();

        if(isMarkerDraggable) {
            google.maps.event.addListener(map, 'click', function(event) {
                marker = placeMarker(map, event.latLng, '', isMarkerDraggable);
            });
        }
    };

    //поиск адреса
    var locationSearch = function (el) {
        locations_input_add_remove();
        var address = $(el).val();
        var item = $(el).parents('.js__locations__item');

        tormozilka_geocode(address, item);
    };

    //тормозилка для геокодера https://learn.javascript.ru/settimeout-setinterval
    var throttle = function(func, ms) {
        var isThrottled = false,
            savedArgs,
            savedThis;

        function wrapper() {

            if (isThrottled) { // (2)
                savedArgs = arguments;
                savedThis = this;
                return;
            }

            func.apply(this, arguments); // (1)

            isThrottled = true;

            setTimeout(function() {
                isThrottled = false; // (3)
                if (savedArgs) {
                    wrapper.apply(savedThis, savedArgs);
                    savedArgs = savedThis = null;
                }
            }, ms);
        }
        return wrapper;
    };

    //задержка для поиска геокодером
    var tormozilka_geocode = throttle(function(address, item){
        geocoderSearch(geocoder, map, address, item);
    }, 1000);

    //поиск геокодер
    var geocoderSearch = function(geocoder, resultsMap, address, item) {
        var location_input = item.find('.js__item__location-input');
        var location_input_error = item.find('.js__item__location-input-error');
        var location_country_input = item.find('.js__item__country-input');
        var location_city_input = item.find('.js__item__city-input');
        var location_postal_input = item.find('.js__item__postal-input');
        var location_lat_input = item.find('.js__item__lat-input');
        var location_lng_input = item.find('.js__item__lng-input');
        var location_manually_input = item.find('.js__item__manually-input');

        if(address.length > 3 && address != last_address) {
            clearOverlays();
            last_address = address;

            geocoder.geocode({'address': address}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    location_input.removeClass('error');
                    location_input_error.hide();

                    resultsMap.setCenter(results[0].geometry.location);

                    marker = placeMarker(resultsMap, results[0].geometry.location, '', isMarkerDraggable);
                    markersArray.push(marker);

                    //меняем зум
                    if (results[0].geometry.viewport) resultsMap.fitBounds(results[0].geometry.viewport);

                    //записываем кординаты
                    location_lat_input.val(results[0].geometry.location.lat());
                    location_lng_input.val(results[0].geometry.location.lng());
                    geocoder_location.lat = results[0].geometry.location.lat();
                    geocoder_location.lng = results[0].geometry.location.lng();

                    //адрес не manually а автоматом
                    location_manually_input.val(0);

                    //выбираем адрес
                    var arrAddress = results[0].address_components;
                    $.each(arrAddress, function (i, address_component) {
                        //console.log('address_component:'+i);
                        if (address_component.types[0] == "country"){
                            //console.log("country:"+address_component.long_name);
                            geocoder_location.country = address_component.long_name;
                            location_country_input.val(address_component.long_name);
                        }

                        if (address_component.types[0] == "locality"){
                            //console.log("city:"+address_component.long_name);
                            geocoder_location.city = address_component.long_name;
                            location_city_input.val(address_component.long_name);
                        }

                        if (address_component.types[0] == "postal_code"){
                            //console.log("postal_code:"+address_component.long_name);
                            geocoder_location.postal = address_component.long_name;
                            location_postal_input.val(address_component.long_name);
                        }

                        if (address_component.types[0] == "route"){
                        }

                        if (address_component.types[0] == "street_number"){
                        }
                    });
                } else {
                    if(isManuallyEnabled) {
                        location_input.addClass('error');
                        location_input_error.show();
                        $html.manually_fields.slideDown();
                        location_manually_input.val(1);
                    }
                }
            });
        }
    };

    //удаление всех маркеров с карты
    var clearOverlays = function() {
        for (var i = 0; i < markersArray.length; i++ ) {
            markersArray[i].setMap(null);
        }
        markersArray.length = 0;
    };

    //если на карте должны быть метки - нанести их и спозиционировать карту
    var placeMarkersFromJson = function() {
        var bounds = new google.maps.LatLngBounds(); //массив точек

        ////добавляем метки
        var locations = $html.map.data('locations');
        if(locations) {
            $.each(locations, function() {
                //alert(this.id + " " + this.type);
                var location = this;

                if(location.lat && location.lng) {
                    var position = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lng));

                    marker = placeMarker(map, position, location.location, isMarkerDraggable);

                    bounds.extend(position); //добавляем позиции маркеров
                    markersArray.push(marker); //добавлем маркеры в массив
                }
            });
        }

        //меняем зум
        if(markersArray.length > 0) map.fitBounds(bounds);

        //уменьшаем зум
        google.maps.event.addListenerOnce(map, 'idle', function() {
            var zoom = map.getZoom();
            //console.log(zoom);
            if(zoom > 12) zoom = 12;
            map.setZoom(zoom);
        });
    };

    //добавить маркер на карту
    var placeMarker = function(map, location, title, draggable) {
        if(draggable) {
            if(marker) marker.setMap(null); //удалить предидущий маркет
        }

        marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable:draggable,
            title: title,
        });

        if(draggable) {
            google.maps.event.addListener(marker, 'dragend', function(event) {
                save_location();
            });

            function save_location() {
                var item = $html.fields_wrapper;
                var location_lat_input = $(item).find('.js__item__lat-input').val(marker.getPosition().lat());
                var location_lng_input = $(item).find('.js__item__lng-input').val(marker.getPosition().lng());
            }

            save_location();
        }

        return marker;
    };

    //добавление и удаление полей
    var locations_input_add_remove = function() {
        var input_box = $html.fields_wrapper.find('.js__locations__item').first();
        var count_all_item = parseInt($('.js__locations__item').length);
        var count_not_empty_item = 0;

        //считаем заполненные
        $('.js__locations__item').each(function () {
            var val = $(this).find('input').val();
            $(this).find('.location_title span').html(count_not_empty_item+1);
            if(val != '') count_not_empty_item ++;
        });

        //console.log(count_all_item);
        //console.log(count_not_empty_item);
        //console.log('count_all_item:'+count_all_item+' - count_not_empty_item:'+count_not_empty_item);

        //добавить если все заполнены
        if(count_all_item === count_not_empty_item) {
            if(!$html.fields_wrapper.hasClass('m-no-additional-fields')) {
                input_box_copy = input_box.clone();
                input_box_copy.find('input').val('');
                input_box_copy.find('textarea').val('');
                input_box_copy.find('.location_title span').html(count_not_empty_item+1);
                $($html.fields_wrapper).append(input_box_copy);
            }
        }

        //удалить лишние
        if(count_all_item > count_not_empty_item+1) {
            $('.js__locations__item').each(function () {
                var val = $(this).find('input').val();
                if(val == '' && $('.js__locations__item').length > 1) $(this).remove();
            });

            locations_input_add_remove();
        }
    }

    return {
        init: function () {
            initMap();

            //поиск адреса CV, компании итд
            $(document).on('keyup keypress click', '.js__item__location-input', function(e){
                locationSearch(this);

                if(e.keyCode == 13) {
                    //отключаем сабмит по энтеру
                    e.preventDefault();
                    return false;
                }
            });

            locations_input_add_remove();

            //show map
            $('.js__locations-show').on('click', function () {
                $($html.map).slideToggle(function () {
                    google.maps.event.trigger(map, 'resize');
                    placeMarkersFromJson();
                });
            });
        }
    };

}();

jQuery(document).ready(function() {
    if ($('.b-locations').length){
        AppLocations.init();
    }
});





////////////////////old///////////////////////

//$(document).ready(function() {
    // //добавлении офиса компании при редактировании вакансии - popup
    // $('#popup_location').on('shown.bs.modal', function (e) {
    //     initializeMap();
    // });


    // //поиск адреса CV, компании итд
    // $(document).on('keyup keypress click', '.location_country_input, .location_city_input', function(e){
    //     locations_input_add_remove();
    //     var item = $(this).parents('.locations_map_item');
    //     var country = item.find('.location_country_input').val();
    //     var city = item.find('.location_city_input').val();
    //     var address = country+' '+city;
    //
    //     //console.log(address);
    //
    //     if(e.keyCode == 13) {
    //         //отключаем сабмит по энтеру
    //         e.preventDefault();
    //         return false;
    //     }
    //
    //     tormozilka_geocode(address, item);
    // });

    // //удаление полей по нажатию на крестик
    // $(document).on('click', '.locations_map_item .remove', function(){
    //     //удаляем метку на карте
    //     var lat = $(this).parent('.locations_map_item').find('.location_lat_input').val();
    //     var lng = $(this).parent('.locations_map_item').find('.location_lng_input').val();
    //     for (var i = 0; i < markersArray.length; i++ ) {
    //         if((markersArray[i].getPosition().lat()+'').substr(0, 6) == lat.substr(0, 6) && (markersArray[i].getPosition().lng()+'').substr(0, 6) == lng.substr(0, 6)) {
    //             markersArray[i].setMap(null);
    //         }
    //     }
    //
    //     //удаляем поле
    //     $(this).parent('.locations_map_item').remove();
    //
    //     locations_input_add_remove();
    // });

    // //google map reinit - глюк если была открыта другая вкладка тут http://trabaj.tvr/usuario/ajustes/informacion_personal#tab_1_2
    // $('.google-map-reinit').on('click', function(){
    //     setTimeout(function () {
    //         google.maps.event.trigger(map, 'resize');
    //
    //         placeMarkersFromJson();
    //     }, 1000);
    // });
//});

//click location-locations-list (перечень локаций компании)
// $('.location-locations-list li').on('click', function(){
//     var index = $(this).index();
//     map.setCenter(markersArray[index].getPosition());
//     map.setZoom(10);
//
//     $('.location-locations-list li').removeClass('active');
//     $(this).addClass('active');
// });