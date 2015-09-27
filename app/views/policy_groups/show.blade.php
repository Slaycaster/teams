@extends("layout-noheader")
@section("content")

<head>
    <title>Policy Group | Time and Electronic Attendance Monitoring System</title>
</head>


  <div class="col-md-6">

    <div class="col-md-12" style="padding:5px; margin-top:10px">
      <div class="col-md-4" >
          <img style = "height:100px; width:100px;" src="{{ URL::asset('img/PremiumPolicy.png') }}">
      </div>
      <div class="col-md-8" style="margin-left:0px">
          <p style="color:white; font-size:30px"> <strong>{{$policy_group->policygroup_name}}</strong> <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a></p>
      </div>
    </div>
    <hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;">
    <div class="col-md-12">
       <div class="col-md-4">
         <h5 style="color:white"> Description:</h5>
       </div>
       <div class="col-md-8">
         <h5 style="color:white"> {{$policy_group->description}}</h5>
       </div>
    </div>

    <div class="col-md-12">
       <div class="col-md-4">
         <h5 style="color:white"> Exception Policy/ies:</h5>
       </div>
       <div class="col-md-8">
          @foreach ($exception_groups as $exception)
            @if ($exception->id == $policy_group->exception_id)
              <h5 style="color:white"> {{$exception->exceptiongroup_name}}</h5>
            @endif
          @endforeach
       </div>
    </div>
    
    <div class="col-md-12">
       <div class="col-md-4">
         <h5 style="color:white"> Holiday Policy/ies:</h5>
       </div>
       <div class="col-md-8">
        @foreach($holiday_pivot as $holiday_p)
          @foreach ($holiday_policies as $holiday)
            @if ($holiday->id == $holiday_p->holiday_id)
              <h5 style="color:white"> {{$holiday->holiday_name}}</h5>
            @endif
          @endforeach
        @endforeach
       </div>
    </div>
    


{{ Form::open(array('url' => 'policy_groups/assign_policy', 'method' => 'post', 'autocomplete' => 'off')) }}
  <div style = "color:white; margin-top:50px">
      {{ Form::label('new_subordinates', 'Add new subordinate:') }}
      {{ Form::select('new_subordinates', $new_subordinates, Input::old('new_subordinates'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'new_subordinates[]')) }}
      {{ Form::hidden('policygroup_id', $policy_group->id) }}
      <br><br>
      {{ Form::submit('Add selected subordinates', array('class' => 'btn btn-info')) }}
  </div>
 <br><br>
{{ Form::close() }}
    
<table class="table table-bordered" style = "color:white;">
  <thead>
    <tr>
      <th>Subordinates</th>
      <th>Name</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
  @for ($i=0; $i < count($employee_lists); $i++)
    @foreach ($employee_lists[$i] as $employee_list) 
      <?php $emp_fname = preg_replace('/\s+/', '', $employee_list->fname);?>
      <td><img style = "height:100px; width:100px;" src="{{URL::asset('employees').'/'.$employee_list->id.''.$employee_list->lname.''.$emp_fname.'.jpg'}}"></td>
      <td>{{{ $employee_list->lname}}}, {{{ $employee_list->fname}}}</td>
      
      <td>{{ Form::open(array('url' => 'policy_groups/remove_employee', 'method' => 'post', 'autocomplete' => 'off')) }}
         {{ Form::hidden('policygroup_id', $policy_group->id) }}
         {{ Form::hidden('employee_id', $employee_list->id) }}
         {{ Form::submit('Remove subordinate', array('class' => 'btn btn-danger')) }}
        {{ Form::close() }}</td>    
                                
    </tr>
     @endforeach
  @endfor
  </tbody>
</table>
</div>

<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
</script>
@stop
