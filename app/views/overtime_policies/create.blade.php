@extends("layout")
@section("content")
 
<head>
    <title>Create Overtime policy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Create Overtime policy</h1>

        @if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('overtime_policies') }}"  class="btn btn-default">Overtime policy</a>
            <a class="btn btn-default">Add Overtime policy</a>
        </div>
  </div> 



{{ Form::open(array('route' => 'overtime_policies.store')) }}
    <ul>
        
            <div class="label_white">{{ Form::label('overtime_name', 'Overtime name:') }}</div>
            {{ Form::text('overtime_name', Input::get('overtime_name'), array('placeholder' => 'Overtime name','autocomplete' => 'off', 'size' => '40')) }}<br><br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        
             
            <div class="label_white">{{ Form::label('active_after', 'Active After (Hours) from Daily Scheduled time') }}</div>
            <div class="label_white" style = "background-color:white;">
            {{ Form::text('active_after', Input::get('active_after'), array('placeholder' => 'Number of Hours:','autocomplete' => 'off', 'size' => '40')) }}</div><br>
        
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        
    </ul>
{{ Form::close() }}



@stop


