@extends("layout-noheader")
@section("content")

<head>
    <title>Employee | Time and Electronic Attendance Monitoring System</title>
</head>
  
<div class="col-md-12" style="margin-bottom:10px">
    <h1>Show Employee</h1>
    </div>
</div>

<?php $emp_fname = preg_replace('/\s+/', '', $employee->fname); ?>
<div class="col-md-12" style="margin-top:10px">
<div class="col-md-6">
  	<div class="col-md-12" style="padding:5px">
    	<div class="col-md-4" >
            <img style = "height:150px; width:150px;" src="{{URL::asset('employees').'/'.$employee->id.''.$employee->lname.''.$emp_fname.'.jpg'}}">

    	</div>


    	<div class="col-md-8" style="margin-left:0px">

           <p style="color:white; font-size:30px"> <strong>{{$employee->fname}}
           {{ $employee->lname }}</strong></p>
           <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
           <p style="color:white; font-size:15px">{{$employee->status}}
           @if ($employee->status == 'Active')
           	<img style = "height:20px; width:20px;" src="{{ URL::asset('img/Check.png') }}">
            @else
        	<img style = "height:20px; width:20px;" src="{{ URL::asset('img/Wrong.png') }}">
        	@endif </p>
      		
           @foreach ($departments as $department)
            @if ($department->id == $employee->department_id)
              <p style="color:white; font-size:15px">{{  $department->name }}</p>
            @endif
           @endforeach
       </div>
     </div>

     <div class="col-md-12">
     	<h4 style="color:white"> Personal Details</h4>
  	 </div>
  	 <hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;">
  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 		<h5 style="color:white" >BirthDate:</h5>
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$employee->date_of_birth}}</h5>
  	 	</div>
  	 </div>

  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 		<h5 style="color:white">No/ Street:</h5>
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white">  {{$employee->street}}</h5>
  	 	</div>
  	 </div>


     <div class="col-md-12">
      <div class="col-md-1">
      </div>
      <div class="col-md-2">
        <h5 style="color:white"> Barangay/ Subd.:</h5>
      </div>
      <div class="col-md-9">
        <h5 style="color:white">  {{$employee->barangay}}</h5>
      </div>
     </div>

     <div class="col-md-12">
      <div class="col-md-1">
      </div>
      <div class="col-md-2">
        <h5 style="color:white"> City/ Municipality:</h5>
      </div>
      <div class="col-md-9">
        <h5 style="color:white">  {{$employee->city}}</h5>
      </div>
     </div>

  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 		<h5 style="color:white"> Email:</h5>
  	 	</div>
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$employee->email}}</h5>
  	 	</div>
  	 </div>

  	 <div class="col-md-12">
     	<h4 style="color:white"> Employee Details</h4>
  	 </div>
 <hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;">
  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>

  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 		<h5 style="color:white"> Employee Type:</h5>
  	 	</div>
  	 	@foreach ($contracts as $contract)
            @if ($contract->id == $employee->contract_id)
            @endif
            @endforeach
  	 	<div class="col-md-9">
  	 		<h5 style="color:white"> {{$contract->contract_name}}</h5>
  	 	</div>
  	 </div>

  	 <div class="col-md-12">
  	 	<div class="col-md-1">
  	 	</div>
  	 	<div class="col-md-2">
  	 		<h5 style="color:white"> Job Title:</h5>
  	 	</div>
  	 	<div class="col-md-9">
  	 		@foreach ($jobtitles as $jobtitle)
            @if ($jobtitle->id == $employee->jobtitle_id)
              <h5 style="color:white">{{$jobtitle->jobtitle_name}}</h5>
            @endif
           @endforeach
  	 	</div>
  	 </div>
</div>
</div>
<div class="col-md-6">
	<h5 style="color:white"> QR Code:</h5>
	<img style = "height:150px; width:150px;" src="{{URL::asset('qrcodes').'/'.$employee->id.''.$employee->lname.''.$emp_fname.'.png'}}">
  

</div>
</div>
	  	

  	 




@stop
