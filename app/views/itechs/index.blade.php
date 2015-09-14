@extends("layout")
@section("content")


<div class = "navbar navbar-default navbar-fixed-top">
            <div class = "container">
                               
                <a href="{{ URL::to('employee/dashboard') }}" class = "navbar-brand"><img style ="height:30px; margin-top:-4px;"src="{{ URL::asset('img/teams_pahalang.png') }}"/></a>
                               
                <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
                        <span class = "icon-bar"></span>
                        <span class = "icon-bar"></span>
                        <span class = "icon-bar"></span>
              	</button>
                               
                <div class = "collapse navbar-collapse navHeaderCollapse">

                		<ul class = "nav navbar-nav">
                            <li><a href = "{{ URL::to('itechs/index') }}">Utilities</a>
                            </li>		
                            
                        </ul>
                               
                        <ul class="nav navbar-nav navbar-right">
                          <li><a href="#">Hi, {{ $name }}</a></li>
                          
                          <li><a href="{{ URL::to('infotechs/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                          
     					</ul>
                </div>                               
            </div>
         </div>


<h1>All Employees</h1>

<div class="col-md-12" style="margin-top:5">
  <div class="col-md-4">
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('itechs/dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="#"  class="btn btn-default">Utilities</a>
            <a class="btn btn-default">All Employees</a>
        </div>
  </div>

<div class ="col-md-2">
    {{ $employs->links() }}
  </div>

	 <div class = "col-md-3">
        <div id="custom-search-input">
                    <div class="input-group col-md-12">
                        <input type="text" class="search-query form-control" placeholder="Search Employee" />
                        <span class="input-group-btn">
                            <button class="btn btn-danger" type="button">
                                <span class=" glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    
        </div>
	 </div>

</div>
<br><br>

<div class="label_white"><table class="table table-stripped">
		<thead  style="border: 1px solid white">
			<tr >
				<th style="text-align:center">User Picture</th>
				<th style="text-align:center">Username</th>
				<th style="text-align:center">Name</th>
				<th style="text-align:center">Password</th>
			</tr>
		</thead>
		
		<tbody align="center"> 
			@foreach ($employs as $employ)
			<?php $emp_fname = preg_replace('/\s+/', '', $employ->fname); ?>
            <tr>
 			<td >           	
            <img style = "height:75px; width:75px;" src="{{URL::asset('employees').'/'.$employ->id.''.$employ->lname.''.$emp_fname.'.jpg'}}">
    			</td>
              <td style=" font-size:15px ">{{  $employ->employee_number }}</td>

              <td style=" font-size:15px"> {{$employ->fname}}
           {{ $employ->lname }}</td>
               <td style=" font-size:15px"><strong>{{  $employ->password }}</strong></td>
            <tr>
           @endforeach
		</tbody>
	</div>


@stop
