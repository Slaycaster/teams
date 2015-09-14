@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Employee Type | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px; margin-left:-15px">
        <h1>Edit Employee Type</h1>
        
  </div>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
{{ Form::model($contract, array('method' => 'PATCH', 'route' => array('contracts.update', $contract->id))) }}
	
			<div class="label_white">{{ Form::label('contract_name', 'Employee Type:') }}</div>
            {{ Form::text('contract_name', Input::get('contract_name'), array('placeholder' => 'Employee Type','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>

            <div class="label_white">{{ Form::label('duration', 'Duration:') }}</div>
            {{ Form::input('number', 'duration', Input::get('duration'), array('placeholder' => 'Months','autocomplete' => 'off', 'size' => '40')) }}<br><br>

            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}

            <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>

{{ Form::close() }}


@stop
