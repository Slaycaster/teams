@extends("layout")
@section("content")

<head>
	<title>Leave Credits | Time and Attendance Monitoring System</title>
</head>
			<h1 style = "color:white;">Leave Credits</h1>

			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			<div class = "col-md-12"></div>
			 <table  class = "table table-bordered" style = "color:black; ">
                <thead style="background-color:white;">
                    <tr>
                    
                        <th style="text-align:center">Employee ID</th>
                        <th style="text-align:center">Employee Name</th>
                        <th style="text-align:center" colspan="4">Accumulated Leave</th>
                        
                    </tr>
                    <tr>
                    	<th></th>
                    	<th></th>
                    	<th style="text-align:center">Sick Leave</th>
                        <th style="text-align:center">Vacation Leave</th>
                        <th style="text-align:center">Force Leave</th>
                        <th style="text-align:center">Adjust Leave</th>
                    </tr>
                </thead>
                <tbody style = "color:white;">
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
                      		<p style="color:black"> {{ Form::select('type', array('sick_leave' => 'sick leave', 'vacation_leave' => 'vacation leave')) }}</p>
                       
                         {{ Form::submit('Leave Deduction', array('class' => 'btn btn-info')) }}          
     			   {{ Form::close() }}
                    </td>
         		 <?php $a++; ?> 
                 @endforeach
       
                </tbody>
            </table>

		</div>
@stop