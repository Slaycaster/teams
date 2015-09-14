@extends("layout")
@section("content")


<head>
    <title>DTR Manual Edit | Time and Electronic Attendance Monitoring System</title>
</head>

<h1>Daily Time Record Manual Edit</h1>

<div class="row">
	<div class="col-md-12" style="margin-top:40px" align="center">
		<div class="col-md-4">
			<div class="label_white">
			{{ Form::label('layout', ' Select an Employee:') }} </div>
			{{ Form::select('employs_id',$employs_id, Input::old('employs_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br>
		</div>
		<div class="col-md-8">
			
			<div class="col-md-2">

				<div class="label_white">{{ Form::label('layout', ' Month:') }}</div>
				{{ Form::selectMonth('month', array('class' => 'btn btn-default dropdown-toggle'))}}<br>
			</div>

			<div class="col-md-3">
				<div class="label_white">
			
				{{ Form::label('layout', ' Year:') }}  </div>
				{{ Form::selectRange('year', 1995, 2050 , array('class' => 'btn btn-default dropdown-toggle'))}}<br>
			</div>
		</div>
	</div>
</div>
<br><br>
<div class="container">
	<div class="col-md-12">
		<div class="col-md-9">
			<div class="col-md-5">
        <div id="custom-search-input">
          {{ Form::model(null, array('route' => array('employs.search'))) }}
                    <div class="input-group col-md-12">
                      {{ Form::text('query', null, array( 'class' => 'search-query form-control', 'placeholder' => 'Search for Employee No. or Name', 'autocomplete' => 'off')) }}
                        <span class="input-group-btn">

                                {{ Form::submit('Search', array('class' => 'btn btn-danger')) }}
                            
                        </span>
                    </div>
           {{ Form::close() }}         
        </div>
			</div>
		</div>
		<div class="col-md-3">
		</div>
	</div>
</div>
<br><br>
<h3>Daily Time Record - Search Results</h3>

<div class="container" align="center">
    <div class="row col-md-8 col-md-offset-2 custyle">
    <table class="table table-striped custab">
    <thead>
        <tr>
            <th style="color:white">DTR Record(Month/Year/Empno)</th>
            <th style="color:white">Year</th>
            <th style="color:white">Month</th>
            <th style="color:white">Employee</th>
            <th class="text-center" style="color:white">Action</th>
        </tr>
    </thead>
            <tr>
                <td>DTR-JUN15-00001</td>
                <td>2015</td>
                <td>June</td>
                <td>Denimar Fernandez</td>
                <td class="text-center"><a class='btn btn-info btn-xs' href="#"><span class="glyphicon glyphicon-edit"></span> View</a></td>
            </tr>
    </table>
    </div>
</div>


@stop