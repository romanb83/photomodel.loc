@extends('layouts.base')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-3">
                Content
            </div> --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6>Профиль пользователя {{ $itemUserProfile->nick_name }}</h6>
                    <a class="nav-link" href="{{ route('edit.profile') }}">Редактировать профиль</a>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            @if ($fileis)
                            <img src="{{ asset($path.'avatar.jpg') }}">
                            @else
                            <img src="{{ asset(env('DEFAULT_AVATAR')) }}" width="200" height="400">
                            @endif
                        </div>
                        <div class="col-md-9">

                            <div class="card-title"></div>
                            <div class="card-subtitle mb-2 text-muted"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#maindata" role="tab">Основные
                                        данные</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#adddata" role="tab">Дополнительные
                                        данные</a>
                                </li>
                            </ul>
                            <br>
                            <div class="tab-content">
                                <div class="tab-pane active" id="maindata" role="tabpanel">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <p class="text-justify border border-primary">Логин:
                                                {{ $itemShowUser->nick_name }}</p>
                                            <p class="text-justify border border-primary">Имя:
                                                {{ $itemShowUser->first_name }}</p>
                                            <p class="text-justify border border-primary">Фамилия:
                                                {{ $itemShowUser->last_name }}</p>
                                            <p class="text-justify border border-primary">E-mail:
                                                {{ $itemShowUser->email }}</p>
                                            <p class="text-justify border border-primary">Город:
                                                {{ $itemShowUser->city->city_name }}</p>
                                            <p class="text-justify border border-primary">Дата рождения:
                                                {{ Date::parse($itemShowUser->userAttribute->age)->format('j F Y г.') }}</p>
                                            <p class="text-justify border border-primary">
                                                @if ($itemShowUser->userAttribute->gender == 'male')
                                                Пол: Мужской
                                                @endif
                                                @if ($itemShowUser->userAttribute->gender == 'female')
                                                Пол: Женский
                                                @endif
                                            </p>
                                            <p class="text-justify border border-primary">Номер телефона:
                                                {{ $itemShowUser->userAttribute->phone }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-justify border border-primary">Цвет глаз:
                                                {{ $itemShowUser->userAttribute->eye_color }}</p>
                                            <p class="text-justify border border-primary">Цвет волос:
                                                {{ $itemShowUser->userAttribute->hair_color }}</p>
                                            <p class="text-justify border border-primary">Рост:
                                                {{ $itemShowUser->userAttribute->height }}</p>
                                            <p class="text-justify border border-primary">Вес:
                                                {{ $itemShowUser->userAttribute->weight }}</p>
                                            <p class="text-justify border border-primary">Грудь:
                                                {{ $itemShowUser->userAttribute->chest }}</p>
                                            <p class="text-justify border border-primary">Талия:
                                                {{ $itemShowUser->userAttribute->waist }}</p>
                                            <p class="text-justify border border-primary">Бёдра:
                                                {{ $itemShowUser->userAttribute->hip }}</p>
                                            <p class="text-justify border border-primary">Размер одежды:
                                                {{ $itemShowUser->userAttribute->clothing_size }}</p>
                                            <p class="text-justify border border-primary">Размер обуви:
                                                {{ $itemShowUser->userAttribute->foot_size }}</p>
                                            <p class="text-justify border border-primary">О себе:
                                                {{ $itemShowUser->userAttribute->about }}</p>
                                            <p class="text-justify border border-primary">Опыт:
                                                {{ $itemExp[$itemShowUser->userAttribute->experience] }}</p>

                                            @if ($itemShowUser->userAttribute->is_tfp == 1)
                                                <p class="text-justify border border-primary">TFP: Да</p>
                                            @elseif ($itemShowUser->userAttribute->is_tfp == 0)                                            
                                                <p class="text-justify border border-primary">TFP: Нет</p>
                                            @elseif ($itemShowUser->userAttribute->is_tfp == null)
                                                <p class="text-justify border border-primary">TFP:</p>
                                            @endif

                                            @if ($itemShowUser->userAttribute->is_commerce)
                                            <p class="text-justify border border-primary">Коммерция: Да</p>
                                            @else
                                            <p class="text-justify border border-primary">Коммерция: Нет</p>
                                            @endif                                            
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <p class="text-justify">Жанры:</p>
                                        <div class="col-sm-4">
                                            @foreach ($itemGenres as $item)
                                                <p class="text-justify border border-primary">{{ $item->description }}</p>
                                            @endforeach
                                        
                                        </div>
                                        <div class="col-sm-4">

                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="adddata" role="tabpanel">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection