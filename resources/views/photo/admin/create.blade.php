@extends('layouts.base')

@section('navigation')

    @include('photo.includes.navbar')

@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">Content</div>
            <div class="col-md-9">  
                <p>Регистрация нового пользователя</p>
                <form action="{{ route('admin.user.store') }}" method="post">
                    @csrf
                    <label for="first_name">Имя</label>
                    <input type="text" name="first_name" id="first_name">
                    <label for="last_name">Фамилия</label>
                    <input type="text" name="last_name" id="last_name">
                    <label for="nick_name">Ник</label>
                    <input type="text" name="nick_name" id="nick_name">
                    <label for="age">Дата рождения</label>
                    <input type="text" name="age" id="age">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" id="password">
                    <select name="group_id">
                        @foreach ($itemsSelectList as $option)
                            <option value="{{ $option->id }}">{{ $option->group_name }}</option>
                        @endforeach                        
                    </select>
                    {{-- <select name="country_id">
                            @foreach ($itemsCountrySelectList as $option)
                                <option value="{{ $option->id }}">{{ $option->country_name }}</option>
                            @endforeach                        
                    </select>
                    <select name="region_id">
                        @foreach ($itemsRegionSelectList as $option)
                            <option value="{{ $option->country_id }}">{{ $option->region_name }}</option>
                        @endforeach                        
                    </select> --}}
                    <select name="city_id">
                        @foreach ($itemsCitySelectList as $option)
                            <option value="{{ $option->id }}">{{ $option->city_name }}</option>
                        @endforeach                        
                    </select>
                    <input type="hidden" name="user_attributes_id" value="1">
                    
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
             </div>            
        </div>
    </div>    

@endsection