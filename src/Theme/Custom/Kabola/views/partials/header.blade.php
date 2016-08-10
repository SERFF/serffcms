<header>
    <div class="section wrappernav">
        <div class="primarynav animated fadeInDown">
            <ul id="language-switch">
                @php $countries = get_countries_and_locales() @endphp
                @php $active_country = app()->getLocale() @endphp
                @php $primary_country = get_primary_locale()  @endphp
                <li id="selected"><a href="#"><img src="/themes/kabola/assets/img/{{ $active_country }}.png">{{ array_get($countries, $active_country .'.label') }}<em>{!! translate('kabola.language.change') !!}</em></a></li>
                <ul>
                    @foreach ($countries as $key => $item)
                        @if($key !== $active_country)
                            @php $prefix = ($key != $primary_country) ? $key . '.': ''; @endphp
                            <li>
                                <a href="{{ route($prefix.'home') }}">
                                    <img src="/themes/kabola/assets/img/{{ $key }}.png">{{ array_get($item, 'label') }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </ul>
            <a href="#" id="showsearch"></a>
            <a href="#" id="facebook">f</a>
            <a href="#" id="twitter">t</a>
            <a href="#" id="email">e</a>
        </div>
    </div>
    <div class="search">
        <form method="get" id="searchform" action="{{ route('kabola.search') }}">
            <a href="" id="closesearch">x</a>
            <input type="text" name="s" id="s" placeholder="{!! translate('kabola.search.what_are_you_looking_for') !!}" value="">
            <input type="submit" value="`" class="Submit" name="submit">
        </form>
    </div>
    <div class="stickynav-container" data-sticky-container>
        <div class="stickynav" data-sticky data-anchor="vanafhiersticky">
            <div class="bg">
                <div class="section nomargin">
                    <div class="logo">
                        <a href="{{ route_with_locale('home') }}"><img src="/themes/kabola/assets/img/kabola-logo.svg"
                                                                       alt="Kabola Heating Systems"></a>
                    </div>
                    <div class="navigationwrapper">
                        <nav class="nav-collapse" id="nav">
                            <ul>
                                @foreach ($menu as $item)
                                    @php $active =  (\Request::url() == array_get($item, 'link')); @endphp
                                    <li @if($active) id="currentpage" @endif><a href="{{ array_get($item, 'link') }}">{{ array_get($item, 'label') }}</a></li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>