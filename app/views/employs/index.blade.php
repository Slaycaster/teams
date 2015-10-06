@extends("layout")
@section("content")

<head>
    <title>Employees | Time and Electronic Attendance Monitoring System</title>
</head>
<h1 style="margin-left:25px">Employee Maintenance</h1>
<div class="col-md-12" style="margin-top:5">
<br>
  <div class ="col-md-4">
    {{ $employees->links() }}
  </div>
	<div class = "col-md-3" style="margin-top:20px">
        <div id="custom-search-input">
          {{ Form::model(null, array('route' => array('employs.search'))) }}
                    <div class="input-group col-md-12">
                      {{ Form::text('query', null, array( 'class' => 'search-query form-control', 'placeholder' => 'Search for Employee Number or Name', 'autocomplete' => 'off')) }}
                        <span class="input-group-btn">

                                {{ Form::submit('Search', array('class' => 'btn btn-danger')) }}
                            
                        </span>
                    </div>
           {{ Form::close() }}         
        </div>
	</div>
</div>
<br>
<br>


<div class="container" style = "margin-left: -4%">
    <div class="row">
      <div class="col-md-7">
         <h3 style = "margin-left: 9%">Add Employee </h3>
         @if ($errors->any())
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif
                
            {{ Form::open(array('route' => 'employs.store', 'files' => true)) }}
          <ul>

        <div class="col-md-6">
            <fieldset class="field">
            <div class="label_white">{{ Form::label('employee_number', 'Employee Number:') }}
            {{ $emp_id }}
            {{ Form::hidden('employee_number', $emp_id) }}
            </div>
            <br>
              <legend>Personal Information</legend>
            <div class="label_white">{{ Form::label('lname', 'Last name:') }}</div>
            {{ Form::text('lname',Input::get('lname'), array('placeholder' => 'Last Name','autocomplete' => 'off', 'size' => '35')) }}<br> 
        

        
            <div class="label_white">{{ Form::label('fname', 'First name:') }}</div>
            {{ Form::text('fname',Input::get('fname'), array('placeholder' => 'First Name','autocomplete' => 'off', 'size' => '35')) }}<br>
        

        
            <div class="label_white">{{ Form::label('midinit', 'Middle Initial:') }}</div>
            {{ Form::text('midinit',Input::get('midinit'), array('placeholder' => 'Middle Initial','autocomplete' => 'off', 'size' => '35')) }}<br>
        
            <div class="label_white">{{ Form::label('date_of_birth', 'Date of birth:') }}</div>
            {{ Form::text('date_of_birth',Input::get('date_of_birth'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}<br>
        
            <div class="label_white">{{ Form::label('picture_path', 'Picture path:') }}</div>
            {{ Form::file('picture_path') }}<br>
            </fieldset>

            <div>
              <fieldset class="field">
              <legend>Address</legend>
           
              {{ Form::text('street',Input::get('street'), array('placeholder' => 'No/Street','autocomplete' => 'off', 'size' => '35')) }}<br><br>
              {{ Form::text('barangay',Input::get('barangay'), array('placeholder' => 'Barangay/Subd.','autocomplete' => 'off', 'size' => '35')) }}<br><br>
              {{ Form::text('city',Input::get('city'), array('placeholder' => 'City/Municipality','autocomplete' => 'off', 'size' => '35')) }}
              
              </fieldset><br>
            </div><br>
            <div>
              <fieldset class="field">
              <legend>Contact Information</legend>
                <div class="label_white">{{ Form::label('phone', 'Phone number:') }}</div>
                {{ Form::text('phone',Input::get('phone'), array('placeholder' => ' ex. 09991789756','autocomplete' => 'off', 'size' => '35')) }}<br>
        

        
                <div class="label_white">{{ Form::label('email', 'Email:') }}</div>
                {{ Form::text('email',Input::get('email'), array('placeholder' => ' ex. sampleaccount@yahoo.com','autocomplete' => 'off', 'size' => '35')) }}<br>
              </fieldset>
            </div>
        </div>
        <div class="col-md-1">
        </div>

      <div class="col-md-4">
        
              <div class="label_white">{{ Form::label('hire_date', 'Hire date:') }}</div>
                {{ Form::text('hire_date',Input::get('hire_date'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar2','placeholder' => 'yyyy-mm-dd')) }}<br>
    
        
                <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
                {{ Form::select('status', array('Active' => 'Active', 'Inactive' => 'Inactive','Leave-Illness/Injury'=>'Leave-Illness/Injury','Leave-Maternal/Parental'=>'Leave-Maternal/Parental','Leave-Other'=>'Leave-Other','Terminated'=>'Terminated')) }}<br>
        
              <div class="label_white">{{ Form::label('qr_code', 'Qr code:') }}</div>
              {{ Form::hidden('qr_code', $emp_id) }}
            
              {{ QrCode::size(100)->generate($emp_id); }}<br><br>
        
              <div class="label_white">{{ Form::label('name', 'Department:') }}</div>
              {{ Form::select('department_id', $departments_id, Input::old('department_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br><br>
        
              
              <div class="label_white">{{ Form::label('contract_name', 'Employee Type:') }}</div>
              {{ Form::select('contract_id', $contracts_id, Input::old('contract_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
             

        
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
                  {{ Form::select('level_id', $level_id, Input::old('level_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
                  </fieldset>
                  </div>
                  <div class="label_white">
                {{ Form::radio('permission', '2');}}
                {{ Form::label('permission', 'System Administrator') }}
                  </div>
              </fieldset>
      
              <div class="label_white">{{ Form::label('jobtitle_name', 'Jobtitle:') }}</div>
              {{ Form::select('jobtitle_id', $jobtitles_id, Input::old('jobtitle_id'), array('class' => 'btn btn-default dropdown-toggle')) }}
              <br><br>
  
              {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
              </ul>    
                {{ Form::close() }}
            
        </div>
      <div class="col-md-5">
         <h3 style = "margin-left: 5%">All Employees</h3>
                
          @foreach ($employees as $employee)
            <?php $emp_fname = preg_replace('/\s+/', '', $employee->fname); ?>
            <div class="col-md-6" style="margin-bottom:15px;">
  	         <div class="col-md-12 greytile" style="padding:4px;height:175px; width:200px; ">
    	           <div class="col-md-6" style="margin-top:25px;" >
                    <img style = "height:85px; width:85px;" src="{{URL::asset('employees').'/'.$employee->id.''.$employee->lname.''.$emp_fname.'.jpg'}}">
    	           </div>
    	           <div class="col-md-6" style="margin-left:0px; ">

                <p style="color:white; font-size:10px"> {{$employee->employee_number}}</p>
                  <p style="color:white; font-size:10px "> <strong>{{$employee->fname}}
                  {{ $employee->lname }}</strong></p>
      
                @foreach ($departments as $department)
                @if ($department->id == $employee->department_id)
                <p style="color:white; font-size:10px">{{  $department->name }}</p>
                @endif
                @endforeach
                @foreach ($jobtitles as $jobtitle)
                @if ($jobtitle->id == $employee->jobtitle_id)
                <p style="color:white; font-size:10px">{{  $jobtitle->jobtitle_name }}</p>
                @endif
                @endforeach
                <a href="{{ URL::to('employs/' . $employee->id) }}" onclick="window.open('{{ URL::to('employs/' . $employee->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('employs/' . $employee->id . '/edit') }}" onclick="window.open('{{ URL::to('employs/' . $employee->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
                </div>
            </div>
           </div>
           @endforeach
  </div>
</div>
</div>
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
