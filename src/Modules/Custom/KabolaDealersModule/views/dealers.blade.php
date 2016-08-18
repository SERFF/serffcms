@if(isset($dealers))
    @foreach($dealers as $dealer)
        <a href="javascript:loadDealer(marker{{$dealer->id}}, {{ $dealer->toJson() }})" class="dealer">
            <h3>{{ $dealer->name }}</h3>
            <span class="adres">{{ $dealer->street }}</span>
            <span class="adres2">{{ $dealer->postcode }} {{ $dealer->city }}</span>
            <span class="adres2">{{ $dealer->country }}</span>
            <span class="telephone">{{ $dealer->phone }}</span>
            <span class="emergencyline">{{ $dealer->emergency_phone }}</span>
        </a>
    @endforeach

    <script>
        function drawMarkers() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];

            @foreach($dealers as $dealer)

                    marker{{$dealer->id}}= new google.maps.Marker({
                position: {lat: {{ $dealer->latitude }}, lng:{{ $dealer->longitude }}},
            });

            marker{{$dealer->id}}.setMap(map);
            marker{{$dealer->id}}.addListener('click', function () {
                infowindow.setContent("<div style='height:250px; width:200px'><i class=\"marker\"></i><div class=\"marker-info\"><h3>{{ $dealer->name }}</h3><span class=\"adres\">{{ $dealer->street }}</span><span class=\"adres2\">{{ $dealer->postcode }} {{ $dealer->city }}</span><span class=\"telephone\">{{ $dealer->phone }}</span><span class=\"website\"><a href=\"http://{{ $dealer->contact_address }}\">{{ $dealer->contact_address }}</a></span><span class=\"emergencyline\">{{ $dealer->emergency_phone }}</span></div></div>");
                infowindow.open(map, marker{{ $dealer->id }});
            });

            markers[markers.length] = marker{{$dealer->id}};

            @endforeach
        }
    </script>

@endif
