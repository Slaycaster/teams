@extends('layout-noheader')
@section('content')

<h1>Edit Download</h1>
<br><br>
{{ Form::model($download, array('method' => 'PATCH', 'route' => array('downloads.update', $download->id))) }}
<div class="label_white">
            {{ Form::label('file_name', 'File name:') }}
</div>
            {{ Form::text('file_name') }}
            <br><br>
<div class="label_white">
            {{ Form::label('path', 'Path:') }}
</div>
            {{ Form::text('path') }}
            <br><br>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('downloads.show', 'Cancel', $download->id, array('class' => 'btn')) }}
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
