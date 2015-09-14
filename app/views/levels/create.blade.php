@extends("layout")
@section("content")

<head>
    <title>Levels | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-top:-18px; margin-bottom:15px">
  <h1>Levels Maintenance</h1>
<div class="col-md-4">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Levels</a>
        </div>
  </div>

<div class="col-md-4">
    

<div class ="col-md-4">
    {{ $levels->links() }}
  </div>

</div>
</div>

{{ Form::open(array('route' => 'levels.store')) }}
	<ul>
        <li>
            {{ Form::label('number', 'Number:') }}
            {{ Form::input('number', 'number') }}
        </li>

        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('description', 'Description:') }}
            {{ Form::textarea('description') }}
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


