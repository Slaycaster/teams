@extends('layout')
@section('content')



<head>
    <title>Hierarchy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:20px">
    <h1>Show Hierarchy</h1>
</div>

@foreach($supervisors as $supervisor)
<div class="label_white"><table class="table  table-bordered ">
    <thead>
        <tr>
            
            <th>Hierarchy name</th>
                <th>Description</th>

        </tr>
    </thead>

    <tbody>
        <tr>
            @foreach($hierarchy as $hierarchies)
            <td>{{{ $hierarchies->hierarchy_name }}}</td>
            <td>{{{ $hierarchies->description }}}</td>
            @endforeach  
        </tr>
    </tbody>
</table></div>


    <div class="label_white">{{ Form::label('supervisor', 'Supervisor:') }}</div>
    <div class="label_white" style="font-size:20px">{{ Form::label('supervisor', $supervisor) }}</div>



<div class="label_white"><table class="table table-bordered">
    <thead>
        <tr>
            <th>Subordinates</th>
            <th>Name</th>
            
        </tr>
    </thead>

    <tbody>
    @for ($i=0; $i < count($employee_lists); $i++)
        @foreach ($employee_lists[$i] as $employee_list) 
         @foreach($hierarchy as $hierarchies)
            <?php $emp_fname = preg_replace('/\s+/', '', $employee_list->fname);?>
            <td><img style = "height:100px; width:100px;" src="{{URL::asset('employees').'/'.$employee_list->id.''.$employee_list->lname.''.$emp_fname.'.jpg'}}"></td>
            <td>{{{ $employee_list->lname}}}, {{{ $emp_fname}}}</td>
        
                 {{ Form::hidden('hierarchy_id', $hierarchies->id) }}
                 {{ Form::hidden('employee_id', $employee_list->id) }}
        
                {{ Form::close() }}</td>        
                    @endforeach             
        </tr>
         @endforeach
    @endfor
    </tbody>
</table></div>
  
 @endforeach
@stop
