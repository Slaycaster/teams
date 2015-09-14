@extends("layout")
@section("content")
<head>
	<title>Dashboard | Time and Electronic Attendance Monitoring System</title>
</head>
<div class = "row">
	<div class = "col-md-1" style = "margin-top:20px;">
		<img src="{{ URL::asset('img/home.png') }}">
	</div>
	<div class = "col-md-2" >
		<h1 style = "color:white;">Dashboard</h1>
	</div>
</div>

<br>
<br>

<div class = "row">
	<div class = "col-md-6">
		<div class = "col-md-3 greentile">
				<center><h1 style = "color:white;">0</h1></center>
				<center><h4 style = "color:white;">Exceptions</h4></center>
		</div>
		<div class = "col-md-9 greytile" >
			<br>
			<center><h3 style = "color:white; margin-bottom:12px">Exceptions Triggered</h3></center>
			<br>
		</div>
	</div>

	

<div class = "col-md-6">
		<div class = "col-md-3 greentile">
				<center><h1 style = "color:white;">0</h1></center>
				<center><h4 style = "color:white;">Employees</h4></center>
		</div>
		<div class = "col-md-9 greytile">
			<br>
			<center><h3 style = "color:white;  margin-bottom:12px ">Absent Employees</h3></center>
			<br>
		</div>
	</div>
</div>


<div class = "row" style = "margin-top:20px;">
	<div class = "col-md-6">
		<div class = "col-md-3 greentile">
			<center><h1 style = "color:white;">0</h1></center>
			<center><h4 style = "color:white;">Requests</h4></center>
		</div>
	<div class = "col-md-9 greytile">
		<center><h3 style = "color:white; margin-bottom:6px">Approved requests pending for execution</h3></center>
		<br>
	</div>
</div>

</div>



@stop