@extends('layouts.scaffold')

@section('main')

<h1>Edit Assign_exception</h1>
@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

{{ Form::model($assign_exception, array('method' => 'PATCH', 'route' => array('assign_exceptions.update', $assign_exception->id))) }}
	
			<div class="label_white">{{ Form::label('group_name', 'Group_name:') }}</div>
            {{ Form::text('group_name') }}<br>
        
            <div class="label_white">{{ Form::label('exception_id', 'Exception_id:') }}</div>
            {{ Form::input('number', 'exception_id') }}<br><br>

			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('assign_exceptions.show', 'Cancel', $assign_exception->id, array('class' => 'btn')) }}
			
{{ Form::close() }}


@stop
