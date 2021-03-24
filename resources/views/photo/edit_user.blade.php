@extends('layouts.base')



@section('content')
    <div class="row">
    <div class="col-md-3 p-3">
        <div class="card">
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="col-md-6 p-3">
    <div class="card">
        <div class="card-body">
        <form method="POST" action="{{ route('group.update', [$group, $itemUser->id]) }}">
            @method('PATCH')
            @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="first_name">Имя</label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $itemUser->first_name }}">
            </div>
              <div class="form-group col-md-6">
                <label for="last_name">Фамилия</label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $itemUser->last_name }}">
              </div>
            </div>
            <div class="form-group">
              <label for="nick_name">Ник</label>
              <input type="text" class="form-control" name="nick_name" id="nick_name" value="{{ $itemUser->nick_name }}">
            </div>
            <div class="form-group">
              <label for="age">Дата рождения</label>
              <input type="text" class="form-control" name="age" id="age" value="{{ $itemUser->age }}">
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                    <label for="city">Город</label>
                    <select name="city_id" id="city" class="form-control">
                        <option value="{{ $itemUser->city->id }}" selected>{{ $itemUser->city->city_name }}</option>
                        @foreach ($itemCities as $option)
                            <option value="{{ $option->id }}">{{ $option->city_name }}</option>
                        @endforeach                      
                    </select>               
              </div>
              <div class="form-group col-md-3">
                <label for="group">Группа</label>
                <select name="group" id="group" class="form-control">
                    <option selected>{{ $group }}</option>
                    @foreach ($itemsGroup as $group)
                        <option value="{{ $group->alias }}">{{ $group->group_name }}</option>
                    @endforeach
                  
                </select>
              </div>
              <div class="form-group col-md-5">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ $itemUser->email }}">
              </div>
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                  Check me out
                </label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Редактировать</button>
          </form>
        </div>
        </div>
    </div>
    <div class="col-md-3 p-3">
        <div class="card">
            <div class="card-body"></div>
        </div>
    </div>
</div>
    
@endsection