@extends("layout_employee")
@section("content")

<head>
    <title>Accumulated Hours - Subordinates Query | Time and Electronic Attendance Monitoring System</title>
</head>
<br><br>
<div class = "container">
	<br>
<h2>Accumulated Hours - Subordinates</h2>
<div class="col-md-2">
</div>
<div class="col-md-9" align="center" style="margin-top	:55px; background-color:white; ">
	<br>
	<h2 style="color:black">{{$now}}</h2>
	<h1 style="color:black">Accumulated Hrs</h1>
			<table class = "table table-bordered" align="center" style = "color:black;  width:800px;" >
					<thead>
						<td style = "text-align:center;"><b>Employee Name</b></td>
						<td style = "text-align:center;"><b>Regular Hours</b></td>
						<td style = "text-align:center;" ><b>Overtime</b></td>
						<td style = "text-align:center;" ><b>Holiday</b></td>
						<td style = "text-align:center;"><b>Total</b></td>
						
					</thead>
					@for ($i=0; $i < count($user); $i++)
              		
					<tr>
						<td style = "text-align:center;">{{$employee_lists[$i]['id']}}</td>
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

@stop