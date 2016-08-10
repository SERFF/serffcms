@extends('app')
@section('pageid')""@endsection
@section('bodyclass')"product product--overview product--advice"@endsection
@section('content')

    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="{{ route_with_locale('home', []) }}">Home</a> // <span>{!! translate('kabola.configurator.breadcrumb') !!}</span>
        </div>
    </div>
    <div class="section intro">
        <h1>{!! translate('kabola.configurator.kabola_products') !!}</h1>
        <p>{!! translate('kabola.configurator.intro_text') !!}</p>
    </div>
    <div class="section container">
        <aside>
            @include('partials.configurator_filter')
        </aside>
        <section id="products">

        </section>
    </div>
@endsection