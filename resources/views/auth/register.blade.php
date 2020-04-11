@extends('auth.base')

@section('content')

    <a class="logo" href="{{ url('/') }}">
        <img src="{{ asset('images/logos/logo-white.svg') }}">
    </a>

    <form class="login-form"
          action="{{ route('register') }}"
          method="POST">

        @csrf

        <input class="login-form__input"
               type="text"
               name="name"
               placeholder="Your name"
               required>

        <input class="login-form__input"
               type="email"
               name="email"
               placeholder="Your email"
               required>

        <input class="login-form__input"
               type="password"
               name="password"
               placeholder="Your password"
               autocomplete="new-password"
               required>

        <div class="login-form__bottom">

            <button class="btn btn--med btn--full-width" type="submit">Create account</button>
        </div>

    </form>

    <div class="sep"></div>

    <div class="social-auth">

        <span class="social-auth__heading">Or sign up using</span>

        <div class="social-auth__links">

            @php
            $links = [
                ['label' => 'Google login', 'method' => 'google', 'logo' => 'google-logo.png'],
                ['label' => 'Apple login', 'method' => 'sign-in-with-apple', 'logo' => 'apple-logo.png'],
                ['label' => 'Facebook login', 'method' => 'facebook', 'logo' => 'facebook-logo.png'],
            ];
            @endphp

            @foreach ($links as $l)

                <a title="{{ $l['label'] }}"
                   class="social-auth__link"
                   href="{{ route('social-auth', [
                    'provider' => $l['method'],
                    'type' => 'register'
                ]) }}">
                    <img src="{{ asset('images/auth/' . $l['logo']) }}">
                </a>

            @endforeach

        </div>

        <a class="switch-link"
           href="{{ route('login') }}">Already have an account?</a>

    </div>

@endsection
