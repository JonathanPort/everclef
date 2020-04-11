<div class="app-header">

    <div class="app-header__inner">

        <a class="app-header__logo" href="{{ route('repertoire') }}">
            <img src="{{ asset('images/logos/logo-black.svg') }}">
        </a>

        <div class="app-header__user">

            <img class="app-header__user-avatar" src="{{ \Auth::user()->avatar }}">

            <span class="app-header__user-name">{{ \Auth::user()->name }}</span>

        </div>

    </div>

</div>