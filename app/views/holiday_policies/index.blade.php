@extends("layout")
@section("content")

<head>
    <title>Holiday policies | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Holiday policies</h1>

<div class="col-md-4" style="margin-left:-15px">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Holiday Policy</a>
        </div>
 </div>

<br><br>


<div class="container" style="margin-top:20px">
<div class = "row"> 
    <h3>Add Holiday Policy</h3>
    <div class = "col-md-4" style="margin-left:-5%">
    
                @if ($errors->any())
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif

                  {{ Form::open(array('route' => 'holiday_policies.store')) }}
                      <ul>
                          
                              <div class="label_white">{{ Form::label('holiday_name', 'Holiday Name:') }}</div>
                              {{ Form::text('holiday_name',Input::get('holiday_name'), array('placeholder' => 'Holiday Name','autocomplete' => 'off', 'size' => '40'))}}<br>
                          
                              <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
                              {{ Form::textarea('description') }}<br>
                            
                                </div>
        
                            <div class = "col-md-3">
                              <div class="label_white">{{ Form::label('default_schedule_status', 'Default Schedule Status:') }}</div>
                              {{ Form::select('default_schedule_status', array('Working' => 'Working', 'Non-working' => 'Non-working')) }}<br>      
                               
                              <div class="label_white">{{Form::label('recurring_holiday','Recurring:')}}
                              {{Form::checkbox('recurring', 'true', false)}}<br></div>
                                

                              <div class="label_white">{{ Form::label('day_of_month', 'Day Of Month:') }}</div>
                              {{ Form::text('day_of_month', null, array('id' => 'dayofmonth')) }}<br>
                          
                              <div class="label_white">{{ Form::label('month', 'Month:') }}</div>
                              {{ Form::select('month', array('January' => 'January', 'February' => 'February', 'March' => 'March','April' => 'April','May' => 'May','June' => 'June','July' => 'July','August' => 'August','September' => 'September','October' => 'October','November' => 'November','December' => 'December')) }}<br><br>
                          
                              {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
                            
                                 </ul>
                                 {{ Form::close() }}

                           </div>

  <div class = "col-md-5" style="margin-top:-4%">
  <h3 style="margin-left:3%">All Holidays</h3>
  @foreach ($holiday_policies as $holiday_policy)

  <div class="col-md-6" style="margin-bottom:5px">
  	<div class="col-md-12 greytile" style="padding:5px">
    	<div class="col-md-5" >
           <img style = "height:70px; width:70px;" src="{{ URL::asset('img/PremiumPolicy.png') }}">
    	</div>
    	<div class="col-md-7" style="margin-left:0px">

           <p style="color:white; font-size:14px"> {{$holiday_policy->holiday_name}}
           </p>                    
       
           <p style="color:white; font-size:12px"> {{$holiday_policy->frequency}}</p>

           <p style="color:white; font-size:12px">{{$holiday_policy->month}} {{$holiday_policy->day_of_month}}</p>
           <a href="{{ URL::to('holiday_policies/' . $holiday_policy->id) }}" onclick="window.open('{{ URL::to('holiday_policies/' . $holiday_policy->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('holiday_policies/' . $holiday_policy->id . '/edit') }}" onclick="window.open('{{ URL::to('holiday_policies/' . $holiday_policy->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
       </div>

     </div>
    </div>
	@endforeach 
</div>
</div>
</div>

<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>
@stop