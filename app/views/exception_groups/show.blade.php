@extends('layouts.scaffold')

@section('main')

<h1>Show Exception_group</h1>

<p>{{ link_to_route('exception_groups.index', 'Return to all exception_groups') }}</p>

<div class="label_white"><table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Exceptiongroup_name</th>
				<th>Description</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $exception_group->exceptiongroup_name }}}</td>
					<td>{{{ $exception_group->description }}}</td>
                    <td>{{ link_to_route('exception_groups.edit', 'Edit', array($exception_group->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('exception_groups.destroy', $exception_group->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table></div>

@stop
