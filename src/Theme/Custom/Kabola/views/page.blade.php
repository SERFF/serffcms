@extends('app')
@section('pageid')"regularpage"@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="{{ route_with_locale('home', []) }}">Home</a> // <span>{{ array_get($page, 'title') }}</span>
        </div>
    </div>
    <div class="section maincontent">
        <div class="content" id="content">
            {!! parse_page_content(array_get($page, 'content'), array_get($page, 'id')) !!}
        </div>
        @include('partials.sidebar')
    </div>
@endsection