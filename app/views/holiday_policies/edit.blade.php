@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Holiday policy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Edit Holiday policy</h1>
  </div>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
 <ul>
           
        </ul>
{{ Form::model($holiday_policy, array('method' => 'PATCH', 'route' => array('holiday_policies.update', $holiday_policy->id))) }}
    <ul>
            <div class="label_white">{{ Form::label('holiday_name', 'Holiday Name:') }}</div>
            {{ Form::text('holiday_name',Input::get('holiday_name'), array('placeholder' => 'Holiday Name','autocomplete' => 'off', 'size' => '40'))}}<br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        
            <div class="label_white">{{ Form::label('default_schedule_status', 'Default Schedule Status:') }}</div>
            {{ Form::select('default_schedule_status', array('Working' => 'Working', 'Non-working' => 'Non-working')) }}<br>
        
             <div class="label_white">{{Form::label('recurring_holiday','Recurring:')}}</div>
            {{Form::checkbox('recurring', 'true', false)}}<br>
            
            <div class="label_white">{{ Form::label('day_of_month', 'Day Of Month:') }}</div>
            {{ Form::text('day_of_month', null, array('id' => 'dayofmonth')) }}<br>
        
            <div class="label_white">{{ Form::label('month', 'Month:') }}</div>
            {{ Form::select('month', array('January' => 'January', 'February' => 'February', 'March' => 'March','April' => 'April','May' => 'May','June' => 'June','July' => 'July','August' => 'August','September' => 'September','October' => 'October','November' => 'November','December' => 'December')) }}<br><br>

            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
        
    </ul>
{{ Form::close() }}

<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>

@stop
