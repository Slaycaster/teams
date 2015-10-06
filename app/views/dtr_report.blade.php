@extends("layout")
@section("content")


<head>
    <title>DTR Manual Edit | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Daily Time Record Manual Edit</h1>
<hr>
<div class="row">
  <div class="col-md-12" align="center">
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
           @for($date = 1; $date <= 31; $date++)
              <? $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));?>
          
                           <center>  <div class="label_white" style="margin-bottom:1px">{{ Form::label('day', $date) }}</center>
                            <br> 
          

                @endfor
         </div>
        <div class ='col-md-4' style="margin-top:-15px;">
               <center><h2>AM</h2></center><br>

                @for($date = 1; $date <= 31; $date++)
                      <?php $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));?>

                      <?php $hasTimeIn = false; ?>
                        @foreach ($punch_in as $in)
                            @if( $curr_date == $in->date)
                            
                                 {{ Form::text('time_in', $in->time, array('autocomplete' => 'off', 'size' => '10')) }} <br> <br>
                                  <?php $hasTimeIn = true; ?>
                            @endif
                             

                               
                        @endforeach
                         @if($hasTimeIn == false)
                                   {{ Form::text('time_in', ' ', array('autocomplete' => 'off', 'size' => '10')) }}   <br> <br>
                        @endif
                @endfor

       

                </div>
                <div class ='col-md-4' style="margin-top:-15px;">
                <center><h2>PM</h2> </center> <br>
                    @for($date = 1; $date <= 31; $date++)
                      <?php $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));?>

                      <?php $hasTimeOut = false; ?>
                @foreach ($punch_out as $out)
                            @if( $curr_date == $out->date)
                            
                                 {{ Form::text('time_out', $out->time, array('autocomplete' => 'off', 'size' => '10')) }} <br> <br>
                                  <?php $hasTimeOut = true; ?>
                            @endif
                             

                               
                        @endforeach
                         @if($hasTimeOut == false)
                                   {{ Form::text('time_out', ' ', array('autocomplete' => 'off', 'size' => '10')) }}   <br> <br>
                        @endif
                @endfor
               </div>       
</div>
@endif



@if ($is_post == 'break')
  {{ Form::open(array('url' => 'queries/dtr_adjusted', 'method' => 'post', 'autocomplete' => 'off')) }}
  
  {{Form::hidden('emp_id', $emp_id)}}
  {{Form::hidden('employs_id', Input::get('employs_id'))}}
  {{Form::hidden('month', Input::get('month'))}}
  {{Form::hidden('year', $get_year)}}
<div class = 'col-md-3' style='margin-top:50px; margin-left:90px;'>
     <h3 style=' color:white; margin-top:-10px;'>Adjust Daily Time Record</h3><br>
      <div class="label_white">{{ Form::label('dtr_date', 'Date:') }}</div>
                {{ Form::text('dtr_date',Input::get('dtr_date'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}<br>
      <div class="label_white">{{ Form::label('time_in', 'Time-in:') }}</div>
             <div class="input-group clockpicker" style = "background-color:white;">
            {{ Form::text('time_in', Input::get('time_in'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '35')) }}</div>
            <div class="label_white">{{ Form::label('break_in', 'Break-in:') }}</div>
             <div class="input-group clockpicker" style = "background-color:white;">
            {{ Form::text('break_in', Input::get('break_in'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '35')) }}</div>
            <div class="label_white">{{ Form::label('break_out', 'Break-out:') }}</div>
             <div class="input-group clockpicker" style = "background-color:white;">
            {{ Form::text('break_out', Input::get('break_out'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '35')) }}</div>
      <div class="label_white">{{ Form::label('time_out', 'Time-out:') }}</div>
             <div class="input-group clockpicker" style = "background-color:white;">
            {{ Form::text('time_out', Input::get('time_out'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '35')) }}</div><br>
            <div class = 'col-md-5' style="margin-left:-15px">
            <input class = 'btn btn-info' type="submit" name="Change" value="Make Changes">
                </div>
            <div class = 'col-md-5' style="margin-left:20px">
            <input class = 'btn btn-danger' type="submit" name="Delete" value="Delete"><br>
            </div>
    {{Form::close()}}
                  
</div>

<div class = 'col-md-7' style='margin-top:50px; margin-left:90px;  border-style: solid;
    border-width: 3px; border-color:white;'>
    @foreach($employee as $emp)
   <center> <h4 style=' color:white;'>{{$emp->lname}}, {{$emp->fname}}</h4></center><br>
    <center> <h5 style=' color:white; margin-top:-20px'>Daily Time Record as of {{$month_name}} {{$get_year}}</h5></center><br>
    @endforeach

    <hr style='margin-top:-10px;'>


    <div class='col-md-12'>
        <div class='col-md-2'>
           <h2>Day</h2>
        </div>
        <div class='col-md-5'>
          <center> <h2 style="margin-left:-60px">AM</h2> </center>
        </div>
        <div class='col-md-5'>
          <center><h2 style="margin-left:-40px">PM</h2></center>
        </div>

     
    </div>
         <div class ='col-md-2' style="color:white; margin-top:-15px;" >  
          <br><br><br> <br>
           @for($date = 1; $date <= 31; $date++)
              <? $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));?>
          
                           <center>  <div class="label_white" style="margin-bottom:1px">{{ Form::label('day', $date) }}</center>
                            <br> 
          

                @endfor
         </div>
        <div class ='col-md-2' style="margin-top:-15px;">
         <br>
               <center><h4>Arrival</h4></center><br>

                @for($date = 1; $date <= 31; $date++)
                      <?php $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));?>

                      <?php $hasTimeIn = false; ?>
                        @foreach ($punch_in as $in)
                            @if( $curr_date == $in->date)
                            
                                 {{ Form::text('time_in', $in->time, array('autocomplete' => 'off', 'size' => '10')) }} <br> <br>
                                  <?php $hasTimeIn = true; ?>
                            @endif
                             

                               
                        @endforeach
                         @if($hasTimeIn == false)
                                   {{ Form::text('time_in', ' ', array('autocomplete' => 'off', 'size' => '10')) }}   <br> <br>
                        @endif
                @endfor

          </div>

                 <div class ='col-md-3' style="margin-top:-15px;">
                  <br>
                 <center><h4 style="margin-left:-40px">Departure</h4></center><br>
               @for($date = 1; $date <= 31; $date++)
                      <?php $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));?>

                      <?php $hasBreakIn = false; ?>
                        @foreach ($break_in as $bin)
                            @if( $curr_date == $bin->date)
                            
                                 {{ Form::text('break_in', $bin->time, array('autocomplete' => 'off', 'size' => '10')) }} <br> <br>
                                  <?php $hasBreakIn = true; ?>
                            @endif
                             

                               
                        @endforeach
                         @if($hasBreakIn == false)
                                   {{ Form::text('break_in', ' ', array('autocomplete' => 'off', 'size' => '10')) }}   <br> <br>
                        @endif
                @endfor
                </div>


                 <div class ='col-md-2' style="margin-top:-15px;">
                  <br>
                 <center><h4>Arrival</h4></center><br>
               @for($date = 1; $date <= 31; $date++)
                      <?php $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));?>

                      <?php $hasBreakOut = false; ?>
                        @foreach ($break_out as $bout)
                            @if( $curr_date == $bout->date)
                            
                                 {{ Form::text('break_out', $bout->time, array('autocomplete' => 'off', 'size' => '10')) }} <br> <br>
                                  <?php $hasBreakOut = true; ?>
                            @endif
                             

                               
                        @endforeach
                         @if($hasBreakOut == false)
                                   {{ Form::text('break_out', ' ', array('autocomplete' => 'off', 'size' => '10')) }}   <br> <br>
                        @endif
                @endfor
                </div>

                <div class ='col-md-3' style="margin-top:-15px;">
                 <br>
                <center><h4 style="margin-left:-40px">Departure</h4> </center> <br>
                    @for($date = 1; $date <= 31; $date++)
                      <?php $curr_date = $year.'-'.date("m", mktime(0, 0, 0, $month, $month)).'-'.date("d", mktime(0, 0, 0, $month, $date));?>

                      <?php $hasTimeOut = false; ?>
                @foreach ($punch_out as $out)
                            @if( $curr_date == $out->date)
                            
                                 {{ Form::text('time_out', $out->time, array('autocomplete' => 'off', 'size' => '10')) }} <br> <br>
                                  <?php $hasTimeOut = true; ?>
                            @endif
                             

                               
                        @endforeach
                         @if($hasTimeOut == false)
                                   {{ Form::text('time_out', ' ', array('autocomplete' => 'off', 'size' => '10')) }}   <br> <br>
                        @endif
                @endfor
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
