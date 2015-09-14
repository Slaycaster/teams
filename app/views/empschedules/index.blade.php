@extends("layout")
@section("content")

<head>
    <title>All Assigned Schedule | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px">
<h1>All Assigned Schedule</h1>
 <div class="col-md-4">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">All Assigned Schedule</a>
        </div>
  </div>
  <div class="col-md-4">
		
	</div>


  <div class ="col-md-4">
    {{ $schedule->links() }}
  </div>

</div>

@if ($schedule->count())
<div class="container">
  @foreach ($schedules as $schedule)
  <div class="col-md-4" style="margin-bottom:5px">
    <div class="col-md-12 greytile" style="adding:5px"><br>
      <div class="col-md-5" >
            <img style = "height:100px; width:100px;" src="{{ URL::asset('img/Calendar.png') }}">">
      </div>
      <div class="col-md-7" style="margin-left:0px">

        <b>  <p style="color:white"> {{$schedule->schedule_name}}</p>
         <b> <a style="color:cyan"{{ link_to_route('empschedules.create', 'Add Employees')}} <br><br>
         <b> <a style="color:cyan"{{ link_to_route('empschedules.show', 'View Assigned Employee',($schedule->id )) }}
       </div>

     </div>
  <br><br><br><br><br>
  </div>
	@endforeach 
</div>
@else
	There are no employee schedules
@endif

@stop
