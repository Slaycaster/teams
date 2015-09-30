@extends("layout")
@section("content")
<head>
    <title>Approved Leave | Time and Electronic Attendance Monitoring System</title>
</head>
      <br><br><br>
  
<div class="container"> 

<h2>Absent Employees</h2>
<br>
<div class="label_white"><table class="table table-bordered">
	<thead>
		<tr style="color:white">
                <th>Photo</th>
                <th>Employee Name</th>
                <th>Department</th>
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