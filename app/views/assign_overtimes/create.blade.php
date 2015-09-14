@extends('layouts.scaffold')

@section('main')

<h1>Create Assign_overtime</h1>

{{ Form::open(array('route' => 'assign_overtimes.store')) }}
	<ul>
        <li>
            {{ Form::label('range_from', 'Range_from:') }}
            {{ Form::text('range_from') }}
        </li>

        <li>
            {{ Form::label('range_to', 'Range_to:') }}
            {{ Form::text('range_to') }}
        </li>

        <li>
            {{ Form::label('overtime_id', 'Overtime_id:') }}
            {{ Form::input('number', 'overtime_id') }}
        </li>

        <li>
            {{ Form::label('employee_id', 'Employee_id:') }}
            {{ Form::input('number', 'employee_id') }}
        </li>

		<li>
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


