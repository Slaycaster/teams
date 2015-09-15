
<!-- contains navbar -->
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
                            <li><a href = "{{ URL::to('dashboard') }}">Dashboard</a></li>
                            <li><a href = "{{ URL::to('maintenance') }}">Maintenance</a></li>
                            <li><a href ="{{ URL::to('transaction') }}">Transaction</a></li>
                            <li><a href ="{{URL::to('query')}}">Queries</a></li>
                            <li><a href ="{{URL::to('report')}}">Reports</a></li>
                            <li><a href ="{{URL::to('utility')}}">Utilities</a></li>
                        
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                          @if(Auth::check())
                          <li><a href="{{ URL::to('logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                          @else
                          <li><a href="{{ URL::to('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                          @endif
     					</ul>
                </div>                               
            </div>
         </div>
         <br> <br> <br>
         <!-- end of navbar -->