@extends("layout")
@section("content")
<head>
	<title>Login | Time and Electronic Attendance Monitoring System</title>
</head>
			{{ Form::open(array('url' => 'login', 'method' => 'post')) }}

				
				<div id="raleway" class="row">
					<div class="col-md-7">
					<!--
						<div class = "container-fluid">
							<video controls muted width="426" height="320" autoplay="autoplay" loop="loop">
						  <source src="{{ URL::asset('img/dancecraze.mp4') }}" type="video/mp4">
						Your browser does not support the video tag.
						</video>    
						</div>
					-->
					
						<img src="{{ URL::asset('img/teams_logo.png') }}" class="img-responsive" alt="INSERT PICTURE HERE" width="350" height="200">
					
						
					
						
    				</div>
    				<div class="col-md-1">
    				</div>
    				<div class="col-md-4" style="margin-top:120px;">
						<h2 id = "raleway">Login</h2>
						<p id = "raleway">{{ $errors->first('username') }}
						  				  {{ $errors->first('password') }}</p>

						<p id = "raleway" style="color:black"><strong>{{ Form::text('username', Input::get('username'), array('placeholder' => 'Username','autocomplete' => 'off', 'size' => '32')) }}</strong></p>

						<p id = "raleway" style="color:black"><strong>{{ Form::password('password', array('placeholder' => 'Password', 'size' => '32')) }}</strong>
							<span class="help-block">Password must be more 4 characters.</span>
						</p>
				
						<p id = "raleway">{{ Form::submit('Submit!', array('class' => 'btn btn-primary')) }}</p>
						{{ Form::close() }}
					</div>
					</div>

		        </div>
	        
	    </div>
@stop