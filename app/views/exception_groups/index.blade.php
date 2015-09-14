@extends('layouts.scaffold')

@section('main')

<h1>All Exception_groups</h1>

<p>{{ link_to_route('exception_groups.create', 'Add new exception_group') }}</p>

@if ($exception_groups->count())
	<div class="label_white"><table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Exceptiongroup_name</th>
				<th>Description</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($exception_groups as $exception_group)
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
			@endforeach
		</tbody>
	</table></div>
@else
	There are no exception groups
@endif

@stop
