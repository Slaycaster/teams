@extends("layout_employee")
@section("content")
      <br><br><br>
      <div class = "container">
            <div class = "row">
                  
                  <div class = "col-md-9" >
                        <h1 style = "color:white;">Request</h1>
                  </div>
            </div>

            <br>
            <br>
                  <div id="raleway" class="row">
<h1>Show Create request</h1>

<p>{{ link_to_route('create_requests.index', 'Return to all create requests') }}</p>

<div class="label_white"><table class="table table-bordered">
	<thead>
		<tr>
			<th>Status</th>
				<th>Request date</th>
				<th>Request type</th>
				<th>Start date</th>
				<th>Start time</th>
				<th>End date</th>
				<th>End time</th>
				<th>Message</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $create_request->status }}}</td>
					<td>{{{ $create_request->request_date }}}</td>
					<td>{{{ $create_request->request_type }}}</td>
					<td>{{{ $create_request->start_date }}}</td>
					<td>{{{ $create_request->start_time }}}</td>
					<td>{{{ $create_request->end_date }}}</td>
					<td>{{{ $create_request->end_time }}}</td>
					<td>{{{ $create_request->message }}}</td>
                    <td>{{ link_to_route('create_requests.edit', 'Edit', array($create_request->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('create_requests.destroy', $create_request->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table></div>

            </div>


                </div>
            </div>


<script type="text/javascript">
    $(function(){
    $(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            });
    });
    
</script>

@stop