@extends("layout_employee")
@section("content")

<head>
    <title>DTR Subordinates | Time and Electronic Attendance Monitoring System</title>
</head>
<br><br><br>
<h1 align="center">DTR Queries</h1>


<div class="col-md-2">
</div>
<div class="col-md-9" align="center" style="margin-top:55px; background-color:white; ">
	<br>
	 {{ Form::label('date', 'Date:') }}
            {{ Form::text('date',Input::get('date'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}
            <br>
	<h1 style="color:black">Daily Time Record</h1>
			<table class = "table table-bordered" align="center" style = "color:black;  width:800px;" >
					<thead>
						<td style = "text-align:center;"><b>Employee Name</b></td>
						<td style = "text-align:center;" colspan=10><b>Time-in</b></td>
						<td style = "text-align:center;" colspan=10><b>Break-in</b></td>
						<td style = "text-align:center;" colspan=10><b>Break-out</b></td>
						<td style = "text-align:center;" colspan=10><b>Time-out</b></td>
						<td style = "text-align:center;" colspan=5><b>Undertime</b></td>
							

					</thead>
					    
					@foreach($user as $emp)
					<tr>
						<td style = "text-align:center;">{{$emp->lname}},{{$emp->fname}}</td>
						
						<td style = "text-align:center;" colspan=10></td>
						<td style = "text-align:center;" colspan=10></td>
						<td style = "text-align:center;" colspan=10></td>
						<td style = "text-align:center;" colspan=10></td>
						<td style = "text-align:center;">Hours</td>
						<td style = "text-align:center;" ></td>
						<td style = "text-align:center;">Minutes</td>
						<td style = "text-align:center;" ></td>

					</tr>
					@endforeach
				</table>
</div>




 <script type="text/javascript">
    $('#calendar').datepicker({
        format: "yyyy-mm-dd"
    });
</script>
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