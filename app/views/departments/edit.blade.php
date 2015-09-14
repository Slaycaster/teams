@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Department | Time and Electronic Attendance Monitoring System</title>
</head>
<h1>Edit Department</h1>
<!--
<div class="col-md-12" style="margin-bottom:15px; margin-left:-15px">
        <h1>Edit Department</h1>
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('departments') }}"  class="btn btn-default">Departments</a>
            <a class="btn btn-default">Edit Department</a>
        </div>
  </div>
-->
{{ Form::model($department, array('method' => 'PATCH', 'route' => array('departments.update', $department->id))) }}
	
         <div class="label_white">{{ Form::label('branch_id', 'Branch name:') }}</div>
            {{ Form::select('branch_id', $branches, Input::old('<br>branch_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
        <div class="label_white">{{ Form::label('name', 'Name:') }}</div>
            {{ Form::text('name', Input::get('name'), array('placeholder' => 'Name','autocomplete' => 'off', 'size' => '40')) }}<br>
        
            <div class="label_white">{{ Form::label('code', 'Code:') }}</div>
            {{ Form::text('code', Input::get('code'), array('placeholder' => 'Code','autocomplete' => 'off', 'size' => '40')) }}<br>
       
            <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
            {{ Form::select('status', array('Enabled' => 'Enabled', 'Disabled' => 'Disabled')) }}<br><br>
      
            
			{{ Form::submit('Update', array('class' => 'btn btn-info', 'onrelease' => 'window.opener.location.reload(true);')) }}
			<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>

{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
