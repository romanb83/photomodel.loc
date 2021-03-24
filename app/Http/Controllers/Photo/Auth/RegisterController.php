<?php

namespace App\Http\Controllers\Photo\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\PhotoRepository;
use App\Services\FormService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\VerifyMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends BaseController
{
    use RegistersUsers;

    public $user;
    private $formService;
    private $userRepository;
    private $photoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
        $this->formService = new FormService();
        $this->userRepository = new UserRepository();
        $this->photoRepository = new PhotoRepository();
    }

    public function showRegisterForm()
    {
        return view('photo.auth.register');
    }

    public function register(RegisterRequest $request)
    {
//        $this->formService->fullDateFromRequest($request);
//        dd($request);
        $user = User::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'verify_token' => Str::random(30),
            'status' => User::STATUS_WAIT,
        ]);

        Mail::to($user->email)->send(new VerifyMail($user));
        event(new Registered($user));

        $this->guard()->logout();

        return redirect()->route('login')
            ->with('success', 'Проверьте свою почту и пройдите по ссылке для подтверждения регистрации');
    }

    public function verify($token)
    {
        if (!$user = User::where('verify_token', $token)->first()) {
            return redirect()->route('login')->with('error', 'Ваша почта не подтверждена');
        }

        if ($user->status !== User::STATUS_WAIT) {
            return redirect()->route('login')->with('error', 'Ваша почта уже подтверждена');
        }

        $this->userRepository->setUserAttributeId($user->id);
        $this->photoRepository->setPhotoId($user->id);

        $user->status = User::STATUS_ACTIVE;
        $user->verify_token = null;
        $user->role = User::ROLE_USER;
        $user->save();

        return redirect()->route('login')->with('success', 'Ваша почта успешно подтверждена');

    }
}
