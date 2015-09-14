@extends("layout")
@section("content")

<head>
    <title>Edit Exception Group | Time and Electronic Attendance Monitoring System</title>
</head>
<h1>Edit Exception Group</h1>
{{ Form::model($exception_group, array('method' => 'PATCH', 'route' => array('exception_groups.update', $exception_group->id))) }}
	
            <div class="label_white">{{ Form::label('exceptiongroup_name', 'Exceptiongroup_name:') }}</div>
            {{ Form::text('exceptiongroup_name') }}<br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}<br></div>
            {{ Form::textarea('description') }}<br>
       
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('exception_policies.index', 'Cancel') }}
	
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
