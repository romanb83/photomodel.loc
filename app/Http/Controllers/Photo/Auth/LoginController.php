<?php

namespace App\Http\Controllers\Photo\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends BaseController
{
    use ThrottlesLogins;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogleProvider()
    {
//        dd(1);
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        $user->getId();
        $user->getNickname();
        $user->getName();
        $user->getEmail();
        dd($user->token);
    }

    public function redirectToVkProvider()
    {
//        dd(1);
        return Socialite::with('vkontakte')->redirect();
    }

    public function handleVkProviderCallback()
    {
        dd(1);
        $user = Socialite::driver('vkontakte')->user();

        $user->getId();
        $user->getNickname();
        $user->getName();
        $user->getEmail();
        dd($user->token);
    }

    public function showLoginForm()
    {
        return view('photo.auth.login');
    }

    public function login(LoginRequest $request)
    {
        // dd($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $authenticate = Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        );

        if ($authenticate) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            $user = Auth::user();
            if ($user->status !== User::STATUS_ACTIVE) {
                Auth::logout();
                return back()->with('error', 'Вы не подтвердили свой аккаунт. Пожалуйста проверьте свою почту');
            }
            return redirect()->intended(route('edit.profile'));     //(route('show.profile'))
        }

        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages([$this->username() => [trans('auth.failed')],]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    protected function username()
    {
        return 'email';
    }

}
