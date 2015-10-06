@extends("layout_employee")
@section("content")
      <br><br>
      <div class = "container">
            <div class = "row">
                     @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  <br>
                  <div class = "col-md-9" >
                        <h1 style = "color:white;">File a Leave Request</h1>
                  </div>
            </div>
            <hr>
                  <div id="raleway" class="row">
<div class = "row">
<p>{{ link_to_route('create_requests.create', 'Make a Request') }}</p>


	<div class="label_white"><table class="table table-bordered">
		<thead>
			<tr style="color:white">
				<th>Status</th>
				<th>Request date</th>
				<th>Start date</th>
			
				<th>End date</th>
				
				<th>Message</th>
				<th>Request type</th>
				<th colspan=2>Actions</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($create_requests as $create_request)
				<tr style="color:white">
					<td>{{{ $create_request->status }}}</td>
					<td>{{{ $create_request->request_date }}}</td>
					<td>{{{ $create_request->start_date }}}</td>

					<td>{{{ $create_request->end_date }}}</td>
			
					<td>{{{ $create_request->message }}}</td>
					<td>{{{ $create_request->request_type }}}</td>
                    
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('create_requests.destroy', $create_request->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table></div>


@if ($errors->any())
      <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
      </ul>
@endif

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