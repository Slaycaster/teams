@extends("layout")
@section("content")

<head>
    <title>Hierarchies | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style=" margin-bottom:20px">

<h1>Hierarchies Maintenance</h1>

<div class="col-md-4">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Hierarchies</a>
        </div>
  </div>

  <div class ="col-md-4">
    {{ $hierarchy->links() }}
  </div>

</div>

<div class="container" style="margin-top:30px">
  <div class = "row">
      
    <div class = "col-md-5" style="margin-left:-3%">
    <h3 style="margin-left:8%">Add Hierarchy</h3>
                @if ($errors->any())
                    <ul>  
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif
               
    <ul>
            
            <h3>Filter by levels</h3>
            {{ Form::open(array('url' => 'hierarchies/index', 'method' => 'post')) }}
            {{ Form::select('levels_id', $levels, Input::old('<br>levels_id'), array('class' => 'btn btn-default dropdown-toggle target','id' => 'levels_id', 'tabindex' => '2') ) }}
            {{ Form::close() }}

             <div class="label_white">{{ Form::label('levels_id', 'Selected Level:') }}
               </div>
                <div class="label_white">
                  @foreach($levelss as $level)
                  
                    @if($level->id == Input::get('levels_id'))
                 
                    <p style="font-size:25px;"><strong>{{$level->name}}</strong></p>
                    @endif
                  
                @endforeach
               </div>
                {{ Form::open(array('route' => 'hierarchies.store')) }}
             <div class="label_white">{{ Form::label('supervisor_id', 'Supervisor:') }}
               </div>
             
                  {{ Form::select('supervisor_id', $supervisors, Input::old('supervisor_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
              
            
            <div class="label_white">{{ Form::label('hierarchy_name', 'Hierarchy Name:') }}</div>
            {{ Form::text('hierarchy_name', Input::get('hierarchy_name'), array('placeholder' => 'Hierarchy name','autocomplete' => 'off', 'size' => '40')) }}<br>
            
        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::text('description',null, array('placeholder' => 'Short description here','autocomplete' => 'off', 'size' => '40')) }}<br><br>
        
            <div class="label_white">{{ Form::label('subordinates', 'Subordinates:') }}</div>
    
            {{ Form::select('subordinates', $subordinates, Input::old('subordinates'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'subordinates[]')) }}<br><br><br>
        
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
    
    </ul>
{{ Form::close() }}
</div>


  <div class = "col-md-7 ">
        <h3 style="margin-left:3%">All Hierarchies</h3>
  @foreach ($hierarchy as $hierarchies)
  <?php $hierarchy_name = preg_replace('/\s+/', '', $hierarchies->hierarchy_name); ?>

  <div class="col-md-6" style="margin-bottom:5px">
  	<div class="col-md-12 greytile" style="padding:5px">
    	<div class="col-md-5" >
           <img style = "height:100px; width:100px;" src="{{ URL::asset('img/Kiosk.png') }}">
    	</div>
    	<div class="col-md-7" style="margin-left:0px">

           <p style="color:white; font-size:20px"> {{$hierarchies->hierarchy_name}}
           <p style="color:white; font-size:12px"> {{$hierarchies->description}}
           </p>
            <a href="{{ URL::to('hierarchies/' . $hierarchies->id) }}" onclick="window.open('{{ URL::to('hierarchies/' . $hierarchies->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('hierarchies/' . $hierarchies->id . '/edit') }}" onclick="window.open('{{ URL::to('hierarchies/' . $hierarchies->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
       </div>

     </div>
  <br><br><br><br><br>
  </div>
	@endforeach 
</div>
</div>
</div>
<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();

$('#levels_id').on('change', function(e){
    $(this).closest('form').submit();
});
</script>
@stop

