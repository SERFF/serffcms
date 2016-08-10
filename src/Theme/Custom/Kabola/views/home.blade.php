@extends('app')
@section('pageid')"front-page"@endsection
@section('content')
    <div class="frontimage">
        {!! Form::hidden('frontimage', get_cf_image_url(array_get($page, 'id'), 'page', 'homepage.header-achtergrond-afbeelding')) !!}
        <div class="content wow animated zoomIn">
            <h1>{!! translate('kabola.home_title') !!}</h1>
            <h2>{!! translate('kabola.home_subtitle') !!}</h2>
            <p>{!! translate('kabola.home_promo_text') !!}</p>
            <a href="" class="c2a">{!! translate('kabola.home_wacht_our_promo') !!}</a>
            <a href="">{!! translate('kabola.general.read_more')  !!}</a>
        </div>
    </div>
    <div class="upcomingevents">
        <div class="section wow animated fadeIn">
            <ul>
                <li id="thisisupcoming">
                    <span>Upcoming[EVENTS]</span>
                </li>
                <li>
                    <a href="#">
                        <span class="eventname">Hiswa te water</span>
                        <span class="eventdate">30-08-'16 t/m 03-09-'16</span>
                        <span class="eventlocation">Amsterdam, NL</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="eventname">Gebruikte Botenbeurs</span>
                        <span class="eventdate">19-08-'16 t/m 21-08-'16</span>
                        <span class="eventlocation">Hoorn, NL</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="eventname">Caravan &amp; Botenbeurs</span>
                        <span class="eventdate">23-09'16 t/m 24-09'16</span>
                        <span class="eventlocation">Gorinchem, NL</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="section">
        <div class="orbit productslider" role="region" data-orbit>
            <ul class="orbit-container">
                <button class="orbit-previous">&#9664;&#xFE0E;</button>
                <button class="orbit-next">&#9654;&#xFE0E;</button>
                @php $items = get_meta_value(array_get($page, 'id'), 'page', 'homepage.homepage-deelpaginas', []); $i = 0; @endphp
                @foreach($items as $item)
                    <li class="@if($i == 0)is-active @endif orbit-slide product-slide">
                        {!! array_get(get_partial_by_id($item, []), 'content') !!}
                    </li>
                    @php $i++; @endphp
                @endforeach
            </ul>
            <nav class="orbit-bullets">
                @for($i = 0; $i < count($items); $i++)
                    <button @if($i == 0)class="is-active" @endif data-slide="{{ $i }}"></button>
                @endfor
            </nav>
        </div>
    </div>

    <div class="configurator wow animated fadeIn">
        @include('partials.configurator')
    </div>
    <div class="findadealerbar">
        <div class="section">
            <h1>{!! translate('kabola.home_find_closest_dealer') !!}</h1>
            <h2>{!! translate('kabola.home_tell_us_where_you_are') !!}</h2>
            <a href="" class="wow animated5 fadeInRight">{!! translate('kabola.home_find_a_dealer') !!}</a>
        </div>
    </div>
    @php $images = get_meta_value(array_get($page, 'id'), 'page', 'homepage.footer-slider-gallery', collect([])); @endphp
    <div class="fullwidthslideshow orbit" role="region" data-orbit>
        <ul class="orbit-container">
            <button class="orbit-previous">&#9664;&#xFE0E;</button>
            <button class="orbit-next">&#9654;&#xFE0E;</button>
            @for($i = 0; $i < count($images); $i++)
                <li class="@if($i == 0)is-active @endif orbit-slide">
                    <img src="{{ route('media.view', [
                                    'id'     => array_get($images[$i], 'id'),
                                    'name'   => array_get($images[$i], 'title'),
                                    'width' => 1000,
                                    'height' => 371
                                ]) }}">
                </li>
            @endfor
        </ul>
        <nav class="orbit-bullets">
            @for($i = 0; $i < count($images); $i++)
                <button class="@if($i == 0)is-active @endif" data-slide="{{ $i }}"></button>
            @endfor
        </nav>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            var frontimage = $('input[name=frontimage]').val();
            $('#front-page').find('.frontimage').css('background', 'url(' + frontimage + ') no-repeat').css('background-size', 'cover');
        });
    </script>
@endsection
