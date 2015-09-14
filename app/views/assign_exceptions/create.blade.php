@extends('layouts.scaffold')

@section('main')

<h1>Create Assign_exception</h1>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

{{ Form::open(array('route' => 'assign_exceptions.store')) }}
        
            <div class="label_white">{{ Form::label('group_name', 'Group_name:') }}</div>
            {{ Form::text('group_name') }}<br>
        
            <div class="label_white">{{ Form::label('exception_id', 'Exception_id:') }}</div>
            {{ Form::input('number', 'exception_id') }}<br><br>
        
        	{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
	
{{ Form::close() }}


@stop


