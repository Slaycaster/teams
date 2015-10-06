@extends("layout_employee")
@section("content")

<head>
    <title>Punctuality Assessment Query | Time and Electronic Attendance Monitoring System</title>
</head>
<br><br>
	<div class = "container">
		<div class = "row">
			
			<div class = "col-md-9" >
				<br>
				<h1 style = "color:white;">Punctuality Assessment | {{$now}} {{$to}} {{$dateto}}    </h1>
			</div>
		</div>
		<hr>

		
		
			<div id="raleway" class="row">
				{{ Form::open(array('url' => 'employee/postpunctassessment', 'method' => 'post')) }}
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
				<br><br><br>
				
				{{ Form::open(array('url' => 'employee/postpunctassessment', 'method' => 'post')) }}
			<div class = "row">
				<div class = "col-md-6">
					<div class = "col-md-3 greentile">
					
						<center><h1 style = "color:white;">{{$ontime}}</h1></center>
						
						<center><h4 style = "color:white;">Day/s</h4></center>
					</div>
					<div class = "col-md-9 greytile" >
						<br>
						<center><h3 style = "color:white; margin-bottom:12px">On-Time</h3></center>
						<br>
					</div>
				</div>

				<div class = "col-md-6">
					<div class = "col-md-3 greentile">
						<center><h1 style = "color:white;">{{$earlybreak}}</h1></center>
						<center><h4 style = "color:white;">Day/s</h4></center>
					</div>
					<div class = "col-md-9 greytile" >
						<br>
						<center><h3 style = "color:white; margin-bottom:12px">Early Break</h3></center>
						<br>
					</div>
				</div>
			</div>

			<div class = "row" style="margin-top:20px">
				<div class = "col-md-6">
					<div class = "col-md-3 greentile">
					
						<center><h1 style = "color:white;">{{$late}}</h1></center>
						
						<center><h4 style = "color:white;">Day/s</h4></center>
					</div>
					<div class = "col-md-9 greytile" >
						<br>
						<center><h3 style = "color:white; margin-bottom:12px">Late</h3></center>
						<br>
					</div>
				</div>

				<div class = "col-md-6">
					<div class = "col-md-3 greentile">
						<center><h1 style = "color:white;">{{$longbreak}}</h1></center>
						<center><h4 style = "color:white;">Day/s</h4></center>
					</div>
					<div class = "col-md-9 greytile" >
						<br>
						<center><h3 style = "color:white; margin-bottom:12px">Long Break</h3></center>
						<br>
					</div>
				</div>
			</div>

			<div class = "row" style = "margin-top:20px;">
				<div class = "col-md-6">
					<div class = "col-md-3 greentile">
						<center><h1 style = "color:white;">{{$absent}}</h1></center>
						<center><h4 style = "color:white;">Hours</h4></center> 	
					</div>
					<div class = "col-md-9 greytile">
						<br>
						<center><h3 style = "color:white;  margin-bottom:12px ">Absent</h3></center>
						<br>
					</div>
				</div>
				<div class = "col-md-6">
					<div class = "col-md-3 greentile">
						<center><h1 style = "color:white;">{{$earlyout}}</h1></center>
						<center><h4 style = "color:white;">Day/s</h5></center>
					</div>
					<div class = "col-md-9 greytile">
							<br>
							<center><h3 style = "color:white; margin-bottom:12px;">Early Out</h3></center>
							<br>
					</div>
				</div>
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