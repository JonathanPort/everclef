<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="@stack('html-class-list')">
<head>

    @include('app.includes.seo')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/auth.css') }}">

    @stack('head-styles')
    @stack('head-scripts')
    @stack('head-meta')

</head>
<body>

    <div class="auth-layout">

        <div class="auth-layout__flex">

            <div class="auth-layout__bg"
                 style="background-image: url({{ asset('images/auth/bg.jpg') }})"
            ></div>

            <main class="auth-layout__main">
                <div class="auth-layout__main-inner">
                    @yield('content')
                </div>
            </main>

        </div>

    </div>

    @include('app.includes.notifications')

    @stack('foot-styles')

    <script src="{{ asset('js/auth.js') }}"></script>
    @stack('foot-scripts')

</body>
</html>