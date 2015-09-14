@extends('layouts.scaffold')

@section('main')

<h1>Edit Custom_assign_overtime</h1>
{{ Form::model($custom_assign_overtime, array('method' => 'PATCH', 'route' => array('custom_assign_overtimes.update', $custom_assign_overtime->id))) }}
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
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('custom_assign_overtimes.show', 'Cancel', $custom_assign_overtime->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
