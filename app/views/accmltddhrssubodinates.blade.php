@extends("layout_employee")
@section("content")

<head>
    <title>Accumulated Hours - Subordinates Query | Time and Electronic Attendance Monitoring System</title>
</head>
<br><br>
<div class = "container">
	<br>
<h1>Accumulated Hours - Subordinates</h1>
<br>
<div class = "container-fluid">   
						</div>
<div align="center">
{{ Form::open(array('url' => 'employee/accmldthrssub', 'method' => 'post')) }}
				<div class = "col-md-4">
					<div class="label_white">
					{{ Form::label('choose_date', 'Date from:')}}
					</div>
					
					 {{ Form::text('datefrom',Input::get('datefrom'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}
				</div>
					
				<div class = "col-md-4">
					<div class="label_white">
					{{ Form::label('choose_date', 'Date to:')}}
					</div>

					{{ Form::text('dateto',Input::get('dateto'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar2','placeholder' => 'yyyy-mm-dd')) }}
				</div>
				<br>
				<div class = "col-md-2">
					{{ Form::button('Go!', array('class' => 'btn btn-success','id' => 'query')) }}
				</div>
				
				{{ Form::close() }}	
</div>

<div class = "row">
	<div class="col-md-1">
	</div>

	{{ Form::open(array('url' => 'employee/accmldthrssub', 'method' => 'post')) }}
	<div class="col-md-9" align="center" style="margin-top	:55px; background-color:white; ">
		<br>
		<h2 style="color:black">{{$now}} {{$to}} {{$dateto}}</h2>
		<h1 style="color:black">Accumulated Hours</h1><br>


				<table class = "table table-bordered" align="center" style = "color:black;  width:800px;" >
						<thead>
							<td style = "text-align:center;"><b>Employee Name</b></td>
							<td style = "text-align:center;"><b>Regular Hours/Minutes</b></td>
							<td style = "text-align:center;" ><b>Overtime Hours/Minutes</b></td>
							<td style = "text-align:center;" ><b>Holiday Hours/Minutes</b></td>
							<td style = "text-align:center;"><b>Total Hours/Minutes</b></td>
							
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
</div>
<script type="text/javascript">
    $(function(){
    $(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            });
    });
    
</script>

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