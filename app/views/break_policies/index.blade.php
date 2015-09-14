@extends("layout")
@section("content")

<head>
    <title>Break policies | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>All Break Policies</h1>
<div class="col-md-12">
	<div class="col-md-6">
	<div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('break_policies') }}" class="btn btn-default">Break Policies</a>
    </div>
</div>
    <div class="col-md-6">
    	<button id="b1" class="btn btn-primary">{{ link_to_route('break_policies.create', '+ Add new Break Policy') }}
		</button>
    </div>
</div>

<br><br>
@if ($break_policies->count())
	

	<div class="container" style="margin-top:30px">
  @foreach ($break_policies as $break_policy)

  <div class="col-md-4" style="margin-bottom:5px">
  	<div class="col-md-12 greytile" style="padding:5px">
    	<div class="col-md-5" >
           <img style = "height:100px; width:100px;" src="{{ URL::asset('img/PremiumPolicy.png') }}">
    	</div>
    	<div class="col-md-7" style="margin-left:0px">

           <p style="color:white; font-size:16px"> {{$break_policy->break_name}}
           </p>                    
       
           <p style="color:white; font-size:12px"> {{$break_policy->type}}</p>
          
           {{ link_to_route('break_policies.show', 'View',($break_policy->id )) }} | {{ link_to_route('break_policies.edit', 'Edit',($break_policy->id) ) }}
       </div>

     </div>
  <br><br><br><br><br>
  </div>
	@endforeach 
</div>



@else
	There are no break policies
@endif

@stop
