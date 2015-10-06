@extends("layout")
@section("content")
<head>
    <title>Absent Employees | Time and Electronic Attendance Monitoring System</title>
</head>
      
<div class="container"> 

<h1>Absent Employees</h1>
<br>
<div class = "row">

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
  {{Form::close()}}
</div>
<hr>

 <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Employees</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>

 <table class="table">
                <thead>
                    <tr class="filters">
                    
                        <th></th>

                        <th><input type="text" class="form-control" placeholder="Employee Name"></th>
                        <th><input type="text" class="form-control" placeholder="Department"></th>
                        <th><input type="text" class="form-control" placeholder="Date of Absent"></th>
                    
                    </tr>
                </thead>
 
	<tbody>
     @foreach ($absents as $absent)
		<tr>
           
                                
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