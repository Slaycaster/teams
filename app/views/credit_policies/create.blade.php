@extends("layout")
@section("content")
 
<head>
    <title>Create Credit Policy | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12"  style="margin-bottom:15px; margin-left:-15px">

        <h1>Create Credits Policy</h1>

        @if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('credit_policies') }}"  class="btn btn-default">Credit Policies</a>
            <a class="btn btn-default">Add Credit Policy</a>
        </div>
  </div>



                @if($leave_type = 0)
                     {{ Form::hidden('able', 'enable') }}
                @else
                     {{ Form::hidden('able', 'disable') }}
                @endif

{{ Form::open(array('route' => 'credit_policies.store')) }}
        <div class="col-md-12">
           
                <div class="label_white">
                {{ Form::label('name', 'Credit Policy Name:')}}</div>
                {{ Form::text('name', Input::get('name'), array('placeholder' => 'credit policy name','autocomplete' => 'off', 'size' => '40')) }}<br>
                <div class="label_white">
                {{ Form::label('description', 'Description:')}}</div>
                {{ Form::text('description', Input::get('description'), array('placeholder' => 'description','autocomplete' => 'off', 'size' => '40')) }}<br>
                 <div class="label_white">
                {{ Form::label('leave_type', 'Leave Type:')}}</div>
                <div class="label_white">
                     {{ Form::radio('leave_type', '0');}}
                     {{ Form::label('leave_type', ' Granted') }}
                     {{ Form::radio('leave_type', '1');}}
                     {{ Form::label('leave_type', ' Accrued') }}
                     {{Form::radio('leave_type','2');}}
                     {{ Form::label('leave_type', ' Grant by demand') }}
                </div>
                <fieldset class="hideit">
                <fieldset class="field">
                <div class="label_white">
                    
                {{ Form::label('credit_reset', 'Credit reset based on:')}}</div>
                <legend>Granted</legend>
                <div class="label_white">
                     {{ Form::radio('credit_reset', '5');}}
                     {{ Form::label('credit_reset', ' Hire Basis') }}
                     {{ Form::radio('credit_reset', '4');}}
                     {{ Form::label('credit_reset', ' Preset Basis') }}
                 
                </div>
            
                 <div class="label_white">
                {{ Form::label('preset_basis`', 'Preset Basis:')}}</div>
                <fieldset class="hideit4">
                    
                {{ Form::text('preset_basis', Input::get('preset_basis'), array('placeholder' => 'yyyy/mm/dd','autocomplete' => 'off', 'size' => '60')) }}
            </fieldset>

                <div class="label_white">
                {{ Form::label('withdrawable', 'Withdrawable:')}}</div>
                <div class="label_white">
                     {{ Form::radio('withdrawable', 'yes');}}
                     {{ Form::label('withdrawable', ' Yes') }}
                     {{ Form::radio('withdrawable', 'no');}}
                     {{ Form::label('withdrawable', ' No') }}
                </div>
            </fieldset>
        </fieldset>
            <fieldset class="hideit2">
                <fieldset class="field">
                 <div class="label_white">
                
                {{ Form::label('frequency', 'Frequency:')}}</div>
                <legend>Accrued</legend>
                <div class="label_white">
                     {{ Form::radio('frequency', 'Pay Period');}}
                     {{ Form::label('frequency', ' Pay Period') }}
                     {{ Form::radio('frequency', 'Monthly');}}
                     {{ Form::label('frequency', ' Monthly') }}
                     {{ Form::radio('frequency', 'Annually');}}
                     {{ Form::label('frequency', ' Annually') }}
                     {{ Form::radio('frequency', 'Weekly');}}
                     {{ Form::label('frequency', ' Weekly') }}
                     <div class="label_white">
                     {{ Form::radio('credit_reset', '5');}}
                     {{ Form::label('credit_reset', ' Hire Basis') }}
                     {{ Form::radio('credit_reset', '4');}}
                     {{ Form::label('credit_reset', ' Preset Basis') }}
                 
                </div>
                <fieldset class="hideit4">
                 <div class="label_white">
                {{ Form::label('preset_basis`', 'Preset Basis:')}}</div>
                {{ Form::text('preset_basis', Input::get('preset_basis'), array('placeholder' => 'yyyy/mm/dd','autocomplete' => 'off', 'size' => '60')) }}
            </fieldset>
                
                <div class="label_white">
                {{ Form::label('withdrawable', 'Withdrawable:')}}</div>
                <div class="label_white">
                     {{ Form::radio('withdrawable', 'yes');}}
                     {{ Form::label('withdrawable', ' Yes') }}
                     {{ Form::radio('withdrawable', 'no');}}
                     {{ Form::label('withdrawable', ' No') }}
                </div>
                <div class="label_white">{{ Form::label('start_value', 'Start value :') }}</div>
                 {{ Form::number('start_value',Input::get('start_value'), array('placeholder' => '00','autocomplete' => 'off', 'size' => '20')) }}<br>
                 <div class="label_white">{{ Form::label('rate', 'Rate :') }}</div>
                 {{ Form::number('rate',Input::get('rate'), array('placeholder' => '00','autocomplete' => 'off', 'size' => '20')) }}<br>

                </fieldset>
            </fieldset>
                
                
         
                 
            <fieldset class="hideit3">
                <fieldset class="field">
                    <legend>Grant by Demand</legend>
                 <div class="label_white">{{ Form::label('allowed_leaves', 'Allowed Leaves :') }}</div>
                 {{ Form::number('allowed_leaves',Input::get('allowed_leaves'), array('placeholder' => '00','autocomplete' => 'off', 'size' => '20')) }}<br><br>

                     
                </fieldset>
            </fieldset>
       <br><br>
        </div>
       
       {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        </div>

    
        
 
    </ul>
{{ Form::close() }}  

<script type="text/javascript">
      $(".hideit").hide();

     $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="0"){
                $(".hideit").toggle(500);
                $(".hideit2").hide();
                $(".hideit3").hide();
       
            }
            if($(this).attr("value")=="1"){
                $(".hideit2").toggle(500);
                $(".hideit").hide();
                $(".hideit3").hide();
            }
            if($(this).attr("value")=="2"){
                $(".hideit3").toggle(500);
                $(".hideit").hide();
                $(".hideit2").hide();
            }
            

        });
    });
</script>
<script type="text/javascript">
      $(".hideit2").hide();

     
</script>
<script type="text/javascript">
      $(".hideit3").hide();

</script>

<script type="text/javascript">
      $(".hideit4").hide();

     $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="4"){
                $(".hideit4").toggle(500);
       
            }
            else {
                $(".hideit4").hide();
            }

        });
    });
</script>


@stop


