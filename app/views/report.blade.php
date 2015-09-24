@extends("layout")
@section("content")	
<head>
	<title>Reports | Time and Attendance Monitoring System</title>
</head>
			<h1 style = "color:white;">Reports</h1>

			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			

			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Request.png') }}">
				<a style="color:white;" href="{{ URL::to('report/dailytimerecord') }}"class="btn btn-link btn-lg">Daily Time Record</a>
				<hr>
			</div>
			
			


		</div>
@stop