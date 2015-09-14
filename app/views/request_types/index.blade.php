@extends("layout")
@section("content")

<head>
    <title>Request types | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-top:-18px; margin-left:-2%; margin-bottom:15px">
  <h1>All Request types</h1>

	<div class="col-md-4">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Request Type</a>
        </div>
  </div>
  
	
  <div class ="col-md-4">
    {{ $request_types->links() }}
  </div>
	
</div>

	<div class="container" style="margin-top:30px">
    <div class = "row">
      <br>
       
      <div class = "col-md-5" style="margin-left:-5%">
        <h3 style="margin-left:8%">Add a request type of leave</h3>
        {{ Form::open(array('route' => 'request_types.store')) }}
          <ul>
                    <div class="label_white">{{ Form::label('request_type', 'Request type:') }}</div>
                    {{ Form::text('request_type') }}<br>
                    
                
                    <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
                    {{ Form::textarea('description') }}<br><br>
                
              {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
            
          </ul>
        {{ Form::close() }}
      </div>
      <div class = "col-md-7">
        <h3>All request type of leave</h3>
        @foreach ($request_types as $request_type)

        <div class="col-md-4" style="margin-bottom:5px">
          <div class="col-md-12 greytile" style="padding:5px">
            <div class="col-md-5" >
                 <img style = "height:70px; width:70px;" src="{{ URL::asset('img/Request.png') }}">
            </div>
            <div class="col-md-7" style="margin-left:0px">

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
