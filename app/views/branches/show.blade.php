@extends("layout-noheader")
@section("content")

<head>
    <title>Branch | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-6">
  	<div class="col-md-12" style="padding:5px">
    	<div class="col-md-4" >
          <img style = "height:100px; width:100px;" src="{{ URL::asset('img/Branches.png') }}">
    	</div>
    	<div class="col-md-8" style="margin-left:0px">
    	 <p style="color:white; font-size:30px"> <strong>{{$branch->branch_name}}</strong></p>
   		<p style="color:white; font-size:25px"> {{$branch->country}}</p>
     
       </div>
     </div>
     <hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;">
    

    <div class="col-md-12" style="margin-left:-15px">
      <h4 style="color:white"> Code:</h4>
     </div>
     <div class="col-md-12">
      <div class="col-md-9">
        <h5 style="color:white"> {{$branch->code}}</h5>
      </div>
     </div>
    </div>

    <div class="col-md-12">
     	<h4 style="color:white"> Complete Address:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$branch->address}}, {{$branch->country}}</h5>
  	 	</div>
  	 </div>
  	 <div class="col-md-12">
     	<h4 style="color:white"> Email:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$branch->email}}</h5>
  	 	</div>
  	 </div>

  	  
 <a  style="margin-left:20px" href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
@stop
