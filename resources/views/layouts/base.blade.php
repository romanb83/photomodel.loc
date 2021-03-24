<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    {{-- <script src="{{ asset('js/photo.js') }}" defer></script> --}}


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">

        {{-- @section('header')
        <div class="row jusify-content-center">
            <div class="col col-md-12">
                <p>header1</p>
            </div>
        </div>
        @show --}}

        @section('navigation')
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ route('home') }}">Главная</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('group.index', 'model') }}">Модели</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('group.index', 'photografer') }}">Фотографы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('group.index', 'makeup') }}">Визажисты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('group.index', 'stylist') }}">Стилисты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Студии</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">События</a>
                    </li>
                </ul>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('show.profile') }}">Профиль</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link">Выход</button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                    </li>
                    @endif

                </ul>
            </div>

        </nav>
        @show

        <main>
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/test.js') }}"></script>
</body>

</html>