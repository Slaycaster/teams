@extends("layout")
@section("content")

<head>
    <title>Hierarchies | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12">

<h1>Hierarchies Maintenance</h1>

  <div class ="col-md-4">
    {{ $hierarchy->links() }}
  </div>

</div>

<div class="container">
  <div class = "row"> 
    <div class = "col-md-5">
    <h3>Add Hierarchy</h3><hr>
                @if ($errors->any())
                    <ul>  
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif
               
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
        <h3 >All Hierarchies</h3><hr>
  @foreach ($hierarchy as $hierarchies)
  <?php $hierarchy_name = preg_replace('/\s+/', '', $hierarchies->hierarchy_name); ?>

  <div class="col-md-6" style="margin-bottom:5px">
    <div class="col-md-12 greytile" style="padding:5px">
      <div class="col-md-5" >
           <img style = "height:100px; width:100px; margin-top:13px" src="{{ URL::asset('img/Hierarchies.png') }}">
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

