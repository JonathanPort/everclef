@extends('auth.base')

@section('content')

    <a class="logo" href="{{ url('/') }}">
        <img src="{{ asset('images/logos/logo-white.svg') }}">
    </a>

    <form class="login-form"
          action="{{ route('password.email') }}"
          method="POST">

        @csrf

        <input class="login-form__input"
               type="email"
               name="email"
               placeholder="Your email"
               required>

        @error('email')
        <div class="notification"
             data-notification-message="No account was found with this email address."
             data-notification-type="error"></div>
        @enderror

        @if (session('status'))
        <div class="notification"
             data-notification-message="An email with a reset link was sent"
             data-notification-type="success"></div>
        @endif

        <div class="login-form__bottom">

            <button class="btn btn--med btn--full-width"
                    type="submit">Send password reset link</button>

        </div>

    </form>

@endsection
