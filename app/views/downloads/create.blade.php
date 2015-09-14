@extends('layouts.scaffold')

@section('main')

<h1>Create Download</h1>

{{ Form::open(array('route' => 'downloads.store')) }}
	<ul>
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


