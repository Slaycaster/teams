@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Hierarchy | Time and Electronic Attendance Monitoring System</title>
</head>
<h1>Edit Hierarchy</h1>

<div class="col-md-12" style="margin-bottom:15px; margin-left:-55px">

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
{{ Form::model($hierarchy, array('method' => 'PATCH', 'route' => array('hierarchies.update', $hierarchy->id))) }}
	<ul>
        
            <div class="label_white">{{ Form::label('hierarchy_name', 'Hierarchy name:') }}</div>
            {{ Form::text('hierarchy_name',Input::get('hierarchy_name'), array('placeholder' => 'Hierarchy name','autocomplete' => 'off', 'size' => '40')) }}<br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br><br>
        

		
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			 <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
		
	</ul>
{{ Form::close() }}
</div>

@stop
