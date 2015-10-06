@extends("layout")
@section("content")

<head>
    <title>Request Type Maintenance | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12">
  <h1>Request Type Maintenance</h1>

  <div class ="col-md-4">
    {{ $request_types->links() }}
  </div>
	
</div>

	<div class="container">
    <div class = "row">
      <br>
       
      <div class = "col-md-5">
        <h3>Add a Request Type</h3><hr>
        {{ Form::open(array('route' => 'request_types.store')) }}
          
                    <div class="label_white">{{ Form::label('request_type', 'Request type:') }}</div>
                    {{ Form::text('request_type') }}<br>
                    
                
                    <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
                    {{ Form::textarea('description') }}<br><br>
                
              {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
            
        {{ Form::close() }}
      </div>
      <div class = "col-md-7">
        <h3>All request type of leave</h3><hr>
        @foreach ($request_types as $request_type)

        <div class="col-md-4" style="margin-bottom:5px">
          <div class="col-md-12 greytile" style="padding:5px">
            <div class="col-md-4" >
                 <img style = "height:50px; width:50px; margin-left:-10px" src="{{ URL::asset('img/Letters.png') }}">
            </div>
            <div class="col-md-8" style="margin-left:0px">

                 <p style="color:white; font-size:14px"> {{$request_type->request_type}} </p>
                 <a href="{{ URL::to('request_types/' . $request_type->id) }}" onclick="window.open('{{ URL::to('request_types/' . $request_type->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('request_types/' . $request_type->id . '/edit') }}" onclick="window.open('{{ URL::to('request_types/' . $request_type->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
             </div>

           </div>
        </div>
        @endforeach 
      </div>
    </div>

 
</div>


@stop
