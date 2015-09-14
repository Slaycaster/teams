@extends("layout")
@section("content")

<head>
    <title>Break policy | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Show Break Policy</h1>
<div class="col-md-12" style="margin-bottom:15px">
	<div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('break_policies') }}" class="btn btn-default">Break Policies</a>
            <a class="btn btn-default">{{$break_policy->break_name}}</a>
	</div>
</div>

<div class="label_white"><table class="table  table-bordered">
	<thead>
		<tr>
			<th>Break name</th>
				<th>Description</th>
				<th>Type</th>
				<th>Active after</th>
				<th>Auto-Detect Breaks By</th>
				<th colspan="2" style=text-align:center>Actions</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $break_policy->break_name }}}</td>
					<td>{{{ $break_policy->description }}}</td>
					<td>{{{ $break_policy->type }}}</td>
					<td>{{{ $break_policy->active_after }}}</td>
					<td>{{{ $break_policy->autodetect_breaksby }}}</td>
                    <td align="center">{{ link_to_route('break_policies.edit', 'Edit', array($break_policy->id), array('class' => 'btn btn-info')) }}</td>
                    <td align="center">
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('break_policies.destroy', $break_policy->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table></div>

@stop
