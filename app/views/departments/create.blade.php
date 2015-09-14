@extends("layout")
@section("content")

<head>
    <title>Create Department | Time and Electronic Attendance Monitoring System</title>
</head>


 <div class="col-md-12" style="margin-bottom:15px; margin-left:-15px">
        <h1>Create Department</h1>

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('departments') }}"  class="btn btn-default">Departments</a>
            <a class="btn btn-default">Add Department</a>
        </div>
  </div>


{{ Form::open(array('route' => 'departments.store')) }}
    
            
            <div class="label_white"> 
            
            <fieldset class="field">
            <legend>Branch</legend>
            {{ Form::label('branch_id', 'Branch name:') }}
            {{ Form::select('branch_id', $branches, Input::old('<br>branch_id'), array('class' => 'btn btn-default dropdown-toggle')) }}
            </fieldset>
            
            </div>
            <br><br>
            <div>
            <fieldset class="field">
            <div class="label_white">{{ Form::label('name', 'Name:') }}</div>
            {{ Form::text('name', Input::get('name'), array('placeholder' => 'Name','autocomplete' => 'off', 'size' => '40')) }}<br>
        
            <div class="label_white">{{ Form::label('code', 'Code:') }}</div>
            {{ Form::text('code', Input::get('code'), array('placeholder' => 'Code','autocomplete' => 'off', 'size' => '40')) }}<br>
       
            <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
            {{ Form::select('status', array('Enabled' => 'Enabled', 'Disabled' => 'Disabled')) }}<br><br>
            </fieldset>
            </div>
            <br>
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
            
        

        
    
{{ Form::close() }}


@stop


