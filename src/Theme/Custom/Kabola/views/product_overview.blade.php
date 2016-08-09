@extends('app')
@section('pageid')""@endsection
@section('bodyclass')"product product--overview product--advice"@endsection
@section('content')
	
	@php
		$categories = app(\Serff\Cms\Modules\Custom\KabolaProductsModule\Domain\Repositories\CategoryRepository::class)->all();
	@endphp
	
    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="{{ route_with_locale('home', []) }}">Home</a> // <span>{{ array_get($page, 'title') }}</span>
        </div>
    </div>
    <div class="section intro">
        <h1>{!! translate('kabola.product_overview.kabola_products') !!}</h1>
        <p>{!! translate('kabola.product_overview.intro_text') !!}</p>
    </div>
    <div class="section container">
        <aside>
            @include('partials.products_filter')
        </aside>
        <section id="products">
            
				@include('partials.products')
		</section>
    </div>
@endsection