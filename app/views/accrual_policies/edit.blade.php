@extends("layout")
@section("content")

<head>
    <title>Edit Accrual policy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Edit Accrual policy</h1>
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('accrual_policies') }}"  class="btn btn-default">Accrual policy</a>
            <a class="btn btn-default">Edit Accrual policy</a>
        </div>
  </div>

  {{ Form::model($accrual_policy, array('method' => 'PATCH', 'route' => array('accrual_policies.update', $accrual_policy->id))) }}
	<ul>
        
       <div class = "col-md-5">
            <div class="label_white">{{ Form::label('accrual_name', 'Accrual name:') }}</div>
            {{ Form::text('accrual_name', Input::get('accrual_name'), array('placeholder' => 'Accrual name','autocomplete' => 'off', 'size' => '48')) }}<br>
        

        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        

        
            <div class="label_white">{{ Form::label('frequency', 'Frequency:') }}</div>
            {{ Form::select('frequency', array('each Pay Period' => 'each Pay Period', 'Annually' => 'Annually', 'Monthly' => 'Monthly','Weekly' => 'Weekly')) }}<br>
        

        <div class = "col-md-7">
                    <h3> <b> Credit Reset every</b> </h3>
                            <div class="label_white">{{ Form::label('', 'Employee Hired Date:')}}</div>
                        
                            <div class="label_white">{{ Form::label('day_of_month', 'Day of month:') }}</div>
                            {{ Form::input('number', 'day_of_month')}}<br>
                    

        
                            <div class="label_white">{{ Form::label('month', 'Month:') }}</div>
                            {{ Form::select('month', array('January' => 'January', 'February' => 'February', 'March' => 'March','April' => 'April','May' => 'May','June' => 'June','July' => 'July','August' => 'August','September' => 'September','October' => 'October','November' => 'November','December' => 'December')) }}<br>
        

        
             {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('accrual_policies.show', 'Cancel', $accrual_policy->id, array('class' => 'btn')) }}
        </div>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>


@stop
