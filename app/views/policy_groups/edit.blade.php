@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Policy Group | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
<h1>Edit Policy Group</h1>

</div>

{{ Form::model($policy_group, array('method' => 'PATCH', 'route' => array('policy_groups.update', $policy_group->id))) }}
	<ul>
        <div class = "col-md-6">
            <div class="label_white">{{ Form::label('policygroup_name', 'Policy Group name:') }}</div>
            {{ Form::text('policygroup_name') }}<br>
        

        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        

        
            <div class="label_white">{{ Form::label('exception_name', 'Exception name:') }}</div>
            {{ Form::select('exceptiongroup_id', $exception_groups, Input::old('exceptiongroup_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
        </div>

        
            <div class="label_white">{{ Form::label('overtime_name', 'Overtime name:') }}</div>
            {{ Form::select('overtime_id', $overtime_policies, Input::old('overtime_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
    

        
            <div class="label_white">{{ Form::label('holiday_name', 'Holiday name:') }}</div>
            {{ Form::select('holiday_id', $holiday_policies, Input::old('holiday_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
        
            <br>
            
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			 <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
		
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
