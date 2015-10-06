@extends("layout_employee")
@section("content")

<head>
    <title>Punctuality Assessment - Subordinates Query | Time and Electronic Attendance Monitoring System</title>
</head>
<br><br><br>
<div class = "container">
<h1>Punctuality Assessment - Subordinates</h1>
<div align="center">
	<br>
	{{ Form::open(array('url' => 'employee/punctassessmentsubpost', 'method' => 'post')) }}
				<div class = "col-md-4">
					<div class="label_white">
					{{ Form::label('choose_date', 'Date from:')}}
					</div>
					 {{ Form::text('datefrom',Input::get('datefrom'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}<br>
				</div>
				
				<div class = "col-md-4">
					<div class="label_white">
					{{ Form::label('choose_date', 'Date to:')}}
					</div>

					{{ Form::text('dateto',Input::get('dateto'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar2','placeholder' => 'yyyy-mm-dd')) }}<br>
				</div>

				<div class = "col-md-2">
					<br>
					{{ Form::button('Go!', array('class' => 'btn btn-success','id' => 'query')) }}
				</div>
				
				{{ Form::close() }}	
	</div>
<div class="col-md-1">
</div>
{{ Form::open(array('url' => 'employee/punctassessmentsubpost', 'method' => 'post')) }}
<div class="col-md-9" align="center" style="margin-top	:55px; background-color:white; ">
	<br>
	<h2 style="color:black">{{$now}} {{$to}} {{$dateto}}</h2>
	<h1 style="color:black">Punctuality</h1><br>
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