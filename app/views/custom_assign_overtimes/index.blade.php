@extends('layouts.scaffold')

@section('main')

<h1>All Custom_assign_overtimes</h1>

<p>{{ link_to_route('custom_assign_overtimes.create', 'Add new custom_assign_overtime') }}</p>

@if ($custom_assign_overtimes->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Active_after</th>
				<th>Allowed_number_of_hours</th>
				<th>Name</th>
				<th>Range_from</th>
				<th>Range_to</th>
				<th>Employee_id</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($custom_assign_overtimes as $custom_assign_overtime)
				<tr>
					<td>{{{ $custom_assign_overtime->active_after }}}</td>
					<td>{{{ $custom_assign_overtime->Allowed_number_of_hours }}}</td>
					<td>{{{ $custom_assign_overtime->name }}}</td>
					<td>{{{ $custom_assign_overtime->range_from }}}</td>
					<td>{{{ $custom_assign_overtime->range_to }}}</td>
					<td>{{{ $custom_assign_overtime->employee_id }}}</td>
                    <td>{{ link_to_route('custom_assign_overtimes.edit', 'Edit', array($custom_assign_overtime->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('custom_assign_overtimes.destroy', $custom_assign_overtime->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no custom_assign_overtimes
@endif

@stop
