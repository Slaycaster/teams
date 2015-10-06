@extends("layout")
@section("content")	
<head>
	<title>Utilities | Time and Attendance Monitoring System</title>
</head>

<h1 style = "color:white;">Utilities</h1>

			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			
			
			<div class = "col-md-4">
				<img style= 'hieght:50px; width:50px' src="{{ URL::asset('img/Upload.png') }}">
				<a style="color:white;" href="{{ URL::to('downloads') }}"class="btn btn-link btn-lg">Downloadable Forms</a>
				<hr>
			</div>


			<div class = "col-md-4">
				<img style= 'hieght:50px; width:50px' src="{{ URL::asset('img/Upload.png') }}">
				<a style="color:white;" href="{{ URL::to('empdownloads') }}"class="btn btn-link btn-lg">Employee Files</a>
				<hr>
			</div>

			


		</div>
@stop