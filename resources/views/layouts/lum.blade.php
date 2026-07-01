<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="lum-is-loading">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#fffddf">
    <meta name="color-scheme" content="light">
    <style>
        html, body { background: #fffddf; margin: 0; }
        html.lum-is-loading .lum-page { opacity: 0; }
        .lum-burger-menu[hidden] { display: none !important; }
        .lum-lang-panel[hidden] { display: none !important; }
        .lum-sticky-header:not(.is-visible) { visibility: hidden; }
    </style>
    <script>
        (function () {
            var w = window.innerWidth;
            document.documentElement.dataset.lumBp =
                w <= 430 ? 'mobile' : w <= 1023 ? 'tablet' : 'desktop';
        })();
    </script>
    <title>@yield('title', __('lum.meta.title'))</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;0,500;0,800;1,400&family=Kalam:wght@300;400;700&family=Marck+Script&family=Vollkorn:ital,wght@0,400;0,500;1,400;1,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        setTimeout(function () {
            document.documentElement.classList.remove('lum-is-loading');
        }, 4000);
    </script>
</head>
<body class="w-full">
    @yield('content')

    @include('lum.partials.burger-menu')
    <x-lum.sticky-header />
</body>
</html>
