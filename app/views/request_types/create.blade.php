@extends("layout")
@section("content")

<head>
    <title>Create Request type | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Create Request Type</h1>

        @if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('request_types') }}"  class="btn btn-default">Request Type</a>
            <a class="btn btn-default">Add Request Type</a>
        </div>


  </div>




{{ Form::open(array('route' => 'request_types.store')) }}
	<ul>
            <div class="label_white">{{ Form::label('request_type', 'Request type:') }}</div>
            {{ Form::text('request_type') }}<br>
            
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br><br>
        
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		
	</ul>
{{ Form::close() }}


@stop


