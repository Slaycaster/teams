@extends("layout")
@section("content")	
<head>
	<title>Transactions | Time and Attendance Monitoring System</title>
</head>
			<h1 style = "color:white;">Transactions</h1>

			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"><br></div>

			<div class = "col-md-4">
				<img style ='hieght:50px; width:50px' src="{{ URL::asset('img/CalendarAdd.png') }}">
				<a style="color:white;" href="{{ URL::to('empschedules/create') }}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Assign Schedule to Employees</a>
				<hr>
			</div>


			<div class = "col-md-4">
				<img style ='hieght:50px; width:50px' src="{{ URL::asset('img/CalendarDelete.png') }}">
				<a style="color:white;" href="{{ URL::to('emp_schedules/remove') }}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Remove Employee Schedule</a>
				<hr>
			</div>

			<div class = "col-md-4">
				<img style ='hieght:50px; width:50px' src="{{ URL::asset('img/Hirarch.png') }}">
				<a style="color:white;" href="{{ URL::to('transactions/assign_hierarchy') }}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Assign Hierarchy</a>
				<hr>
			</div>
		
			<div class = "col-md-4">
				<img style ='hieght:50px; width:50px' src="{{ URL::asset('img/Overtime.png') }}">
				<a style="color:white;" href="{{ URL::to('assign_overtimes') }}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Assign Overtime</a>
				<hr>
			</div>
             
             <div class = "col-md-4">
				<img style ='hieght:50px; width:50px' src="{{ URL::asset('img/DTR.png') }}">
				<a style="color:white;" href="{{ URL::to('queries/dtr') }}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Manual Adjust DTR</a>
				<hr>
			</div>

			  <div class = "col-md-4">
				<img style ='hieght:50px; width:50px' src="{{ URL::asset('img/Animation.png') }}">
				 <a style="color:white;" href="{{ URL::to('leavecredits') }}"class="btn btn-link btn-lg" type = "button" data-toggle="collapse" data-target="#demo4">Manual Deduct Leave Credits</a>
				<hr>
			</div>

			


		</div>
@stop