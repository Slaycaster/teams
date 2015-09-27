@extends("layout-noheader")
@section("content")

<head>
    <title>Assign Overtime | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Show Assign Overtime</h1>



<div class="col-md-6">
    <div class="col-md-12" style="padding:5px">
      <div class="col-md-4" >
          <img style = "height:100px; width:100px;" src="{{ URL::asset('img/Kiosk.png') }}">
      </div>
      <div class="col-md-8" style="margin-left:0px">
       <p style="color:white; font-size:30px"> <strong>{{$assign_overtime->name}}</strong></p>
      
     
       </div>
     </div>
     <hr style="display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;">
    

    <div class="col-md-12" style="margin-left:-15px">
      <h4 style="color:white"> From:</h4>
     </div>
     <div class="col-md-12">
      <div class="col-md-9">
        <h5 style="color:white"> {{$assign_overtime->range_from}}</h5>
      </div>
     </div>
    </div>

    <div class="col-md-12">
      <h4 style="color:white"> To:</h4>
     </div>
     <div class="col-md-12">
      <div class="col-md-9">
        <h5 style="color:white"> {{$assign_overtime->range_to}}</h5>
      </div>
     </div>
     
     <div class="label_white"><table class="table table-bordered">
            <thead>
              <tr>
                <th>Employees</th>
                <th>Name</th>
          
              </tr>
            </thead>

            <tbody>
            @for ($i=0; $i < 1; $i++)
              @foreach ($employee_lists[$i] as $employee_list) 
                <?php $emp_fname = preg_replace('/\s+/', '', $employee_list->fname);?>
                <td><img style = "height:100px; width:100px;" src="{{URL::asset('employees').'/'.$employee_list->id.''.$employee_list->lname.''.$emp_fname.'.jpg'}}"></td>
                <td>{{{ $employee_list->lname}}}, {{{ $emp_fname}}}</td>
                  
                                          
              </tr>
               @endforeach
            @endfor
            </tbody>
          </table>
          </div>

      
 <a  style="margin-left:20px" href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>



@stop