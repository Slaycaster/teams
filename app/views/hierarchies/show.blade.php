@extends("layout-noheader")
@section("content")

<head>
    <title>Hierarchy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:20px">
	<h1>Show Hierarchy</h1>
</div>


<div class="label_white"><table class="table  table-bordered ">
	<thead>
		<tr>
			
			<th>Hierarchy name</th>
				<th>Description</th>
				<th style="text-align:center;">Actions</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $hierarchy->hierarchy_name }}}</td>

					<td>{{{ $hierarchy->description }}}</td>
                    <td align="center">{{ link_to_route('hierarchies.edit', 'Edit', array($hierarchy->id), array('class' => 'btn btn-info')) }}</td>
		</tr>
	</tbody>
</table></div>
{{ Form::open(array('url' => 'hierarchies/assign_hierarchy', 'method' => 'post', 'autocomplete' => 'off')) }}
@foreach($supervisors as $supervisor)
 	<div class="label_white">{{ Form::label('supervisor', 'Supervisor:') }}</div>
 	<div class="label_white" style="font-size:20px">{{ Form::label('supervisor', $supervisor) }}</div>
 @endforeach
 <div class="label_white">{{ Form::label('new_subordinates', 'Add Employees:') }}</div>

 {{ Form::select('new_subordinates', $new_subordinates, Input::old('new_subordinates'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'new_subordinates[]')) }}
 {{ Form::hidden('hierarchy_id', $hierarchy->id) }}
 {{ Form::submit('Add selected employees', array('class' => 'btn btn-info')) }}
{{ Form::close() }}
<div class="label_white"><table class="table table-bordered">
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
			<td>{{{ $employee_list->lname}}}, {{{ $emp_fname}}}</td>
			
			<td>{{ Form::open(array('url' => 'hierarchies/remove_employee', 'method' => 'post', 'autocomplete' => 'off')) }}
				 {{ Form::hidden('hierarchy_id', $hierarchy->id) }}
				 {{ Form::hidden('employee_id', $employee_list->id) }}
				 {{ Form::submit('Remove Employee', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}</td>		
                                
		</tr>
		 @endforeach
	@endfor
	</tbody>
</table></div>
<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
</script>
@stop
