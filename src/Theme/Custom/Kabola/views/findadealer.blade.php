@php
    $location = get_location(); 
    $dealers = get_dealers($location, 10);
    $lat = array_get($location, 'lat');
    $lng = array_get($location, 'lng');
@endphp
@extends('app')
@section('pageid')""@endsection
@section('bodyclass')"findadealer"@endsection
@section('css_header')
    @parent
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 100% !important;

        }

        #dealer_wrapper {
            float: left;
            width: 100%;
        }

        .gm-style-iw {
            width: 350px !important;
            top: 0 !important;
            left: 0 !important;
            border-radius: 2px 2px 0 0;
            max-height:200px;
        }
        .marker-info {
            height: 100% !important;
            left: 2px !important;;
            top: 1px !important;;
            width: 250px !important;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="{{ route_with_locale('home', []) }}">Home</a> //
            <span>{!! translate('kabola.dealers.find_a_dealer') !!}</span>
        </div>
    </div>
    <div class="section wrapper">
        <div class="dealers">
            <h1>{!! translate('kabola.dealers.find_a_dealer') !!}</h1>
            <form method="get" id="searchform">
                <input type="text" name="s" id="search_autocomplete"
                       placeholder="{!! translate('kabola.dealers.enter_your_location') !!}" value=""
                       onfocus="geolocate()">
                <input type="submit" value="`" class="Submit" name="submit">
            </form>
            <div id="dealer_wrapper">
                @include('dealers')
            </div>
        </div>
        <div class="map" id="map">
            <h3>Loading...</h3>
            {{--<i class="marker"></i>
            <div class="marker-info">
                <h3>Van Schaik Grafimedia</h3>
                <span class="adres">Populierenweg 47</span>
                <span class="adres2">3421 TX Oudewater</span>
                <span class="telephone">0348 56 30 55</span>
                <span class="website"><a href="http://www.vsgm.nl">VSGM.nl</a></span>
                <span class="emergencyline">0348 56 30 55</span>
            </div>--}}

        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        var autocomplete, map, geolocation, infowindow;
        var markers = [];
        $(function () {
            $('.dealers form').on('submit', function (event) {
                event.preventDefault();
                return false;
            });
        });

        function initAutocomplete() {

            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: {{ $lat }}, lng: {{ $lng }} },
                zoom: 9
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(geolocation);
                    map.setZoom(9);

                });
            }

            infowindow = new google.maps.InfoWindow({
                content: ''
            });


            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */(document.getElementById('search_autocomplete')),
                    {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', locatePlace);
            drawMarkers();
        }


        function boundMap() {
            var current_bounds = map.getBounds();
            for (var i = 0; i < markers.length; i++) {
                var marker_pos = markers[i].getPosition();
                if (!current_bounds.contains(marker_pos)) {
                    current_bounds = current_bounds.extend(marker_pos);
                }
            }
            map.fitBounds(current_bounds);
        }

        function locateSubmitPlace(evt) {
            evt.preventDefault();
            locatePlace();
            return false;
        }

        function locatePlace() {
            var place = autocomplete.getPlace();

            map.setCenter(place.geometry.location);
            map.setZoom(13);
            boundMap();
            $.ajax({
                url: "{{ route('kabola_dealers.ajax.location_result') }}",
                method: 'GET',
                data: {lat: place.geometry.location.lat(), lng: place.geometry.location.lng()}
            }).done(function (result) {
                $('#dealer_wrapper').html(result);
                drawMarkers();
            });
        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }

        function loadDealer(dealerMarker, data) {
            map.setCenter(dealerMarker.getPosition());
            map.setZoom(15);
            infowindow.setContent("<div style='height:250px; width:200px'><i class=\"marker\"></i><div class=\"marker-info\"><h3>" +
                    data.name + "</h3><span class=\"adres\">" + data.street + "</span><span class=\"adres2\">" +
                    data.postcode + " " + data.city + "</span><span class=\"telephone\">" + data.phone +
                    "</span><span class=\"website\"><a href=\"http://" + data.contact_address + "\">" + data.contact_address +
                    "</a></span><span class=\"emergencyline\">" + data.emergency_phone + "</span></div></div>");
            infowindow.open(map, dealerMarker);
        }
    </script>

    <script
            src="https://maps.googleapis.com/maps/api/js?v=3.20&key={{ get_option('kabola_dealers.google_maps_js_api_key', '') }}&libraries=places&callback=initAutocomplete&language={{ app()->getLocale() }}&region={{ strtoupper(app()->getLocale()) }}"
            async defer></script>
@endsection