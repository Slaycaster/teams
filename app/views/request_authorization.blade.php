@extends("layout_employee")
@section("content")

	<br><br><br>
	<div class = "container">
		<div class = "row">
			<div class = "col-md-9" >
				<h1 style = "color:white;">Pending Leave Requests</h1>
			</div>
		</div>
@if (Session::has('messages'))
         <div class="alert alert-warning">{{ Session::get('messages') }}</div><br>
@endif
		<br>
		<br>
			<div id="raleway" class="row">

				
		<table class = "table table-bordered">

				<thead>
          <td style="color:white">Employee Number</td>
					<td style="color:white">First Name</td>
					<td style="color:white">Last Name</td>
          <td style="color:white">Request Type</td>
          <td style="color:white">Status</td>
          <td style="color:white">Start Date</td>
          <td style="color:white">End Date</td>

					<td style="color:white">Actions</td>
				</thead>
				@foreach($employees as $employee)
					<tr>
          <td style="color:white"> {{ $employee->employee_number }}</td>
						<td style="color:white"> {{ $employee->fname }}</td>
						<td style="color:white"> {{ $employee->lname }}</td>
            <td style="color:white"> {{ $employee->request_type }}</td>
            <td style="color:white"> {{ $employee->status }}</td>
            <td style="color:white"> {{ $employee->start_date }}</td>
            <td style="color:white"> {{ $employee->end_date }}</td>
						
							
						
						<td> 
                       <div class='col-md-6'>
                        {{ Form::open(array('url' => 'employee/requests_authorized', 'method' => 'post', 'autocomplete' => 'off')) }}  
                         {{ Form::hidden('emp_id', $employee->id) }}
                         {{ Form::hidden('status', 'approved') }}
						
                          {{ Form::submit('Approve', array('class' => 'btn btn-success')) }}          
                         {{ Form::close() }}
                         </div>
                          <div class='col-md-6'>
						 {{ Form::open(array('url' => 'employee/requests_authorized', 'method' => 'post', 'autocomplete' => 'off')) }}  
                         {{ Form::hidden('emp_id', $employee->id) }}
                         {{ Form::hidden('status', 'declined') }}
                        
                          {{ Form::submit('Decline', array('class' => 'btn btn-warning')) }}          
                         {{ Form::close() }}
                         </div>
                          <div class='col-md-4'>
                      
                        </div>
					</tr>
				@endforeach
			</table>

		</div>


		    </div>
		</div>


<script type="text/javascript">
    window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}

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