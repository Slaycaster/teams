@extends("layout-noheader")
@section("content")

<head>
    <title>Exception policy | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Show Exception policy</h1>


<div class = "label_white">

@for ($i=0; $i < 1; $i++)
	@foreach ($groups[$i] as $group) 
 {{ Form::label('exceptiongroup_name', 'Exception Group Name:') }}
  <h4>{{ Form::label($group->exceptiongroup_name) }}</h4><br>
 
 {{ Form::label('description', 'Description:') }}<br>
 {{ Form::label($group->description) }}<br><br>
	 @endforeach
	@endfor
<div class="label_white"><table class="table table-bordered">
	<thead>
		<tr>
			<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
			<th>Active</th>
			
				<th>Exception name</th>
				<th>Severity</th>
				<th>Grace</th>
				<th>Watch window</th>
				<th>Email notification</th>
				
		</tr>
	</thead>

	<tbody>
	@for ($i=0; $i < count($exceptions_lists); $i++)
		@foreach ($exceptions_lists[$i] as $exceptions_list) 
			<tr>
					<td>{{{ $exceptions_list->is_active }}}</td>
				
					<td>{{{ $exceptions_list->exception_name }}}</td>
					@foreach($exception_groups as $group)
						@if($exceptions_list->id == $group->exception_id)
							<td>{{{ $group->severity }}}</td>
							<td>{{{ $group->grace }}}</td>
							<td>{{{ $group->watch_window }}}</td>
							<td>{{{ $group->email_notification }}}</td> 
						@endif
					@endforeach  
		 @endforeach

			</tr>
	@endfor
	</tbody>
</table></div>
</div>
@stop
