@extends("layout_employee")
@section("content")
<br><br><br>
<head>
    <title>Employee Summary | Time and Electronic Attendance Monitoring System</title>
</head>
<div class="container">
    <h1>Your Subordinates</h1>
    <br>
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
                    	<th><input type="text" class="form-control" placeholder="E-mail"></th>
                    	<th><input type="text" class="form-control" placeholder="Hire Date"></th>
                    	<th><input type="text" class="form-control" placeholder="Job Title"></th>
                    	<th><input type="text" class="form-control" placeholder="Contract"></th>
                        <th><input type="text" class="form-control" placeholder="Department"></th>
                        <th><input type="text" class="form-control" placeholder="Branch"></th>
                        
                    
   
                   
                    </tr>
                </thead>
                <tbody>
                @foreach ($user as $users)
                <tr>

                    <td>
                        {{$users->fname}}
                    </td>
                    <td>
                        {{$users->lname}}
                    </td>

                    <td>
                        {{$users->phone}}
                    </td>

                    <td>
                        {{$users->email}}
                    </td>

                    <td>
                        {{$users->hire_date}}
                    </td>
                    @foreach($jobtitles as $jobtitle)
                    		@if($jobtitle->id == $users->jobtitle_id)
                    		<td>{{$jobtitle->jobtitle_name}}</td>
                    		@endif
                    @endforeach

                    @foreach($contracts as $contract)
                    		@if($contract->id == $users->contract_id)
                    		<td>{{$contract->contract_name}}</td>
                    		@endif
                    @endforeach

                    @foreach ($departments as $department)
                         @if ($department->id == $users->department_id)
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

<script type="text/javascript">
    $(function(){
    $(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            });
    });
    
</script>


@stop
