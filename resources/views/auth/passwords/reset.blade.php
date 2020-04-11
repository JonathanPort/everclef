@extends('auth.base')

@section('content')

    <a class="logo" href="{{ url('/') }}">
        <img src="{{ asset('images/logos/logo-white.svg') }}">
    </a>

    <form class="login-form"
          action="{{ route('password.update') }}"
          method="POST">

        @csrf

        <input class="login-form__input"
               type="email"
               name="email"
               placeholder="Your email"
               required>

        @error('email')
        <div class="notification"
             data-notification-message="Please enter your email address"
             data-notification-type="error"></div>
        @enderror

        <input class="login-form__input"
               type="password"
               name="password"
               placeholder="Your password"
               autocomplete="new-password"
               required>

        <input class="login-form__input"
               type="password"
               name="password_confirm"
               placeholder="Confirm password"
               autocomplete="new-password"
               required>

        @error('password')
        <div class="notification"
             data-notification-message="Passwords did not match"
             data-notification-type="error"></div>
        @enderror

        <div class="login-form__bottom">

            <button class="btn btn--med btn--full-width" type="submit">Change password</button>

        </div>

    </form>

@endsection
