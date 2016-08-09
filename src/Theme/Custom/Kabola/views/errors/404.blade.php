@extends('app')
@section('pageid')""@endsection
@section('bodyclass')"pagenotfound"@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="/">Home</a> // <span> {!! translate('kabola.error.page_not_found') !!}</span>
        </div>
    </div>
    <div class="section wrapper">
        <h1>{!! translate('kabola.error.we_are_sorry') !!}</h1>
        <h2>{!! translate('kabola.error.we_could_not_find_the_page') !!} {!! translate('kabola.error.you_can_search') !!}</h2>
        <form method="get" id="searchform">
            <input type="text" size="40" value="" name="s" id="s">
            <input type="submit" id="searchsubmit" value="`">
        </form>
        <div class="sitemap">
            <div>
                <h3>{!! translate('kabola.error.all_our_pages') !!}</h3>
                <ul>
                    <li><a href="">Page</a></li>
                    <li><a href="">Page</a></li>
                    <li><a href="">Page</a></li>
                    <li><a href="">Page</a></li>
                    <li><a href="">Page</a></li>
                    <li><a href="">Page</a></li>
                    <li><a href="">Page</a></li>
                </ul>
            </div>
            <div>
                <h3>{!! translate('kabola.error.all_our_products') !!}</h3>
                <ul>
                    <li><a href="">Product</a></li>
                    <li><a href="">Product</a></li>
                    <li><a href="">Product</a></li>
                    <li><a href="">Product</a></li>
                    <li><a href="">Product</a></li>
                    <li><a href="">Product</a></li>
                    <li><a href="">Product</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection