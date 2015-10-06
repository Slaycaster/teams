@extends("layout")
@section("content")
 
<head>
    <title>Exceptions | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-top:10px; margin-bottom:20px; margin-left:-40px">
<h1>Exception Policies</h1>
<div class ="col-md-4" style="margin-left:-15px">
  <div class="btn-group btn-breadcrumb">
              <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a class="btn btn-default">Exception</a>
            
    </div>
		
	</div>

<div class="col-md-4">

    {{ $exception_group->links() }}
  </div>
</div>

<div class="container" style="margin-top:80px">


   <div class = "row">
    <div class = "col-md-4" style="margin-left:-40px">
      <h3>Add Exception Group</h3>
                @if ($errors->any())
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif
            {{ Form::open(array('route' => 'exception_policies.store')) }}
      
            <div class="label_white">{{ Form::label('exceptiongroup_name', 'Exception Group Name:') }}</div>
            {{ Form::text('exceptiongroup_name', Input::get('exceptiongroup_name'), array('placeholder' => 'Exception Group name','autocomplete' => 'off', 'size' => '48')) }}<br>
    
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br><br>
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }} <br><br>

              </div>

           
               <div class="col-md-5">
        
         
      <div class="label_white"><table id="scroll" class="table table-bordered">
               <br><br>
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
              </tbody>
                {{ Form::close() }}
            
      </table></div>
      
      </div>
      



        <div class = "col-md-3" style="margin-left:30px">
          <br><br>
                  @foreach ($exception_group as $exception)
                  <?php $exceptiongroup_name = preg_replace('/\s+/', '', $exception->exceptiongroup_name); ?>

                  <div class="col-md-12" style="margin-bottom:5px">
                  	<div class="col-md-12 greytile" style="padding:5px">
                    	<div class="col-md-5" >
                           <img style = "height:80px; width:80px; margin-top:12px" src="{{ URL::asset('img/PremiumPolicy.png') }}">
                    	</div>
                    	<div class="col-md-7" style="margin-left:0px">

                           <p style="color:white; font-size:12px"> {{$exception->exceptiongroup_name}}
                         
                           <p style="color:white; font-size:12px"> <strong>{{$exception->description}}
                           </strong></p>
                       
                           <a href="{{ URL::to('exception_policies/' . $exception->id) }}" onclick="window.open('{{ URL::to('exception_policies/' . $exception->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('exception_policies/' . $exception->id . '/edit') }}" onclick="window.open('{{ URL::to('exception_policies/' . $exception->id . '/edit') }}', 'newwindow', 'width=1860, height=720'); return false;">Edit</a>
                       </div>

     </div>
  <br><br><br><br><br>
  </div>
	@endforeach 
</div>
</div>
</div>

<script type="text/javascript">
    window.onload = function() {
    if(!window.location.hash) {        
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
</script>

<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>

@stop

