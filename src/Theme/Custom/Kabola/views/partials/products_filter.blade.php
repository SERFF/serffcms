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
			<input type="checkbox" id="111">
			<label for="1">Centrale verwarming</label>
		</li>
		<li>
			<input type="checkbox" id="112">
			<label for="2">Heet water</label>
		</li>
		<li>
			<input type="checkbox" id="114">
			<label for="4">Hete lucht</label>
		</li>
		<li>
			<input type="checkbox" id="113">
			<label for="3">Airconditioning</label>
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
        var option_products, water_cb, capacity, efficiency;

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('input[name="option_product[]"]').on('change', function () {
                option_products = [];
                $('input[name="option_product[]"]:checked').each(function () {
                    option_products[option_products.length] = $(this).val();
                });

                update_products();
            });

            $('input[name="water_cb[]"]').on('change', function () {
                water_cb = [];
                $('input[name="water_cb[]"]:checked').each(function () {
                    water_cb[water_cb.length] = $(this).val();
                });

                update_products();
            });

            $('input[name="capacity[]"]').on('change', function () {
                capacity = [];
                $('input[name="capacity[]"]:checked').each(function () {
                    capacity[capacity.length] = $(this).val();
                });

                update_products();
            });

            $('input[name="efficiency[]"]').on('change', function () {
                efficiency = [];
                $('input[name="efficiency[]"]:checked').each(function () {
                    efficiency[efficiency.length] = $(this).val();
                });

                update_products();
            });
        });

        function update_products() {
            $.ajax({
                url: "{{ route('products.filtered') }}",
                method: "POST",
                data: {
                    option_products: option_products,
                    water_cb: water_cb,
                    capacity: capacity,
                    efficiency: efficiency
                }
            }).done(function (result) {
                $('#products').html(result);
            });
        }
    </script>
@endsection