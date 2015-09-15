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
	<title>Exceptions | Time and Electronic Attendance Monitoring System</title>
	
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
<div class="col-md-4">
</div>
<div class="col-md-5" align="center" style="margin-top:55px; background-color:white; ">
<h1 style="color:black">Daily Time Record</h1>
<br>
<p style="color:black">____________________________________</p>
<p style="color:black">Name</p>


<p style="color:black"> For the month of _____________ 20 ___ </p>
<p style="color:black">Regular Days ___________ </p>
<p style="color:black">Saturdays ___________ </p>

<p style="color:black"> Official Hours of arrival and departure</p>


	<table class = "table table-bordered" align="center" style = "color:black;  width:150px;" >
					<thead>
						<td style = "text-align:center;">Day</td>
						<td style = "text-align:center;" colspan=7><b>A.M.</b></td>
						<td style = "text-align:center;" colspan=7><b>P.M.</b></td>
						<td style = "text-align:center;" colspan=7><b>Undertime</b></td>
					</thead>
					<thead>
						<td></td>
						<td style = "text-align:center;" colspan=3>Arrival</td>
						<td  style = "text-align:center;" colspan=4>Departure</td>
						
						<td style = "text-align:center;" colspan=3>Arrival</td>
			   	        <td style = "text-align:center;" colspan=4>Departure</td>
			   	        
						<td style = "text-align:center;" colspan=3>Hours</td>
						<td style = "text-align:center;" colspan=4>Minutes</td>
					</thead>
					
					<tr>
						<td style = "text-align:center;">1</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">2</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">3</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">4</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">5</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">6</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">7</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">8</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">9</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">10</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">11</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">12</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">13</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">14</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>
					</tr>
					<tr>
						<td style = "text-align:center;">15</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">16</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">17</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">18</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">19</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">20</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">21</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">22</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">23</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">24</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">25</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">26</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">27</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">28</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">29</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">30</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style = "text-align:center;">31</td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>

						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td>	
					</tr>
					<tr>
						<td style="text-align:center;" colspan=15><b>TOTAL</b></td>
						<td style = "text-align:center;" colspan=3></td>
						<td style = "text-align:center;" colspan=4></td> 
					</tr>


				
	</table>
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