@extends("layout_employee")
@section("content")
      <br><br><br>
      <div class = "container">
            <div class = "row">
                  <div class = "col-md-9" >
                        <h1 style = "color:white;">Leave History</h1>
                  </div>
            </div>
            <hr>

                  <div id="raleway" class="row">
<div class = "row">
        {{ Form::open(array('url' => 'employee/leavehistory', 'method' => 'post', 'autocomplete' => 'off')) }}
   
      
      <div class="col-md-2">

        <div class="label_white">{{ Form::label('layout', ' Month:') }}</div>
        {{ Form::selectMonth('month', Input::get('month'), array('class' => 'btn btn-default dropdown-toggle'))}}<br>
      </div>

      <div class="col-md-2">
        <div class="label_white">
      
        {{ Form::label('layout', ' Year:') }}  </div>
        {{ Form::selectRange('year', $year, 1995  , Input::get('year'), array('class' => 'btn btn-default dropdown-toggle'))}}
        </div>
        <br>
            <div class="col-md-2">
                <div class="label_white" style="margin-top:-5px;">
                     <td>  {{ Form::submit('Go', array('class' => 'btn btn-warning', 'style'=>'padding-left:30px; padding-right:30px; padding-top:7px; padding-bottom:7px;')) }}</td><br>
                 </div>
        {{Form::close()}}
    </div>
    <br>
</div>

	<br><br>

	<div><table class="table table-bordered" style = "background-color:white;">
		<thead>
			<tr>
				<th>Status</th>
				<th>Request date</th>
				<th>Start date</th>
			
				<th>End date</th>
				
				<th>Message</th>
				<th>Request type</th>
				
			</tr>
		</thead>

		<tbody>
			@foreach ($create_requests as $create_request)
				<tr>
					<td>{{{ $create_request->status }}}</td>
					<td>{{{ $create_request->request_date }}}</td>
					<td>{{{ $create_request->start_date }}}</td>

					<td>{{{ $create_request->end_date }}}</td>
			
					<td>{{{ $create_request->message }}}</td>
					<td>{{{ $create_request->request_type }}}</td>
                    

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