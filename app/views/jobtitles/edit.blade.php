@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Job title | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Edit Job title</h1>
@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
{{ Form::model($jobtitle, array('method' => 'PATCH', 'route' => array('jobtitles.update', $jobtitle->id))) }}
	<ul>
         	<div class="label_white">{{ Form::label('jobtitle_name', 'Job title name:') }}</div>
            {{ Form::text('jobtitle_name', Input::get('jobtitle_name'), array('placeholder' => 'Job title','autocomplete' => 'off', 'size' => '40')) }}<br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>

			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
	</ul>
{{ Form::close() }}


@stop
