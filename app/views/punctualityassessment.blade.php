@extends("layout")
@section("content")

<head>
    <title>Punctuality Assessment -  Query | Time and Electronic Attendance Monitoring System</title>
</head>

<div class = "container">
	
<h2>Punctuality Assessment  </h2>
<div class="col-md-2">
</div>
<div class="col-md-9" align="center" style="margin-top	:55px; background-color:white; ">
	<br>
	<h2 style="color:black">{{$now}}</h2>
	<h1 style="color:black">Punctuality Assessment</h1>
			<table class = "table table-bordered" align="center" style = "color:black;  width:800px;" >
					<thead>
						<td style = "text-align:center;"><b>Employee Name</b></td>
						<td style = "text-align:center;"><b>On-Time</b></td>
						<td style = "text-align:center;" ><b>Late</b></td>
						<td style = "text-align:center;" ><b>Absent</b></td>
						<td style = "text-align:center;"><b>Early Break</b></td>
						<td style = "text-align:center;"><b>Long Break</b></td>
						<td style = "text-align:center;"><b>Early Out</b></td>
						
					</thead>
					@for ($i=0; $i < count($user); $i++)
              		
					<tr>
						<td style = "text-align:center;">{{$employee_lists[$i]['id']}}</td>
						<td style = "text-align:center;" >{{$employee_lists[$i]['ontime']}}</td>
						<td style = "text-align:center;" >{{$employee_lists[$i]['late']}}</td>
						<td style = "text-align:center;" >{{$employee_lists[$i]['absent']}}</td>
						<td style = "text-align:center;" >{{$employee_lists[$i]['earlybreak']}}</td>
						<td style = "text-align:center;" >{{$employee_lists[$i]['longbreak']}}</td>
						<td style = "text-align:center;" >{{$employee_lists[$i]['earlyout']}}</td>
					</tr>
					
					@endfor
					
				</table>
</div>
</div>



@stop