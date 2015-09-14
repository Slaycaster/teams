@extends("layout-noheader")
@section("content")
<h1>Show Level</h1>


<div class="col-md-6">
  	<div class="col-md-12" style="padding:5px">
    	<div class="col-md-4" >
          <img style = "height:100px; width:100px;" src="{{ URL::asset('img/Hierarchy.png') }}">
    		<p style="color:white; font-size:30px"> <strong>{{$level->number}}</strong></p>
   		<p style="color:white; font-size:25px"> {{$level->name}}</p>
    	</div>

    	<hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;">
    	<div class="col-md-8" style="margin-left:0px">
    	 
     	<p style="color:white; font-size:12px"> <strong>{{$level->description}}</p>
       </div>
     </div>
 </div>
     
    

  
  	  
 <a  style="margin-left:20px" href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>

@stop
