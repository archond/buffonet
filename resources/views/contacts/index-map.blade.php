{{--{{dd($contacts)}}--}}

{{--<div class="fa fa-remove" id="hide-map"></div>--}}
{{--<div id="map" style="width: 100%;height: 300px;"></div>--}}
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBscL3X5ebQPR9R_3SscZvMicZebaBzyKg&language=en&libraries=places&callback=initMap"
        async defer></script>
<script src="https://googlemaps.github.io/js-marker-clusterer/src/markerclusterer.js"></script>


<style>
    #map {
        width: 100%;
        height: 300px;
        /*min-height: 200px;*/
        padding: 0.5em;
    }

    /*#map h3 { text-align: center; margin: 0; }*/
</style>


<div id="wrapper" style="position: relative; margin:  10px">
    <div id="map"></div>
</div>


<script>
    $(function () {
        $("#map").resizable();
    });

    $('#map').resize(function () {
        google.maps.event.trigger(map, "resize");
    });


    $('#hide-map').on('click', function () {
        $('#map').addClass('hidden');
        $(this).addClass('hidden');
    });


    function initMap() {

        // var center_cords = {lat: 56.9569844, lng: 24.1174842};
        var center_cords = {lat: 56.9569844, lng: 24.1174842};
        var infowindow;
        //

//        var marker_pos = {lat:56.9579813, lng:24.00306};


        var map = new google.maps.Map(document.getElementById('map'), {
            center: center_cords,
            zoom: 11,
            // title:"Hello World!",
            // mapTypeId: google.maps.MapTypeId.ROADMAP
        });


        var marker;

        var markers = [];

        var infoWindows = [];


        geocoder = new google.maps.Geocoder();
        var bounds = new google.maps.LatLngBounds();

                <? $addressCount=0;?>
                @foreach($contacts as $contact)
        {{--{{dd(Route::currentRouteName())}}--}}

        @if(in_array($contact['id'], explode(',', Request::get('contacts_checked')) ) || Route::currentRouteName() != 'contacts.index' )
                @foreach($contact['addresses'] as $address)

                <? $addressCount++;?>



        var marker_pos ={{ ($address['lat'] && $address['lng']) ? '{lat:'.$address['lat'].',  lng:'.$address['lng'].' }'  : '{}'  }};


        var markerContent = '{{  isset($contact['title']) ?  is_array($contact['title'] ) ? implode(",", $contact['title'] ) : $contact['title'] : null }} <a href="{{ route('contacts.show', $contact['id'])}}" target="_blank"><i class="fa fa-info-circle"></i></a><br>' +
                '{{_('Type')}}: {{ isset($contact['type'][0]) ? $contact['type'][0] : _('Type is not set') }}<br>' +

                '{{$address['marker_address']}}, ' +
                '{{$address['city']['name']}}, ' +
                '{{$address['country']['name']}}, ' +
                '{{$address['marker_zip']}}<br>' +
                '{{$contact['mainobejects']['phone']}}' +
                '{{isset($contact['phone']) ? is_array($contact['phone'] ) ? ', '.implode(",", $contact['phone'] ) : $contact['phone'] : null  }}<br>' +
                '{{isset($contact['e-mail']) ? is_array($contact['e-mail'] ) ? implode(",", $contact['e-mail'] ) : $contact['e-mail'] : null  }}<br>' +
                @foreach([1,2,3,4,5] as $star) @if($star <= $contact['rating_overall']) '<span class="fa fa-star"></span>' + @else '<span class="fa fa-star-o"></span>' + @endif @endforeach
                        '({{$contact['rating_count']}})';

        addMarker(marker_pos, markerContent);

        @endforeach
        @endif

        @endforeach

                map.fitBounds(bounds);


        {{--@if(count($contact['addresses'])==1)--}}
        @if($addressCount==1)

        var listener = google.maps.event.addListener(map, "idle", function () {
                    map.setZoom({{$contact['addresses'][0]['map_zoom']}});
                    google.maps.event.removeListener(listener);
                });
                @endif





        var homeControlDiv = document.createElement('div');
        var homeControl = new HomeControl(homeControlDiv, map);
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);

        function HomeControl(controlDiv, map) {
            controlDiv.style.padding = '5px';
            var controlUI = document.createElement('div');
            controlUI.style.backgroundColor = '#D7D7D7';
            controlUI.style.border = '1px solid';
            controlUI.style.cursor = 'pointer';
            controlUI.style.textAlign = 'center';
            controlUI.title = '{{_('Close map')}}';
            controlDiv.appendChild(controlUI);
            var controlText = document.createElement('div');
            controlText.style.fontFamily = 'Arial,sans-serif';
            controlText.style.fontSize = '12px';
            controlText.style.paddingLeft = '4px';
            controlText.style.paddingRight = '4px';
            controlText.innerHTML = '<i id="hide-map" class="fa fa-remove"></i>'
            controlUI.appendChild(controlText);

            // Setup click-event listener: simply set the map to London
            google.maps.event.addDomListener(controlUI, 'click', function () {
                $('#map').addClass('hidden');
            });

        }

        var mcOptions = {
            gridSize: 50,
            maxZoom: 15,
            imagePath: 'https://raw.githubusercontent.com/googlemaps/v3-utility-library/master/markerclustererplus/images/m'
        };

        var markerCluster = new MarkerClusterer(map, markers, mcOptions);

//        var markerCluster = new MarkerClusterer(map, markers, {imagePath: 'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m'});


//------------------------------------------------------------
//        for (var i = 0; i < markers.length; i++) {
//            var marker = markers[i];
//            var infowindow = new google.maps.InfoWindow({
//                content: "aaaa"
//            });
//
//            google.maps.event.addListener(marker, 'click', function () {
//                infowindow.open(map, this);
//            });
//        }
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


// ------------------------------------------------------------
//        for (var i = 0; i < markers.length; i++) {
//            var marker = markers[i];
//
//            google.maps.event.addListener(marker, 'dblclick', function () {
//                marker.setMap(null);
//            });
//        }
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


//        var marker_pos ={lat:56.9579813, lng:24.00306};
//        addMarker(marker_pos);


        // EVENT LISTENERS
//        document.getElementById('country').addEventListener('change', function () {
//            var country = country_select.value;
//
//            city_select.value = 0;
//
//            address_select.value = '';
//            address_select.disabled = true;
//            if (country == 0) {
//                city_select.disabled = true;
//
//            } else {
//                city_select.disabled = false;
//            }
//
//            findAddress(country);
//            map.setZoom(6);
//        });
//
//        document.getElementById('city').addEventListener('change', function () {
//            var country = country_select.value;
//            var city = city_select.value;
//            var data = country + ', ' + city;
//            findAddress(data);
//            map.setZoom(12);
//
//            address_select.value = '';
//            if (city == 0) {
//                address_select.disabled = true;
//            } else {
//                address_select.disabled = false;
//            }
//
//        });
//
//        document.getElementById('address').addEventListener('change', function () {
//            var country = country_select.value;
//            var city = city_select.value;
//            var address = address_select.value;
//            var data = country + ', ' + city + ', ' + address;
//            findAddress(data);
//            map.setZoom(14);
//
//        });


//        map.addListener('click', function (event) {
//            addMarker(event.latLng);
//        });

//        map.addListener('idle', function (event) {
//            getMarkerData(marker);
//        });

        google.maps.event.addListener(map, 'click', function (event) {
            placeMarker(event.latLng);
        });


        // FUNCTIONS

        var marker1;

        function placeMarker(location) {
            if (marker1) {
                marker1.setPosition(location);
            } else {
                marker1 = new google.maps.Marker({
                    position: location,
                    map: map,
//                    icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
//                    icon: 'https://cdn1.iconfinder.com/data/icons/Map-Markers-Icons-Demo-PNG/48/Map-Marker-Ball-Azure.png'
                    icon: '{{asset('/img/Map-Marker-Ball-Azure.png') }}'
                });
            }
        }


        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        function addMarker(location, markerContent) {
//            deleteMarkers();
            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: false,
            });


            bounds.extend(marker.getPosition());


            //
            var infowindow = new google.maps.InfoWindow({
                content: markerContent
            });

            infoWindows.push(infowindow);


            google.maps.event.addListener(marker, 'click', function () {
                for (var i = 0; i < infoWindows.length; i++) {
                    infoWindows[i].close();
                }

                infowindow.open(map, this);
            });
            //

//            google.maps.event.addListener(marker, 'dblclick', function () {
//
//                marker.setMap(null);
//            });


            markers.push(marker);
            console.log(marker);
            getCity(location);
            getMarkerData(marker);


            google.maps.event.addListener(marker, 'dragend', function () {
                getMarkerData(marker);
            });

        }

        google.maps.event.addListener(map, 'click', function () {
            if (infowindow) {
                infowindow.close();
            }
        });


        function findAddress(data) {
            console.log(data);

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
                                // console.info('aaa', results);
                                console.log(results);
                                var value = add.split(",");

                                count = value.length;


                                city = value[count - 3];
                                code = value[count - 2];
                                country = value[count - 1];

                                // console.log("City: ", city);
                                // console.log("Country: " + country);
                                // console.log("Code: ", code);
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

        function getMarkerData(data) {
            console.info(data.getPosition().lat());
//            var data = {
//                'map_center': map.getCenter(),
//                'map_zom': map.getZoom(),
//                'marker_position': data.getPosition(),
//                'marker_country': country_select.value,
//                'marker_city': city_select.value,
//                'marker_address': address_select.value,
//            }
//
//            console.info('Map data ', data);
        }

        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

        function clearMarkers() {
            setMapOnAll(null);
        }

    }

</script>

