@extends("layout")
@section("content")	
<head>
	<title>Maintenance | Time and Attendance Monitoring System</title>
</head>
			<h1 style = "color:white;">Maintenance</h1>

			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			
			<div class = "col-md-12">
				<a href="#demo"><img src="{{ URL::asset('img/Policy.png') }}"></a>
				
				<button style="color:white;" class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo">Policy</button>
				<hr>
				<div id="demo" class="collapse">
					<div class = "col-md-7">
						<div class = "col-md-3"><a style="color:white;" href="{{ URL::to('policy_groups') }}" class="btn btn-link">Policy Groups</a></div>
						<div class = "col-md-3"><a style="color:white;" href="{{ URL::to('exception_policies') }}" class="btn btn-link">Exception</a></div>
						<div class = "col-md-3"><a style="color:white;" href="{{ URL::to('holiday_policies') }}" class="btn btn-link">Holiday</a></div>
						<div class = "col-md-3"><a style="color:white;" href="{{ URL::to('overtime_policies') }}" class="btn btn-link">Overtime</a></div>
						<!--<div class = "col-md-3"><a style="color:white;" href="{{ URL::to('leave_grants') }}"class="btn btn-link">Leave Grants</a></div>-->
						<!--<div class = "col-md-3"><a style="color:white;" href="{{ URL::to('credit_policies') }}"class="btn btn-link">Credit</a></div>-->
					</div>

				</div>


			</div>

			
			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Branch.png') }}">
				<a style="color:white;" href="{{ URL::to('branches') }}"class="btn btn-link btn-lg">Branch</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Department.png') }}">
				<a style="color:white;" href="{{ URL::to('departments') }}"class="btn btn-link btn-lg">Department</a>
			<hr>
			</div>

			<!--
			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Station.png') }}">
				<a style="color:white;" href="{{ URL::to('stations') }}"class="btn btn-link btn-lg">Terminal</a>
				<hr>
			</div>
			-->

			<div class = "col-md-4">
				<img src="{{ URL::asset('img/level.png') }}">
				<a style="color:white;" href="{{ URL::to('levels')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Hierarchy Levels</a>
				<hr>
			</div>

			
			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Hierarchy.png') }}">
				<a style="color:white;" href="{{ URL::to('hierarchies') }}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo3">Hierarchy</a>
				<hr>
			</div>


			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Worker.png') }}">
				<a style="color:white;" href="{{ URL::to('jobtitles')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Job Titles</a>
				<hr>
			</div>


			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Contract.png') }}">
				<a style="color:white;" href="{{ URL::to('contracts')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Employee Type</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Calendar.png') }}">
				<a style="color:white;" href="{{ URL::to('schedules') }}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Schedule</a>
				<hr>
			</div>


			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Request.png') }}">
				<a style="color:white;" href="{{ URL::to('request_types') }}"class="btn btn-link btn-lg">Request Type</a>
				<hr>
			</div>

			
			<div class = "col-md-4">
				<img src="{{ URL::asset('img/Employee.png') }}">
				<a style="color:white;" href="{{ URL::to('employs')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Employee</a>
				<hr>
			</div>

			<!--
			<div class = "col-md-4">
				<img src="{{ URL::asset('img/pay.png') }}">
				<a style="color:white;" href="{{ URL::to('pay_periods')}}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Pay Period</a>
				<hr>
			</div>-->


			


		</div>
@stop