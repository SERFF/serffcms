@if(isset($best_choice) && ($best_choice !== null))
    <div id="bestchoice">
        <h1>{!! translate('kabola.product_overview.best_choice') !!}</h1>
        <div class="product-image-text animated5 bounceIn">
            <div class="image">
                <img src="{{ route('media.view', ['id' => array_get($best_choice, 'product_image'), 'name' => array_get($best_choice, 'title'), 'width' => 350 ]) }}">
            </div>
            <div class="text">
                <h2>{{ array_get($best_choice, 'title')}}</h2>
                {!! array_get($best_choice, 'intro_text') !!}
                <a href="{{ route('product.category.view', ['id' => array_get($best_choice, 'id')]) }}?best_choice={{ array_get($best_choice, 'product_id') }}"
                   class="c2a">{!! translate('kabola.product_overview.product_more_information') !!}</a>
            </div>
        </div>
    </div>
    <div id="tailormadeadvice" class="wow  fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
        <div class="text">
            <h3>{!! translate('kabola.product_overview.tailor_made_advice') !!}</h3>
            <span>{!! translate('kabola.product_overview.leave_your_email') !!}</span>
        </div>
        <form id="tailor-made-form">
            <input name="email" id="tm_email" type="text" value="{!! translate('kabola.product_overview.email') !!}">
            <input name="telephone" id="tm_phone" type="text"
                   value="{!! translate('kabola.product_overview.telephone') !!}">
            <input type="submit" value="{!! translate('kabola.product_overview.contact_me') !!}" id="submit">
        </form>
    </div>
@endif
@if(count($categories) == 0)
    <h2>{!! translate('kabola.product_overview.unfortunately') !!}</h2>
    <p>{!! translate('kabola.product_overview.no_products_matching') !!} {!! translate('kabola.product_overview.try_other_criteria_or') !!}
        <a href="{{ route('page', ['slug' => 'contact']) }}">{!! translate('kabola.product_overview.contact_us') !!}</a> {!! translate('kabola.product_overview.to_discuss_possibilities') !!}
    </p>
@endif
<div id="allproducts">
    @foreach($categories as $category)
        <a href="{{ route('product.category.view', ['id' => array_get($category, 'id')]) }}?selected_product={{ array_get($category, 'product_id') }}" class="wow fadeInUp">
            <div>
                <img src="{{ route('media.view', ['id' => array_get($category, 'product_image'), 'name' => array_get($category, 'title'), 'width' => 150 ]) }}">
            </div>
            <div>
                <h1>{{ array_get($category, 'title')}}</h1>
                <span class="description">
                    @php if(!isset($products_defined)) { $products_defined = false; } @endphp
                    @if($products_defined == true)
                        <table>
                            <tbody>
                            <tr>
                                <td>Waterinhoud:</td>
                                <td>{{ array_get($category, 'water_capacity') }} liter</td>
                            </tr>
                            <tr>
                                <td>Capaciteit:</td>
                                <td>{{ array_get($category, 'capacity') }} kW</td>
                            </tr>
                            <tr>
                                <td>Inbouwmaat:</td>
                                <td>
                                    B. {{ array_get($category, 'build_size_w') }} mm<br>
                                    D: {{ array_get($category, 'build_size_d') }} mm<br>
                                    H: {{ array_get($category, 'build_size_h') }} mm
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @else
                        {!! array_get($category, 'overview_preview_text') !!}
                    @endif
									</span>
                <span class="moreinfo"> {!! translate('kabola.product_overview.more_information') !!} »</span>
            </div>
        </a>
    @endforeach
</div>

<script>
    $(function () {
        $('#tailor-made-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('products.tailer_made') }}",
                method: 'POST',
                data: {
                    email: $('#tm_email').val(),
                    phone: $('#tm_phone').val()
                }
            }).done(function () {
//                alert('ok');

            }).error(function () {
//                alert('curwa');
            });

            return false;
        })
    })
</script>