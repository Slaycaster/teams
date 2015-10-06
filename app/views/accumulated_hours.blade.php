@extends("layout_employee")
@section("content")

<head>
    <title>Accumulated Hours Query | Time and Electronic Attendance Monitoring System</title>
</head>
<br><br><br>
	<div class = "container">
		<div class = "row">
			
			<div class = "col-md-9" >
				<h1 style = "color:white;">Accumulated Hours | {{$now}} {{$to}} {{$dateto}}   </h1>
			</div>
		</div>
		<hr>
			<div id="raleway" class="row">
				{{ Form::open(array('url' => 'employee/accmldthrs', 'method' => 'post')) }}
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
				<div class = "col-md-4">
					{{ Form::button('Go!', array('class' => 'btn btn-success','id' => 'query')) }}
				</div>
				{{ Form::close() }}	
				<br><br><br>
				{{ Form::open(array('url' => 'employee/accumulated_hours', 'method' => 'post')) }}
				<div class = "row">
			<div class = "col-md-6">
				<div class = "col-md-3 greentile">
					
						<center><h1 style = "color:white;">{{$acchrs}}</h1></center>
					
						<center><h4 style = "color:white;">Hours/minutes</h4></center>
				</div>
				<div class = "col-md-9 greytile" >
					<br>
					<center><h3 style = "color:white; margin-bottom:12px">Regular</h3></center>
					<br>
				</div>
			</div>

			<div class = "col-md-6">
				<div class = "col-md-3 greentile">
						<center><h1 style = "color:white;">{{$overtime}}</h1></center>
						<center><h4 style = "color:white;">Hours/minutes</h4></center>
				</div>
				<div class = "col-md-9 greytile" >
					<br>
					<center><h3 style = "color:white; margin-bottom:12px">Overtime</h3></center>
					<br>
				</div>
			</div>
			

		</div>


		<div class = "row" style = "margin-top:20px;">
			<div class = "col-md-6">
				<div class = "col-md-3 greentile">
						<center><h1 style = "color:white;">0</h1></center>
						<center><h4 style = "color:white;">Hours/minutes</h4></center>
				</div>
				<div class = "col-md-9 greytile">
					<br>
					<center><h3 style = "color:white;  margin-bottom:12px ">Holiday</h3></center>
					<br>
				</div>
			</div>
			<div class = "col-md-6">
				<div class = "col-md-3 greentile">
					<center><h1 style = "color:white;">{{$total}}</h1></center>
					<center><h4 style = "color:white;">Hours/minutes</h5></center>
				</div>
				<div class = "col-md-9 greytile">
					<br>
					<center><h3 style = "color:white; margin-bottom:12px;">Total</h3></center>
					<br>
				</div>
			</div>
		</div>
		    </div>
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
    
</script


@stop