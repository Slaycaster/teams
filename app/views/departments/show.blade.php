@extends("layout-noheader")
@section("content")

<head>
    <title>Department | Time and Electronic Attendance Monitoring System</title>
</head>
<h1>Show Department</h1>
<!--
<div class="col-md-12" style="margin-bottom:30px">
    
    <div class="btn-group btn-breadcrumb">
              <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('departments') }}"class="btn btn-default">Departments</a>
            <a class="btn btn-default">Show Department - {{$department->name}}<a>
    </div>
</div>
-->
<div class="col-md-6">
  	<div class="col-md-12" style="padding:5px">
    	<div class="col-md-4" >
          <img style = "height:75px; width:75px;" src="{{ URL::asset('img/Houses.png') }}">
    	</div>
    	
    	 <p style="color:white; font-size:30px"> <strong>{{$department->name}}</strong></p>
       
     </div>
     <hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;">
    <div class="col-md-12">
     	<h4 style="color:white"> Status:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$department->status}}</h5>
  	 	</div>
  	 </div>
  	 <div class="col-md-12">
     	<h4 style="color:white"> Code:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$department->code}}</h5>
  	 	</div>
  	 </div>

  	  <div class="col-md-12">
     	<h4 style="color:white"> Branch:</h4>
  	 </div>
  	 <div class="col-md-12">
  	 	<div class="col-md-9">
  	 		 @foreach ($branches as $branch)
            @if ($branch->id == $department->branch_id)
       		<h5 style="color:white"> {{$branch->branch_name}}</h5>
            @endif
           @endforeach
  	 	</div>
  	 </div>

  	</div>
    <br>
    <a style="margin-left:30px" href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
@stop
