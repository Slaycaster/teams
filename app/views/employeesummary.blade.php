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
	<title>Employee Summary Query | Time and Electronic Attendance Monitoring System</title>
	
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
                                <li><a href="{{ URL::to('employee/employeesummary') }}">Employee Summary</a></li>
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
<div class="container">
    <h3>Subordinates</h3>
    <hr>
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
           
            <table class="table">
                <thead>
                    <tr class="filters">
                    
                        <th><input type="text" class="form-control" placeholder="fname"></th>
                        <th><input type="text" class="form-control" placeholder="lname"></th>
                    	<th><input type="text" class="form-control" placeholder="phone number"></th>
                    	<th><input type="text" class="form-control" placeholder="email"></th>
                    	<th><input type="text" class="form-control" placeholder="hire date"></th>
                    	<th><input type="text" class="form-control" placeholder="job title"></th>
                    	<th><input type="text" class="form-control" placeholder="contract name"></th>
                        <th><input type="text" class="form-control" placeholder="department"></th>
                        <th><input type="text" class="form-control" placeholder="branch"></th>
                        
                    
   
                   
                    </tr>
                </thead>
                <tbody>
                @foreach ($user as $users)
                <tr>

                    <td>
                        {{$users->fname}}
                    </td>
                    <td>
                        {{$users->lname}}
                    </td>

                    <td>
                        {{$users->phone}}
                    </td>

                    <td>
                        {{$users->email}}
                    </td>

                    <td>
                        {{$users->hire_date}}
                    </td>
                    @foreach($jobtitles as $jobtitle)
                    		@if($jobtitle->id == $users->jobtitle_id)
                    		<td>{{$jobtitle->jobtitle_name}}</td>
                    		@endif
                    @endforeach

                    @foreach($contracts as $contract)
                    		@if($contract->id == $users->contract_id)
                    		<td>{{$contract->contract_name}}</td>
                    		@endif
                    @endforeach

                    @foreach ($departments as $department)
                         @if ($department->id == $users->department_id)
                        <td>{{  $department->name }}</td>
                        @foreach($branches as $branch)
                                    @if ($branch->id == $department->branch_id)
                                        <td>{{  $branch->branch_name }}</td>
                                    @endif
                                @endforeach
                        @endif
                    @endforeach
             
                @endforeach
                </tbody>
            </table>
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



