@extends("layout")
@section("content")

<head>
    <title>Queries | Time and Electronic Attendance Monitoring System</title>
</head>

<h3>Employee Summary </h3>

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
           
            <table class="table">
                <thead>
                    <tr class="filters">
                    
                        <th><input type="text" class="form-control" placeholder="fname"></th>
                        <th><input type="text" class="form-control" placeholder="lname"></th>
                        <th><input type="text" class="form-control" placeholder="phone number"></th>
                        <th><input type="text" class="form-control" placeholder="email"></th>
                        <th><input type="text" class="form-control" placeholder="hire date"></th>
                        <th><input type="text" class="form-control" placeholder="job title"></th>
                        <th><input type="text" class="form-control" placeholder="contract name"></th>
                        <th><input type="text" class="form-control" placeholder="department"></th>
                        <th><input type="text" class="form-control" placeholder="branch"></th>

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

                    <td>
                        {{$emp->phone}}
                    </td>

                    <td>
                        {{$emp->email}}
                    </td>

                    <td>
                        {{$emp->hire_date}}
                    </td>
                    @foreach($jobtitles as $jobtitle)
                            @if($jobtitle->id == $emp->jobtitle_id)
                            <td>{{$jobtitle->jobtitle_name}}</td>
                            @endif
                    @endforeach

                    @foreach($contracts as $contract)
                            @if($contract->id == $emp->contract_id)
                            <td>{{$contract->contract_name}}</td>
                            @endif
                    @endforeach
                 
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


                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

@stop