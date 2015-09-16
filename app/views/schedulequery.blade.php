@extends("layout_employee")
@section("content")

<head>
    <title>Schedule Query | Time and Electronic Attendance Monitoring System</title>
</head>
<br><br><br>

<h1 align="center">Schedule</h1>
<br>
<h2 align="center">Current Schedule </h2>
	@foreach($schedule as $sched)
		@if(empty($sched))
		<h4 align="center" style="color:red"> Not assigned</h4>
		@else
		<h4 align="center"> {{$sched->schedule_name}}</h4>
		@endif
	
<div class="col-md-1">
</div>

<div class="col-md-11" align="center" style="margin-top:20px; background-color:white; ">
	
	<h3 style="color:black">{{$sched->description}}</h3>
	<br>
	
			<table class = "table table-bordered" align="center" style = "color:black;  width:1000px;" >
					<thead>
						<td style = "text-align:center;" colspan=10><b>Monday</b></td>
						<td style = "text-align:center;" colspan=10><b>Tuesday</b></td>
						<td style = "text-align:center;" colspan=10><b>Wednesday</b></td>
						<td style = "text-align:center;" colspan=10><b>Thursday</b></td>
						<td style = "text-align:center;" colspan=10><b>Friday</b></td>
						<td style = "text-align:center;" colspan=10><b>Saturday</b></td>
						<td style = "text-align:center;" colspan=10><b>Sunday</b></td>
						
					</thead>
					    
					
					<tr>
						@if($sched->m_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->m_timein}} AM - {{$sched->m_timeout}} PM</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->t_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->t_timein}} AM - {{$sched->t_timeout}} PM</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->w_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->w_timein}} AM - {{$sched->w_timeout}} PM</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->th_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->th_timein}} AM - {{$sched->th_timeout}} PM</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->f_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->f_timein}} AM - {{$sched->f_timeout}} PM</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->sat_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->sat_timein}} AM - {{$sched->sat_timeout}} PM</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->sun_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->sun_timein}} AM - {{$sched->sun_timeout}} PM</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
					</tr>
					
				</table>
				@endforeach
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



