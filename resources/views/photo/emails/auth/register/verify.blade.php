@component('mail::message')
# Подтверждение регистрации

Пожалуйста перейдите по ссылке:
    @component('mail::button', ['url' => route('register.verify', ['token' => $user->verify_token])])
        Проверка почты
    @endcomponent
Спасибо, <br>
Команда {{ config('app.name') }}
@endcomponent
