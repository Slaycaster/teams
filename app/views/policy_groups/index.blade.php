@extends("layout")
@section("content")

<head>
    <title>Policy Groups | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Policy Group Maintenance</h1>

<div class="col-md-12" style="margin-top:0px">

  <div class="col-md-4">
    <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Policy Groups</a>
        </div>
   </div>


  <div class="col-md-4">
  </div>
	
  <div class ="col-md-4">
		{{ $policy_groups->links() }}
	</div>
</div>

<div class="container" style="margin-top:60px">
    <div class="row">
      <div class="col-md-7">
        <h3>Add Policy Group</h3>
        @if ($errors->any())
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif
          <div class="col-md-7">
                {{ Form::open(array('route' => 'policy_groups.store')) }}
                <div class="label_white">{{ Form::label('policygroup_name', 'Policy Group name:') }}</div>
                {{ Form::text('policygroup_name',Input::get('policygroup_name'), array('placeholder' => 'Policy Group name','autocomplete' => 'off', 'size' => '40')) }}<br>
        

    
                <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
                {{ Form::textarea('description') }}<br>
        

            </div>
            <div class="col-md-5">

             <div class="label_white">{{ Form::label('exception_name', 'Exception name:') }}</div>
                {{ Form::select('exceptiongroup_id', $exception_groups_id, Input::old('exceptiongroup_id'), array('class' => 'btn btn-default dropdown-toggle')) }}
                
               <!-- <div class="label_white">{{ Form::label('overtime_name', 'Overtime name:') }}</div>

                {{ Form::select('overtime_id', $overtime_policies_id, Input::old('overtime_id'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi1', 'multiple'=>'multiple', 'name' => 'overtime_id[]')) }}<br>-->

        
                <div class="label_white">{{ Form::label('holiday_name', 'Holiday name:') }}</div>

                {{ Form::select('holiday_id', $holiday_policies_id, Input::old('holiday_id'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi3', 'multiple'=>'multiple', 'name' => 'holiday_id[]')) }}<br>

        
        
              
          <!--
                <div class="label_white">{{ Form::label('credit_name', 'Credit name:') }}</div>

                {{ Form::select('credit_id', $credit_policies_id, Input::old('credit_policies_id'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi7', 'multiple'=>'multiple', 'name' => 'credit_id[]')) }}<br>-->
    
                <div class="label_white">{{ Form::label('employees_id', 'Assign employees:') }}</div>
                {{ Form::select('employees', $employees, Input::old('employees'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'employees[]')) }}<br><br>
        
                {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
            </div>
        
   
            {{ Form::close() }}
      </div>
      <div class="col-md-4">
        @foreach ($policy_groups as $policy_group)
        <div class="cold-md-6" style="margin-bottom:5px">

            <div class="col-md-8 greytile" style="padding:2px">
                   <div class="col-md-5" >
                      <img style = "height:90px; width:90px; margin-top:15px; margin-left:-10px" src="{{ URL::asset('img/PremiumPolicy.png') }}">
                   </div>
                  <div class="col-md-7" style="margin-left:0px">

                   <p style="color:white; font-size:20px"> {{$policy_group->policygroup_name}}</p>
                   <a href="{{ URL::to('policy_groups/' . $policy_group->id) }}" onclick="window.open('{{ URL::to('policy_groups/' . $policy_group->id) }}', 'newwindow', 'width=450, height=500'); return false;">View/ Edit<br>Subordinates</a>
                        |
                   <a href="{{ URL::to('policy_groups/' . $policy_group->id . '/edit') }}" onclick="window.open('{{ URL::to('policy_groups/' . $policy_group->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit Group</a>
                  </div>

          </div>
        </div>
     @endforeach 
    </div>
   </div>
  </div>
<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
$("#multi1").multiselect().multiselectfilter();
$("#multi2").multiselect().multiselectfilter();
$("#multi3").multiselect().multiselectfilter();
$("#multi4").multiselect().multiselectfilter();
$("#multi5").multiselect().multiselectfilter();
$("#multi6").multiselect().multiselectfilter();
$("#multi7").multiselect().multiselectfilter();
</script>
@stop
