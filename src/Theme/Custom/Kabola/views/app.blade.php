<!DOCTYPE html>
<html>
<head>
    <!-- typekit font -->
    <script src="https://use.typekit.net/exq0umc.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="/themes/kabola/assets/css/global.css" type="text/css">
    <script src="/themes/kabola/assets/js/min/responsive-nav-min.js"></script>
    <meta name="viewport" content="width=device-width,height=device-height,user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    @yield('css_header')
    @include('admin.helpers.header')
</head>
<body id=@yield('pageid') class=@yield('bodyclass')>
<div class="page-wrap">
    @include('partials.header')
    <div id="vanafhiersticky">
        @yield('content')
    </div>
</div>
@include('partials.footer')
<script src="/themes/kabola/assets/js/vendor/jquery.js"></script>
<script src="/themes/kabola/assets/js/simsalabim.js"></script>
<script src="/themes/kabola/assets/js/parallax.js"></script>
<script src="/themes/kabola/assets/js/vendor/what-input.js"></script>
<script src="/themes/kabola/assets/js/vendor/foundation.js"></script>
<!--<script src="/themes/kabola/assets/js/app.js"></script>-->
<script src="/themes/kabola/assets/js/wow.js"></script>
<script>
    var navigation = responsiveNav("#nav");

    $(document).foundation();
    $('.stickynav').on('sticky.zf.stuckto:top', function(){
        $(this).addClass('vast');
    }).on('sticky.zf.unstuckfrom:top', function(){
        $(this).removeClass('vast');
    })

    wow = new WOW(
            {
                animateClass: 'animated',
                offset:       100,
                callback:     function(box) {
//                    console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
                }
            }
    );
    wow.init();
    document.getElementById('moar').onclick = function() {
        var section = document.createElement('section');
        section.className = 'section--purple wow fadeInDown';
        this.parentNode.insertBefore(section, this);
    };
</script>
@yield('scripts')
@include('admin.helpers.footer')
</body>
</html>




