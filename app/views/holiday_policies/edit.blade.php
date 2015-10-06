@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Holiday policy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
        <h1>Edit Holiday policy</h1>
  </div>

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
 <ul>
           
        </ul>
{{ Form::model($holiday_policy, array('method' => 'PATCH', 'route' => array('holiday_policies.update', $holiday_policy->id))) }}
    <ul>
           <div class="label_white">{{ Form::label('holiday_name', 'Holiday Name:') }}</div>
                              {{ Form::text('holiday_name',Input::get('holiday_name'), array('placeholder' => 'Holiday Name','autocomplete' => 'off', 'size' => '40'))}}<br>
                          
                              <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
                              {{ Form::textarea('description') }}<br>
                            
                                </div>
        
                            <div class = "col-md-3">
                              <div class="label_white">{{ Form::label('default_schedule_status', 'Default Schedule Status:') }}</div>
                              {{ Form::select('default_schedule_status', array('Working' => 'Working', 'Non-working' => 'Not-Working')) }}<br>
                              <br>
                              <div class="label_white">{{ Form::label('holiday_type', 'Holiday Type:') }}</div>
                              {{ Form::select('holiday_type', array('Regular Holiday' => 'Regular Holiday', 'Special Non-working day' => 'Special Non-working day')) }}<br>      
                               
                              <div class="label_white">{{Form::label('recurring_holiday','Recurring:')}}
                              <!--{{Form::checkbox('recurring', 'true', false, ['id' => 'field'])}}!-->
                              <input type = "checkbox" id = "field" name = "recurring" value="true"><br></div>
                                

                              <div class="label_white">{{ Form::label('day_of_month', 'Day Of Month:') }}</div>
                              {{ Form::text('day_of_month', null, array('id' => 'dayofmonth')) }}<br>
                              
                              <div class="label_white">{{ Form::label('month', 'Month:') }}</div>
                              {{ Form::select('month', array('January' => 'January', 'February' => 'February', 'March' => 'March','April' => 'April','May' => 'May','June' => 'June','July' => 'July','August' => 'August','September' => 'September','October' => 'October','November' => 'November','December' => 'December')) }}
                             <fieldset  id="granted">
                              <div class="label_white">{{ Form::label('year', 'Year:') }}</div>
                              {{Form::selectYear('year',date('Y'), 2020)}}
                              </fieldset>
                              <br>
                              <div class="label_white">{{ Form::label('month', 'Branches:') }}</div>
                                {{ Form::select('branches', $branches, Input::old('branches'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi', 'multiple'=>'multiple', 'name' => 'branches[]')) }}

            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            <a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn">Cancel</a>
        
    </ul>
{{ Form::close() }}

<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>

<script type="text/javascript">
$("#multi").multiselect().multiselectfilter();

$('#levels_id').on('change', function(e){
    $(this).closest('form').submit();
});
</script>
<script>
document.getElementById("granted").disabled = false;
</script>

<script type="text/javascript">
var update_recurring = function () {
    if ($("#field").is(":checked")) {
        $("#granted").prop('disabled', 'disabled');
    }
    else {
        $("#granted").removeAttr("disabled");
    }
};

$(update_recurring);
$("#field").change(update_recurring);
/*$('#field').on('change', function(e){
    if($('#field').attr('checked')){
    document.getElementById("granted").disabled = true;}
   else
   {
    document.getElementById("granted").disabled = false;
  }
});
*/
</script>

@stop
