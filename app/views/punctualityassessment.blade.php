@extends("layout")
@section("content")

<head>
    <title>Punctuality Assessment - Query | Time and Electronic Attendance Monitoring System</title>
</head>

<div class = "container">
	<h1>Punctuality Assessment - All Employees</h1><br>
	<div class = "row">
		{{ Form::open(array('url' => 'postpunctualityassessment', 'method' => 'post')) }}
			<div class="col-md-3">
				<div class="label_white">
					{{ Form::label('choose_date', 'Date from:')}}
				</div>
				{{ Form::text('datefrom',Input::get('datefrom'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}<br>
			</div>
			<div class = "col-md-3">
				<div class="label_white">
					{{ Form::label('choose_date', 'Date to:')}}
				</div>
				{{ Form::text('dateto',Input::get('dateto'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar2','placeholder' => 'yyyy-mm-dd')) }}<br>
				<br>
			</div>
				{{ Form::button('Go!', array('class' => 'btn btn-success','id' => 'query')) }}
					{{ Form::close() }}
	</div>
<hr>
{{ Form::open(array('url' => 'postpunctualityassessment', 'method' => 'post')) }}
<div class="col-md-9" align="center" style="background-color:white; ">
	<br>
	<h3 style="color:black">Punctuality Assessment</h3>
	<h3 style="color:black">{{$now}} {{$to}} {{$dateto}}</h3>
	<br>
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
						<td style = "text-align:center;">{{$employee_lists[$i]['id']}}, {{$employee_lists[$i]['name']}}</td>
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

<script type="text/javascript">
$('#query').click(function(e){
    $(this).closest('form').submit();
});
</script>



<script type="text/javascript">
    $('#calendar').datepicker({
        format: "yyyy-mm-dd"
    });
</script>

<script type="text/javascript">
    $('#calendar2').datepicker({
        format: "yyyy-mm-dd"
    });
</script>



@stop