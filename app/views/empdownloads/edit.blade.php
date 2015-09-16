@extends('layouts.scaffold')

@section('main')

<h1>Edit Empdownload</h1>
{{ Form::model($empdownload, array('method' => 'PATCH', 'route' => array('empdownloads.update', $empdownload->id))) }}
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
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('empdownloads.show', 'Cancel', $empdownload->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
