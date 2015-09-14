@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Terminal | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Edit Terminal</h1>
  </div>

{{ Form::model($station, array('method' => 'PATCH', 'route' => array('stations.update', $station->id))) }}
	<ul>
             <div class="label_white">{{ Form::label('branch_id', 'Branch name:') }}</div>
            {{ Form::select('branch_id', $branches, Input::old('<br>branch_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
        
            <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
            {{ Form::select('status', array('Enabled' => 'Enabled')) }}<br>

        
            <div class="label_white">{{ Form::label('station_name', 'Terminal name:') }}</div>
            {{ Form::text('station_name',Input::get('station_name'), array('placeholder' => 'Station Name','autocomplete' => 'off', 'size' => '40')) }}<br>
        

        
            <div class="label_white">{{ Form::label('type', 'Type:') }}</div>
            {{ Form::select('type', array('PC' => 'PC')) }}<br>
        

        
            <div class="label_white">{{ Form::label('source', 'Source:') }}</div>
            {{ Form::text('source',Input::get('source'), array('placeholder' => 'ex. 192.168.254.254','autocomplete' => 'off', 'size' => '40')) }}<br>
        

        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::text('description', null, array('placeholder' => 'Short description here','autocomplete' => 'off', 'size' => '40')) }}<br>
            <br>
		
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
		
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
