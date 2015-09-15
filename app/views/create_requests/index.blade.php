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
      <title>Your Requests | Time and Electronic Attendance Monitoring System</title>
      
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
                                @foreach($supervisor as $supervisors)
                                @if( $supervisors->supervisor_id == $id)
                                <li><a href="{{ URL::to('employee/employeesummary') }}">Employee Summary</a></li>
                                @endif
                                @endforeach
                                </ul>
                            <li class="dropdown"><a href = "#">Reports<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                            </li>
                                <li><a href="{{ URL::to('employee/dailytimerecord') }}">Daily Time Record</a></li>
                                </ul>

                            <li class="dropdown"><a href = "#">Utilities<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                            </li>
                                <li><a href="{{ URL::to('employee/downloads') }}">Downloadable Forms</a></li>
                                <li><a href="{{ URL::to('employee/change_password') }}">Change Password</a></li>
                                </ul>

                        </ul>
                               
                        <ul class="nav navbar-nav navbar-right">
                          <li><a href="{{ URL::to('employee/dashboard') }}">Hi, {{ $name }}</a></li>
                           
                          <li><a href="{{ URL::to('employee/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                          
              </ul>
                </div>                               
            </div>
         </div>
            
</head>
      <br><br><br>
      <div class = "container">
            <div class = "row">
                  
                  <div class = "col-md-9" >
                        <h1 style = "color:white;">Your Requests</h1>
                  </div>
            </div>

            <br>
            <br>
                  <div id="raleway" class="row">
<div class = "row">
	<br><br>

<p>{{ link_to_route('create_requests.create', 'Make a Request') }}</p>

@if ($create_requests->count())
	<div class="label_white"><table class="table table-bordered">
		<thead>
			<tr style="color:white">
				<th>Status</th>
				<th>Request date</th>
				<th>Start date</th>
				<th>Start time</th>
				<th>End date</th>
				<th>End time</th>
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
					<td>{{{ $create_request->start_time }}}</td>
					<td>{{{ $create_request->end_date }}}</td>
					<td>{{{ $create_request->end_time }}}</td>
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
@else
	There are no create requests
@endif

@if ($errors->any())
      <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
      </ul>
@endif

            </div>


                </div>
            </div>

            <div class = "container" style = "position: fixed; bottom: 0px; width: 100%;  height: 60px; background-color: #2c3e50; padding: 25px 0; text-align:center;">
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