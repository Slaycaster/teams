@extends("layout")
@section("content")

<head>
    <title>Create Employee | Time and Electronic Attendance Monitoring System</title>
</head>

 @if (Session::has('age_valid'))
        <div class="alert alert-danger">{{ Session::get('age_valid') }}</div>
    @endif
@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
  <div class="col-md-12" style="margin-bottom:15px">
    <h1 style = "margin-top:-2px;">Add Employee</h1>
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
              <a href="{{ URL::to('employs') }}"  class="btn btn-default">Employee</a>
            <a class="btn btn-default">Add Employee</a>
        </div>
  </div>

<!--will be used to show any messages -->

   

{{ Form::open(array('route' => 'employs.store', 'files' => true)) }}
    <ul>

        <div class = "col-md-4">
            <div class="label_white">{{ Form::label('employee_number', 'Employee Number:') }}
            {{ $emp_id }}
            {{ Form::hidden('employee_number', $emp_id) }}
            </div>
            <br>

            <div class="label_white">{{ Form::label('lname', 'Last name:') }}</div>
            {{ Form::text('lname',Input::get('lname'), array('placeholder' => 'Last Name','autocomplete' => 'off', 'size' => '35')) }}<br> 
        

        
            <div class="label_white">{{ Form::label('fname', 'First name:') }}</div>
            {{ Form::text('fname',Input::get('fname'), array('placeholder' => 'First Name','autocomplete' => 'off', 'size' => '35')) }}<br>
        

        
            <div class="label_white">{{ Form::label('midinit', 'Middle Initial:') }}</div>
            {{ Form::text('midinit',Input::get('midinit'), array('placeholder' => 'Middle Initial','autocomplete' => 'off', 'size' => '35')) }}<br>
        

        
            <div class="label_white">{{ Form::label('picture_path', 'Picture path:') }}</div>
            {{ Form::file('picture_path') }}<br>
        

        
            <div class="label_white">{{ Form::label('address', 'Address:') }}</div>
            {{ Form::text('street',Input::get('street'), array('placeholder' => 'Street','autocomplete' => 'off', 'size' => '35')) }}<br><br>
            {{ Form::text('city',Input::get('city'), array('placeholder' => 'City','autocomplete' => 'off', 'size' => '35')) }}<br><br>
            {{ Form::text('zipcode',Input::get('zipcode'), array('placeholder' => 'Zip Code','autocomplete' => 'off', 'size' => '35')) }}<br>
        
        
            
        </div>
        

        <div class = "col-md-4">

            <div class="label_white">{{ Form::label('date_of_birth', 'Date of birth:') }}</div>
            {{ Form::text('date_of_birth',Input::get('date_of_birth'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}<br>


            <div class="label_white">{{ Form::label('phone', 'Phone number:') }}</div>
            {{ Form::text('phone',Input::get('phone'), array('placeholder' => ' ex. 09991789756','autocomplete' => 'off', 'size' => '35')) }}<br>
        

        
            <div class="label_white">{{ Form::label('email', 'Email:') }}</div>
            {{ Form::text('email',Input::get('email'), array('placeholder' => ' ex. lorenz_viovicente@yahoo.com','autocomplete' => 'off', 'size' => '35')) }}<br>
        

        
            <div class="label_white">{{ Form::label('hire_date', 'Hire date:') }}</div>
            {{ Form::text('hire_date',Input::get('hire_date'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar2','placeholder' => 'yyyy-mm-dd')) }}<br>
    
        
            <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
            {{ Form::select('status', array('Active' => 'Active', 'Inactive' => 'Inactive','Leave-Illness/Injury'=>'Leave-Illness/Injury','Leave-Maternal/Parental'=>'Leave-Maternal/Parental','Leave-Other'=>'Leave-Other','Terminated'=>'Terminated')) }}<br>
        

        
            <div class="label_white">{{ Form::label('qr_code', 'Qr code:') }}</div>
            {{ Form::hidden('qr_code', $emp_id) }}
            
            {{ QrCode::size(100)->generate($emp_id); }}<br>
        
        </div>

        <div class="col-md-4">
            <fieldset class="field">
                <legend>Department</legend>
            <div class="label_white">{{ Form::label('name', 'Department:') }}</div>
            {{ Form::select('department_id', $departments, Input::old('department_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
        </fieldset>

            <fieldset class="field">
                <legend>Employee Type</legend>
            <div class="label_white">{{ Form::label('contract_name', 'Employee Type:') }}</div>
            {{ Form::select('contract_id', $contracts, Input::old('contract_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
            </fieldset>

        <div>
            <fieldset class="field">
                <legend>Hierarchy</legend>
            <div class="label_white">
                {{ Form::radio('permission', '0');}}
                {{ Form::label('permission', 'Staff') }}
            </div>


            
            <div class="label_white">
                {{ Form::radio('permission', '1');}}
                {{ Form::label('permission', ' Superior') }}
                <fieldset class = "hideit">
            <div class="label_white">{{ Form::label('level_id', 'Level :') }}</div>
            {{ Form::number('level_id',Input::get('level_id')) }}<br>
        </fieldset>
            </div>

            

            <div class="label_white">
                {{ Form::radio('permission', '2');}}
                {{ Form::label('permission', ' Administrator') }}
            </div>


   
            </fieldset>
        </div>
           <fieldset class="field">
                <legend>Jobtitle</legend>
            <div class="label_white">{{ Form::label('jobtitle_name', 'Jobtitle:') }}</div>
            {{ Form::select('jobtitle_id', $jobtitles, Input::old('jobtitle_id'), array('class' => 'btn btn-default dropdown-toggle')) }}
            </fieldset><br><br>
        

        
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        </div>
    </ul>

{{ Form::close() }}


<script type="text/javascript">
      $(".hideit").hide();

     $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="1"){
                $(".hideit").toggle(500);
       
            }
            else {
                $(".hideit").hide();
            }

        });
    });
</script>
<script type="text/javascript">
    $('#calendar').datepicker({
        format: "yyyy-mm-dd"
    });
</script>
<script type="text/javascript">
    $('#calendar2').datepicker({
        format: "yyyy-mm-dd"
    });
</script>
<script type="text/javascript">
    $('#calendar3').datepicker({
        format: "yyyy-mm-dd"
    });
</script>

@stop
