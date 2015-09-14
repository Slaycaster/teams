@extends("layout")
@section("content")

<head>
    <title>Create Premium policy | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Create Premium policy</h1>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
<div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('premium_policies') }}"  class="btn btn-default">Premium  Policy</a>
            <a class="btn btn-default">Add Overtime policy</a>
        </div>

{{ Form::open(array('route' => 'premium_policies.store')) }}
    <ul>
        <div class = "col-md-5">
            <div class="label_white">{{ Form::label('premium_name', 'Premium name:') }}</div>
            {{ Form::text('premium_name', Input::get('premium_name'), array('placeholder' => 'Premium name','autocomplete' => 'off', 'size' => '40')) }}<br><br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br><br>
        </div>

            <div class="col-md-7">
            <fieldset>
                <legend>Schedules</legend>
            <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Sunday</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Monday</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Tuesday</a></li>
                            <li><a href="#tab4primary" data-toggle="tab">Wednesday</a></li>
                            <li><a href="#tab5primary" data-toggle="tab">Thurday</a></li>
                            <li><a href="#tab6primary" data-toggle="tab">Friday</a></li>
                            <li><a href="#tab7primary" data-toggle="tab">Saturday</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        
                        <div class="tab-pane fade in active" id="tab1primary" >
                            <div class="label_white">
                            
                            {{ Form::label('sun_timein', 'Sunday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('sun_timein', Input::get('sun_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div class="label_white">{{ Form::label('sun_timeout', 'Sunday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('sun_timeout', Input::get('sun_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div>
                            
                            
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                            <div class="label_white">{{ Form::label('m_timein', 'Monday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('m_timein', Input::get('m_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                            
                            <div class="label_white">{{ Form::label('m_timeout', 'Monday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('m_timeout', Input::get('m_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div>
                            
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                            <div class="label_white">{{ Form::label('t_timein', 'Tuesday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('t_timein', Input::get('t_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div class="label_white">{{ Form::label('t_timeout', 'Tuesday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('t_timeout', Input::get('t_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">
                            <div class="label_white">{{ Form::label('w_timein', 'Wednesday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('w_timein', Input::get('w_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div class="label_white">{{ Form::label('w_timeout', 'Wednesday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('w_timeout', Input::get('w_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div>
                        </div>
                        <div class="tab-pane fade" id="tab5primary">
                           <div class="label_white">{{ Form::label('th_timein', 'Thursday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('th_timein', Input::get('th_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div class="label_white">{{ Form::label('th_timeout', 'Thursday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('th_timeout', Input::get('th_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div>
                        </div>
                        <div class="tab-pane fade" id="tab6primary">
                           <div class="label_white">{{ Form::label('f_timein', 'Friday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('f_timein', Input::get('f_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div class="label_white">{{ Form::label('f_timeout', 'Friday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('f_timeout', Input::get('f_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div>
                        </div>
                        <div class="tab-pane fade" id="tab7primary">
                           <div class="label_white">{{ Form::label('sat_timein', 'Saturday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('sat_timein', Input::get('sat_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div class="label_white">{{ Form::label('sat_timeout', 'Saturday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('sat_timeout', Input::get('sat_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div>
                        </div>
                    </div>
                    
            </fieldset>
            <br><br>
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        </div>
    </ul>
{{ Form::close() }}
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
$('.clockpicker').clockpicker();
</script>

@stop


