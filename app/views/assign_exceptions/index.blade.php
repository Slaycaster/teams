@extends('layouts.scaffold')

@section('main')

<h1>All Assign_exceptions</h1>

<p>{{ link_to_route('assign_exceptions.create', 'Add new assign_exception') }}</p>

@if ($assign_exceptions->count())
	<div class="label_white"><table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Group_name</th>
				<th>Exception_id</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($assign_exceptions as $assign_exception)
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
			@endforeach
		</tbody>
	</table></div>
@else
	There are no assign exceptions
@endif

@stop
