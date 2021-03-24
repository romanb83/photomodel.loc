@extends('layouts.base')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-4">

    </div>
    <div class="col-md-4 p-5">
        <div class="card">
            <div class="card-header text-center">
                Регистрация
            </div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="username">Имя пользователя</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                            id="username">
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Электронная почта</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            id="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Введите пароль</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" id="password" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Повторите пароль</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password-confirm" required>
                    </div>
                    <div class="row justify-content-center">
                        <button class="btn btn-primary" type="submit">Зарегистрировать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">

    </div>
</div>

@endsection