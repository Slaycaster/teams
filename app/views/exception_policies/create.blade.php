@extends("layout")
@section("content")

<head>
    <title>Exception policies | Time and Electronic Attendance Monitoring System</title>
</head>

      <h1>Exception Policy Group</h1>

@if ($errors->any())
  <ul>
    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
  </ul>
@endif
<div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('exception_policies') }}"  class="btn btn-default">Exception Policy</a>
            <a class="btn btn-default">Add Overtime policy</a>
        </div>
      
            <div class="row">
             <div class="col-md-4">
                  {{ Form::open(array('route' => 'exception_policies.store')) }}
      
            <div class="label_white">{{ Form::label('exceptiongroup_name', 'Exception Group Name:') }}</div>
            {{ Form::text('exceptiongroup_name', Input::get('exceptiongroup_name'), array('placeholder' => 'Exception Group name','autocomplete' => 'off', 'size' => '48')) }}<br>
    
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br><br>
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }} <br><br>

                  
          </div>
      
 
<!--<p>{{ link_to_route('exception_policies.create', 'Add new exception policy') }}</p>
-->
      <div class="col-md-8">
        
@if ($exception_policies->count())
         
      <div class="label_white"><table id="scroll" class="table table-bordered">
            
            <tbody class="bodytable">
              <tr>
                        <th>Active</th>
          
                        <th>Exception name</th>
                        <th>Severity</th>
                        <th>Grace</th>
                        <th>Watch window</th>
                        <th>E-mail notification</th>
          
                  </tr>
                  @foreach ($exception_policies as $exception_policy)
                  
                        <tr>
                              <td align="center">{{ Form::checkbox($exception_policy->id, $exception_policy->id)}} {{ $exception_policy->id }}</td>
                      
                              <td>{{{ $exception_policy->exception_name }}}</td>
                              
                                <td style = "color:black;">{{ Form::select($exception_policy->id.'exception_severity', array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High', 'Critical' => 'Critical'), array('style' => 'color:black;')) }}
                                </td>
                                
                                @if($exception_policy->id == 1 || $exception_policy->id == 2 || $exception_policy->id == 4 || $exception_policy->id == 5 || $exception_policy->id == 6 || $exception_policy->id == 7 || $exception_policy->id == 8 || $exception_policy->id == 9 || $exception_policy->id == 10 || $exception_policy->id == 12 || $exception_policy->id == 13 || $exception_policy->id == 14 || $exception_policy->id == 15)
                                <td>
                                
                                  {{ Form::text($exception_policy->id.'exception_grace', null, array('placeholder' => 'hh:mm:ss', 'size' => '10', 'class' => 'form-control')) }}
                                
                                </td>
                                <td>
                                  {{ Form::text($exception_policy->id.'exception_watchwindow', null, array('placeholder' => 'hh:mm:ss', 'size' => '10', 'class' => 'form-control')) }}
                                  
                                </td>
                                @else
                                <td></td><td></td>
                                @endif
                                <td style = "color:black;">
                                  {{ Form::select($exception_policy->id.'exception_emailnotification', array('Both' => 'Both', 'Superior' => 'Superior', 'Employee' => 'Employee'), array('style' => 'color:black;')) }}
                                </td>
                        </tr>
                  @endforeach
              </tbody>
                {{ Form::close() }}
            
      </table></div>
      
      </div>
      </div>
@else
      There are no exception policies
@endif
<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>
@stop
