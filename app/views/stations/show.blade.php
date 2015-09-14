@extends("layout-noheader")
@section("content")

<head>
    <title>Terminals | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px">
	<h1>Show Terminal</h1>
</div>


<?php $station_name = preg_replace('/\s+/', '', $station->station_name); ?>
<div class="col-md-12" style="margin-top:-10px">
	<div class="col-md-6">
  		<div class="col-md-12" style="padding:5px">
    		<div class="col-md-4" >
            	<img style = "height:100px; width:100px;" src="{{ URL::asset('img/Kiosk.png') }}">
    		</div>
		    	<div class="col-md-8" style="margin-left:0px">

		           <p style="color:white; font-size:30px"> <strong>{{$station->station_name}}
		           </strong>
		        	
		           		@if ($station->status == 'Enabled')
			           	<img style = "height:20px; width:20px;" src="{{ URL::asset('img/Check.png') }}">
			            @else
			        	<img style = "height:20px; width:20px;" src="{{ URL::asset('img/Wrong.png') }}">
			        	@endif
			        </p>
		           @foreach ($branches as $branch)
		            @if ($branch->id == $station->branch_id)
		              <p style="color:white; font-size:15px">{{ $branch->branch_name }} - {{ $station->source }} </p>
		            @endif
		           @endforeach
		        </div>

			     <div class="col-md-12">
			     	<hr style="display: block;
					    margin-top: 0.5em;
					    margin-bottom: 0.5em;
					    margin-left: auto;
					    margin-right: auto;
					    border-style: inset;
					    border-width: 1px;">
			     	<h3 style="color:white">Description</h3>
			  	 </div>
			     <div class="row">
     				<div class="col-md-2"></div>
     				<div class="col-md-10" style="margin-left:5%">
     				<p style="color:white; font-size:15px" >{{ $station->description }}</p>
     				<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
				 </div>
				 </div>
  		</div>
	</div>
</div>

@stop
