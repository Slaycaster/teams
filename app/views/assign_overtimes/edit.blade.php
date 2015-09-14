@extends("layout-noheader")
@section("content")

<h1>Edit Assign overtime</h1>
{{ Form::model($assign_overtime, array('method' => 'PATCH', 'route' => array('assign_overtimes.update', $assign_overtime->id))) }}
	
@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
                <br>
                <div class="label_white">{{ Form::label('name', 'Assign Overtime name:') }}</div>
                    {{ Form::text('name',Input::get('name'), array('placeholder' => 'Assign Overtime Name','autocomplete' => 'off', 'size' => '50')) }}<br>
                <div class="label_white">
                    {{ Form::label('layout', ' Overtime Policies') }}
                </div>
                     {{ Form::select('overtime_id', $overtime_policies, Input::old('<br>overtime_id'), array('class' => 'btn btn-default dropdown-toggle')) }}
                <br>
                <div class="label_white">
                    {{Form::label('layout','Employees')}}
                </div>
                <div class="label_white">
                    
                    {{ Form::select('employees', $employees, Input::old('employees'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'employees[]')) }}
                    
                </div>
                <br>
                <div class="label_white">
                    {{Form::label('layout','Effective Date')}}
                </div>
                <div class="label_white">
                    {{Form::label('layout','From:')}}
                </div>
                    {{ Form::text('range_from',Input::get('range_from'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar2','placeholder' => 'yyyy-mm-dd')) }}<br>
                <div class="label_white">
                    {{Form::label('layout','To:')}}
                </div>
                    {{ Form::text('range_to',Input::get('range_to'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar3','placeholder' => 'yyyy-mm-dd')) }}<br><br>

                 {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
                 <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
{{ Form::close() }}




<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
</script>

<script type="text/javascript">
    $('#calendar2').datepicker({
        format: "yyyy-mm-dd"
    });
</script>

<script type="text/javascript">
    $('#calendar3').datepicker({
        format: "yyyy-mm-dd"
    });
</script>
@stop
