@extends("layout_employee")
@section("content")

      <br><br><br>
      <div class = "container">
            <div class = "row">
                  
                  <div class = "col-md-9" >
                        <h1 style = "color:white;">Edit Request</h1>
                  </div>
            </div>

            <br>
            <br>
                  <div id="raleway" class="row">

                        
 {{ Form::model($create_request, array('method' => 'PATCH', 'route' => array('create_requests.update', $create_request->id))) }}

            {{ Form::hidden('status') }}<br>
            <h4>Request Date/Time:</h4>
            <div class="label_white">{{ Form::label('request_date', date("Y/m/d"). '/' . date("h:i:sa")) }}</div>
            {{ Form::hidden('request_date', date("Y/m/d"). '/' . date("h:i:sa")) }}
        
            <div class="label_white">{{ Form::label('request_type', 'Request type:') }}</div>
            {{ Form::select('request_type', $request_types, Input::old('request_type'), array('class' => 'btn btn-default dropdown-toggle')) }}<br><br>

       
            <div class="label_white">{{ Form::label('start_date', 'Start Date:') }}</div>
            {{ Form::text('start_date', Input::get('start_date'), array('placeholder' => 'yyyy-mm-dd','autocomplete' => 'off', 'size' => '40')) }}<br>
        

       
            <div class="label_white">{{ Form::label('start_time', 'Start_Time:') }}</div>
            {{ Form::text('start_time', Input::get('start_time'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}<br>
        

       
            <div class="label_white">{{ Form::label('end_date', 'End_Date:') }}</div>
            {{ Form::text('end_date', Input::get('end_date'), array('placeholder' => 'yyyy-mm-dd','autocomplete' => 'off', 'size' => '40')) }}<br>
        

       
            <div class="label_white">{{ Form::label('end_time', 'End_Time:') }}</div>
            {{ Form::text('end_time', Input::get('end_time'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}<br>
        

       
            <div class="label_white">{{ Form::label('message', 'Message:') }}</div>
            {{ Form::textarea('message') }}<br>

            {{ Form::hidden('employee_id', $id)}}


                  {{ Form::submit('Update', array('class' => 'btn btn-info')) }}<br>
                  {{ link_to_route('create_requests.show', 'Cancel', $create_request->id, array('class' => 'btn')) }}
      

{{ Form::close() }}

@if ($errors->any())
      <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
      </ul>
@endif

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