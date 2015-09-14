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
    <script src="{{ URL::asset('js/jquery.webcamqrcode.js') }}"></script>
	<title>Attendance | Time and Electronic Attendance Monitoring System</title>
</head>
	@if (Session::has('message'))
		<div class="alert alert-danger">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('message2'))
		<div class="alert alert-info">{{ Session::get('message2') }}</div>
	@endif
			

				
				<div id="raleway" class="row" align="center">
						<h1 style="font-size:400%; padding:2px; " padding:1px; class="greentile">Hello there!</h1>
						<h4 class="greytile" style="color:white; font-size:200%; padding:8px;">Please place your QR Code in front of the camera to start.</h4>     
						<div style="width: 350px; height: 350px;" id = "qrcodebox" >
							<object type="application/x-shockwave-flash" data="{{ URL::asset('swf/webcamqrcode.swf?ID=1') }}" width="100%" height="100%"><p>L'animation flash n'est pas prise en charge</p></object>
						</div>
						<h1 id="qrcode_result">not set</h1>
						<input type="button" value="Start" id="btn_start" /> 
						<input type="button" value="Stop" id="btn_stop" />
				</div>
				<div id="raleway" class="row" align="center">
					<p>or <a class="aaf" href = "javascript:void(0)">log-in</a> instead.</p>	     
				</div>
				{{ Form::open(array('url' => 'employee/attendance', 'method' => 'post')) }}
				<fieldset class = "hideit">
    			<div id="raleway" class="row" align="center">
						<h2 id = "raleway">Employee Login</h2>
						<p id = "raleway">{{ $errors->first('username') }}
						  				  {{ $errors->first('password') }}</p>

						<p id = "raleway"><strong>{{ Form::text('username', Input::get('username'), array('placeholder' => 'Username','autocomplete' => 'off', 'size' => '32')) }}</strong></p>

						<p id = "raleway"><strong>{{ Form::password('password', array('placeholder' => 'Password', 'size' => '32')) }}</strong>
							<span class="help-block">Password must be more 4 characters.</span>
						</p>
				
						<p id = "raleway">{{ Form::submit('Log In', array('class' => 'btn btn-primary')) }}</p>
						{{ Form::close() }}
				</div>
				</fieldset>

				<script type="text/javascript">
				      $(".hideit").hide();
					$('.aaf').on("click",function(){
					  var usersid =  $(this).attr("id");
					  	$(".hideit").toggle(500);
					})

					$('#qrcodebox').WebcamQRCode({
						onQRCodeDecode: function(p_data){
								$('#qrcode_result').html(p_data);
						}
					});
					
					$('#btn_start').click(function(){
						$('#qrcodebox').WebcamQRCode().start();
					});
					
					$('#btn_stop').click(function(){
						$('#qrcodebox').WebcamQRCode().stop();
					});
				</script>

				<div class = "container" style = "position: fixed; bottom: 0px; width: 100%; 	height: 60px; background-color: #2c3e50; padding: 25px 0; text-align:center;">
				<p style = "color:white;">Copyright &copy; pending. Fare Matrix</p>
				</div>