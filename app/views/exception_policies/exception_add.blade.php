@extends("layout")
@section("content")

<div class="label_white"><table id="scroll" class="table table-bordered">
               <br><br>
           
              <tr>
                        <th>Active</th>
          
                        <th>Exception name</th>
                        <th>Severity</th>
                        <th>Grace</th>
                        <th>Watch window</th>
                        <th>E-mail notification</th>
          
                  </tr>
            {{ Form::open(array('url' => 'exception/edit', 'method' => 'post', 'autocomplete' => 'off')) }}
             {{Form::hidden('group_id', $exception_id)}}
                  @foreach ($exception_policies as $exception_policy)
                  
                        <tr>
                              <td align="center">{{ Form::checkbox($exception_policy->id, $exception_policy->id)}} {{ $exception_policy->id }}</td>
                      
                              <td>{{{ $exception_policy->exception_name }}}</td>
                              
                                <td style = "color:black;">{{ Form::select($exception_policy->id.'exception_severity', array('Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High', 'Critical' => 'Critical'), array('style' => 'color:black;')) }}
                                </td>
                                
                                @if($exception_policy->id == 1 || $exception_policy->id == 2 || $exception_policy->id == 4 || $exception_policy->id == 5 || $exception_policy->id == 6 || $exception_policy->id == 7 || $exception_policy->id == 8 || $exception_policy->id == 9 || $exception_policy->id == 10 || $exception_policy->id == 12 || $exception_policy->id == 13 || $exception_policy->id == 14 || $exception_policy->id == 15 )
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
                 </div>
                 </table>
               <input class = 'btn btn-info' type="submit" name="Insert" value="Insert">
                {{ Form::close() }}
            
      </div>
      

@stop