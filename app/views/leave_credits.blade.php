@extends("layout_employee")
@section("content")

<head>
	<title>Leave Credits | Time and Electronic Attendance Monitoring System</title>
</head>
	<br><br><br>
	<div class = "container">
		<div class = "row">
        <br>
			<div class = "col-md-1" style = "margin-top:20px;">
				<img src="{{ URL::asset('img/home.png') }}">
			</div>
			<div class = "col-md-4" >
				<h1 style = "color:white;">Leave Credits</h1>
			</div>
		</div>

		<br>
		<br>
        <br>
		<div class = "row">
			<div class = "col-md-6">
			
				<div class = "col-md-3 greentile" style="height:97px">
						<center><h1 style:"font-size:80px">{{$sick_leave}}</h1></center>
						<center><h4 style="margin-top:-5px">Days</h4></center>
				</div>
				<div class = "col-md-9 greytile" >
					<br>
					<center><h3 style = "color:white; margin-bottom:12px">Sick Leave</h3></center>
					<br>
				</div>
		
			
			</div>
            <div class = "col-md-6">
           
                <div class = "col-md-3 greentile" style="height:97px">
                        <center><h1 style:"font-size:80px">{{$vacation_leave}}</h1></center>
                        <center><h4 style="margin-top:-5px">Days</h4></center>
                </div>
                <div class = "col-md-9 greytile" >
                    <br>
                    <center><h3 style = "color:white; margin-bottom:12px">Vacation Leave</h3></center>
                    <br>
                </div>
        
           
            </div>
            <div class="col-md-3" style="margin-top:10px"></div>
             <div class = "col-md-6" style="margin-top:20px">
           
                <div class = "col-md-3 greentile" style="height:97px">
                        <center><h1 style:"font-size:80px">{{$force_leave}}</h1></center>
                        <center><h4 style="margin-top:-5px">Days</h4></center>
                </div>
                <div class = "col-md-9 greytile" >
                    <br>
                    <center><h3 style = "color:white; margin-bottom:12px">Force Leave</h3></center>
                    <br>
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
@stop