@extends('app')
@section('pageid')""@endsection
@section('bodyclass')"product product--single"@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="{{ route_with_locale('home', []) }}">Home</a> // <span>{{ array_get($category, 'title') }}</span>
        </div>
    </div>
    <div class="section container">
        <aside>
            <a href="configurator.php" class="c2a">Help me decide</a>
            <span>
						<ul>
							<li>
								<a href="">All Central heating</a>
							</li>
							<li>
								<a href="">All Hot water</a>
							</li>
							<li>
								<a href="">All Airconditioning</a>
							</li>
							<li>
								<a href="">All Floor-heating</a>
							</li>
						</ul>
					</span>
            <span>
						<h3>Ideal boiler for:</h3>
						<ul>
							<li><a href="">Maritiem</a></li>
							<li><a href="">Automotive</a></li>
							<li><a href="">Gebouwen</a></li>
							<li><a href="">Waterverwarming</a></li>
							<li><a href="">Overig</a></li>
						</ul>
					</span>
        </aside>
        <section id="single-product">
            <h1>{!! array_get($category, 'title') !!}</h1>
            <div class="product-image-text">
                <div class="image">
                    <img src="{{ route('media.view', ['id' => array_get($category, 'product_image'), 'name' => array_get($category, 'title'), 'width' => 500 ]) }}">
                </div>
                <div class="text">
                    {!! array_get($category, 'intro_text') !!}
                    <a href="/page/vind-een-dealer" class="c2a">{!! translate('kabola.products.find_a_dealer') !!}</a>
                </div>
            </div>
            <div class="description">
                <h2>{!! translate('kabola.products.description_title') !!}</h2>
                {!! array_get($category, 'product_content') !!}
            </div>
            @if(count(array_get($category, 'attributes', [])) > 0)
                <div class="technicalinfo">
                    <h2>{!! translate('kabola.products.technical_information') !!}</h2>
                    @php
                        $best_choice = false;
                        $class_name = '';
                        $header_element = 'th';
                        if((Request::get('best_choice', 0) > 0)) {
                        $element_found = 1;
                        $advice  = 0;
                        foreach(array_get($category, 'products', []) as $product) {
                            if(array_get($product, 'id') == Request::get('best_choice', 0)) {
                                $advice = $element_found + 1;
                            }
                            $element_found++;
                        }
                        $best_choice = true;
                        $class_name = 'advice'.$advice;
                        $header_element = 'td';
                        }
                    @endphp
                    <table class="{{ $class_name }}">
                        @if($best_choice)
                            <tr class="bestekeuze">
                                @for($i = 0; $i <= count(array_get($category, 'products', [])); $i++)
                                    <td>Beste keus</td>
                                @endfor
                            </tr>
                        @endif
                        <tr>
                            <th>SPECIFICATIES</th>
                            @foreach(array_get($category, 'products') as $product)
                                <{{$header_element}}>{{ array_get($product, 'name') }}</{{$header_element}}>
                        @endforeach
                        </tr>
                        <tr>
                            <td>Type</td>
                            @foreach(array_get($category, 'products') as $product)
                                <td>{{ array_get($product, 'type') }}</td>
                            @endforeach
                        </tr>

                        @foreach(array_get($category, 'attributes') as $attribute)
                            <tr>
                                <td>{!! array_get($attribute, 'label') !!}</td>
                                @foreach(array_get($category, 'products') as $product)
                                    <td>{{ get_attribute_value(array_get($attribute, 'id'), array_get($product, 'attributes')) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            @php $gallery = get_meta_value(array_get($category, 'id'), 'product', 'product_gallery', []); @endphp
            @if(count($gallery) > 0)
                <div class="images">
                    <h2>{!! translate('kabola.product.images') !!}</h2>
                    @foreach($gallery as $image)
                        <a href=""><img
                                    src="{{ route('media.view', ['id' => array_get($image, 'id'), 'name' => array_get($image, 'title'), 'width' => 150, 'height' => 150 ]) }}"></a>
                    @endforeach
                </div>
            @endif

        </section>
    </div>
@endsection