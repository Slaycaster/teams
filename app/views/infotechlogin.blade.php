@extends("layout-loginheader")
@section("content")
<br><br><br>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<title>IT Personnel Login | Time and Electronic Attendance Monitoring System</title>
</head>
	@if (Session::has('message'))
		<div class="alert alert-danger">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('message2'))
		<div class="alert alert-info">{{ Session::get('message2') }}</div>
	@endif
			{{ Form::open(array('url' => 'login/infotech', 'method' => 'post')) }}

				
				<div id="raleway" class="row" align="center">
						<img src="{{ URL::asset('img/teams_logo.png') }}" class="img-responsive" alt="INSERT PICTURE HERE" width="250" height="150">      
				</div>

    			<div id="raleway" class="row" align="center">
						<h2 id = "raleway">IT Personnel Login</h2>
						<p id = "raleway">{{ $errors->first('username') }}
						  				  {{ $errors->first('password') }}</p>

						<p id = "raleway" style="color:black"><strong>{{ Form::text('username', Input::get('username'), array('placeholder' => 'Username','autocomplete' => 'off', 'size' => '32')) }}</strong></p>

						<p id = "raleway" style="color:black"><strong>{{ Form::password('password', array('placeholder' => 'Password', 'size' => '32')) }}</strong>
							<span class="help-block">Password must be more 4 characters.</span>
						</p>
				
						<p id = "raleway">{{ Form::submit('Submit!', array('class' => 'btn btn-primary')) }}</p>
						{{ Form::close() }}
				</div>
				<div class = "container" style = "position: fixed; bottom: 0px; width: 100%; 	height: 60px; background-color: #2c3e50; padding: 25px 0; text-align:center;">
				<p style = "color:white;">Copyright &copy; pending. Fare Matrix</p>
				</div>