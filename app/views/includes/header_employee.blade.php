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
                            <li><a href="{{ URL::to('employee/dashboard') }}">Dashboard</a></li>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transactions<b class="caret"></b></a>
                              <ul class="dropdown-menu">
                            </li>       
                           
                            @if($level == '0')
                            @else
                                <li><a href = "{{ URL::to('employee/requests_authorization') }}">Approve Leave Requests</a></li>
                            @endif
                            <li><a href = "{{ URL::to('create_requests') }}">Request a Leave</a></li>
                              </ul>
                            </li>
                            <li class="dropdown"><a href = "#">Queries<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                            </li>
                                 @foreach($supervisor as $supervisors)
                                @if( $supervisors->supervisor_id == $id)
                                <li><a href="{{ URL::to('employee/employeesummary') }}">Employee Summary - Subordinates</a></li>
                                
                                 <li><a href="{{ URL::to('employee/accmltddhrssubodinates') }}">Accumulated Hours - Subordinates</a></li>
                                 <li><a href="{{ URL::to('employee/punctassessmentsub') }}">Punctuality Assessment - Subordinates</a></li>
                                <li><a href="{{ URL::to('employee/requesthistory') }}">Request History</a></li>
                                @endif
                                @endforeach
                                <li><a href="{{ URL::to('employee/schedulequery') }}">Schedule</a></li>
                                 <li><a href="{{ URL::to('employee/leavehistory') }}">Leave History</a></li>
                                 <li><a href="{{ URL::to('employee/accumulated_hours') }}">Accumulated Hours</a></li>
                                 <li><a href="{{ URL::to('employee/punctassessment') }}">Punctuality Assessment</a></li>
                                </ul>
                            <li class="dropdown"><a href = "#">Reports<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                            </li>
                                <li><a href="{{ URL::to('employee/dailytimerecord') }}">Daily Time Record</a></li>
                                <li><a href="{{ URL::to('employee/reports/assessment') }}">Punctuality Assessment</a></li>
                                <li><a href="{{ URL::to('employee/reports/accumulated') }}">Accumulated Hours</a></li>
                                @foreach($supervisor as $supervisors)
                                @if( $supervisors->supervisor_id == $id)
                                <li><a href="{{ URL::to('employee/dtrsubordinates') }}">Daily Time Record - Subordinates</a></li>
                                <li><a href="{{ URL::to('employee/reports/assessment_sub') }}">Punctuality Assessment - Subordinates</a></li>
                                <li><a href="{{ URL::to('employee/reports/accumulated_sub') }}">Accumulated Hours - Subordinates</a></li>
                                @endif
                                @endforeach
                                </ul>
                              <li class="dropdown"><a href = "#">Utilities<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                            </li>
                                <li><a href="{{ URL::to('employee/downloads') }}">Downloadable Forms</a></li>
                                <li><a href="{{ URL::to('employee/empdownloads') }}">Employee Files</a></li>
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