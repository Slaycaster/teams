@extends("layout")
@section("content")

<head>
    <title>Assign Overtime | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px">
	<h1>Assign Overtime</h1>

	<div class ="col-md-4">
    	{{ $assign_overtimes->links() }}
  	</div>
  	<div class="col-md-4">
  	</div>
</div>


<div class = "col-md-12">
		<div class = "col-md-6">
			<h3>Choose Overtime Policy</h3>
			<hr>
			@if ($errors->any())
                    <ul>
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                @endif
			{{ Form::open(array('route' => 'assign_overtimes.store')) }}
				<div class="label_white">
				  <button class="btn btn-info" onclick="granted(); return false;"value="0">Overtime Policies</button>
				 
				 <button class="btn btn-info" onclick="accrued(); return false;" value="1">Custom</button>
				 
				</div>
				<br>
			<div>
				<fieldset class="field" id="Granted">


				<div class="label_white">
					{{ Form::label('layout', ' Overtime Policies') }}
				</div>
					 {{ Form::select('overtime_id', $overtime_policies, Input::old('<br>overtime_id'), array('class' => 'btn btn-default dropdown-toggle')) }}

			</fieldset>
			</div>
			<br>
			<fieldset class="field" id="Accrued">
        
            <div class="label_white">{{ Form::label('active_after', 'Active After (Hours) from Daily Scheduled time') }}</div>
            
            {{ Form::number('active_after', Input::get('active_after'), array('placeholder' => '0','autocomplete' => 'off', 'size' => '40')) }}<br><br>

            <div class="label_white">{{ Form::label('Allowed_number_of_hours', 'Allowed number of hours:') }}</div>
            {{ Form::number('Allowed_number_of_hours', Input::get('Allowed_number_of_hours'), array('placeholder' => '0','autocomplete' => 'off', 'size' => '40')) }}<br><br>
				</fieldset>
				<div class="label_white">{{ Form::label('name', 'Assign Overtime name:') }}</div>
            		{{ Form::text('name',Input::get('name'), array('placeholder' => 'Assign Overtime Name','autocomplete' => 'off', 'size' => '50' ,'id'=> 'Granted')) }}<br>
				
				<br>
				<div class="label_white">
					{{Form::label('layout','Employees')}}
				</div>
				<div class="label_white">
					
					{{ Form::select('employees', $employees, Input::old('employees'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'employees[]')) }}
					
				</div>
				<br>
				<div class="label_white">
					{{Form::label('layout','Effective Date')}}
				</div>
				<div class="label_white">
					{{Form::label('layout','From:')}}
				</div>
					{{ Form::text('range_from',Input::get('range_from'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar2','placeholder' => 'yyyy-mm-dd')) }}<br>
				<div class="label_white" >
					{{Form::label('layout','To:')}}
				</div>
					{{ Form::text('range_to',Input::get('range_to'), array('autocomplete' => 'off', 'size' => '35','id' => 'calendar3','placeholder' => 'yyyy-mm-dd')) }}<br><br>
				
				<br>
				 {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
				 {{ Form::close() }}
		</div>
		<div class="col-md-6">
			<h3>All Assigned Overtimes</h3><hr>
			@foreach ($assign_overtimes as $assign_overtime)
			<div class="col-md-5" style="margin-bottom:5px">
        		
        		<div class="col-md-12 greytile" style="padding:5px">
          			<div class="col-md-5">
          				<img style = "height:75px; width:75px;" src="{{ URL::asset('img/Kiosk.png') }}">
          			</div>
          			<div class="col-md-7">
          				<p style="color:white; font-size:14px"> <strong>{{$assign_overtime->name}}</strong><br>
          					<a href="{{ URL::to('assign_overtimes/' . $assign_overtime->id) }}" onclick="window.open('{{ URL::to('assign_overtimes/' . $assign_overtime->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a> | <a href="{{ URL::to('assign_overtimes/' . $assign_overtime->id . '/edit') }}" onclick="window.open('{{ URL::to('assign_overtimes/' . $assign_overtime->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
          			</div>
                </div>
           </div>
         @endforeach
		</div>
	</div>

</div>
</div>

<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();
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

<script>
document.getElementById("Granted").disabled = true;
document.getElementById("Accrued").disabled = true;


function granted() {
    document.getElementById("Granted").disabled = false;
    document.getElementById("Accrued").disabled = true;
}

function accrued() {
    document.getElementById("Granted").disabled = true;
    document.getElementById("Accrued").disabled = false;
   
}
</script>

@stop
