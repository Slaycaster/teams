@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Employee | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px">
    <h1 style = "margin-top:-2px;">Edit Employee</h1>
        
  </div>
{{ Form::model($employee, array('method' => 'PATCH', 'route' => array('employs.update', $employee->id), 'files' => true)) }}
    <ul>
           <div class = "col-md-4">
            <div class="label_white">{{ Form::label('employee_number', 'Employee Number:') }}<br>
            {{ $employee->employee_number }}
            {{ Form::hidden('employee_number', $employee->employee_number) }}
            <br></div>

            <div class="label_white">{{ Form::label('lname', 'Last name:') }}</div>
            {{ Form::text('lname',Input::get('lname'), array('placeholder' => 'Last Name','autocomplete' => 'off', 'size' => '35')) }}<br> 
        

        
            <div class="label_white">{{ Form::label('fname', 'First name:') }}</div>
            {{ Form::text('fname',Input::get('fname'), array('placeholder' => 'First Name','autocomplete' => 'off', 'size' => '35')) }}<br>
        

        
            <div class="label_white">{{ Form::label('midinit', 'Middle Initial:') }}</div>
            {{ Form::text('midinit',Input::get('midinit'), array('placeholder' => 'Middle Initial','autocomplete' => 'off', 'size' => '35')) }}<br>
        

        
            <div class="label_white">{{ Form::label('picture_path', 'Picture path:') }}</div>
            {{ Form::file('picture_path') }}<br>
        

        
            <div class="label_white">{{ Form::label('address', 'Address:') }}</div>
            {{ Form::text('street',Input::get('street'), array('placeholder' => 'No/Street','autocomplete' => 'off', 'size' => '35')) }}<br><br>
            {{ Form::text('barangay',Input::get('barangay'), array('placeholder' => 'Barangay/Subd.','autocomplete' => 'off', 'size' => '35')) }}<br><br>
            {{ Form::text('city',Input::get('city'), array('placeholder' => 'City/Municipality','autocomplete' => 'off', 'size' => '35')) }}<br>
            
        
        
            
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
            {{ Form::hidden('qr_code', $employee->employee_number) }}
            
            {{ QrCode::size(100)->generate($employee->employee_number); }}<br>
        
        </div>

        <div class="col-md-4">
            
            <div class="label_white">{{ Form::label('name', 'Department:') }}</div>
            {{ Form::select('department_id', $departments, Input::old('department_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
        

            
          
            <div class="label_white">{{ Form::label('contract_name', 'Employee Type:') }}</div>
            {{ Form::select('contract_id', $contracts, Input::old('contract_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
           
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
           {{ Form::select('level_id', $levels, Input::old('level_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
        </fieldset>
            </div>

            

            <div class="label_white">
                {{ Form::radio('permission', '2');}}
                {{ Form::label('permission', ' Administrator') }}
            </div>


   
            </fieldset>

           
            <div class="label_white">{{ Form::label('jobtitle_name', 'Jobtitle:') }}</div>
            {{ Form::select('jobtitle_id', $jobtitles, Input::old('jobtitle_id'), array('class' => 'btn btn-default dropdown-toggle')) }}
            <br><br>

        
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
        
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
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