@extends("layout")
@section("content")

<head>
    <title>Queries | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Employee By Department </h1>

{{ Form::open(array('url' => 'queries/empbydept', 'method' => 'post')) }}
    
            <h3>Filter by Department</h3>
            {{ Form::select('departmento', $departments, Input::old('<br>departmento'), array('class' => 'btn btn-default dropdown-toggle target','id' => 'department', 'tabindex' => '2') ) }}
     
{{ Form::close() }}

<div class="container">
    <h3>The columns titles are merged with the filters inputs thanks to the placeholders attributes</h3>
    <hr>
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            {{ Form::open(array('url' => 'empbydept', 'method' => 'post')) }}
            <table class="table">
                <thead>
                    <tr class="filters">
                    
                        <th><input type="text" class="form-control" placeholder="fname"></th>
                        <th><input type="text" class="form-control" placeholder="lname"></th>
                    
                        <th><input type="text" class="form-control" placeholder="department"></th>
                    
   
                   
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


                    @foreach ($departmentss as $department)
                         @if ($department->id == $emp->department_id)
                        <td>{{  $department->name }}</td>
                        @endif
                    @endforeach

                    

                 @endforeach
       
                </tbody>
            </table>
        </div>
    </div>
</div>

{{ Form::close() }}

<script type="text/javascript">
$('#department').on('change', function(e){
    $(this).closest('form').submit();
});
</script>
@stop