@extends("layout")
@section("content")
<head>
    <title>Approved Leave | Time and Electronic Attendance Monitoring System</title>
</head>
    
  
<div class="container"> 

<h2>Absent Employees</h2>
<br>
{{ Form::open(array('url' => 'absent_employee', 'method' => 'post', 'autocomplete' => 'off')) }}
 <div class = 'col-md-2'>
<h4>Date Range:</h4><br>
</div>
      <div class = 'col-md-3' style="margin-left:-50px; margin-top:8px">
                {{ Form::text('date_from',Input::get('date_from'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar','placeholder' => 'yyyy-mm-dd')) }}
        </div>
                <div class = 'col-md-1' style="margin-left:-10px">
                <h4> to </h4>
                </div>
       
      <div class = 'col-md-3' style="margin-left:-50px; margin-top:8px">
                {{ Form::text('date_to',Input::get('date_to'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar1','placeholder' => 'yyyy-mm-dd')) }}
      </div>
       <div class = 'col-md-2'>
      {{ Form::submit('Submit', array('class' => 'btn btn-info', 'style'=>'margin-top:3px')) }}
      </div>

<br>
  {{Form::close()}}
<div class="label_white"><table class="table table-bordered">
	<thead>
		<tr style="color:white">
                <th>Photo</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Date of Absent</th>

		</tr>
	</thead>
 
	<tbody>
     @foreach ($absents as $absent)
		<tr style="color:white">
           
                                
         <?php $emp_fname = preg_replace('/\s+/', '', $absent->fname);?>
      <td><img style = "height:100px; width:100px;" src="{{URL::asset('employees').'/'.$absent->id.''.$absent->lname.''.$emp_fname.'.jpg'}}"></td>
      <td>{{{ $absent->lname}}}, {{{ $emp_fname}}}</td>

      @foreach ($departments as $department)
            @if ($department->id == $absent->department_id)
              <td>{{  $department->name }}</td>
            @endif
           @endforeach
           <td>{{{ $absent->date}}}</td>
      </tr>
        @endforeach

	</tbody>
</table></div>
            </div>


                </div>
            </div>
</div>
            <div class = "container" style = "position: fixed; bottom: 0px; width: 100%;  height: 60px; background-color: #2c3e50; padding: 25px 0; text-align:center;">
                  <p style = "color:white;">Copyright &copy; pending. Fare Matrix</p>
            </div>


<script type="text/javascript">
    $('#calendar').datepicker({
        format: "yyyy-mm-dd"
    });
</script>

<script type="text/javascript">
    $('#calendar1').datepicker({
        format: "yyyy-mm-dd"
    });
</script>

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