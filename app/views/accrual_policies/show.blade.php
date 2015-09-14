@extends("layout")
@section("content")

<head>
    <title>Accrual policy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px">
	<h1>Show Accrual Policy</h1>
    <div class="btn-group btn-breadcrumb">
              <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('accrual_policies') }}"class="btn btn-default">Accual Policy</a>
            <a class="btn btn-default">Show Accrual Policy - {{$accrual_policy->accrual_name}}<a>
    </div>
</div>

<div class="label_white"><table class="table  table-bordered">
	<thead>
		<tr>
			<th>Accrual name</th>
				<th>Description</th>
				<th>Frequency</th>
				<th>After minimum employee days</th>
				<th>Day of month</th>
				<th>Month</th>
				<th>Length of service</th>
				<th>Rate year</th>
				<th>Total maximum</th>
				<th colspan="2" style=text-align:center>Actions</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $accrual_policy->accrual_name }}}</td>
					<td>{{{ $accrual_policy->description }}}</td>
					<td>{{{ $accrual_policy->frequency }}}</td>
					<td>{{{ $accrual_policy->afterminimum_empdays }}}</td>
					<td>{{{ $accrual_policy->day_of_month }}}</td>
					<td>{{{ $accrual_policy->month }}}</td>
					<td>{{{ $accrual_policy->length_of_service }}}</td>
					<td>{{{ $accrual_policy->rate_year }}}</td>
					<td>{{{ $accrual_policy->total_maximum }}}</td>
                    <td align="center">{{ link_to_route('accrual_policies.edit', 'Edit', array($accrual_policy->id), array('class' => 'btn btn-info')) }}</td>
                    <td align="center">
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('accrual_policies.destroy', $accrual_policy->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table></div>

@stop
