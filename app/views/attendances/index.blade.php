@extends("layout")
@section("content")

<head>
    <title>Attendances | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>All Attendances</h1>

<p>{{ link_to_route('attendances.create', 'Add new attendance') }}</p>

@if ($attendances->count())
	<div class="label_white"><table class="table table-bordered">
		<thead>
			<tr>
				<th>Employee name</th>
				<th>Attendance time</th>
				<th>Attendance date</th>
				<th>Punch type</th>
				<th>In/out</th>
				<th colspan="2" style="text-align:center">Actions</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($attendances as $attendance)
				<tr>
					<td>{{{ $attendance->employee_name }}}</td>
					<td>{{{ $attendance->attendance_time }}}</td>
					<td>{{{ $attendance->attendance_date }}}</td>
					<td>{{{ $attendance->punch_type }}}</td>
					<td>{{{ $attendance->in_out }}}</td>
                    <td align="center">{{ link_to_route('attendances.edit', 'Edit', array($attendance->id), array('class' => 'btn btn-info')) }}</td>
                    <td align="center">
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('attendances.destroy', $attendance->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table></div>
@else
	There are no attendances
@endif

@stop
