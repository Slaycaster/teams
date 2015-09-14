@extends("layout")
@section("content")

<head>
    <title>Create Attendance | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Create Attendance</h1>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

{{ Form::open(array('route' => 'attendances.store')) }}

        
            <div class="label_white">{{ Form::label('employee_name', 'Employee name:') }}</div>
            {{ Form::text('employee_name', Input::get('employee_name'), array('placeholder' => 'Employee name','autocomplete' => 'off', 'size' => '32')) }}<br>
       
            <div class="label_white">{{ Form::label('attendance_time', 'Attendance time:') }}</div>
            {{ Form::text('attendance_time', Input::get('attendance_time'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '32')) }}<br>
        
            <div class="label_white">{{ Form::label('attendance_date', 'Attendance date:') }}</div>
            {{ Form::text('attendance_date', Input::get('attendance_date'), array('placeholder' => 'yyyy-mm-dd','autocomplete' => 'off', 'size' => '32')) }}<br>
       
            <div class="label_white">{{ Form::label('punch_type', 'Punch type:') }}</div>
            {{ Form::select('punch_type', array('Normal' => 'Normal', 'Lunch' => 'Lunch', 'Break' => 'Break')) }}<br>
        
            <div class="label_white">{{ Form::label('in_out', 'In/out:') }}</div>
            {{ Form::select('in_out', array('In' => 'In', 'Out' => 'Out')) }}<br><br>
        
                  {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}<br>
            
{{ Form::close() }}


@stop


