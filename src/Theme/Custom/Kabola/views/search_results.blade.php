@extends('app')
@section('pageid')""@endsection
@section('bodyclass')"searchresults"@endsection
@section('content')
    <div class="breadcrumbs">
        <div class="section animated fadeInDown">
            <a href="{{ route_with_locale('home', []) }}">Home</a> //
            <span>{!! translate('kabola.search.breadcrumb') !!}</span>
        </div>
    </div>
    <div class="section maincontent">
        <div class="section wrapper">
            <h2>{!! translate('kabola.search.results_for') !!} {{ $s }}</h2>
            <div class="newsearch">
                <h4>{!! translate('kabola.search.need_a_new_search') !!}</h4>
                <p>{!! translate('kabola.search.if_not_found_try_again') !!}</p>
                <form method="get" id="searchform" action="{{ route('kabola.search') }}">
                    <input type="text" size="40" value="{{ $s }}" name="s" id="s">
                    <input type="submit" id="searchsubmit" value="`">
                </form>
            </div>
            <div class="results">
                @foreach ($results as $item)
                <article>
                    <h2><a href="">{{ array_get($item, 'title') }}</a></h2>
                    <div class="entry-info">
                        <a>
                            <time>{{ array_get($item, 'date') }}</time>
                        </a>                        
                    </div>
                    <p class="summary">{!! array_get($item, 'intro_text') !!}</p>
                    <a href="{{ array_get($item, 'link') }}" class="readmore">Read more</a>
                </article>
                @endforeach
            </div>

        </div>
    </div>
@endsection