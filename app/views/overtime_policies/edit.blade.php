@extends("layout")
@section("content")
 
<head>
    <title>Edit Overtime policy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Edit Overtime policy</h1>
        
  </div> 

{{ Form::model($overtime_policy, array('method' => 'PATCH', 'route' => array('overtime_policies.update', $overtime_policy->id))) }}
	<ul>
            <div class="label_white">{{ Form::label('overtime_name', 'Overtime name:') }}</div>
            {{ Form::text('overtime_name', Input::get('overtime_name'), array('placeholder' => 'Overtime name','autocomplete' => 'off', 'size' => '40')) }}<br><br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        
        
            <div class="label_white">{{ Form::label('active_after', 'Active After (Hours) from Daily Scheduled time') }}</div>
            
            {{ Form::number('active_after', Input::get('active_after'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}

            <div class="label_white">{{ Form::label('Allowed_number_of_hours', 'Allowed number of hours:') }}</div>

            {{ Form::number('Allowed_number_of_hours', Input::get('Allowed_number_of_hours'), array('placeholder' => '0','autocomplete' => 'off', 'size' => '40')) }}<br><br>


			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
		
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
