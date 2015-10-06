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
			<br>
			<!--
			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Request.png') }}">
				<a style="color:white;" href="{{URL::to('report/branch')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Employee by Branch</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Request.png') }}">
				<a style="color:white;" href="{{URL::to('report/department')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Employee by Department</a>
				<hr>
			</div>
			-->
			<div class = "col-md-4">
				<img style= 'hieght:50px; width:50px' src="{{ URL::asset('img/Branches.png') }}">
				<a style="color:white;" href="{{URL::to('report/hierarchy')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Hierarchy Structure</a>
				<hr>
			</div>
			
			<div class = "col-md-4">
				<img style= 'hieght:50px; width:50px' src="{{ URL::asset('img/Documents.png') }}">
				<a style="color:white;" href="{{URL::to('report/leavecases')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Leave Cases</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img style= 'hieght:50px; width:50px' src="{{ URL::asset('img/Hour.png') }}">
				<a style="color:white;" href="{{URL::to('report/dtr')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Daily Time Record</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img style= 'hieght:50px; width:50px' src="{{ URL::asset('img/DTR.png') }}">
				<a style="color:white;" href="{{URL::to('report/assessment')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Punctuality Assessment</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img style= 'hieght:50px; width:50px' src="{{ URL::asset('img/DTR.png') }}">
				<a style="color:white;" href="{{URL::to('report/accumulated')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Accumulated Hours</a>
				<hr>
			</div>


		</div>
@stop