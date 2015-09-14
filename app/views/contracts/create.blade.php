@extends("layout")
@section("content")

<head>
    <title>Create Employee Type | Time and Electronic Attendance Monitoring System</title>
</head>



<div class="col-md-12" style="margin-bottom:15px; margin-left:-15px">
        <h1>Create Employee Type</h1>

        @if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('contracts') }}"  class="btn btn-default">Employee Type</a>
            <a class="btn btn-default">Add Employee Type</a>
        </div>
  </div>




{{ Form::open(array('route' => 'contracts.store')) }}
    
            <div class="label_white">{{ Form::label('contract_name', 'Employee Type:') }}</div>
            {{ Form::text('contract_name', Input::get('contract_name'), array('placeholder' => 'Employee Type','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>

            <div class="label_white">{{ Form::label('duration', 'Duration:') }}</div>
            {{ Form::input('number', 'duration', Input::get('duration'), array('placeholder' => 'Months','autocomplete' => 'off', 'size' => '40')) }}<br><br>
 
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}

    
{{ Form::close() }}


@stop


