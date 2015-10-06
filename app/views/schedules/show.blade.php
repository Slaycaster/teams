@extends("layout-noheader")
@section("content")

<head>
    <title>Schedules | Time and Electronic Attendance Monitoring System</title>
</head>
<div class="col-md-12" style="margin-bottom:20px">
  <h1>Show Schedule</h1>
</div>

<div class="col-md-12">
<div class="col-md-6">
  	<div class="col-md-12" style="padding:5px">
    	<div class="col-md-4" >
          <img style = "height:75px; width:75px;" src="{{ URL::asset('img/Calendars.png') }}">
    	</div>
    	<div class="col-md-8" style="margin-left:0px">
    	 <p style="color:white; font-size:30px"> <strong>{{$schedule->schedule_name}}</strong></p>
   		<p style="color:white; font-size:25px"> {{$schedule->description}}</p>
      <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
       </div>
     </div>
     <hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;

    margin-right: auto;
    border-style: inset;
    border-width: 1px;">


  	 <div class="col-md-12">
     	<h4 style="color:white"> Schedule:</h4>
  	</div>

  	
    @if($schedule->m_timein != '00:00:00')
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
          <h5 style="color:white"> MONDAY </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:white">{{$schedule->m_timein}}  - {{$schedule->m_timeout}} </h5>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        @foreach($mon_breaks as $mon_break)
        <div class="col-md-3">
          <h5 style="color:Orange"> Break: </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:Orange">{{$mon_break->break_in}}  - {{$mon_break->break_out}} </h5>
          @endforeach
        </div>
    </div>
    @endif

    @if($schedule->t_timein != '00:00:00')
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
          <h5 style="color:white"> TUESDAY </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:white">{{$schedule->t_timein}}  - {{$schedule->t_timeout}} </h5>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        @foreach($tue_breaks as $tue_break)
        <div class="col-md-3">
          <h5 style="color:Orange"> Break: </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:Orange">{{$tue_break->break_in}}  - {{$tue_break->break_out}} </h5>
          @endforeach        
        </div>
    </div>
    @endif

    @if($schedule->w_timein != '00:00:00')
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
          <h5 style="color:white"> WEDNESDAY </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:white">{{$schedule->w_timein}}  - {{$schedule->w_timeout}} </h5>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        @foreach($wed_breaks as $wed_break)
        <div class="col-md-3">
          <h5 style="color:orange"> Break: </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:orange">{{$wed_break->break_in}}  - {{$wed_break->break_out}} </h5>
          @endforeach
        </div>
    </div>
    @endif  

    @if($schedule->th_timein != '00:00:00')
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
          <h5 style="color:white"> THURSDAY </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:white">{{$schedule->th_timein}}  - {{$schedule->th_timeout}} </h5>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        @foreach($thu_breaks as $thu_break)
        <div class="col-md-3">
          <h5 style="color:orange"> Break: </h5>
        </div>        
        <div class="col-md-8">
          <h5 style="color:orange">{{$thu_break->break_in}}  - {{$thu_break->break_out}} </h5>
          @endforeach
        </div>
    </div>
    @endif

    @if($schedule->f_timein != '00:00:00')
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
      
        <fieldset class = "friday">
        <div class="col-md-3">
          <h5 style="color:white"> FRIDAY </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:white">{{$schedule->f_timein}}  - {{$schedule->f_timeout}} </h5>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        @foreach($fri_breaks as $fri_break)
        <div class="col-md-3">
          <h5 style="color:orange"> Break: </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:orange">{{$fri_break->break_in}}  - {{$fri_break->break_out}} </h5>
          @endforeach        
        </div>
    </div>
    @endif

    @if($schedule->sat_timein != '00:00:00')
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
          <h5 style="color:white"> SATURDAY </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:white">{{$schedule->sat_timein}} - {{$schedule->sat_timeout}} </h5>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-1">
        </div>
        @foreach($sat_breaks as $sat_break)
        <div class="col-md-3">
          <h5 style="color:orange"> Break: </h5>
        </div>
        <div class="col-md-8">
          <h5 style="color:orange">{{$sat_break->break_in}}  - {{$sat_break->break_out}} </h5>
          @endforeach
        </div>
    </div>
    @endif

    @if($schedule->sun_timein != '00:00:00')
    <div class="col-md-12">
      <div class="col-md-1">
      </div>
      <div class="col-md-3">
         <h5 style="color:white"> SUNDAY </h5>
      </div>
      <div class="col-md-8">
       <h5 style="color:white">{{$schedule->sun_timein}}  - {{$schedule->sun_timeout}} </h5>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-1">
      </div>
      @foreach($sun_breaks as $sun_break)
      <div class="col-md-3">
        <h5 style="color:orange"> Break: </h5>
      </div>
      <div class="col-md-8">
        <h5 style="color:orange">{{$sun_break->break_in}}  - {{$sun_break->break_out}} </h5>
        @endforeach
      </div>
     </div>
     @endif
</div>
<div class="col-md-6">
          {{ Form::open(array('url' => 'schedules/assign_employee', 'method' => 'post', 'autocomplete' => 'off')) }}
           <div class="label_white">{{ Form::label('new_employees', 'Add Employee:') }}</div>
           {{ Form::select('new_employees', $new_subordinates, Input::old('new_employees'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'new_subordinates[]')) }}
           {{ Form::hidden('schedule_id', $schedule->id) }}
           
           {{ Form::submit('Add selected employee', array('class' => 'btn btn-info')) }}
          {{ Form::close() }}
          <div class="label_white"><table class="table table-bordered">
            <thead>
              <tr>
                <th>Employees</th>
                <th>Name</th>
                <th>Actions</th>
              </tr>
            </thead>

            <tbody>
            @for ($i=0; $i < count($employee_lists); $i++)
              @foreach ($employee_lists[$i] as $employee_list) 
                <?php $emp_fname = preg_replace('/\s+/', '', $employee_list->fname);?>
                <td><img style = "height:100px; width:100px;" src="{{URL::asset('employees').'/'.$employee_list->id.''.$employee_list->lname.''.$emp_fname.'.jpg'}}"></td>
                <td>{{{ $employee_list->lname}}}, {{{ $emp_fname}}}</td>
                
                <td>{{ Form::open(array('url' => 'schedules/remove_employee', 'method' => 'post', 'autocomplete' => 'off')) }}
                   {{ Form::hidden('schedule_id', $schedule->id) }}
                   {{ Form::hidden('employee_id', $employee_list->id) }}
                   {{ Form::submit('Remove employee', array('class' => 'btn btn-danger')) }}
                  {{ Form::close() }}</td>    
                                          
              </tr>
               @endforeach
            @endfor
            </tbody>
          </table>
          </div>

</div>
          
<script type="text/javascript">
      
       $(document).ready(function(){
        $('input[type="radio"]').load(function(){
            if($(this).attr("value")=="00:00:00"){
                $(".sunday").hide();  
       
            }
</script>
<script type="text/javascript">
      $(".monday").hide();
      if($schedule->m_timein="00:00:00"{$(".monday").toggle(500);})
</script>
<script type="text/javascript">
      $(".tuesday").hide();
      if($schedule->t_timein="00:00:00"{$(".tuesday").toggle(500);})
</script>
<script type="text/javascript">
      $(".wednesday").hide();
      if($schedule->w_timein="00:00:00"{$(".wednesday").toggle(500);})
</script>
<script type="text/javascript">
      $(".thursday").hide();
      if($schedule->th_timein="00:00:00"{$(".thursday").toggle(500);})
</script>
<script type="text/javascript">
      $(".friday").hide();
      if($schedule->f_timein="00:00:00"{$(".friday").toggle(500);})
</script>
<script type="text/javascript">
      $(".saturday").hide();
      if($schedule->sat_timein="00:00:00"{$(".saturday").toggle(500);})
</script>

<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
</script>
@stop
