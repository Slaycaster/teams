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
		<div class ="col-md-4">
    {{ $levels->links() }}
  </div>

</div>

<div class="container" style = "margin-left: -3%">
	<div class="row">
		<div class="col-md-4">
			<h3 style = "margin-left: 10%">Add a Level</h3>
                @if ($errors->any())
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif

                {{ Form::open(array('route' => 'levels.store')) }}
				<ul>
        			<div class="label_white">
            		{{ Form::label('number', 'Number:') }}
            		</div>
            		{{ Form::input('number', 'number') }}
        			

        			<div class="label_white">
            		{{ Form::label('name', 'Name:') }}
            		</div>
            		{{ Form::text('name') }}
        			

        			<div class="label_white">
            		{{ Form::label('description', 'Description:') }}
            		</div>
            		{{ Form::textarea('description') }}
        			

					<br>
					{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
					
				</ul>
				{{ Form::close() }}

		</div>
		<div class="col-md-8">
			<h3>All Levels</h3>
			 @foreach ($levels as $level)

              <div class="col-md-4" style="margin-bottom:5px">
                <div class="col-md-12 greytile" style="padding:5px">
                    <div class="col-md-5" style="margin-top:25px;">
                       <img style = "height:70px; width:70px;" src="{{ URL::asset('img/Hierarchy.png') }}">
                    </div>
                    <div class="col-md-7" style="margin-left:-15px">

                       <p style="color:white; font-size:14px"> {{$level->number}}
                       </p>                    
                   
                       <p style="color:white; font-size:12px"> {{$level->name}}</p>
                       <p style="color:white; font-size:11px"> {{$level->description}}</p>
                       <a href="{{ URL::to('levels/' . $level->id) }}" onclick="window.open('{{ URL::to('levels/' . $level->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('levels/' . $level->id . '/edit') }}" onclick="window.open('{{ URL::to('levels/' . $level->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
                   </div>

                 </div>
              </div>
                @endforeach

		</div>
	</div>
</div>

@stop
