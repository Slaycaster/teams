@extends("layout-noheader")
@section("content")

<head>
    <title>Edit Policy Group | Time and Electronic Attendance Monitoring System</title>
</head>

<div class="col-md-12" style="margin-bottom:15px; margin-left:25px">
<h1>Edit Policy Group</h1>

</div>

{{ Form::model($policy_group, array('method' => 'PATCH', 'route' => array('policy_groups.update', $policy_group->id))) }}
	<ul>
        <div class = "col-md-6">
            <div class="label_white">{{ Form::label('policygroup_name', 'Policy Group name:') }}</div>
            {{ Form::text('policygroup_name') }}<br>
        

        
            <div class="label_white">{{ Form::label('description', 'Description:') }}</div>
            {{ Form::textarea('description') }}<br>

              <div class="label_white">{{ Form::label('exception_name', 'Exception name:') }}</div>
                {{ Form::select('exceptiongroup_id', $exception_groups, Input::old('exceptiongroup_id'), array('class' => 'btn btn-default dropdown-toggle')) }}<br><br>

              <div class="label_white">{{ Form::label('holiday', 'Holidays:') }}</div>
              @foreach($holiday as $holidays)
              <div class='label-white'>
                <p> {{ $holidays->holiday_name }}</p>
                 </div>
              @endforeach
                
              <div style='color:white'>
              {{ Form::radio('permission', '1');}}
              {{ Form::label('permission', 'Add Holiday') }}

              {{ Form::radio('permission', '2');}}
              {{ Form::label('permission', 'Delete Holiday') }}
              
              </div>

              <fieldset class = "hideit">
             <div class="label_white">{{ Form::label('holiday_name', 'Add Holiday:') }}</div>
              {{ Form::select('holiday_id', $holiday_policies, Input::old('holiday_id'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi3', 'multiple'=>'multiple', 'name' => 'holiday_id[]')) }}<br><br>
               </fieldset>

           
               <fieldset class = "hideit2">
               <div class="label_white">{{ Form::label('holiday_name', 'Delete Holiday:') }}</div>
              {{ Form::select('holiday_id_delete', $holiday_policies, Input::old('holiday_id'), array('class' => 'btn btn-default dropdown-toggle', 'id' => 'multi4', 'multiple'=>'multiple', 'name' => 'holiday_id_delete[]')) }}<br>

        		<br>
        		</fieldset>

               <br> <br>
               {{Form::hidden('policy_groupid', $policy_group->id)}}
            
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
      $(".hideit2").hide();

     $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="2"){
                $(".hideit2").toggle(500);
       
            }
            else {
                $(".hideit2").hide();
            }

        });
    });
</script>

<script type="text/javascript">
$("#multi3").multiselect().multiselectfilter();
$("#multi4").multiselect().multiselectfilter();

</script>
@stop
