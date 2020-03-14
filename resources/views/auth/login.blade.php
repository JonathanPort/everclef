<form action="{{ route('login') }}" method="POST">

    @csrf

    <input type="email" name="email" placeholder="Your email" required>

    <input type="password" name="password" placeholder="Your password" required>

    <button type="submit">Login</button>

    <div>
        <a href="{{ route('social-auth', ['provider' => 'google', 'type' => 'login']) }}">Google Login</a>
        <a href="{{ route('social-auth', ['provider' => 'sign-in-with-apple', 'type' => 'login']) }}">Apple Login</a>
        <a href="{{ route('social-auth', ['provider' => 'facebook', 'type' => 'login']) }}">Facebook Login</a>
    </div>

    <div>
        <a href="{{ route('social-auth', ['provider' => 'google', 'type' => 'register']) }}">Google Register</a>
        <a href="{{ route('social-auth', ['provider' => 'sign-in-with-apple', 'type' => 'register']) }}">Apple Register</a>
        <a href="{{ route('social-auth', ['provider' => 'facebook', 'type' => 'register']) }}">Facebook Register</a>
    </div>

    @if (session('error'))
        {{ session('error') }}
    @endif

</form>