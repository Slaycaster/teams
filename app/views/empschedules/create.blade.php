@extends("layout")
@section("content")

<head>
    <title>Assign Employee Schedule | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-top:10px; margin-left:-10px">
   @if (Session::has('message2'))
    <div class="alert alert-info">{{ Session::get('message2') }}</div>
  @endif
    <h1>Assign Employee Schedule</h1>
  </div>

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

{{ Form::open(array('route' => 'empschedules.store')) }}
    

    
            <h3>Schedule Name</h3>
            {{ Form::select('schedule_id', $schedule, Input::old('<br>schedule_id'), array('class' => 'btn btn-default dropdown-toggle')) }}
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
                @foreach ($employs as $emp)
                <tr>
                    <td>
                        {{$emp->fname}}
                    </td>
                    <td>
                        {{$emp->lname}}
                    </td>


                    @foreach ($departments as $department)
                         @if ($department->id == $emp->department_id)
                        <td>{{  $department->name }}</td>
                        @foreach($branches as $branch)
                                    @if ($branch->id == $department->branch_id)
                                        <td>{{  $branch->branch_name }}</td>
                                    @endif
                                @endforeach
                        @endif
                    @endforeach

                    <td align="center">{{ Form::checkbox($emp->id, $emp->id)}}</td>
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

</script>
@stop
