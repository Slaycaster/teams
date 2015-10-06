@extends("layout")
@section("content")

<head>
    <title>Departments | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12">
<h1>Department Maintenance</h1>

	<div class="col-md-4" >
		{{ $departments->links() }}
	</div>
	
  

</div>


	<div class="container" style="margin-top:30px">

  <div class = "row">
      <div class = "col-md-4">
        <h3>Add a Department</h3><hr>
        @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
        </ul>
        @endif 
        {{ Form::open(array('route' => 'departments.store')) }}           
          
              <fieldset class="field">
              <legend>Department</legend>
               <div class="label_white">  
              {{ Form::label('branch_id', 'Branch name:') }}
            </div>
              {{ Form::select('branch_id', $branches_id, Input::old('branch_id'), array('class' => 'btn btn-default dropdown-toggle')) }}
            
        
         
            
            <div class="label_white">{{ Form::label('name', 'Name:') }}</div>
            {{ Form::text('name', Input::get('name'), array('placeholder' => 'Name','autocomplete' => 'off', 'size' => '40')) }}<br>
        
            <div class="label_white">{{ Form::label('code', 'Code:') }}</div>
            {{ Form::text('code', Input::get('code'), array('placeholder' => 'Code','autocomplete' => 'off', 'size' => '40')) }}<br>
       
            
            <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
            {{ Form::select('status', array('Enabled' => 'Enabled', 'Disabled' => 'Disabled')) }}<br><br>
            </fieldset>
            
            <br><br>
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}          
        {{ Form::close() }}
      </div>

      <div class = "col-md-8">
        <h3>All Departments</h3><hr>
        @foreach ($departments as $department)
          <div class="col-md-5" style="margin-bottom:5px">
            <div class="col-md-12 greytile" style="padding:5px">
              <div class="col-md-3">
                   <img style = "height:75px; width:75px; margin-left:-13px; margin-top:5px; " src="{{ URL::asset('img/Houses.png') }}">
              </div>
              <div class="col-md-9" style="margin-left:0px">

                   <p style="color:white; font-size:14px"> {{$department->name}}
                    @if ($department->status == 'Enabled')
                    <img style = "height:20px; width:20px;" src="{{ URL::asset('img/Check.png') }}">
                    @else
                    <img style = "height:20px; width:20px;" src="{{ URL::asset('img/Wrong.png') }}">
                    @endif</p>

                     <p style="color:white; font-size:14px">
                      @foreach ($branches as $branch)
                      @if ($branch->id == $department->branch_id)
                        <h5 style="color:white"> {{$branch->branch_name}} - {{$department->code}}</h5>
                      @endif
                      @endforeach
                    </p>                    
               
                  
                    <a href="{{ URL::to('departments/' . $department->id) }}" onclick="window.open('{{ URL::to('departments/' . $department->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('departments/' . $department->id . '/edit') }}" onclick="window.open('{{ URL::to('departments/' . $department->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
                  </p>
               </div>
             </div>
          </div>
        @endforeach 
        
      </div>
  </div>
    
</div>

@stop
