@extends("layout-noheader")
@section("content")

<h1>Edit Level</h1>
@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

{{ Form::model($level, array('method' => 'PATCH', 'route' => array('levels.update', $level->id))) }}
	<ul>
        <div class="label_white">
            {{ Form::label('number', 'Number:') }}
            {{ Form::input('number', 'number') }}</div>
        

        <div class="label_white">
            {{ Form::label('name', 'Name:') }}</div>
            {{ Form::text('name') }}
        

        <div class="label_white">
            {{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}
        

		  <br><br>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			 <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
		
	</ul>
{{ Form::close() }}



@stop
