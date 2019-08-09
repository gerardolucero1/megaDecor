@extends('layouts.backend')
@section('content')
<body>
   <div class="container">
       <div class="jumbotron">
        <div class="row">
        <div class="col-6">
        <a href="/addeventurl" class="btn btn-primary btn-block">Add Events</a>
        </div>
        <div class="col-6">
            <form method="post" action="{{route('Borrar', $id=1)}}">
               {{csrf_field()}} 
               @method('delete')
               <button type="submit" class="btn btn-warning btn-block">Dlt Events</button>
               
            </form>
            </div>
        </div>
    <br/>
    <br/>
    
        <div class="row">
            @if (count($errors)>0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>    
                            @endforeach
                        </ul>
                    </div> 
            @endif

            @if (\Session::has('success'))
                    <div class="alert alert-success">
                    <p>{{\Session::get('success')}}</p>
                    </div>                
            @endif
            <div class="row">
            <div class="col-md-8">             
                                  
                                      
                <div class="panel panel-default"> 
                </div>
                <div class="panel-body">
                        {!! $calendar->calendar()!!}
                        {!! $calendar->script()!!}
                </div>
            </div>
             
            </div>
        
    </div> 
</body>
@endsection('content')