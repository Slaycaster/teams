@extends("layout_employee")
@section("content")

<head>
    <title>Schedule Query | Time and Electronic Attendance Monitoring System</title>
</head>
<br><br><br>

<h1>Your Current Schedule</h1>
	@foreach($schedule as $sched)
		@if(empty($sched))
		<h4 style="color:red">Not assigned to any schedule!</h4>
		@else
		<h4> {{$sched->schedule_name}} - {{$sched->description}}</h4>
		@endif
		<hr>
<div class="col-md-11" align="left" style="background-color:white; ">
	
	<h3 style="color:black"></h3>
			<table class = "table table-bordered" align="left" style = "color:black;  width:1000px;" >
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
						<td style = "text-align:center;" colspan=10>{{$sched->m_timein}} - {{$sched->m_timeout}}</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->t_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->t_timein}} - {{$sched->t_timeout}}</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->w_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->w_timein}} - {{$sched->w_timeout}}</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->th_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->th_timein}} - {{$sched->th_timeout}}</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->f_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->f_timein}} - {{$sched->f_timeout}} </td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->sat_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->sat_timein}} - {{$sched->sat_timeout}}</td>
						@else
						<td style = "text-align:center; color:red" colspan=10><b>NO SCHEDULE</b></td>
						@endif
						@if($sched->sun_timein != '00:00:00')
						<td style = "text-align:center;" colspan=10>{{$sched->sun_timein}} - {{$sched->sun_timeout}}</td>
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



