@extends("layout")
@section("content")

<head>
    <title>Pay Periods | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>All Pay Periods</h1>

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif


<div class="col-md-12">
    <div class="col-md-4" style="margin-left:-30px">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Pay Periods</a>
        </div>
    </div>
</div>

<div class = "row">
    <div class = "col-md-4">
      <h3>Add a Pay period</h3>
          {{ Form::open(array('url' => 'pay_periods')) }}
          
              <div class="label_white">{{ Form::label('name', 'Name') }}</div>
              {{ Form::text('name', Input::old('name'), array('placeholder' => 'Name','autocomplete' => 'off', 'size' => '25')) }}
          
              <div class="label_white">{{ Form::label('description', 'Description') }}</div>
              {{ Form::text('description', Input::old('description')) }}
     
              <div class="label_white">{{ Form::label('type', 'Type') }}</div>
              {{ Form::select('type', array('Weekly' => 'Weekly', 'Bi-Weekly' => 'Bi-Weekly', 'Monthly' => 'Monthly'), Input::old('type')) }}
          
              <div class="label_white">{{ Form::label('payperiod_day', 'Pay Period Day') }}</div>
              {{ Form::text('payperiod_day', Input::get('payperiod_day'), array('placeholder' => 'Day','autocomplete' => 'off', 'size' => '16')) }}

               <div class="label_white">{{ Form::label('initial_payperiod', 'Initial Pay Period Date') }}</div>
              {{ Form::text('initial_payperiod', Input::old('initial_payperiod'), array('id' => 'calendar', 'size' => '10', 'placeholder' => 'yyyy-mm-dd')) }}<br><br>
          {{ Form::submit('Create Pay Period', array('class' => 'btn btn-primary')) }}

      {{ Form::close() }}
    </div>

    <div class = "col-md-8">
      <h3 style = "margin-left: 4%">All Pay periods</h3>
          <div class="container" style="margin-top:60px">
                @foreach ($pay_periods as $pay_period)

              <div class="col-md-3" style="margin-bottom:5px">
                <div class="col-md-12 greytile" style="padding:5px">
                    <div class="col-md-5" >
                       <img style = "height:70px; width:70px;" src="{{ URL::asset('img/Department.png') }}">
                    </div>
                    <div class="col-md-7" style="margin-left:0px">

                       <p style="color:white; font-size:14px"> {{$pay_period->name}}
                       </p>                    
                   
                       <p style="color:white; font-size:12px"> <strong>{{$pay_period->type}}</strong></p>
                       <a href="{{ URL::to('pay_periods/' . $pay_period->id) }}" onclick="window.open('{{ URL::to('pay_periods/' . $pay_period->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('pay_periods/' . $pay_period->id . '/edit') }}" onclick="window.open('{{ URL::to('pay_periods/' . $pay_period->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
                   </div>

                 </div>
              </div>
                @endforeach 
            </div>
    </div>
</div>




@stop