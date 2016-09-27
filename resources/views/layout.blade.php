<!doctype html>
<html lang="">
<head class="no-js ">
    <meta charset="UTF-8">
    <meta dir="rtl">
    <meta lang="fa">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        آشوجاش | شروع چشیدن تجربه های جدید
    </title>
    <link rel="shortcut icon" type="image/x-icon" href="/img/static/logo.ico">
    <link rel="stylesheet" href="/css/app.css"/>
    <link rel="stylesheet" href="/css/buttons.min.css">
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-70125480-1', 'auto');
        ga('send', 'pageview');

    </script>
    @yield('header.stylesheets')
</head>
<body class="">
<div id="flash_placeholder"></div>
@include('layouts.partials.navbar')

{{--
@yield('content')
--}}
<div class="free-sans">
    <div id="wrap">
        @yield('content')
    </div>
    @include('layouts.partials.footer')

</div>
<script src="/js/app.js"></script>
@include('layouts.partials.bflash')
@include('layouts.partials.flash')
@include('layouts.partials.cflash')
@yield('footer.scripts')
</body>

</html>