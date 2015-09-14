@extends("layout")
@section("content")

<head>
    <title>Create Terminal | Time and Electronic Attendance Monitoring System</title>
</head>


@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Create Terminal</h1>
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('stations') }}"  class="btn btn-default">Terminals</a>
            <a class="btn btn-default">Add Terminal</a>
        </div>
  </div>



{{ Form::open(array('route' => 'stations.store')) }}
      <ul>
        <div class="col-md-6">
            <fieldset class="field">
            <legend>Branch</legend>
            <div class="label_white">{{ Form::label('branch_id', 'Branch name:') }}</div>
            {{ Form::select('branch_id', $branches, Input::old('<br>branch_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
            </fieldset>
        
        <br><br><br>

        
            <fieldset class="field">
            <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
            {{ Form::select('status', array('Enabled' => 'Enabled')) }}<br>

        
            <div class="label_white">{{ Form::label('station_name', 'Terminal name:') }}</div>
            {{ Form::text('station_name',Input::get('station_name'), array('placeholder' => 'Station Name','autocomplete' => 'off', 'size' => '40')) }}<br>
        

        
            <div class="label_white">{{ Form::label('type', 'Type:') }}</div>
            {{ Form::select('type', array('PC' => 'PC')) }}<br>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="field">
            <div class="label_white">{{ Form::label('source', 'Source:') }}</div>
            {{ Form::text('source',Input::get('source'), array('placeholder' => 'ex. 192.168.254.254','autocomplete' => 'off', 'size' => '40')) }}<br>
        

        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::text('description', null, array('placeholder' => 'Short description here','autocomplete' => 'off', 'size' => '40')) }}<br><br>
        


            </fieldset><br><br>
                  {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        </div>
            
      </ul>
{{ Form::close() }}


@stop


