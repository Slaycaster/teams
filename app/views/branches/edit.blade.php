@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Branch | Time and Electronic Attendance Monitoring System</title>
</head>
<h1>Edit Branch</h1>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

{{ Form::model($branch, array('method' => 'PATCH', 'route' => array('branches.update', $branch->id))) }}
    
            <div class="label_white">{{ Form::label('branch_name', 'Branch Name:')}}</div>
                {{ Form::text('branch_name', Input::get('branch_name'), array('placeholder' => 'Branch name','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
            {{ Form::select('status', array('Enabled' => 'Enabled', 'Disabled' => 'Disabled')) }}<br>

            <div class="label_white">{{ Form::label('code', 'Code:') }}</div>
            {{ Form::text('code', Input::get('code'), array('placeholder' => 'Code','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('address', 'Address:') }}</div>
            {{ Form::text('address', Input::get('address'), array('placeholder' => 'Address','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('city', 'City:') }}</div>
            {{ Form::text('city', Input::get('city'), array('placeholder' => 'City','autocomplete' => 'off', 'size' => '40')) }}<br>
 
            <div class="label_white">{{ Form::label('country', 'Country:') }}</div>
            {{ Form::text('country', Input::get('country'), array('placeholder' => 'Country','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('email', 'Email:') }}</div>
            {{ Form::text('email', Input::get('email'), array('placeholder' => 'Email','autocomplete' => 'off', 'size' => '40')) }}<br><br>
 
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
        
    
{{ Form::close() }}


@stop
