<a href="configurator.php" class="c2a">{!! translate('kabola.products.help_me_decide') !!}</a>
<input type="checkbox" id="filteroptions"/>
<label for="filteroptions"></label>
<span>
	<h3>{!! translate('kabola.products.product') !!}</h3>
	<ul>
		<li>
			<input type="checkbox" name="option_product[]" id="30" value="kettel">
			<label for="30">Ketels</label>
		</li>
		<li>
			<input type="checkbox" name="option_product[]" id="31" value="thermostat">
			<label for="31">Thermostaten</label>
		</li>
	</ul>
</span>
<span>
	<h3>{!! translate('kabola.products.appliance') !!}</h3>
	<ul>
		<li>
			<input type="checkbox" id="111" name="appliciance[]" value="a">
			<label for="111">Centrale verwarming</label>
		</li>
		<li>
			<input type="checkbox" id="112" name="appliciance[]" value="b">
			<label for="112">Heet water</label>
		</li>		
	</ul>
</span>
<span>
	<h3>{!! translate('kabola.products.water_cb') !!}</h3>
	<ul>
		<li>
			<input type="checkbox" name="water_cb[]" value="a" id="1">
			<label for="1">8 - 10 liter</label>
		</li>
		<li>
			<input type="checkbox" name="water_cb[]" value="b" id="2">
			<label for="2">11 - 15 liter</label>
		</li>
		<li>
			<input type="checkbox" name="water_cb[]" value="c" id="4">
			<label for="4">16 - 20 liter</label>
		</li>
		<li>
			<input type="checkbox" name="water_cb[]" value="d" id="3">
			<label for="3">20+ liter</label>
		</li>
	</ul>
    </ul>
</span>
<span id="capacitywrapper">
	<h3>{!! translate('kabola.products.capacity') !!}</h3>
	<ul id="capacity">
		<li>
			<input type="checkbox" id="16" name="capacity[]" value="a">
			<label for="16">4-10 kW</label>
		</li>
		<li>
			<input type="checkbox" id="17" name="capacity[]" value="b">
			<label for="17">11-19 kW</label>
		</li>
		<li>
			<input type="checkbox" id="18" name="capacity[]" value="c">
			<label for="18">20-29 kW</label>
		</li>
		<li>
			<input type="checkbox" id="19" name="capacity[]" value="d">
			<label for="19">30-116 kW</label>
		</li>
	</ul>
</span>
<span id="efficiencewrapper">
	<h3>{!! translate('kabola.products.efficiency') !!}</h3>
	<ul>
		<li>
			<input type="checkbox" id="24" name="efficiency[]" value="a">
			<label for="24">90%</label>
		</li>
		<li>
			<input type="checkbox" id="25" name="efficiency[]" value="b">
			<label for="25">94%</label>
		</li>
	</ul>
</span>

@section('scripts')
    @parent
    <script defer="defer">
        var option_products, water_cb, capacity, efficiency, appliciance;

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('input[name="option_product[]"]').on('change', function () {
				option_products = get_item_values('option_product', option_products);
                update_products();
            });

            $('input[name="water_cb[]"]').on('change', function () {
				water_cb = get_item_values('water_cb', water_cb);
                update_products();
            });

            $('input[name="capacity[]"]').on('change', function () {
				capacity = get_item_values('capacity', capacity);
                update_products();
            });

//            $('input[name="efficiency[]"]').on('change', function () {
//				efficiency = get_item_values('efficiency', efficiency);
//                update_products();
//            });

            $('input[name="appliciance[]"]').on('change', function () {
				appliciance = get_item_values('appliance', appliciance);
                update_products();
            });

            load_preloaded_items();

        });

        function load_preloaded_items() {
			option_products = get_item_values('option_product', option_products);
			water_cb = get_item_values('water_cb', water_cb);
			capacity = get_item_values('capacity', capacity);
//			efficiency = get_item_values('efficiency', efficiency);
			appliciance = get_item_values('appliance', appliciance);
			if((option_products.length > 0) || (water_cb.length > 0) || (capacity.length > 0) || /*(efficiency.length > 0) ||*/ (appliciance.length > 0)) {
				update_products();
			} 
		}
        
        function get_item_values(key, variables) {
			variables = [];
			$('input[name="'+key+'[]"]:checked').each(function () {
				variables[variables.length] = $(this).val();
			});
			return variables;
		}
		
        function update_products() {
            $.ajax({
                url: "{{ route('products.filtered') }}",
                method: "POST",
                data: {
                    option_products: option_products,
                    water_cb: water_cb,
                    capacity: capacity,
//                    efficiency: efficiency,
                    appliciance: appliciance
                }
            }).done(function (result) {
                $('#products').html(result);
            });
        }
    </script>
@endsection