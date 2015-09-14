@extends("layout")
@section("content")
<head>
    <title>Leave Grants | Time and Attendance Monitoring System</title>
</head>
<div class="col-md-12" style="margin-top:-18px; margin-bottom:15px; margin-left:-15px">
  <h1>All Leave Grants</h1>

	<div class="col-md-4" style="margin-left:-25px">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Leave Grants</a>
        </div>
  	</div>
        <div class="col-md-4">
        
		</div>        

	</div>     


	

<div class="container" style="margin-top:30px">

  <div class = "row">
    <div class = "col-md-4">
      <h3>Add a Leave grants</h3>
      {{ Form::open(array('route' => 'leave_grants.store')) }}

               
                 <div class="label_white">{{ Form::label('name', 'Name:') }}</div>
                {{ Form::text('name', Input::get('name'), array('placeholder' => 'Leave Grant name','autocomplete' => 'off')) }}<br>
               
                 <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
                {{ Form::text('description') }}<br>
                
                 <div class="label_white">{{ Form::label('allowed_leave', 'Allowed leave:') }}</div>
                {{ Form::input('number', 'allowed_leave', Input::get('allowed_leave'), array('placeholder' => 'Number of day/s','autocomplete' => 'off', 'size' => '48')) }}<br><br>
                <div style = "color:white">
                <div class="label_white">{{ Form::label('grant_automatically', 'Auto-grant:') }}</div>
                {{ Form::radio('grant_automatically', 'true', false) }} True
                {{ Form::radio('grant_automatically', 'false', true) }} False<br>
                <br>
                
                <div class="label_white">{{ Form::label('withrawable', 'Withrawable:') }}</div>
               {{ Form::radio('withrawable', 'true', false) }} True
               {{ Form::radio('withrawable', 'false', true) }} False<br><br>
               </div>
              {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
                    
              
        {{ Form::close() }}
    </div>
    <div class = "col-md-8">
      <h3>All Leave Grants</h3>
        @foreach ($leave_grants as $leave_grant)

  <div class="col-md-4" style="margin-bottom:5px">
    <div class="col-md-12 greytile" style="padding:5px">
      <div class="col-md-5" >
           <img style = "height:70px; width:70px;" src="{{ URL::asset('img/PremiumPolicy.png') }}">
      </div>
      <div class="col-md-7" style="margin-left:0px">

           <p style="color:white; font-size:16px"> {{$leave_grant->name}}
           </p>                    
       
           <p style="color:white; font-size:12px"> {{$leave_grant->description}}</p>
          
           <a href="{{ URL::to('leave_grants/' . $leave_grant->id) }}" onclick="window.open('{{ URL::to('leave_grants/' . $leave_grant->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('leave_grants/' . $leave_grant->id . '/edit') }}" onclick="window.open('{{ URL::to('leave_grants/' . $leave_grant->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
       </div>

     </div>
  </div>
  @endforeach
    </div>
  </div>  
 

</div>

@stop
