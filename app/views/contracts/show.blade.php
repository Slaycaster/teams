@extends("layout-noheader")
@section("content")

<head>
    <title>Employee Types | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px">
  <h1>Show Employee Type</h1>
      
</div>


<div class="col-md-6">
  	<div class="col-md-12" style="padding:5px">
    	<div class="col-md-4" >
          <img style = "height:100px; width:100px;" src="{{ URL::asset('img/Contract.png') }}">
    	</div>
    	<div class="col-md-8" style="margin-left:0px">
    	 <p style="color:white; font-size:30px"> <strong>{{$contract->contract_name}}</strong></p>
        <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
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
     	<h4 style="color:white"> Employee Type:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$contract->contract_name}}</h5>
  	 	</div>
  	 </div>
  	 <div class="col-md-12">
     	<h4 style="color:white"> Description:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$contract->description}}</h5>
  	 	</div>
  	 </div>

  	  <div class="col-md-12">
     	<h4 style="color:white"> Duration:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$contract->duration}} month/s</h5>
  	 	</div>
  	 </div>
  	</div>


@stop
