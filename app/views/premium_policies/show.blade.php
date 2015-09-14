@extends("layout")
@section("content")

<head>
    <title>Premium policy | Time and Electronic Attendance Monitoring System</title>
</head>

<h1 style="font-size:30px; color:white; margin-top:-10px">Show Description</h1>


<div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('premium_policies') }}"class="btn btn-default">Premium Policies</a>
            <a class="btn btn-default">{{$premium_policy->premium_name}}</a>
</div>


<?php $premium_name = preg_replace('/\s+/', '', $premium_policy->premium_name); ?>
<div class="col-md-12" style="margin-top:10px">
<div class="col-md-6">
  	<div class="col-md-12" style="padding:5px">
    	<div class="col-md-4" >
            <img style = "height:100px; width:100px;" src="{{ URL::asset('img/PremiumPolicy.png') }}">
    	</div>
    	<div class="col-md-8" style="margin-left:0px">

           <p style="color:white; font-size:30px"> <strong>{{$premium_policy->premium_name}}</strong></p>
           <p style="color:white; font-size:15px"> {{ $premium_policy->description }}</p>

       </div>
     </div>
  	 
</div>
</div>

@stop
