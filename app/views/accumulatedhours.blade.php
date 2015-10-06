@extends("layout")
@section("content")

<head>
    <title>Accumulated Hours Query | Time and Electronic Attendance Monitoring System</title>
</head>
	
<div class = "container">
	<h1>Accumulated Hours - All Employees</h1><br>
	<div class = "row">
		{{ Form::open(array('url' => 'postaccumulatedhours', 'method' => 'post')) }}
		<div class = "col-md-3">
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
		</div>
		<br>
		{{ Form::button('Go!', array('class' => 'btn btn-success','id' => 'query')) }}
		{{ Form::close() }}
	</div>	
<hr>
{{ Form::open(array('url' => 'postaccumulatedhours', 'method' => 'post')) }}
<div class="col-md-9" align="center" style="background-color:white; ">
	
	<h2 style="color:black">{{$now}} {{$to}} {{$dateto}}</h2>
	<h1 style="color:black">Accumulated Hrs</h1>
			<table class = "table table-bordered" style = "color:black;  width:800px;" >
					<thead>
						<td style = "text-align:center;"><b>Employee Name</b></td>
						<td style = "text-align:center;"><b>Regular Hours</b></td>
						<td style = "text-align:center;" ><b>Overtime</b></td>
						<td style = "text-align:center;" ><b>Holiday</b></td>
						<td style = "text-align:center;"><b>Total</b></td>
						
					</thead>
					@for ($i=0; $i < count($user); $i++)
              		
					<tr>
						<td style = "text-align:center;">{{$employee_lists[$i]['id']}}, {{$employee_lists[$i]['name']}}</td>
						<td style = "text-align:center;" >{{$employee_lists[$i]['acchrs']}}</td>
						<td style = "text-align:center;" >{{$employee_lists[$i]['overtime']}}</td>
						<td style = "text-align:center;" >0</td>
						<td style = "text-align:center;" >{{$employee_lists[$i]['total']}}</td>
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