@section('header.scripts')
    @parent

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 400px;
        }
    </style>
@endsection

<div class="form-group">
    <label for="name">Dealer naam</label>
    {!! Form::text('name', array_get($dealer, 'name'), ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="street">Straat</label>
    {!! Form::text('street', array_get($dealer, 'street'), ['class' => 'form-control', 'id' => 'street']) !!}
</div>

<div class="form-group">
    <label for="postcode">Postcode</label>
    {!! Form::text('postcode', array_get($dealer, 'postcode'), ['class' => 'form-control', 'id' => 'postcode']) !!}
</div>

<div class="form-group">
    <label for="city">Plaats</label>
    {!! Form::text('city', array_get($dealer, 'city'), ['class' => 'form-control', 'id' => 'city']) !!}
</div>

<div class="form-group">
    <label for="country">Land</label>
    {!! Form::text('country', array_get($dealer, 'country'), ['class' => 'form-control', 'id' => 'country']) !!}
</div>

<div class="form-group">
    <label for="contact_address">Website / e-mail adres</label>
    {!! Form::text('contact_address', array_get($dealer, 'contact_address'), ['class' => 'form-control', 'id' => 'contact_address']) !!}
</div>

<div class="form-group">
    <label for="phone">Telefoonnummer</label>
    {!! Form::text('phone', array_get($dealer, 'phone'), ['class' => 'form-control', 'id' => 'phone']) !!}
</div>

<div class="form-group">
    <label for="phone">Noodnummer</label>
    {!! Form::text('emergency_phone', array_get($dealer, 'emergency_phone'), ['class' => 'form-control', 'id' => 'emergency_phone']) !!}
</div>
<div id="map"></div>
@section('scripts')
    @parent
    @if(array_get($dealer, 'latitude') !== null)
        <script>
            function initMap() {
                var myLatLng = {lat: {{ array_get($dealer, 'latitude') }}, lng: {{ array_get($dealer, 'longitude') }}};

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 15,
                    center: myLatLng
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: '{{ array_get($dealer, 'name') }}'
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ get_option('kabola_dealers.google_maps_js_api_key', '') }}&callback=initMap"
                async defer></script>
    @endif
@endsection