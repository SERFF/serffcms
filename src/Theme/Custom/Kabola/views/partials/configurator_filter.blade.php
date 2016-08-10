@php
    $filter = \Session::get('configurator_filter');
@endphp
<a href="configurator.php" class="c2a">Help me decide</a>
<input type="checkbox" id="filteroptions">
<label for="filteroptions">
	<span id="applicationwrapper">
		<h3>Application</h3>
		<ul id="application">
			<li>
				<input type="checkbox" id="1" name="application[]" value="centralheating"
                       @if(in_array('centralheating', array_get($filter, 'application', []))) checked @endif>
				<label for="1">Central heating</label>
			</li>
			<li>
				<input type="checkbox" id="2" name="application[]" value="hotwater"
                       @if(in_array('hotwater', array_get($filter, 'application', []))) checked @endif>
				<label for="2">Hot water</label>
			</li>
			<li>
				<input type="checkbox" id="4" name="application[]" value="hotair"
                       @if(in_array('hotair', array_get($filter, 'application', []))) checked @endif>
				<label for="4">Hot-air</label>
			</li>
			<li>
				<input type="checkbox" id="3" name="application[]" value="airco"
                       @if(in_array('airco', array_get($filter, 'application', []))) checked @endif>
				<label for="3">Airconditioning</label>
			</li>
		</ul>
	</span>
    <span id="heatingspacewrapper">
		<h3>Heating space</h3>
		<ul id="heatingspace">
			<li>
				<input type="checkbox" id="5" name="heating_m3" value="20"
                       @if((array_get($filter, 'heating_m3', 0) >= 10) && (array_get($filter, 'heating_m3', 0) < 30)) checked @endif>
				<label for="5">10-30 m3</label>
			</li>
			<li>
				<input type="checkbox" id="6" name="heating_m3" value="40"
                       @if((array_get($filter, 'heating_m3', 0) >= 30) && (array_get($filter, 'heating_m3', 0) < 50)) checked @endif>
				<label for="6">30-50 m3</label>
			</li>
			<li>
				<input type="checkbox" id="7" name="heating_m3" value="60"
                       @if((array_get($filter, 'heating_m3', 0) >= 50) && (array_get($filter, 'heating_m3', 0) < 75)) checked @endif>
				<label for="7">50-75 m3</label>
			</li>
			<li>
				<input type="checkbox" id="8" name="heating_m3" value="100"
                       @if(array_get($filter, 'heating_m3', 0) >= 75) checked @endif>
				<label for="8">75+ m3</label>
			</li>
		</ul>
	</span>
    <span id="isolationwrapper">
		<h3>Isolation</h3>
		<ul id="isolation">
			<li>
				<input type="checkbox" id="9" name="isolation" value="150"
                       @if(array_get($filter, 'isolation', 0) == 150) checked @endif>
				<label for="9">Bad (factor 150)</label>
			</li>
			<li>
				<input type="checkbox" id="10" name="isolation" value="120"
                       @if(array_get($filter, 'isolation', 0) == 120) checked @endif>
				<label for="10">Good (factor 120)</label>
			</li>
		</ul>
	</span>
    <span id="applicationareawrapper">
		<h3>Application area</h3>
		<ul id="applicationarea">
			<li>
				<input type="checkbox" id="11" name="application_area" value="a"
                       @if(array_get($filter, 'application_area', null) == 'a') checked @endif>
				<label for="11">Maritiem</label>
			</li>
			<li>
				<input type="checkbox" id="12" name="application_area" value="b"
                       @if(array_get($filter, 'application_area', null) == 'b') checked @endif>
				<label for="12">Automotive</label>
			</li>
			<li>
				<input type="checkbox" id="13" name="application_area" value="c"
                       @if(array_get($filter, 'application_area', null) == 'c') checked @endif>
				<label for="13">Gebouwen</label>
			</li>
			<li>
				<input type="checkbox" id="14" name="application_area" value="d"
                       @if(array_get($filter, 'application_area', null) == 'd') checked @endif>
				<label for="14">Waterverwarming</label>
			</li>
			<li>
				<input type="checkbox" id="15" name="application_area" value="e"
                       @if(array_get($filter, 'application_area', null) == 'e') checked @endif>
				<label for="15">Overig</label>
			</li>
		</ul>
	</span>
</label>

@section('scripts')
    @parent
    <script defer="defer">

        var application, heating_m3, isolation, application_area;

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('input[name="application[]"]').on('change', function () {
                application = get_item_values('application[]', application);
                update_products();
            });

            $('input[name="heating_m3"]').on('change', function () {
				singleSelection('heating_m3', $(this).val());
                heating_m3 = get_item_values('heating_m3', heating_m3);
                update_products();
            });

            $('input[name="isolation"]').on('change', function () {
				singleSelection('isolation', $(this).val());
                isolation = get_item_values('isolation', isolation);
                update_products();
            });

            $('input[name="application_area"]').on('change', function () {
            	singleSelection('application_area', $(this).val());
                application_area = get_item_values('application_area', application_area);
                update_products();
            });

            load_preloaded_items();
        });

        function load_preloaded_items() {
            application = get_item_values('application[]', application);
            heating_m3 = get_item_values('heating_m3', heating_m3);
            isolation = get_item_values('isolation', isolation);
            application_area = get_item_values('application_area', application_area);

            update_products();
        }
        
        function singleSelection(field, value)
		{
			$('input[name="' + field + '"]').each(function() {
				if ($(this).val() != value) {
					$(this).attr('checked', false);
				}
			});
		}

        function get_item_values(key, variables) {
            variables = [];
            $('input[name="' + key + '"]:checked').each(function () {
                variables[variables.length] = $(this).val();
            });
            return variables;
        }

        function update_products() {
            $.ajax({
                url: "{{ route('configurator.filtered') }}",
                method: "POST",
                data: {
                    application: application,
                    heating_m3: heating_m3,
                    isolation: isolation,
					application_area: application_area
                }
            }).done(function (result) {
                $('#products').html(result);
            });
        }
    </script>
@endsection