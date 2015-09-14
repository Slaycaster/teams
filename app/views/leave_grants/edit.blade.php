@extends("layout")
@section("content")
<head>
    <title>Edit Leave Grant | Time and Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px; margin-left:-15px">
        <h1>Edit Leave Grants</h1>
        
  </div>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
      </ul>
@endif
{{ Form::model($leave_grant, array('method' => 'PATCH', 'route' => array('leave_grants.update', $leave_grant->id))) }}
      
            <div class="label_white">{{ Form::label('name', 'Name:') }}</div>
            {{ Form::text('name', Input::get('name'), array('placeholder' => 'Leave Grant name','autocomplete' => 'off')) }}<br>
       
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::text('description') }}<br>
        
            <div class="label_white">{{ Form::label('allowed_leave', 'Allowed leave:') }}</div>
            {{ Form::input('number', 'allowed_leave', Input::get('allowed_leave'), array('placeholder' => 'Number of day/s','autocomplete' => 'off', 'size' => '48')) }}<br><br>
        
            <div class="label_white" style = "color:white;">{{ Form::label('grant_automatically', 'Auto-grant:') }}
            {{ Form::radio('auto-grant', 'true', false) }} True
            {{ Form::radio('auto-grant', 'false', true) }} False<br>
            </div>
            <br>
        
            <div class="label_white" style = "color:white;">{{ Form::label('withrawable', 'Withrawable:') }}
            {{ Form::radio('withrawable', 'true', false) }} True
            {{ Form::radio('withrawable', 'false', true) }} False<br>
            </div>
            <br>
                  {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
                  {{ link_to_route('leave_grants.show', 'Cancel', $leave_grant->id, array('class' => 'btn')) }}

{{ Form::close() }}


@stop
