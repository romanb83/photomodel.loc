@extends('layouts.base')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">Content</div>
            <div class="col-md-9">
                <div class="row">
                    @foreach ($itemsCollection as $itemUser)
                    <div class="col-sm-4">
                        
                        <div class="panel">
                            <img src="https://via.placeholder.com/150">                            
                            <a href="{{ route('group.show', [$group, $itemUser->id]) }}">{{ $itemUser->first_name }}</a>
                            <p>{{ $itemUser->last_name }}</p>
                            <p>{{ $itemUser->age }}</p>
                            <p>{{ $itemUser->id }}</p>
                            <p>{{ $itemUser->email }}</p>
                        </div> 
                           
                    </div>
                    @endforeach    
                </div>  
                <p>{{ $itemsCollection->links() }}</p>
                   
            </div>
            
           
        </div>
    </div>    

@endsection