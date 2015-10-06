@extends("layout")
@section("content")

<head>
    <title>Remove Employee Schedule | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Remove Employee Schedule </h1>

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

{{ Form::open(array('url' => 'emp_schedules/remove', 'method' => 'post')) }}
    
            <h3>Filter by schedule</h3>
            {{ Form::select('schedule_id', $schedule, Input::old('<br>schedule_id'), array('class' => 'btn btn-default dropdown-toggle target','id' => 'schedule_id', 'tabindex' => '2') ) }}
     
{{ Form::close() }}
<hr>
<div class="container">
    
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Employees</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            {{ Form::open(array('url' => 'transaction', 'method' => 'post')) }}
            <table class="table">
                <thead>
                    <tr class="filters">
                    
                        <th><input type="text" class="form-control" placeholder="First Name"></th>
                        <th><input type="text" class="form-control" placeholder="Last Name"></th>
                    
                        <th><input type="text" class="form-control" placeholder="Department"></th>
                        <th><input type="text" class="form-control" placeholder="Branch"></th>
   
                   
                    </tr>
                </thead>
                <tbody>

                     @foreach ($empscheds as $empsched)
                <tr>
                     @foreach($employs as $employ)
                        @if (($empsched->employee_id == $employ->id))
                           <td> {{$employ->fname}} </td>
                           <td>  {{$employ->lname}} </td>
                            @foreach ($departments as $department)
                                @if ($department->id == $employ->department_id)
                                   <td>{{  $department->name }}</td>
                                   @foreach($branches as $branch)
                                    @if ($branch->id == $department->branch_id)
                                        <td>{{  $branch->branch_name }}</td>
                                    @endif
                                @endforeach
                                @endif
                                
                            @endforeach
                        @endif
                     @endforeach

                     
        
                    <td align="center">{{ Form::checkbox($empsched->id, $empsched->id)}}</td>
                </tr>

                 @endforeach
            
       
                </tbody>
            </table>
        </div>
    </div>
</div>
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
    
    
{{ Form::close() }}



<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();

$('#schedule_id').on('change', function(e){
    $(this).closest('form').submit();
});
</script>
@stop
