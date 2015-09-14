@extends("layout")
@section("content")

<head>
    <title>Assign Employee Schedule | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
    <h1>Assign Employee Schedule</h1>
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('schedules') }}"  class="btn btn-default">All Schedules</a>
            <a class="btn btn-default">Assign Employee Schedule</a>
        </div>
  </div>

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

{{ Form::open(array('route' => 'empschedules.store')) }}
    <ul>
        
            <div class="label_white">{{ Form::label('branch_id', 'Branch name:') }}</div>
            {{ Form::select('branch_id', $branch, Input::old('<br>branch_id'), array('class' => 'btn btn-default dropdown-toggle')) }}

            <div class="label_white">{{ Form::label('department_id', 'Department name:') }}</div>
            {{ Form::select('department_id', $department, Input::old('<br>department_id'), array('class' => 'btn btn-default dropdown-toggle')) }}

             <div class="label_white">{{ Form::label('schedule_id', 'Schedule name:') }}</div>
            {{ Form::select('schedule_id', $schedule, Input::old('<br>schedule_id'), array('class' => 'btn btn-default dropdown-toggle')) }}

            <div class="label_white">{{ Form::label('name', 'Assigned Schedule Name:') }}</div>
            {{ Form::text('name', Input::get('name'), array('placeholder' => 'assigned name','autocomplete' => 'off', 'size' => '40')) }}<br>
                    
            <div class="label_white">{{ Form::label('employs', 'Employees:') }}</div>
    
            {{ Form::select('employs', $employs, Input::old('employs'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'employs[]')) }}<br><br>
        
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
    
    </ul>
{{ Form::close() }}



<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
</script>
@stop
