@extends('layouts.scaffold')

@section('main')

<h1>Edit Download</h1>
{{ Form::model($download, array('method' => 'PATCH', 'route' => array('downloads.update', $download->id))) }}
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
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('downloads.show', 'Cancel', $download->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
