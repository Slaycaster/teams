@extends("layout")
@section("content")

<head>
    <title>Accrual policies | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>All Accrual policies</h1>
<div class="col-md-12">
<div class="col-md-4" style="margin-left:-25px">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Accural Policy</a>
        </div>
 </div>
		<div class="col-md-4">
			<button class = "btn btn-primary">{{ link_to_route('accrual_policies.create', 'Add new accrual policy') }}</button><br><br>
		 </div>
</div>

@if ($accrual_policies->count())


<div class="container" style="margin-top:30px">
  @foreach ($accrual_policies as $accrual_policy)

  <div class="col-md-4" style="margin-bottom:5px">
  	<div class="col-md-12 greytile" style="padding:5px">
    	<div class="col-md-5" >
           <img style = "height:100px; width:100px;" src="{{ URL::asset('img/PremiumPolicy.png') }}">
    	</div>
    	<div class="col-md-7" style="margin-left:0px">

           <p style="color:white; font-size:16px"> {{$accrual_policy->accrual_name}}
           </p>                    
       
           <p style="color:white; font-size:12px"> {{$accrual_policy->frequency}}</p>
          
           {{ link_to_route('accrual_policies.show', 'View',($accrual_policy->id )) }} | {{ link_to_route('accrual_policies.edit', 'Edit',($accrual_policy->id) ) }}
       </div>

     </div>
  <br><br><br><br><br>
  </div>
	@endforeach 
</div>

@else
	There are no accrual policies
@endif

@stop
