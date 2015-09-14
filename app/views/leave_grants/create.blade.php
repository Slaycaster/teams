@extends("layout")
@section("content")
<head>
    <title>Create Leave Grant | Time and Attendance Monitoring System</title>
</head>
<div class="col-md-12" style="margin-bottom:15px; margin-left:-15px">
        <h1>Create Leave Grants</h1>

        @if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('leave_grants') }}"  class="btn btn-default">Leave Grants</a>
            <a class="btn btn-default">Add Leave Grants</a>
        </div>
  </div>




{{ Form::open(array('route' => 'leave_grants.store')) }}

       
            <div class="label_white">{{ Form::label('name', 'Name:') }}</div>
            {{ Form::text('name', Input::get('name'), array('placeholder' => 'Leave Grant name','autocomplete' => 'off')) }}<br>
       
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::text('description') }}<br>
        
            <div class="label_white">{{ Form::label('allowed_leave', 'Allowed leave:') }}</div>
            {{ Form::input('number', 'allowed_leave', Input::get('allowed_leave'), array('placeholder' => 'Number of day/s','autocomplete' => 'off', 'size' => '48')) }}<br><br>
            <div style = "color:white">
            <div class="label_white">{{ Form::label('grant_automatically', 'Auto-grant:') }}</div>
            {{ Form::radio('grant_automatically', 'true', false) }} True
            {{ Form::radio('grant_automatically', 'false', true) }} False<br>
            <br>
        
            <div class="label_white">{{ Form::label('withrawable', 'Withrawable:') }}</div>
            {{ Form::radio('withrawable', 'true', false) }} True
            {{ Form::radio('withrawable', 'false', true) }} False<br><br>
            </div>
                  {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
            
      
{{ Form::close() }}


@stop


