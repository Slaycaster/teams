@extends("layout")
@section("content")

<head>
    <title>Assign Hierarchy | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Assign Hierarchy </h1>

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

{{ Form::open(array('url' => 'transactions/assign_hierarchy', 'method' => 'post')) }}
    
            <h3>Select hierarchy</h3>
            {{ Form::select('hierarchy_id', $hierarchies, Input::old('<br>hierarchy_id'), array('class' => 'btn btn-default dropdown-toggle target','id' => 'hierarchy_id', 'tabindex' => '2') ) }}
     
{{ Form::close() }}
<div class="container">
    <hr>
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Subordinates</h3>
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
   
                   
                    </tr>
                </thead>
                <tbody>

                     @foreach($employs as $employ)
                <tr>
                           <td> {{$employ->fname}} </td>
                           <td>  {{$employ->lname}} </td>
                            @foreach ($departments as $department)
                                @if ($department->id == $employ->department_id)
                                   <td>{{  $department->name }}</td>
                                @endif
                            @endforeach

                     
        
                    <td align="center">{{ Form::checkbox($employ->id, $employ->id)}}</td>
                </tr>

                 @endforeach
            
       
                </tbody>
            </table>
        </div>
        {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        {{ Form::close() }}
    </div>

@if($is_post == 'true')
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Already assigned Subordinates</h3>
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
                    </tr>
                </thead>
                <tbody>

                @foreach($hierarchy_subordinates as $sub)
                <tr>
                    @foreach($employs as $employ)
                        @if($employ->id == $sub->employee_id)
                           <td> {{$employ->fname}} </td>
                           <td>  {{$employ->lname}} </td>
                            @foreach ($departments as $department)
                                @if ($department->id == $employ->department_id)
                                   <td>{{  $department->name }}</td>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                     
        
                    <td align="center">{{ Form::checkbox($employ->id, $employ->id)}}</td>
                </tr>

                 @endforeach
            
       
                </tbody>
            </table>
        </div>
        {{ Form::submit('Remove', array('class' => 'btn btn-danger')) }}
        {{ Form::close() }}
    </div>

@endif
</div>
    <br>       
    
    


<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();

$('#hierarchy_id').on('change', function(e){
    $(this).closest('form').submit();
});
</script>
@stop
