@extends('layouts.scaffold')

@section('main')

<h1>Create Custom_assign_overtime</h1>

{{ Form::open(array('route' => 'custom_assign_overtimes.store')) }}
	<ul>
        <li>
            {{ Form::label('active_after', 'Active_after:') }}
            {{ Form::input('number', 'active_after') }}
        </li>

        <li>
            {{ Form::label('Allowed_number_of_hours', 'Allowed_number_of_hours:') }}
            {{ Form::input('number', 'Allowed_number_of_hours') }}
        </li>

        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('range_from', 'Range_from:') }}
            {{ Form::text('range_from') }}
        </li>

        <li>
            {{ Form::label('range_to', 'Range_to:') }}
            {{ Form::text('range_to') }}
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


