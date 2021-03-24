@extends('layouts.base')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-4">

    </div>
    <div class="col-md-4 p-5">
        <div class="card">
            <div class="card-header text-center">{{ __('Вход') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('Электронная почта') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        {{ session('success') }}
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Пароль') }}</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Запомнить меня') }}
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Войти') }}
                            </button>
                        </div>
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Забыли пароль?') }}
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">

    </div>
</div>

@endsection
