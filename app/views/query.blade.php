@extends("layout")
@section("content")	
<head>
	<title>Queries | Time and Attendance Monitoring System</title>
</head>
			<h1 style = "color:white;">Queries</h1>

			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<br>
			<!--			
			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Request.png') }}">
				<a style="color:white;" href="{{URL::to('empbydept')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Employee by Department</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Request.png') }}">
				<a style="color:white;" href="{{URL::to('empbybranch')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Employee by Branch</a>
				<hr>
			</div>
			-->

			<div class = "col-md-4">
				<img style = 'hieght:50px; width:50px ' src="{{ URL::asset('img/ContactsSummary.png') }}">
				<a style="color:white;" href="{{URL::to('empsummary')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Employee Summary</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img style = 'hieght:50px; width:50px ' src="{{ URL::asset('img/Animation.png') }}">
				<a style="color:white;" href="{{URL::to('leave_query')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Employee Leave Credits</a>
				<hr>
			</div>
			
			
			<div class = "col-md-4">
				<img style = 'hieght:50px; width:50px ' src="{{ URL::asset('img/Documents.png') }}">
				<a style="color:white;" href="{{URL::to('leavecases')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">All Leave Cases</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img style = 'hieght:50px; width:50px ' src="{{ URL::asset('img/Hour.png') }}">
				<a style="color:white;" href="{{URL::to('accumulatedhours')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Accumulated Hours</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img style = 'hieght:50px; width:50px ' src="{{ URL::asset('img/DTR.png') }}">
				<a style="color:white;" href="{{URL::to('punctualityassessment')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Punctuality Assessments</a>
				<hr>
			</div>


		</div>
@stop