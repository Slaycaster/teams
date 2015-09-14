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
	<title>Time Sheet | Time and Electronic Attendance Monitoring System</title>
	
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
                            <li><a href = "{{ URL::to('create_requests') }}">Requests</a></li>
                            <li><a href = "{{ URL::to('employee/timesheet') }}">Time Sheet</a></li>
                            <li><a href = "{{ URL::to('employee/accumulated_hours') }}">Accumulated Hours</a></li>
                            <li><a href = "{{ URL::to('employee/exceptions') }}">Exceptions</a></li>
                            <li><a href = "{{ URL::to('employee/accruals') }}">Accrual Account</a></li>
                            @if($level == '0')
                            @else
                            	<li><a href = "{{ URL::to('employee/requests_authorization') }}">Requests Authorization</a></li>
                            @endif
                        </ul>
                               
                        <ul class="nav navbar-nav navbar-right">
                          <li><a href="#">Hi, {{ $name }}</a></li>
                          
                          <li><a href="{{ URL::to('employee/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                          
     					</ul>
                </div>                               
            </div>
         </div>
		
</head>
	<br><br><br>
	<div class = "container">
		<div class = "row">
			<div class = "col-md-1" style = "margin-top:20px;">
				<img src="{{ URL::asset('img/home.png') }}">
			</div>
			<div class = "col-md-5" >
				<h1 style = "color:white;">Time Sheet | Table</h1>
			</div>
		</div>

		<br>
		<br>
			<div id="raleway" class="row">
				

				{{ Form::open(array('url' => 'employee/timesheet/table', 'method' => 'post')) }}			
					{{ Form::label('choose_date', 'Date:', array('style' => 'color:white;'))}}
					{{ Form::input('date', 'choose_date') }}
					{{ Form::submit('Go!', array('class' => 'btn btn-success')) }}
				{{ Form::close() }}	
				

				<table class = "table table-bordered" style = "color:white;">
					<thead>
						<td></td>
						<td style = "text-align:center;" colspan=7>03-01-2015 to 03-07-2015</td>
					</thead>
					<thead>
						<td></td>
						<td>Sunday</td>
						<td>Monday</td>
						<td>Tuesday</td>
						<td>Wednesday</td>
						<td>Thursday</td>
						<td>Friday</td>
						<td>Saturday</td>
					</thead>
					<tr>
						<td>In</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>	
					</tr>
					<tr>
						<td>Out</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>	
					</tr>
					<thead>
						<td style = "text-align:center;" colspan=8>Accumulated Time</td>
					</thead>
					<tr>
						<td>Total Time</td>
						<td>00:00</td>
						<td>00:00</td>
						<td>00:00</td>
						<td>00:00</td>
						<td>00:00</td>
						<td>00:00</td>
						<td>00:00</td>
					</tr>
					<thead>
						<td style = "text-align:center;" colspan=8>Absence</td>
					</thead>
					<tr>
						<td> </td>
						<td> </td>
						<td> </td>
						<td> </td>
						<td> </td>
						<td> </td>
						<td> </td>
						<td> </td>
					</tr>
				</table>

				<br>

				<table class = "table table-bordered" style = "color:white;">
					<thead>
						<td style = "text-align:center;"colspan=3>Accumulated Time</td>
					</thead>
					<thead>
						<td></td>
						<td style = "text-align:center;">Week</td>
						<td style = "text-align:center;">Pay Period</td>
					</thead>
					<thead>
						<td></td>
						<td style = "text-align:center;">03-01-2015 to 03-07-2015</td>
						<td style = "text-align:center;">03-01-2015 to 03-15-2015</td>
					</thead>
					<tr>
						<td>Total Time</td>
						<td>00:00</td>
						<td>00:00</td>
					</tr>
				</table>
		    </div>
		</div>

		<div class = "container" style = "position: fixed; bottom: 0px; width: 100%; 	height: 60px; background-color: #2c3e50; padding: 25px 0; text-align:center;">
			<p style = "color:white;">Copyright &copy; pending. Fare Matrix</p>
		</div>