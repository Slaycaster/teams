@extends("layout")
@section("content")


<head>
    <title>DTR Manual Edit | Time and Electronic Attendance Monitoring System</title>
</head>

<h1 style='margin-left:70px;'>Daily Time Record Manual Edit</h1>

<div class="row">
	<div class="col-md-12" style="margin-top:40px" align="center">
        {{ Form::open(array('url' => 'queries/dtr', 'method' => 'post', 'autocomplete' => 'off')) }}
		<div class="col-md-4">
			<div class="label_white">
			{{ Form::label('layout', ' Select an Employee:') }} </div>
			{{ Form::select('employs_id',$employs_id, Input::get('employs_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
		</div>
		<div class="col-md-8">
			
			<div class="col-md-2">

				<div class="label_white">{{ Form::label('layout', ' Month:') }}</div>
				{{ Form::selectMonth('month', Input::get('month'), array('class' => 'btn btn-default dropdown-toggle'))}}<br>
			</div>

			<div class="col-md-3">
				<div class="label_white">
			
				{{ Form::label('layout', ' Year:') }}  </div>
				{{ Form::selectRange('year', $year, 1995  , Input::get('year'), array('class' => 'btn btn-default dropdown-toggle'))}}<br>
			</div>
            <div class="col-md-2">
                <div class="label_white" style="margin-top:5px">
                    <br>
                     <td>  {{ Form::submit('Go', array('class' => 'btn btn-warning', 'style'=>'padding-left:30px; padding-right:30px; padding-top:7px; padding-bottom:7px;')) }}</td><br>
                 </div>
        {{Form::close()}}
		</div>
	</div>
</div>
<br><br>
@if ($is_post == 'true')
  {{ Form::open(array('url' => 'queries/dtr_adjusted', 'method' => 'post', 'autocomplete' => 'off')) }}
  
  {{Form::hidden('emp_id', $emp_id)}}
  {{Form::hidden('employs_id', Input::get('employs_id'))}}
  {{Form::hidden('month', Input::get('month'))}}
  {{Form::hidden('year', $get_year)}}
<div class = 'col-md-4' style='margin-top:50px; margin-left:90px;'>
     <h3 style=' color:white; margin-top:-10px;'>Adjust Daily Time Record</h3><br>
      <div class="label_white">{{ Form::label('dtr_date', 'Date:') }}</div>
                {{ Form::text('dtr_date',Input::get('dtr_date'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}<br>
      <div class="label_white">{{ Form::label('time_in', 'Time-in:') }}</div>
             <div class="input-group clockpicker" style = "background-color:white;">
            {{ Form::text('time_in', Input::get('time_in'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '35')) }}</div>
      <div class="label_white">{{ Form::label('time_out', 'Time-out:') }}</div>
             <div class="input-group clockpicker" style = "background-color:white;">
            {{ Form::text('time_out', Input::get('time_out'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '35')) }}</div><br>
            <div class = 'col-md-5' style="margin-left:-15px">
            <input class = 'btn btn-info' type="submit" name="Change" value="Make Changes">
                </div>
            <div class = 'col-md-5'>
            <input class = 'btn btn-danger' type="submit" name="Delete" value="Delete"><br>
            </div>
    {{Form::close()}}
                  
</div>

<div class = 'col-md-4' style='margin-top:50px; margin-left:90px;  border-style: solid;
    border-width: 3px; border-color:white;'>
    @foreach($employee as $emp)
   <center> <h4 style=' color:white;'>{{$emp->lname}}, {{$emp->fname}}</h4></center><br>
    <center> <h5 style=' color:white; margin-top:-20px'>Daily Time Record as of {{$month_name}} {{$get_year}}</h5></center><br>
    @endforeach
    <hr style='margin-top:-10px;'>
         <div class ='col-md-4' style="color:white; margin-top:-15px;" >  
            <center><h2>DAY</h2></center><br>
          
              @foreach ($punch_day as $day)
                           <center>  <div class="label_white" style="margin-bottom:1px">{{ Form::label('day', $day) }}</center>
                            <br> 
              @endforeach
         </div>
        <div class ='col-md-4' style="margin-top:-15px;">
               <center><h2>AM</h2></center><br>
                @foreach ($punch_in as $in)
                         {{ Form::text('time_in', $in->time, array('autocomplete' => 'off', 'size' => '10')) }}
                        <br> <br>
                @endforeach
                </div>
                <div class ='col-md-4' style="margin-top:-15px;">
                <center><h2>PM</h2> </center> <br>
                @foreach ($punch_out as $out)
                          {{ Form::text('time_out', $out->time, array('autocomplete' => 'off', 'size' => '10')) }}
                        <br> <br>
                 @endforeach
             
               </div>       
</div>
@endif
</div>
<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>

<script type="text/javascript">
    window.onload = function() {
    if(!window.location.hash) {        
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
</script>

<script type="text/javascript">
    $('#calendar').datepicker({
        format: "yyyy-mm-dd"
    });
</script>

@stop