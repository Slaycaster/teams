@extends("layout")
@section("content")

<head>
    <title>Terminals | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-top:-18px; margin-bottom:15px">
  <h1>Terminal Maintenance</h1>
<div class="col-md-4">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Terminals</a>
        </div>
  </div>

<div class="col-md-4">
	

<div class ="col-md-4">
    {{ $stations->links() }}
  </div>

</div>
</div>


<div class="container" style="margin-top:30px">

  <div class = "row">
    <div class = "col-md-4">
      <h3>Add a Station</h3>
                @if ($errors->any())
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif
                {{ Form::open(array('route' => 'stations.store')) }}
                  
                      
                      <div class="label_white">{{ Form::label('branch_id', 'Branch name:') }}</div>
                      {{ Form::select('branch_id', $branches_id, Input::old('<br>branch_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
                  

                  
                      
                      <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
                      {{ Form::select('status', array('Enabled' => 'Enabled')) }}<br>

                  
                      <div class="label_white">{{ Form::label('station_name', 'Terminal name:') }}</div>
                      {{ Form::text('station_name',Input::get('station_name'), array('placeholder' => 'Station Name','autocomplete' => 'off', 'size' => '40')) }}<br>
                  

                  
                      <div class="label_white">{{ Form::label('type', 'Type:') }}</div>
                      {{ Form::select('type', array('PC' => 'PC')) }}<br>
                    
                  
                  
                      
                      <div class="label_white">{{ Form::label('source', 'Source:') }}</div>
                      {{ Form::text('source',Input::get('source'), array('placeholder' => 'ex. 192.168.254.254','autocomplete' => 'off', 'size' => '40')) }}<br>
                  

                  
                      <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
                      {{ Form::text('description', null, array('placeholder' => 'Short description here','autocomplete' => 'off', 'size' => '40')) }}<br><br>
                  
                      
                            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
          {{ Form::close() }}
    </div>
    <div class = "col-md-8">
        <h3>All Stations</h3>
         @foreach ($stations as $station)
          <?php $station_name = preg_replace('/\s+/', '', $station->station_name); ?>

          <div class="col-md-4" style="margin-bottom:5px">
            <div class="col-md-12 greytile" style="padding:5px">
              <div class="col-md-5" >
                   <img style = "height:70px; width:70px;" src="{{ URL::asset('img/Kiosk.png') }}">
              </div>
              <div class="col-md-7" style="margin-left:0px">

                   <p style="color:white; font-size:14px"> {{$station->station_name}}
                    @if ($station->status == 'Enabled')
                    <img style = "height:20px; width:20px;" src="{{ URL::asset('img/Check.png') }}">
                    @else
                  <img style = "height:20px; width:20px;" src="{{ URL::asset('img/Wrong.png') }}">
                  @endif</p>
                   <p style="color:white; font-size:10px"> <strong>{{$station->type}}
                   {{ $station->source }}</strong></p>
                   <a href="{{ URL::to('stations/' . $station->id) }}" onclick="window.open('{{ URL::to('stations/' . $station->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('stations/' . $station->id . '/edit') }}" onclick="window.open('{{ URL::to('stations/' . $station->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
               </div>
             </div>
          </div>
          @endforeach 
    </div>
  </div>
 
</div>


<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
</script>
@stop
