@extends('layouts.scaffold')

@section('main')

<h1>Create Empdownload</h1>

{{ Form::open(array('route' => 'empdownloads.store')) }}
	<ul>
        <li>
            {{ Form::label('employee_id', 'Employee_id:') }}
            {{ Form::text('employee_id') }}
        </li>

        <li>
            {{ Form::label('file_name', 'File_name:') }}
            {{ Form::text('file_name') }}
        </li>

        <li>
            {{ Form::label('path', 'Path:') }}
            {{ Form::text('path') }}
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


