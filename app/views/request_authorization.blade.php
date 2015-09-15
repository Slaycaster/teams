<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<title>Requests Authorization | Time and Electronic Attendance Monitoring System</title>
	
		<div class = "navbar navbar-default navbar-fixed-top">
            <div class = "container">
                               
                <a href="{{ URL::to('employee/dashboard') }}" class = "navbar-brand"><img style ="height:30px; margin-top:-4px;"src="{{ URL::asset('img/teams_pahalang.png') }}"/></a>
                               
                <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
                        <span class = "icon-bar"></span>
                        <span class = "icon-bar"></span>
                        <span class = "icon-bar"></span>
              	</button>
                               
                <div class = "collapse navbar-collapse navHeaderCollapse">

                		<ul class = "nav navbar-nav">
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transactions<b class="caret"></b></a>
                              <ul class="dropdown-menu">
                            </li>       
                           
                            @if($level == '0')
                            @else
                                <li><a href = "{{ URL::to('employee/requests_authorization') }}">Requests Authorization</a></li>
                            @endif
                            <li><a href = "{{ URL::to('create_requests') }}">Request a Leave</a></li>
                              </ul>
                            </li>
                            <li class="dropdown"><a href = "#">Queries<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                            </li>
                                <li><a href="{{ URL::to('employee/accruals') }}">Accruals</a></li>
                                <li><a href="{{ URL::to('employee/exceptions') }}">Exceptions</a></li>
                                <li><a href="{{ URL::to('employee/dailytimerecord') }}">Daily Time Record</a></li>
                                </ul>
                            <li class="dropdown"><a href = "#">Reports<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                            </li>
                                <li><a href="{{ URL::to('employee/dailytimerecord') }}">Daily Time Record</a></li>
                                </ul>
                        </ul>
                               
                        <ul class="nav navbar-nav navbar-right">
                          <li><a href="#">Hi, {{ $name }}</a></li>
                          
                          <li><a href="{{ URL::to('employee/logout') }}"><span class="glyphi con glyphicon-log-out"></span> Log Out</a></li>
                          
     					</ul>
                </div>                               
            </div>
         </div>
		
</head>
	<br><br><br>
	<div class = "container">
		<div class = "row">
			<div class = "col-md-9" >
				<h1 style = "color:white;">Requests Authorization</h1>
			</div>
		</div>

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
                       <div class='col-md-4'>
                        {{ Form::open(array('url' => 'employee/requests_authorized', 'method' => 'post', 'autocomplete' => 'off')) }}  
                         {{ Form::hidden('emp_id', $employee->id) }}
                         {{ Form::hidden('status', 'approved') }}
						
                          {{ Form::submit('Approve', array('class' => 'btn btn-success')) }}          
                         {{ Form::close() }}
                         </div>
                          <div class='col-md-4'>
						 {{ Form::open(array('url' => 'employee/requests_authorized', 'method' => 'post', 'autocomplete' => 'off')) }}  
                         {{ Form::hidden('emp_id', $employee->id) }}
                         {{ Form::hidden('status', 'declined') }}
                        
                          {{ Form::submit('Decline', array('class' => 'btn btn-warning')) }}          
                         {{ Form::close() }}
                         </div>
                          <div class='col-md-4'>
                         {{ Form::open(array('url' => 'employee/requests_authorized', 'method' => 'post', 'autocomplete' => 'off')) }}  
                         {{ Form::hidden('emp_id', $employee->id) }}
                         {{ Form::hidden('status', 'deleted') }}
                        
                          {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}          
                         {{ Form::close() }}</td>
                        </div>
					</tr>
				@endforeach
			</table>

		</div>


		    </div>
		</div>

		<div class = "container" style = "position: fixed; bottom: 0px; width: 100%; 	height: 60px; background-color: #2c3e50; padding: 25px 0; text-align:center;">
			<p style = "color:white;">Copyright &copy; pending. Fare Matrix</p>
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