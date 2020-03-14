<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use App\Models\User\SocialCredential;
use App\Models\User\User;
use Carbon\Carbon;
use Auth;


/**
 * Handles Social login and register
 */
class SocialAuthController extends Controller
{


    /**
     * Key used to store the auth type [register || login]
     * into the session.
     */
    private const AUTH_TYPE_SESSION_KEY = 'social_auth_type';


    /**
     * Error Message Keys from resources/lang/auth.php
     */
    private const LOGIN_NOT_FOUND_ERROR_MSG = 'auth.social_auth_login_not_found';
    private const USER_EXISTS_ERROR_MSG = 'auth.social_auth_user_exists';
    private const GENERAL_ERROR_MSG = 'auth.social_auth_general';


    /**
     * Start new controller instance with Guest middleware
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(string $provider, string $type)
    {

        $this->setAuthTypeInSession($type);

        return Socialite::driver($provider)->redirect();

    }

    /**
     * Obtain the user information from Provider. Determine from
     * the session whether this is a Login or Register attempt.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(string $provider)
    {

        // Set the provider into class scope to be used later
        $this->provider = $provider;

        // Grab user
        $user = Socialite::driver($this->provider)->user();

        // Decide to login or register
        switch ($this->getAuthTypeFromSession()) {
            case 'login':
                return $this->handleLogin($user);
            case 'register':
                return $this->handleRegister($user);
            default:
                return abort(502);
        }

    }


    /**
     * Handles login attempt. If credential not found, redirect with error.
     * Otherwise log the user in.
     *
     * @param  AbstractUser $socialiteUser
     * @return redirect
     */
    private function handleLogin(AbstractUser $socialiteUser)
    {

        // Fin existing credentials
        $socialCredentials = SocialCredential::where([
            'provider_id' => $socialiteUser->getId(),
            'provider_name' => $this->provider,
        ])->first();

        if (! $socialCredentials) return redirect()->route('login')->with([
            'error' => str_replace('%p%', $this->provider, trans(self::LOGIN_NOT_FOUND_ERROR_MSG))
        ]);


        // Find existing user
        $user = User::find($socialCredentials->user_id);

        if (! $user) return redirect()->route('login')->with([
            'error' => trans(self::GENERAL_ERROR_MSG)
        ]);


        // Login!
        return $this->loginAndRedirectUser($user);

    }


    /**
     * Handle user registration. If the user credential exists,
     * log the user in. If the returned email address exists,
     * redirect to login with error.
     *
     * @param  AbstractUser $socialiteUser
     * @return redirect
     */
    private function handleRegister(AbstractUser $socialiteUser)
    {

        // Find any existing login credentials
        $socialCredentials = SocialCredential::where([
            'provider_id' => $socialiteUser->getId(),
            'provider_name' => $this->provider,
        ])->first();


        // Log them in if they exist
        if ($socialCredentials) {

            $user = User::find($socialCredentials->user_id);

            if (! $user) return redirect()->route('login')->with([
                'error' => trans(self::GENERAL_ERROR_MSG)
            ]);

            return $this->loginAndRedirectUser($user);

        }


        // If email exists in users table, prevent registration
        $existingEmail = User::where('email', $socialiteUser->getEmail())->first();

        if ($existingEmail) return redirect()->route('login')->with([
            'error' => trans(self::USER_EXISTS_ERROR_MSG)
        ]);


        // Create the user and credentials!
        $user = $this->createUser($socialiteUser);
        $socialCredentials = $this->createCredentials($socialiteUser, $user);


        // Login!
        return $this->loginAndRedirectUser($user);

    }


    private function createCredentials(AbstractUser $socialiteUser, User $user)
    {

        return SocialCredential::create([
            'user_id' => $user->id,
            'access_token' => $socialiteUser->token,
            'expires_at' => Carbon::now()->addSeconds($socialiteUser->expiresIn),
            'provider_id' => $socialiteUser->getId(),
            'provider_name' => $this->provider,
            'refresh_token' => $socialiteUser->refreshToken,
        ]);

    }


    private function createUser(AbstractUser $socialiteUser)
    {

        return User::create([
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getEmail(),
            'avatar' => $socialiteUser->getAvatar(),
        ]);

    }


    private function loginAndRedirectUser(User $user)
    {

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);

    }


    private function setAuthTypeInSession(string $type)
    {
        return \Session::put(self::AUTH_TYPE_SESSION_KEY, $type);
    }


    private function getAuthTypeFromSession()
    {
        return \Session::get(self::AUTH_TYPE_SESSION_KEY);
    }


    private function clearAuthTypeFromSession()
    {
        return \Session::forget(self::AUTH_TYPE_SESSION_KEY);
    }

}