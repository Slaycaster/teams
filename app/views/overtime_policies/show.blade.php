@extends("layout")
@section("content")
 
<head>
    <title>Overtime policy | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px; margin-left:-15px">
	<h1>Show Overtime Policy</h1>
   
</div>

<p>{{ link_to_route('overtime_policies.index', 'Return to all overtime policies') }}</p>

<div class="label_white">
	<table class="table table-bordered" >
	<thead>
		<tr>
			<th style="color:white;">Overtime name</th>
				<th  style="color:white;">Description</th>
				<th  style="color:white;">Active After (Hours) from Daily Scheduled time</th>
				<th style="color:white;">Allowed Number of hour/s</th>
				<th colspan="2" style="text-align:center; color:white;">Actions</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td style="color:white;">{{{ $overtime_policy->overtime_name }}}</td>
					<td style="color:white;">{{{ $overtime_policy->description }}}</td>
					<td style="color:white;">{{{ $overtime_policy->active_after }}}</td>
					<td style="color:white;">{{{ $overtime_policy->Allowed_number_of_hours }}}</td>
                    <td align="center">{{ link_to_route('overtime_policies.edit', 'Edit', array($overtime_policy->id), array('class' => 'btn btn-info')) }}</td>
                    <td align="center">
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('overtime_policies.destroy', $overtime_policy->id))) }}
                           <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table></div>

@stop
