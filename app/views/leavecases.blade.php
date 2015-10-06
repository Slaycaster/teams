@extends("layout")
@section("content")

<head>
    <title>Leave Cases | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>All Leave Cases</h1>

<div class="row">
    <div class = "col-md-4">
        {{ Form::open(array('url' => 'queries/leavecases', 'method' => 'post')) }}
        <h3>Filter by Type</h3>
        {{ Form::select('status',array('Select a status','Pending' => 'Pending', 'Approved' => 'Approved','Declined' => 'Declined','Changed'=>'Changed'),null,array('class' => 'btn btn-default dropdown-toggle target','id' => 'stats','tabindex' => '2'))}}<br>  
    </div>
    <div class = "col-md-4">
        {{ Form::open(array('url' => 'queries/leavecases', 'method' => 'post')) }}
            <h3>Filter by Date</h3>
             {{ Form::text('date',Input::get('date'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}<br>
        {{ Form::close() }}
    </div>
</div>

<div class="container">
    <hr>
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Employees</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            {{ Form::open(array('url' => 'leavecases', 'method' => 'post')) }}
            <table class="table">
                <thead>
                    <tr class="filters">
                    
                        <th><input type="text" class="form-control" placeholder="Employee Name"></th>
                        <th><input type="text" class="form-control" placeholder="Request Date"></th>
                        <th><input type="text" class="form-control" placeholder="Request Type"></th>
                        <th><input type="text" class="form-control" placeholder="Message"></th>
                        <th><input type="text" class="form-control" placeholder="Status"></th>
                    
                    </tr>
                </thead>
                <tbody>
                @foreach ($leaves as $leave)
                <tr>
                    @foreach($employs as $employee_name)
                    @if($leave->employee_id == $employee_name->id)
                     <td>
                        {{$employee_name->lname}}, {{$employee_name->fname}}
                    </td>
                    @endif
                    @endforeach
                    <td>
                        {{$leave->request_date}}
                    </td>
                    <td>
                        {{$leave->request_type}}
                    </td>
                   
                    <td>
                        {{$leave->message}}
                    </td>
                    <td>
                        {{$leave->status}}
                    </td>
                 @endforeach
       
                </tbody>
            </table>
        </div>
    </div>
</div>
	

<script type="text/javascript">
$('#stats').on('change', function(e){
    $(this).closest('form').submit();
});
</script>
<script type="text/javascript">
    $('#calendar').datepicker({
        format: "yyyy-mm-dd"
    });
</script>
<script type="text/javascript">
$('#calendar').on('change', function(e){
    $(this).closest('form').submit();
});
</script>
@stop