@extends("layout")
@section("content")

<head>
    <title>Create Policy Group | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
<h1>Create Policy Group</h1>
@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
<div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('policy_groups') }}" class="btn btn-default">Policy Groups</a>
            <a class="btn btn-default">Create Policy Group</a>
</div>
</div>


{{ Form::open(array('route' => 'policy_groups.store')) }}
    <ul>
        <div class = "col-md-6">
            <div class="label_white">{{ Form::label('policygroup_name', 'Policy Group name:') }}</div>
            {{ Form::text('policygroup_name',Input::get('policygroup_name'), array('placeholder' => 'Policy Group name','autocomplete' => 'off', 'size' => '40')) }}<br>
        

    
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        

        
            <div class="label_white">{{ Form::label('exception_name', 'Exception name:') }}</div>
            {{ Form::select('exceptiongroup_id', $exception_groups, Input::old('exceptiongroup_id'), array('class' => 'btn btn-default dropdown-toggle')) }}
             </div>
        
            <div class="label_white">{{ Form::label('overtime_name', 'Overtime name:') }}</div>

            {{ Form::select('overtime_id', $overtime_policies, Input::old('overtime_id'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi1', 'multiple'=>'multiple', 'name' => 'overtime_id[]')) }}<br>

        
            
        
            <div class="label_white">{{ Form::label('holiday_name', 'Holiday name:') }}</div>

            {{ Form::select('holiday_id', $holiday_policies, Input::old('holiday_id'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi3', 'multiple'=>'multiple', 'name' => 'holiday_id[]')) }}<br>

        
        
            <div class="label_white">{{ Form::label('leave_name', 'Leave grants:') }}</div>

            {{ Form::select('leavegrant_id', $leave_grants, Input::old('accrual_id'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi6', 'multiple'=>'multiple', 'name' => 'leavegrant_id[]')) }}<br>
    
            <div class="label_white">{{ Form::label('employees', 'Assign employees:') }}</div>
            {{ Form::select('employees', $employees, Input::old('employees'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'employees[]')) }}<br><br>
        
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        
    </ul>
{{ Form::close() }}

<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
$("#multi1").multiselect().multiselectfilter();
$("#multi2").multiselect().multiselectfilter();
$("#multi3").multiselect().multiselectfilter();
$("#multi4").multiselect().multiselectfilter();
$("#multi5").multiselect().multiselectfilter();
$("#multi6").multiselect().multiselectfilter();
</script>
@stop


