@extends("layout")
@section("content")

<head>
    <title>Employee Types | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1 style="margin-left:18px">Employee Type Maintenance</h1>
  <div class="col-md-4">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Employee Type</a>
        </div>
  </div>

  
	

	 <div class ="col-md-4">
    {{ $contracts->links() }}
  </div>
	
</div>


	<div class="container" style="margin-top:30px">

    <div class="row">
      <div class="col-md-4">
        <h3>Add an Employee Type</h3>
                @if ($errors->any())
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif
        {{ Form::open(array('route' => 'contracts.store')) }}
    
            <div class="label_white">{{ Form::label('contract_name', 'Employee Type:') }}</div>
            {{ Form::text('contract_name', Input::get('contract_name'), array('placeholder' => 'Employee Type','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>

            <div class="label_white">{{ Form::label('duration', 'Duration:') }}</div>
            {{ Form::input('number', 'duration', Input::get('duration'), array('placeholder' => 'Months','autocomplete' => 'off', 'size' => '40')) }}<br><br>
 
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}

    
          {{ Form::close() }}
      </div>
      <div class="col-md-8">
        <h3 style="margin-left:2%">All Employee Type</h3>
        @foreach ($contracts as $contract)

          <div class="col-md-4" style="margin-bottom:5px">
  	       <div class="col-md-12 greytile" style="padding:5px">
    	       <div class="col-md-5" >
           <img style = "height:70px; width:70px;" src="{{ URL::asset('img/Contract.png') }}">
    	         </div>
    	     <div class="col-md-7" style="margin-left:0px">

           <p style="color:white; font-size:14px"> {{$contract->contract_name}} 
           <p style="color:white; font-size:10px"> Duration: {{$contract->duration}} month/s</p>
            <a href="{{ URL::to('contracts/' . $contract->id) }}" onclick="window.open('{{ URL::to('contracts/' . $contract->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('contracts/' . $contract->id . '/edit') }}" onclick="window.open('{{ URL::to('contracts/' . $contract->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
          
    </div>
  </div>
</div>
	@endforeach 
</div>
</div>
</div>

@stop
