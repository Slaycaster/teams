@extends('layouts.scaffold')

@section('main')

<h1>Show Empschedule</h1>

<p>{{ link_to_route('empschedules.index', 'Return to all empschedules') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Id</th>
				<th>Employee_id</th>
				<th>Schedule_id</th>
		</tr>
	</thead>

	<tbody> 
		<tr>
			<td>{{{ $empschedule->id }}}</td>
					<td>{{{ $empschedule->employee_id }}}</td>
					<td>{{{ $empschedule->name }}}</td>
					<td>{{{ $empschedule->schedule_id }}}</td>
                    <td>{{ link_to_route('empschedules.edit', 'Edit', array($empschedule->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('empschedules.destroy', $empschedule->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
