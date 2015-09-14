@extends("layout")
@section("content")

<head>
    <title>Create Job title | Time and Electronic Attendance Monitoring System</title>
</head>


@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

<div class="col-md-12" style="margin-bottom:15px">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
              <a href="{{ URL::to('jobtitles') }}"  class="btn btn-default">Jobtitles</a>
            <a class="btn btn-default">Add Jobtitle</a>
        </div>
  </div>
{{ Form::open(array('route' => 'jobtitles.store')) }}
	<ul>
        
           <div class="label_white"> {{ Form::label('jobtitle_name', 'Job title:') }}</div>
            {{ Form::text('jobtitle_name', Input::get('jobtitle_name'), array('placeholder' => 'Job title','autocomplete' => 'off', 'size' => '40')) }}<br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		
	</ul>
{{ Form::close() }}


@stop


