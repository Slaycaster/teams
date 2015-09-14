@extends("layout")
@section("content")

<head>
    <title>Create Break policy | Time and Electronic Attendance Monitoring System</title>
</head>
<h1>Create Break policy</h1>
@if ($errors->any())
      <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
      </ul>
@endif
<div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('break_policies') }}" class="btn btn-default">Break Policies</a>
            <a class="btn btn-default">Create Break Policy</a>
</div>



{{ Form::open(array('route' => 'break_policies.store')) }}
        
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
              
                  {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
      
{{ Form::close() }}


@stop


