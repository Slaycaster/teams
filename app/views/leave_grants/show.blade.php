@extends("layout")
@section("content")
<head>
    <title>Show Leave Grant | Time and Attendance Monitoring System</title>
</head>
<h1>Show Leave grant</h1>

<p>{{ link_to_route('leave_grants.index', 'Return to all leave grants') }}</p>

<div class="label_white"><table class="table  table-bordered">
	<thead>
		<tr>
			<th>Name</th>
				<th>Description</th>
				<th>Allowed leave</th>
				<th>Auto-grant</th>
				<th>Withrawable</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $leave_grant->name }}}</td>
					<td>{{{ $leave_grant->description }}}</td>
					<td>{{{ $leave_grant->allowed_leave }}}</td>
					<td>{{{ $leave_grant->grant_automatically }}}</td>
					<td>{{{ $leave_grant->withrawable }}}</td>
                    <td>{{ link_to_route('leave_grants.edit', 'Edit', array($leave_grant->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table></div>

@stop
