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
      <title>Create Request | Time and Electronic Attendance Monitoring System</title>
      
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
                        <h1 style = "color:white;">Create Request</h1>
                  </div>
            </div>
<div class = "container">

  <div class = "row">
    <div class = "col-md-3">
   
@if ($errors->any())
      <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
      </ul>
@endif
                        
                  {{ Form::open(array('route' => 'create_requests.store')) }}

            {{ Form::hidden('status','pending') }}<br>
        
            <h4>Request Date/Time:</h4>
            <div class="label_white">{{ Form::label('request_date', date("Y/m/d"). '/' . date("h:i:sa")) }}</div>
            {{ Form::hidden('request_date', date("Y/m/d"). '/' . date("h:i:sa")) }}
        
            <div class="label_white">{{ Form::label('request_type', 'Request type:') }}</div>
            {{ Form::select('request_type', $request_types, Input::old('request_type'), array('class' => 'btn btn-default dropdown-toggle')) }}<br><br>

       
            <div class="label_white">{{ Form::label('start_date', 'Start Date:') }}</div>
            {{ Form::text('start_date', Input::get('start_date'), array('placeholder' => 'yyyy-mm-dd','autocomplete' => 'off', 'size' => '40')) }}<br>
        

       
            <div class="label_white">{{ Form::label('start_time', 'Start_Time:') }}</div>
            {{ Form::text('start_time', Input::get('start_time'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}<br>
        

       
            <div class="label_white">{{ Form::label('end_date', 'End_Date:') }}</div>
            {{ Form::text('end_date', Input::get('end_date'), array('placeholder' => 'yyyy-mm-dd','autocomplete' => 'off', 'size' => '40')) }}<br>
        

       
            <div class="label_white">{{ Form::label('end_time', 'End_Time:') }}</div>
            {{ Form::text('end_time', Input::get('end_time'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}<br>
         </div>
         <div class = "col-md-3">
            <br><br>
            <div class="label_white">{{ Form::label('message', 'Message:') }}</div>
            {{ Form::textarea('message') }}<br>

            {{ Form::hidden('employee_id', $id)}}
      
                  {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
            </div>
      
{{ Form::close() }}


              </div>
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