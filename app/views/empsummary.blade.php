@extends("layout")
@section("content")

<head>
    <title>Employee Summary | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Employee Summary </h1>

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
                    
                        <th><input type="text" class="form-control" placeholder="First Name"></th>
                        <th><input type="text" class="form-control" placeholder="Last Name"></th>
                        <th><input type="text" class="form-control" placeholder="Phone Number"></th>
                        <th><input type="text" class="form-control" placeholder="Status"></th>
                        <th><input type="text" class="form-control" placeholder="Email"></th>
                        <th><input type="text" class="form-control" placeholder="Hire Date"></th>
                        <th><input type="text" class="form-control" placeholder="Job Title"></th>
                        <th><input type="text" class="form-control" placeholder="Contract Name"></th>
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

                    <td>
                        {{$emp->phone}}
                    </td>

                    <td>
                        {{$emp->status}}
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