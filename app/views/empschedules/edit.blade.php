@extends('layouts.scaffold')

@section('main')

<h1>Edit Empschedule</h1>
{{ Form::model($empschedule, array('method' => 'PATCH', 'route' => array('empschedules.update', $empschedule->id))) }}
	<ul>
        <li>
            {{ Form::label('id', 'Id:') }}
            {{ Form::input('number', 'id') }}
        </li>

        <li>
            {{ Form::label('employee_id', 'Employee_id:') }}
            {{ Form::input('number', 'employee_id') }}
        </li>

        <li>
            {{ Form::label('schedule_id', 'Schedule_id:') }}
            {{ Form::text('schedule_id') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('empschedules.show', 'Cancel', $empschedule->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
