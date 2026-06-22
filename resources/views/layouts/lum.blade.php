<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        (function () {
            var w = window.innerWidth;
            document.documentElement.dataset.lumBp =
                w <= 430 ? 'mobile' : w <= 1023 ? 'tablet' : 'desktop';
        })();
    </script>
    <title>Lum — Sri Lanka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;0,500;0,800;1,400&family=Marck+Script&family=Vollkorn:ital,wght@0,400;0,500;1,400;1,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-full overflow-x-hidden">
    @yield('content')
</body>
</html>
