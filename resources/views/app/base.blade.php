<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="theme--dar @stack('html-class-list')">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

    @stack('head-styles')
    @stack('head-scripts')
    @stack('head-meta')

</head>
<body>

    <div class="app-layout">

        <header class="app-layout__header">
            @include('app.includes.header')
        </header>

        <div class="app-layout__flex">

            <aside class="app-layout__sidebar">
                @include('app.includes.sidebar')
            </aside>

            <main class="app-layout__main">
                @yield('content')
            </main>

        </div>

    </div>

    @include('app.includes.set-list-maker')
    @include('app.includes.notifications')

    @stack('foot-styles')

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('foot-scripts')

</body>
</html>