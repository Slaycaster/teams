@extends('layouts.scaffold')

@section('main')

<h1>Show Assign_exception</h1>

<p>{{ link_to_route('assign_exceptions.index', 'Return to all assign_exceptions') }}</p>

<div class="label_white"><table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Group_name</th>
				<th>Exception_id</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $assign_exception->group_name }}}</td>
					<td>{{{ $assign_exception->exception_id }}}</td>
                    <td>{{ link_to_route('assign_exceptions.edit', 'Edit', array($assign_exception->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('assign_exceptions.destroy', $assign_exception->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table></div>

@stop
