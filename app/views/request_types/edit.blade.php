@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Request type | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Edit Request Type</h1>
        
  </div>

{{ Form::model($request_type, array('method' => 'PATCH', 'route' => array('request_types.update', $request_type->id))) }}
	<ul>
        
        <div class="label_white">{{ Form::label('request_type', 'Request type:') }}</div>
            {{ Form::text('request_type') }}<br>
           
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br><br>

			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}

			<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
		
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
