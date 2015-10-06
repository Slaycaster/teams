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
	<title>Time and Attendance Monitoring System</title>
	
		<div class = "navbar navbar-default navbar-fixed-top">
            <div class = "container">
                               
                <a href="{{ URL::to('/') }}" class = "navbar-brand"><img style ="height:30px; margin-top:-4px;"src="{{ URL::asset('img/teams_pahalang.png') }}"/></a>
                               
                <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
                        <span class = "icon-bar"></span>
                        <span class = "icon-bar"></span>
                        <span class = "icon-bar"></span>
              	</button>
                               
                <div class = "collapse navbar-collapse navHeaderCollapse">

                		<ul class = "nav navbar-nav">
                            <li><a href="{{ URL::to('/') }}">Time and Attendance Monitoring System</a></li>
               
                        </ul>
                               
                        <ul class="nav navbar-nav navbar-right">
                          
                          <li><a href="{{ URL::to ('login')}}">Administrator</a></li>
                          <li><a href="{{ URL::to ('login/employee')}}">Employee</a></li>
                          <li><a href="{{ URL::to ('login/infotech')}}">IT Personnel</a></li>
                          
     					</ul>
                </div>                               
            </div>
         </div>
		
</head>
	<br><br><br>
	<div class = "container">
		<center><h1>TimE and Attendance Monitoring<br><h4>because we know that time is gold, we'll make the best out of it just for you.</h4></h1></center>
		<center><img style = "max-width:100% !important;
    height:auto;
    display:block;" src="{{ URL::asset('img/cover.png') }}"></center>
		
		<div style = "display: block; margin-left: 400px; margin-right: auto;" class = "row">
			
		</div>
		
		
	</div>

		<div class = "container" style = "position: fixed; bottom: 0px; width: 100%; 	height: 60px; background-color: #2c3e50; padding: 25px 0; text-align:center;">
			<p style = "color:white;">Copyright &copy; 2015 - Fare Matrix</p>
		</div>