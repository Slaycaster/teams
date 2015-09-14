@extends("layout-noheader")
@section("content")

<head>
    <title>Create Exception policy | Time and Electronic Attendance Monitoring System</title>
</head>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
{{ Form::model($exception_policy, array('method' => 'PATCH', 'route' => array('exception_policies.update', $exception_policy->id))) }}
    <ul>
        <div class="label_white">{{ Form::label('is_active', 'Is active:') }}</div><br>
            {{ Form::checkbox('is_active', true) }}<br>
        
            <div class="label_white">{{ Form::label('code', 'Code:') }}</div>
            {{ Form::text('code', Input::get('code'), array('placeholder' => 'Code','autocomplete' => 'off', 'size' => '32')) }}<br>
     
            <div class="label_white">{{ Form::label('exception_name', 'Exception name:') }}</div>
            {{ Form::text('exception_name', Input::get('exception_name'), array('placeholder' => 'Exception name','autocomplete' => 'off', 'size' => '32')) }}<br>
        
            <div class="label_white">{{ Form::label('severity', 'Severity:') }}</div>
            {{ Form::select('severity', array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High', 'Critical' => 'Critical')) }}<br>
        
            <div class="label_white">{{ Form::label('grace', 'Grace:') }}</div>
            {{ Form::text('grace', Input::get('grace'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '32')) }}<br>
        
            <div class="label_white">{{ Form::label('watch_window', 'Watch window:') }}</div>
            {{ Form::text('watch_window', Input::get('watch_window'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '32')) }}<br>
        
            <div class="label_white">{{ Form::label('email_notification', 'Email notification:') }}</div>
            {{ Form::select('email_notification', array('None' => 'None', 'Employee' => 'Employee', 'Supervisior' => 'Supervisior', 'Both' => 'Both')) }}<br><br>

            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
           <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
        
    </ul>
{{ Form::close() }}


@stop
