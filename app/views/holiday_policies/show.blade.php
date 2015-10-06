@extends("layout-noheader")
@section("content")

<head>
    <title>Holiday policy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:-15px">
	<h1>Show Holiday Policy</h1>
</div>

<div class="col-md-6">
  	<div class="col-md-12" style="padding:5px">
    	<div class="col-md-4" >
          <img style = "height:100px; width:100px;" src="{{ URL::asset('img/PremiumPolicy.png') }}">
    	</div>
    	<div class="col-md-8" style="margin-left:0px">
    	 <p style="color:white; font-size:30px"> <strong>{{$holiday_policy->holiday_name}}</strong></p>
       </div>
     </div>
     <hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;">
    <div class="col-md-12">
     	<h4 style="color:white"> Description:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$holiday_policy->description}}</h5>
  	 	</div>
  	 </div>
  	 <div class="col-md-12">
     	<h4 style="color:white"> Default schedule status:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$holiday_policy->default_schedule_status}}</h5>
  	 	</div>
  	 </div>
  	 <div class="col-md-12">
     	<h4 style="color:white"> Day of month:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$holiday_policy->day_of_month}}</h5>
  	 	</div>
  	 </div>
  	 <div class="col-md-12">
     	<h4 style="color:white"> Month:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$holiday_policy->month}}</h5>
  	 	</div>
  	 </div>
     
     <div class="col-md-12">
      <h4 style="color:white"> Branches:</h4>
     </div>
     @foreach($branches as $branch)
     <div class="col-md-12">
      <div class="col-md-1">
      </div>
      <div class="col-md-2">
      </div>
      <div class="col-md-9">
        <h5 style="color:white"> {{$branch->branch_name}}</h5>
      </div>
     </div>
     @endforeach
     <br>
  	 <a style = "margin-left:5%"href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
  	</div>

@stop
