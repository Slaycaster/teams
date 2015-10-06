@extends("layout_employee")
@section("content")
      <br><br><br>
      <div class = "container">
            <div class = "row">
                  <div class = "col-md-9" >
                  @if (Session::has('messageb'))
         <div class="alert alert-warning">{{ Session::get('messageb') }}</div><br>
      @endif
                        <h1 style = "color:white;">File a Leave Request</h1>
                  </div>
            </div>
<div class = "container">

  <div class = "row">
    <div class = "col-md-3">
   
@if ($errors->any())
      <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
      </ul>
@endif
                        
                  {{ Form::open(array('route' => 'create_requests.store')) }}

            {{ Form::hidden('status','pending') }}<br>
        
            <h4>Request Date/Time:</h4>
            <div class="label_white">{{ Form::label('request_date', date("Y/m/d"). '/' . date("h:i:sa")) }}</div>
            {{ Form::hidden('request_date', date("Y/m/d"). '/' . date("h:i:sa")) }}
        
            <div class="label_white">{{ Form::label('request_type', 'Request type:') }}</div>
            {{ Form::select('request_type', $request_types, Input::old('request_type'), array('class' => 'btn btn-default dropdown-toggle')) }}<br><br>

       
                <div class="label_white">{{ Form::label('start_date', 'Start Date:') }}</div>
            {{ Form::text('start_date', Input::get('start_date'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendara','placeholder' => 'yyyy-mm-dd')) }}<br>
        

       
            <div class="label_white">{{ Form::label('end_date', 'End Date:') }}</div>
            {{ Form::text('end_date', Input::get('end_date'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendarb','placeholder' => 'yyyy-mm-dd')) }}<br>
             </div>
            
         <div class = "col-md-3">
            <br><br>
            <div class="label_white">{{ Form::label('message', 'Message:') }}</div>
            {{ Form::textarea('message') }}<br>

            {{ Form::hidden('employee_id', $id)}}
      
                  {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
            </div>
      
{{ Form::close() }}


              </div>
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

<script type="text/javascript">
    $('#calendara').datepicker({
        format: "yyyy-mm-dd"
    });
</script>
<script type="text/javascript">
    $('#calendarb').datepicker({
        format: "yyyy-mm-dd"
    });
</script>

=======
@stop
@stop