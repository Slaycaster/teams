@extends("layout")
@section("content")

<head>
    <title>Overtime policies | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-top:-18px; margin-bottom:15px">
<h1>All Overtime policies</h1>
<div class="col-md-4" style="margin-left:-15px; margin-bottom:15px">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Overtime Policy</a>
        </div>
 </div>


</div>

	<div class="container" style="margin-top:30px">

    <div class = "row">
      <div class = "col-md-4">
        <h3>Create Overtime policies</h3>
        {{ Form::open(array('route' => 'overtime_policies.store')) }}
    <ul>
        
            <div class="label_white">{{ Form::label('overtime_name', 'Overtime name:') }}</div>
            {{ Form::text('overtime_name', Input::get('overtime_name'), array('placeholder' => 'Overtime name','autocomplete' => 'off', 'size' => '40')) }}<br><br>
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>
        
        
            <div class="label_white">{{ Form::label('active_after', 'Active After (Hours) from Daily Scheduled time') }}</div>
            
            {{ Form::number('active_after', Input::get('active_after'), array('placeholder' => '0','autocomplete' => 'off', 'size' => '40')) }}<br><br>

            <div class="label_white">{{ Form::label('Allowed_number_of_hours', 'Allowed number of hours:') }}</div>

            {{ Form::number('Allowed_number_of_hours', Input::get('Allowed_number_of_hours'), array('placeholder' => '0','autocomplete' => 'off', 'size' => '40')) }}<br><br>

        
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        
    </ul>
{{ Form::close() }}
      </div>
      <div class = "col-md-8">
        <h3>All Overtime policies</h3>
          @foreach ($overtime_policies as $overtime_policy)

          <div class="col-md-4" style="margin-bottom:5px">
            <div class="col-md-12 greytile" style="padding:5px">
              <div class="col-md-5" >
                   <img style = "height:70px; width:70px;" src="{{ URL::asset('img/PremiumPolicy.png') }}">
              </div>
              <div class="col-md-7" style="margin-left:0px">

                   <p style="color:white; font-size:16px"> {{$overtime_policy->overtime_name}}
                   </p>                    
               
                   <p style="color:white; font-size:12px"> {{$overtime_policy->type}}</p>
                  
                   <a href="{{ URL::to('overtime_policies/' . $overtime_policy->id) }}" onclick="window.open('{{ URL::to('overtime_policies/' . $overtime_policy->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('overtime_policies/' . $overtime_policy->id . '/edit') }}" onclick="window.open('{{ URL::to('overtime_policies/' . $overtime_policy->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
               </div>

             </div>

          </div>
          @endforeach
      </div>
    </div>  
   
</div>
@if ($errors->any())
  <ul>
    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
  </ul>
@endif

@stop
