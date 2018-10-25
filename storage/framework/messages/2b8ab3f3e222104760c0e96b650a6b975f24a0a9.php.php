<div class="input-group hidden default-div default-hidden-div" style="margin-bottom: 15px;">
    <div class="form-group111  my-map-group map-control ">
        <?php echo e(Form::select('markers[country_id][]', $countries->pluck('name', 'id') , 1, ['class'=>'form-control col-sm-12 myselect-country country', 'placeholder'=>_('Select country..')] )); ?>

        <?php echo e(Form::select('markers[city_id][]', [] , null, ['class'=>'form-control col-sm-12 myselect-city city', 'placeholder'=>_('Select city..'), ''] )); ?>


        <?php echo e(Form::text('markers[address][]', '', ['class'=>'form-control address', 'disabled'])); ?>

        <?php echo e(Form::text('markers[marker_zip][]', null, ['class'=>'form-control zip', 'disabled', 'placeholder'=>'zip'])); ?>


        <?php echo e(Form::hidden('markers[address_id][]', null, ['class'=>'adress_id'])); ?>

        <?php echo e(Form::hidden('markers[map_center][]', null, ['class'=>'map_center'])); ?>

        <?php echo e(Form::hidden('markers[map_zoom][]', null, ['class'=>'map_zoom'])); ?>

        <?php echo e(Form::hidden('markers[marker_position][]', null, ['class'=>'marker_position'])); ?>


        <?php /*<?php echo e(Form::hidden('markers[marker_city][]', null, ['class'=>'marker_city'])); ?>*/ ?>
        <?php echo e(Form::hidden('markers[marker_address][]', null, ['class'=>'marker_address'])); ?>

        <?php /*<?php echo e(Form::hidden('markers[marker_zip][]', null, ['class'=>'marker_zip'])); ?>*/ ?>
        <div class="map" style="width: 100%;height: 300px;"></div>
    </div>
    <span class="input-group-addon remove-button btn-danger"><i class="fa-remove"></i></span>
</div>


<?php /* te izvadīsim esošās adrese ->kartes->markerus */ ?>
<?php /*<?php echo e(dd($addresses)); ?>*/ ?>

<?php if(isset($addresses)): ?>
    <?php foreach($addresses as $address): ?>
        <div class="input-group default-div"  style="margin-bottom: 15px;">
            <div class="form-group111  my-map-group map-control">
                <?php echo e(Form::select('markers[country_id][]', $countries->pluck('name', 'id') , isset($address->country_id) ? $address->country_id : null, ['class'=>'form-control col-sm-12 myselect-country country', 'placeholder'=>_('Select country..')] )); ?>

                <?php echo e(Form::select('markers[city_id][]', isset($address->country->cities) ? $address->country->cities->pluck('name', 'id') : null, isset($address->city_id) ? $address->city_id : null, ['class'=>'form-control col-sm-12 myselect-city city', 'placeholder'=>_('Select city..'), isset($address->city_id) ? :'disabled'] )); ?>


                <?php echo e(Form::text('markers[address][]',isset($address->marker_address) ? $address->marker_address : null, ['class'=>'form-control address', isset($address->marker_address) ? :'disabled'])); ?>

                <?php echo e(Form::text('markers[marker_zip][]', isset($address->marker_zip) ? $address->marker_zip : null, ['class'=>'form-control zip', isset($address->marker_zip) || isset($address->marker_address) ? :  'disabled'])); ?>


                <?php echo e(Form::hidden('markers[address_id][]', $address->id, ['class'=>'adress_id'])); ?>

                <?php echo e(Form::hidden('markers[map_center][]', $address->map_center, ['class'=>'map_center'])); ?>

                <?php echo e(Form::hidden('markers[map_zoom][]', $address->map_zoom, ['class'=>'map_zoom'])); ?>

                <?php echo e(Form::hidden('markers[marker_position][]', $address->marker_position, ['class'=>'marker_position'])); ?>


                <?php /*<?php echo e(Form::hidden('markers[marker_city][]', $address->marker_city, ['class'=>'marker_city'])); ?>*/ ?>
                <?php echo e(Form::hidden('markers[marker_address][]', $address->marker_address, ['class'=>'marker_address'])); ?>

                <?php /*<?php echo e(Form::hidden('markers[marker_zip][]', $address->marker_zip, ['class'=>'marker_zip'])); ?>*/ ?>
                <div class="map" style="width: 100%;height: 300px;"></div>
            </div>
            <span class="input-group-addon remove-button btn-danger"><i class="fa-remove"></i></span>
        </div>
        <script>
            // function initMap() {
            // mapEach($('.default-div'));
            // }
        </script>
    <?php endforeach; ?>
<?php endif; ?>



<?php /* beidzam izvadīt esoša kartes, markerus*/ ?>
<script>
    $(document).ready(function () {
//        $('body').on('click', '.my-map-group', function () {
//            $(this).closest('.input-group').find('.add-button').click(function () {
//                console.log('clicked');
//            });
//        });
//        function initMap() {
//            mapEach($('.default-div'));
////            addMarker({56.8205293, 24.50706349999996});
//        }
    });
    // markers
    function initMap() {

        var first_load = 2;
        console.info('initMap');
        $('.default-div').each(function (index, Element) {

            console.log('1st MAP ZOOM: ', $('.map_zoom', this).val());

            setMap(
                    $(this),
                    $('.marker_position', this).val(),
                    $('.map_center', this).val(),
                    $('.map_zoom', this).val(),
                    first_load
            );
            // console.log('2st MAP ZOOM: ', $('.map_zoom', this).val());


            // });
        });
        // mapEach($('.default-div'));
    }

    function setMap(div, init_marker_latlng, init_map_center, init_map_zoom, first_load) {


        // console.log('first_load: ' + first_load +' | '+ bb +' | '+ init_map_center +' | '+ init_map_zoom +' | '+ first_load);
        // console.log('first_load 2: ', first_load);

        // }


        // function setMap(div) {
        console.log('init_map_center', init_map_center);

        // $(div).find('.map-control').each(function (index, Element) {
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        var block = $('.map-control', div)[0];

        console.log('block', block);


        var map_box = $('.map', block)[0];
        var center_cords = {lat: 56.9569844, lng: 24.1174842};
//            console.log('!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
        var map = new google.maps.Map(map_box, {
            center: center_cords,
            zoom: 6,
            // mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker;
        var markers = [];
        geocoder = new google.maps.Geocoder();
        var bounds = new google.maps.LatLngBounds();


//            var city_select;
//            var address_select;
//            var country_select;

        // EVENT LISTENERS
        $(".country", block)[0].addEventListener('change', function () {
            var country_select = this;
            updateCityFroDB(country_select);
            var country = this.options[this.selectedIndex].innerHTML;
            console.log('country', country);
            // console.log('country_select.value', country_select.value);
            var city_select = $(this).parent().find('.city:first')[0];
            var city = '';
            var address_select = $(this).parent().find('.address')[0];
            var zip_select = $(this).parent().find('.zip')[0];
//                city_select.value = 0;
            console.log('cc', city_select);
            city_select.value = '';
            address_select.value = '';
            zip_select.value = '';
            // console.log('city_select', city_select);
            address_select.disabled = true;
            // console.log('city_select.disabled', city_select.disabled);
            // console.log('country_select.value', country_select.value);
            if (country_select.value == '') {
                city_select.disabled = true;
                address_select.disabled = true;
                zip_select.disabled = true;
                findAddress(0);
//                    deleteMarkers();
            } else {
                city_select.disabled = false;
                findAddress(country);
            }
            // console.log('city_select.disabled',city_select.disabled);
            // console.log('city_select',city_select);
//                console.log('country',country);
            map.setZoom(6);
        });

        $('.city', block)[0].addEventListener('change', function () {
            var city_select = this;
            var city = this.options[this.selectedIndex].innerHTML;
//                console.log('city', city);
            country_select = $(this).parent().find('.country')[0];
            var country = country_select.options[country_select.selectedIndex].innerHTML;
//                console.log('country click city', country);
//                console.log('city click city', city);
            address_select = $(this).parent().find('.address')[0];
            var address = address_select.value;
            var zip_select = $(this).parent().find('.zip')[0];
//                var zip = zip_select.value;
            var data = country + ', ' + city;
//                console.log('data click city', data);
            findAddress(data);
            map.setZoom(12);
            zip_select.value = '';
            address_select.value = '';
            address = '';
            zip = '';
//                console.log('city_select.value ', city_select.value );
            if (city_select.value == '') {
                address_select.disabled = true;
                zip_select.disabled = true;
            } else {
                address_select.disabled = false;
                zip_select.disabled = false;
            }
        });
        $(".address", block)[0].addEventListener('change', function () {
            var address_select = this;
            country_select = $(this).parent().find('.country')[0];
            country = country_select.options[country_select.selectedIndex].innerHTML;
            city_select = $(this).parent().find('.city')[0];
            city = city_select.options[city_select.selectedIndex].innerHTML;
            zip_select = $(this).parent().find('.zip')[0];
            var data = country + ', ' + city + ', ' + address_select.value;
            findAddress(data);
            map.setZoom(14);
        });
        $(".zip", block)[0].addEventListener('change', function () {
            var zip_select = this;
            $('.marker_zip', div).val(zip_select.value);
//                getMarkerData($(this).closest('map-control') );
        });
//        map.addListener('click', function (event) {
//            addMarker(event.latLng);
//        });
        map.addListener('idle', function (event) {
            getMarkerData(marker);
        });
        // FUNCTIONS
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        function addMarker(location) {
            console.warn(location);
            deleteMarkers();
            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true,
            });
            markers.push(marker);
            console.log(marker);
            getCity(location);
            getMarkerData(marker);
            google.maps.event.addListener(marker, 'dragend', function () {
                getMarkerData(marker);
            });
        }

        function findAddress(data) {
            console.log(data);
            console.log('data ', data);
            if (data == 0) {
                map.setZoom(6);
                map.setCenter(center_cords);
                deleteMarkers();
            } else {
                geocoder.geocode({'address': data}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        addMarker(results[0].geometry.location);
                    } else {
                        console.warn('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }
            ;
        }

        function getCity(cords) {
            geocoder.geocode(
                    {'latLng': cords},
                    function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                var add = results[0].formatted_address;
                                console.log(results);
                                var value = add.split(",");
                                count = value.length;
                                city = value[count - 3];
                                code = value[count - 2];
                                country = value[count - 1];
                                console.log("City: ", city);
                                console.log("Country: " + country);
                                console.log("Code: ", code);
                            }
                            else {
                                console.warn("address not found");
                            }
                        }
                        else {
                            console.warn("Geocoder failed due to: " + status);
                        }
                    }
            );
        };

        // LOAD MAP DATA


        if (init_marker_latlng != '') { //Магическая и долбанная строка хз почему но без неё c*ка не работает!!!
            if (first_load == 2) {
                LoadMapData();
            }
            ;

            function LoadMapData() {
                console.info(init_map_zoom);
                map.setZoom(parseInt(init_map_zoom));

                var cut_init_map_center = init_map_center.split(",");
                map.setCenter({lat: parseFloat(cut_init_map_center[0]), lng: parseFloat(cut_init_map_center[1])});

                var marker_latlng_value = init_marker_latlng.split(",");
                addMarker({lat: parseFloat(marker_latlng_value[0]), lng: parseFloat(marker_latlng_value[1])});
            };
        }
        ;


        function getMarkerData(data) {
            $('.map_center', div).val(map.getCenter().lat() + ',' + map.getCenter().lng());
            $('.map_zoom', div).val(map.getZoom());
            if(marker && marker.getPosition){
                $('.marker_position', div).val(marker.getPosition().lat() + ',' + marker.getPosition().lng());
            }

            // if (country != '') {


            if (typeof country != 'undefined') {
                $('.marker_country', div).val(country);
            } else {
                $('.marker_country', div).val('');
            }


//            $('.country', div).val($('.myselect-country option:selected', div).text());
            $('.marker_city', div).val($('.myselect-city option:selected', div).text());
            $('.marker_address', div).val($('.address', div).val());
//                console.log('map.getPosition()'+ marker.getPosition())
//                $('.marker_address', div).val(address_select.value);

            if (typeof zip_select != 'undefined') {
                $('.marker_zip', div).val(zip_select.value);
            } else {
                $('.marker_zip', div).val('');
            }
            ;


            // var data = {
            //     'map_center': map.getCenter(),
            //     'map_zoom': map.getZoom(),
            //     'marker_position': data.getPosition(),
            //     'marker_country': country_select.value,
            //     'marker_city': city_select.value,
            //     'marker_address': address_select.value,
            // }
            // console.info('Map data ', data);
        }

        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

        function clearMarkers() {
            setMapOnAll(null);
        }

        function updateCityFroDB(select) {
            var changedElement = select;
            console.log('changedElement', changedElement.value);
            var id = changedElement.value;
            var url = '/<?php echo e($selectedLanguage['abbr']); ?>/country/' + id + '/get-cities';
            $.ajax({
                method: "GET",
                dataType: "json",
                url: url,
                success: function (data) {
                    var options = '';
                    $.each(data, function (key, value) {
                        options = options + '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    options = '<option value="">-</option>' + options;
                    if (!options) {
                        return false;
                    }
                    var divOptions = options;
                    var citySelect = $(changedElement).closest('.input-group').find('.myselect-city');
//
                    citySelect.find('option').remove();
                    citySelect.append(divOptions);
                }
            });
        }


        //}); //end each
    }
</script>


<?php if( !isset($googleMapFileIsLoaded) ): ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBscL3X5ebQPR9R_3SscZvMicZebaBzyKg&language=en&libraries=places&callback=initMap" async defer></script>
<?php endif; ?>
<? $googleMapFileIsLoaded = 1;?>

