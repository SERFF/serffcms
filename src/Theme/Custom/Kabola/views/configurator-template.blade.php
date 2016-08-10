@extends('app')
@section('pageid')"configurator"@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="{{ route_with_locale('home', []) }}">Home</a> // <span>{{ array_get($page, 'title') }}</span>
        </div>
    </div>
    <div class="section maincontent">
        <div class="configurator">
            @include('partials.configurator')
        </div>
    </div>
@endsection