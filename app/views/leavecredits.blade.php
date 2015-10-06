@extends("layout")
@section("content")

<head>
	<title>Leave Credits | Time and Attendance Monitoring System</title>
</head>
 @if (Session::has('message10'))
         <div class="alert alert-warning">{{ Session::get('message10') }}</div><br>
      @endif
			<h1 style = "color:white;">Leave Credits</h1>
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
                    
                        <th><input type="text" class="form-control" placeholder="Employee Number"></th>
                        <th><input type="text" class="form-control" placeholder="Name"></th>
                        <th><input type="text" class="form-control" placeholder="Accumulated Leave"></th>
                  
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th style="text-align:center">Sick Leave</th>
                        <th style="text-align:center">Vacation Leave</th>
                        <th style="text-align:center">Force Leave</th>
                        <th style="text-align:center">Deduct Leave</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $a=0; ?>
                @foreach ($employs as $employee)
                <tr>
                    <td>
                        {{$employee->employee_number}}
                    </td>
                    <td>
                        {{$employee->lname}}, {{$employee->fname}}
                    </td>
                <td>
                        {{$sick_leave[$a] }}
                    </td>
                    <td>
                        {{$vacation_leave[$a] }}
                    </td>
                    <td>
                        {{$force_leave[$a] }}
                    </td>
                        <td>
                      {{ Form::open(array('url' => 'leavededuct', 'method' => 'post', 'autocomplete' => 'off')) }}    
                           {{ Form::hidden('emp_id', $employee->id) }}
                          
                           <p style="color:black">{{ Form::number('deduction', "0")}}</p>
                          <p style="color:black"> {{ Form::select('type', array('sick_leave' => 'Sick Leave', 'vacation_leave' => 'Vacation Leave', 'force_leave' => 'Force Leave')) }}</p>
                       
                         {{ Form::submit('Leave Deduction', array('class' => 'btn btn-info')) }}          
             {{ Form::close() }}
                    </td>
             <?php $a++; ?> 

                    
                </tr>

                 @endforeach
       
                </tbody>
            </table>
        </div>
    </div>
</div>
			 

		</div>
@stop