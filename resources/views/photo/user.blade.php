@extends('layouts.base')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                Content
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">                        
                        <h6>Профиль пользователя {{ $itemUser->nick_name }}</h6>                       
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="https://via.placeholder.com/250">                          
                            </div>
                            <div class="col-md-5">
                                <p><strong>Фамилия: </strong>{{ $itemUser->last_name }}</p>
                                <p><strong>Имя: </strong>{{ $itemUser->first_name }}</p>
                                <p><strong>Город: </strong>{{ $itemUser->city->city_name }}</p>
                                <p><strong>Возраст: </strong>{{ $itemUser->age }}</p>
                                <p><strong>Email: </strong>{{ $itemUser->email }}</p>
                            </div>
                            <div class="col-md-4">
                                Доп. информация
                                <a href="{{ route('group.edit', [$group, $itemUser->id]) }}">Редактировать</a>
                                <form method="POST" action="{{ route('group.destroy', [$group, $itemUser->id]) }}">
                                    @method('DELETE')
                                    @csrf                                    
                                    <button type="submit" class="btn btn-link">Удалить</button>                                             
                                </form>
                            </div>
                            <div id="app2">
                                <p>@{{ message }}</p>
                                <button v-on:click="reverseMessage">Reverse Message</button>
                            </div>
                            
                            
                        </div>          
                    
                    
                    </div>
                </div>
                    
                
            </div>    
        </div>
    </div>    
    
@endsection