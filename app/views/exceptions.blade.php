@extends("layout_employee")
@section("content")
	<br><br><br>
	<div class = "container">
		<div class = "row">
			<div class = "col-md-1" style = "margin-top:20px;">
				<img src="{{ URL::asset('img/home.png') }}">
			</div>
			<div class = "col-md-9" >
				<h1 style = "color:white;">Exceptions | <a href="#"><</a> 03-03-2015 <a href="#">></a> </h1>
			</div>
		</div>

		<br>
		<br>
			<div id="raleway" class="row">
				{{ Form::open(array('url' => 'employee/timesheet/table', 'method' => 'post')) }}			
					<div class="label_white">{{ Form::label('choose_date', 'Date:')}}</div>
					{{ Form::input('date', 'choose_date') }}
					{{ Form::submit('Go!', array('class' => 'btn btn-success')) }}
				{{ Form::close() }}	

				
			<table class = "table table-bordered">
				<thead>
					<td style="color:white">Exception</td>
					<td style="color:white">Date</td>
				</thead>

				<tr>
					<td style="color:white">Unscheduled Absence</td>
					<td style="color:white">03-Mar-15</td>
				</tr>
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