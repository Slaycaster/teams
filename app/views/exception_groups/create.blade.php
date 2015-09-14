@extends('layouts.scaffold')

@section('main')

<h1>Create Exception_group</h1>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

{{ Form::open(array('route' => 'exception_groups.store')) }}
	
            <div class="label_white">{{ Form::label('exceptiongroup_name', 'Exceptiongroup_name:') }}</div>
            {{ Form::text('exceptiongroup_name') }}<br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}<br>
            {{ Form::textarea('description') }}</div>
        
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		
{{ Form::close() }}


@stop


