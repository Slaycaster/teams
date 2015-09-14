@extends("layout")
@section("content")

<head>
    <title>Create Holiday policy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Create Holiday policy</h1>

        @if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('holiday_policies') }}"  class="btn btn-default">Holiday policy</a>
            <a class="btn btn-default">Add Holiday policy</a>
        </div>
  </div>



{{ Form::open(array('route' => 'holiday_policies.store')) }}
    <ul>
        
            <div class="label_white">{{ Form::label('holiday_name', 'Holiday Name:') }}</div>
            {{ Form::text('holiday_name',Input::get('holiday_name'), array('placeholder' => 'Holiday Name','autocomplete' => 'off', 'size' => '40'))}}<br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        
            <div class="label_white">{{ Form::label('default_schedule_status', 'Default Schedule Status:') }}</div>
            {{ Form::select('default_schedule_status', array('Working' => 'Working', 'Absent' => 'Absent')) }}<br>
        
            <div class="label_white">{{ Form::label('holiday_time', 'Holiday Time:') }}</div>
            <div class="input-group clockpicker" style = "background-color:white;">
            {{ Form::text('holiday_time',Input::get('holiday_time'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40'))}}</div><br>
        
             
            <div class="label_white">{{Form::label('recurring_holiday','Recurring:')}}</div>
            {{Form::checkbox('checkbox', 'recur', false)}}<br>
            
            <div class="label_white">{{ Form::label('day_of_month', 'Day Of Month:') }}</div>
            {{ Form::text('day_of_month', null, array('id' => 'dayofmonth')) }}<br>
        
            <div class="label_white">{{ Form::label('month', 'Month:') }}</div>
            {{ Form::select('month', array('January' => 'January', 'February' => 'February', 'March' => 'March','April' => 'April','May' => 'May','June' => 'June','July' => 'July','August' => 'August','September' => 'September','October' => 'October','November' => 'November','December' => 'December')) }}<br><br>
     

        
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
          
    </ul>
{{ Form::close() }}

<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>
@stop


