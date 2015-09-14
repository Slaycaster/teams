@extends("layout")
@section("content")

<head>
    <title>Premium policies | Time and Electronic Attendance Monitoring System</title>
</head>

<h2>All Premium Policies</h2>
<div class="col-md-12" style="margin-top:10px">

	<div class ="col-md-4">
    <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Premium Policies</a>
        </div>
	</div
  
	<div class="col-md-4">
		<button id="b1" class="btn btn-primary">{{ link_to_route('premium_policies.create', ' + Add new Premium Policy') }}</button>
	</div>
	<div class = "col-md-4">
	{{ $premium_policies->links() }}
  </div>
	       
</div>


@if ($premium_policies->count())

<div class="container" style="margin-top:10px">
  @foreach ($premium_policies as $premium_policy)
  <?php $premium_name = preg_replace('/\s+/', '', $premium_policy->premium_name); ?>
  <div class="col-md-4" style="margin-bottom:5px">
  	<div class="col-md-12 greytile" style="padding:5px">
    	<div class="col-md-5" >
        <img style = "height:100px; width:100px;" src="{{ URL::asset('img/PremiumPolicy.png') }}">
    	</div>
    	<div class="col-md-7" style="margin-left:0px">

           <p style="color:white; font-size:12px"> {{$premium_policy->premium_policy_number}}</p>
           <p style="color:white; font-size:12px"> <strong>{{$premium_policy->premium_name}}
           {{ $premium_policy->lname }}</strong></p>
     
           <p style="color:white; font-size:12px">{{ $premium_policy->start_date}} to {{ $premium_policy->end_date}}</p>
           {{ link_to_route('premium_policies.show', 'View',($premium_policy->id )) }} | {{ link_to_route('premium_policies.edit', 'Edit',($premium_policy->id)) }}
       </div>

     </div>
  <br><br><br><br><br>
  </div>
	@endforeach 
</div>

@else
	There are no premium_policies
@endif

@stop
