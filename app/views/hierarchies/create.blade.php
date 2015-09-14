@extends("layout")
@section("content")

<head>
    <title>Create Hierarchy | Time and Electronic Attendance Monitoring System</title>
</head>




<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
    <h1>Create Hierarchy</h1>

    @if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('hierarchies') }}"  class="btn btn-default">Hierarchies</a>
            <a class="btn btn-default">Add Hierarchy</a>
        </div>
  </div>



{{ Form::open(array('route' => 'hierarchies.store')) }}
    <ul>
        
             <div class="label_white">{{ Form::label('supervisor_id', 'Supervisor:') }}</div>
            {{ Form::select('supervisor_id', $supervisors, Input::old('supervisors'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>

            <div class="label_white">{{ Form::label('hierarchy_name', 'Hierarchy Name:') }}</div>
            {{ Form::text('hierarchy_name', Input::get('hierarchy_name'), array('placeholder' => 'Hierarchy name','autocomplete' => 'off', 'size' => '40')) }}<br>
            
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::text('description',null, array('placeholder' => 'Short description here','autocomplete' => 'off', 'size' => '40')) }}<br><br>
        
            <div class="label_white">{{ Form::label('subordinates', 'Subordinates:') }}</div>
    
            {{ Form::select('subordinates', $subordinates, Input::old('subordinates'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'subordinates[]')) }}<br><br>
        
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
    
    </ul>
{{ Form::close() }}



<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
</script>
@stop

