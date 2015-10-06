@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Exception policy | Time and Electronic Attendance Monitoring System</title>
</head>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
<br>

<h1 style='margin-left:20px'>Edit Exception Policy</h1>
<br>

{{ Form::open(array('url' => 'exception/edit', 'method' => 'post', 'autocomplete' => 'off')) }}
    <ul>
        @for ($i=0; $i < 1; $i++)
    @foreach ($groups[$i] as $group)
      <div class="col-md-12">
    <div class="label_white">
         {{ Form::label('exceptiongroup_name', 'Exception Group Name:') }}
     </div>
   {{ Form::text('exceptiongroup_name', $group->exceptiongroup_name, array('placeholder' => 'Group Name','autocomplete' => 'off', 'size' => '30')) }}<br>
    <div class="label_white">
        {{ Form::label('description', 'Description:') }}<br>
     </div>
 {{ Form::textarea('description', $group->description) }}<br><br><br>
 {{Form::hidden('id', $group->id)}}
 </div>
     @endforeach
    @endfor

        <div class="col-md-12">
          <input class = 'btn btn-info' type="submit" name="Add" value="Add Exception Policy">
          <br><br>
         
   <div class="label_white"><table class="table table-bordered">
    <thead>
        <tr>
        
                <th>Active</th>
                <th>Exception name</th>
                <th>Severity</th>
                <th>Grace</th>
                <th>Watch window</th>
                <th>Email notification</th>
               <th colspan="2"><center>Action</center></th>
                
        </tr>
    </thead>

    <tbody>
    @for ($i=0; $i < count($exceptions_lists); $i++)
        @foreach ($exceptions_lists[$i] as $exceptions_list) 
            <tr>
                    <td>{{ Form::label('is_active', $exceptions_list->is_active) }}</td>
                    {{ Form::hidden('is_active', $exceptions_list->is_active) }}
                    
                    <td>{{ Form::label('exception_name', $exceptions_list->exception_name) }}</td>
                    {{ Form::hidden('exception_name', $exceptions_list->exception_name) }}
                    @foreach($exception_groups as $group)
                        @if($exceptions_list->id == $group->exception_id)
                            <td style = "color:black;">{{ Form::select('severity',  array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High', 'Critical' => 'Critical'), $group->severity, array('style' => 'color:black;')) }}</td>
                            
                            <td>  {{ Form::text('grace', $group->grace, array('placeholder' => 'hh:mm:ss', 'size' => '10', 'class' => 'form-control')) }}</td>
                    
                            <td> {{ Form::text('watch_window', $group->watch_window, array('placeholder' => 'hh:mm:ss', 'size' => '10', 'class' => 'form-control')) }}</td>
                    
                            <td> {{ Form::select('email_notification',  array('Both' => 'Both', 'Superior' => 'Superior', 'Employee' => 'Employee'), $group->email_notification, array('style' => 'color:black;')) }}</td>
                        @endif
                    @endforeach 

                    {{ Form::hidden('exception_id', $exceptions_list->id)}}
                    <td><input class = 'btn btn-warning' type="submit" name="Edit" value="Edit"></td>
                    <td><input class = 'btn btn-danger' type="submit" name="Delete" value="Delete"></td>


         @endforeach

            </tr>
    @endfor
    </tbody>
</table></div>
      </div>
      <div class='col-md-12'>

           <input class = 'btn btn-info' type="submit" name="Update" value="Update">
           <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
        </div>
    </ul>
{{ Form::close() }}

<script type="text/javascript">
    window.onload = function() {
    if(!window.location.hash) {        
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
</script>
@stop
