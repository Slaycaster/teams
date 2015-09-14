@extends('layout-noheader')
@section('content')

<head>
	<title>Edit Pay Period | Time and Attendance Monitoring System</title>
</head>
<!-- if there are creation errors, they will show here -->
<h1>Edit Pay Period</h1>

{{ HTML::ul($errors->all()) }}

{{ Form::model($pay_period, array('route' => array('pay_periods.update', $pay_period->id), 'method' => 'PUT')) }}
    
    <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('pay_periods') }}" class="btn btn-default">Pay Periods</a>
            <a class="btn btn-default">Edit Pay Periods</a>
    </div>
    
         <div class="label_white">{{ Form::label('name', 'Name') }}</div>
        {{ Form::text('name', Input::old('name'), array('placeholder' => 'Name','autocomplete' => 'off', 'size' => '25')) }}
    <br>

    <br>
        <div class="label_white">{{ Form::label('description', 'Description') }}</div>
        {{ Form::text('description', Input::old('description')) }}
    <br>

    <br>
        <div class="label_white">{{ Form::label('type', 'Type') }}</div>
        {{ Form::select('type', array('Weekly' => 'Weekly', 'Bi-Weekly' => 'Bi-Weekly', 'Monthly' => 'Monthly'), Input::old('type')) }}
    <br>

     <br>
        <div class="label_white">{{ Form::label('payperiod_day', 'Pay Period Day') }}</div>
        {{ Form::text('payperiod_day', Input::get('payperiod_day'), array('placeholder' => 'Day','autocomplete' => 'off', 'size' => '16')) }}
    <br>

     <br>
         <div class="label_white">{{ Form::label('initial_payperiod', 'Initial Pay Period Date') }}</div>
        {{ Form::text('initial_payperiod', Input::old('initial_payperiod'), array('id' => 'calendar', 'size' => '10', 'placeholder' => 'yyyy-mm-dd')) }}
    <br>
    <br>
    {{ Form::submit('Edit Pay Period', array('class' => 'btn btn-primary')) }}
    <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>

{{ Form::close() }}

<script type="text/javascript">
    $('#calendar').datepicker({
        format: "yyyy-mm-dd"
    });
</script>

@stop