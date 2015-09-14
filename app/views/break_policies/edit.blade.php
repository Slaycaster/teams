@extends("layout")
@section("content")

<head>
    <title>Edit Break policy | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Edit Break Policy</h1>

<div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('break_policies') }}" class="btn btn-default">Break Policies</a>
            <a class="btn btn-default">Edit Break Policy</a>
</div>


{{ Form::model($break_policy, array('method' => 'PATCH', 'route' => array('break_policies.update', $break_policy->id))) }}
	
         <div class="label_white">{{ Form::label('break_name', 'Break name:') }}</div>
            {{ Form::text('break_name',Input::get('break_name'), array('placeholder' => 'Break name','autocomplete' => 'off', 'size' => '40')) }}<br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        
            <div class="label_white">{{ Form::label('type', 'Type:') }}</div>
            {{ Form::select('type', array('Auto-Deduct' => 'Auto-Deduct', 'Auto-Add' => 'Auto-Add', 'Normal' => 'Normal')) }}<br>
        
            <div class="label_white">{{ Form::label('active_after', 'Active After (in hours):') }}</div>
            {{ Form::text('active_after',Input::get('active_after'), array('placeholder' => '00:00','autocomplete' => 'off', 'size' => '40')) }}<br>
        
            <div class="label_white">{{ Form::label('autodetect_breaksby', 'Detect Breaks By:') }}</div>
            {{ Form::select('autodetect_breaksby', array('Punch Time' => 'Punch Time', 'Time Window' => 'Time Window'))}}<br><br>

			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('break_policies.show', 'Cancel', $break_policy->id, array('class' => 'btn')) }}
	
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
