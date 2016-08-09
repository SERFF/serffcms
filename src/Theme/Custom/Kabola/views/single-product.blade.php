@extends('app')
@section('pageid')""@endsection
@section('bodyclass')"product product--single"@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="{{ route_with_locale('home', []) }}">Home</a> // <span>{{ array_get($product, 'title') }}</span>
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
            <h1>{!! array_get($product, 'title') !!}</h1>
            <div class="product-image-text">
                <div class="image">
                    <img src="{{ route('media.view', ['id' => array_get($product, 'product_image'), 'name' => array_get($product, 'title'), 'width' => 500 ]) }}">
                </div>
                <div class="text">
                    {!! array_get($product, 'intro_text') !!}    
                </div>
            </div>
            <div class="description">
                {!! array_get($product, 'product_content') !!}
            </div>
            @php $gallery = get_meta_value(array_get($product, 'id'), 'product', 'product_gallery', []); @endphp
            @if(count($gallery) > 0)
            <div class="images">
                <h2>{!! translate('kabola.product.images') !!}</h2>
                @foreach($gallery as $image)
                <a href=""><img src="{{ route('media.view', ['id' => array_get($image, 'id'), 'name' => array_get($image, 'title'), 'width' => 150, 'height' => 150 ]) }}"></a>
                @endforeach
            </div>
            @endif
            
        </section>
    </div>
@endsection