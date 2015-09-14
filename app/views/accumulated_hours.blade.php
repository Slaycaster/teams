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
	<title>Accumulated Hours | Time and Electronic Attendance Monitoring System</title>
	
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
                            <li><a href = "{{ URL::to('employee/request') }}">Request a Leave</a></li>
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
			<div class = "col-md-9" >
				<h1 style = "color:white;">Accumulated Hours | <a href="#"><</a> 03-01-2015 to 03-07-2015 <a href="#">></a> </h1>
			</div>
		</div>

		<br>
		<br>
			<div id="raleway" class="row">
				{{ Form::open(array('url' => 'employee/timesheet/table', 'method' => 'post')) }}			
					<div class="label_white">{{ Form::label('choose_date', 'Date:')}}</div>
					{{ Form::input('date', 'choose_date') }}
					{{ Form::submit('Go!', array('class' => 'btn btn-success')) }}
				{{ Form::close() }}	

				<div class = "row">
			<div class = "col-md-6">
				<div class = "col-md-3 greentile">
						<center><h1 style = "color:white;">0</h1></center>
						<center><h4 style = "color:white;">Hours</h4></center>
				</div>
				<div class = "col-md-9 greytile" >
					<br>
					<center><h3 style = "color:white; margin-bottom:12px">Regular</h3></center>
					<br>
				</div>
			</div>

			<div class = "col-md-6">
				<div class = "col-md-3 greentile">
						<center><h1 style = "color:white;">0</h1></center>
						<center><h4 style = "color:white;">Hours</h4></center>
				</div>
				<div class = "col-md-9 greytile" >
					<br>
					<center><h3 style = "color:white; margin-bottom:12px">Overtime</h3></center>
					<br>
				</div>
			</div>
			

		</div>


		<div class = "row" style = "margin-top:20px;">
			<div class = "col-md-6">
				<div class = "col-md-3 greentile">
						<center><h1 style = "color:white;">0</h1></center>
						<center><h4 style = "color:white;">Hours</h4></center>
				</div>
				<div class = "col-md-9 greytile">
					<br>
					<center><h3 style = "color:white;  margin-bottom:12px ">Overtime</h3></center>
					<br>
				</div>
			</div>
			<div class = "col-md-6">
				<div class = "col-md-3 greentile">
					<center><h1 style = "color:white;">0</h1></center>
					<center><h4 style = "color:white;">Hours</h5></center>
				</div>
				<div class = "col-md-9 greytile">
					<br>
					<center><h3 style = "color:white; margin-bottom:12px;">Total</h3></center>
					<br>
				</div>
			</div>
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