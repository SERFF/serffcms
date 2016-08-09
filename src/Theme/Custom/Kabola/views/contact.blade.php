@extends('app')
@section('pageid')"contactpage"@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="{{ route_with_locale('home', []) }}">Home</a> // <span>{{ array_get($page, 'title') }}</span>
        </div>
    </div>
    {!! get_meta_value(array_get($page, 'id'), 'page', 'contact-pagina.google-maps-iframe') !!}
    <div class="section maincontent">
        <div class="content" id="content">
            @php $header_image = get_cf_image_url(array_get($page, 'id'), 'page', 'standaard-pagina.header-image', 1200, 500); @endphp
            @if(strpos($header_image, 'placehold.it/') == false)
                <img src="{{ $header_image }}">
            @endif
            {!! parse_page_content(array_get($page, 'content'), array_get($page, 'id')) !!}
        </div>
        @include('partials.sidebar')
    </div>
@endsection