@extends("layout")
@section("content")
<br><br><br>
<div class="container">
    <h3>Your Subordinates</h3>
    <hr>
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
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
