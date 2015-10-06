@extends("layout")
@section("content")

<head>
    <title>Schedules | Time and Electronic Attendance Monitoring System</title>
</head>



<div class="col-md-12">
  <h1>Schedule Maintenance</h1>
    <div class="col-md-2">
  </div>

  <div class ="col-md-4">
    {{ $schedules->links() }}
  </div>

</div>

<div class="container">
  <div class = "row">
    <div class = "col-md-7">
        <h3>Add a Schedule</h3><hr>
        @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message')) }}
        </ul>
        @endif
        {{ Form::open(array('route' => 'schedules.store')) }}
        
            <div class = "row">
              <div class = "col-md-6">
                <div class="label_white">{{ Form::label('schedule_name', 'Schedule name:') }}</div>
                {{ Form::text('schedule_name', Input::get('schedule_name'), array('placeholder' => 'Schedule name','autocomplete' => 'off', 'size' => '40')) }}
              </div>
              <div class = "col-md-6">
                <div class="label_white">{{ Form::label('description', 'Description: (optional)') }}</div>
                {{ Form::text('description', null, array('size' => '40')) }}<br>
              </div>
            </div>
            <br>
        
            <fieldset class="field">
                <legend>Schedules</legend>
             <div class="panel with-nav-tabs panel-primary">   
            <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Monday</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Tuesday</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Wednesday</a></li>
                            <li><a href="#tab4primary" data-toggle="tab">Thursday</a></li>
                            <li><a href="#tab5primary" data-toggle="tab">Friday</a></li>
                            <li><a href="#tab6primary" data-toggle="tab">Saturday</a></li>
                            <li><a href="#tab7primary" data-toggle="tab" style="background-color:red;">Sunday</a></li>
                        </ul>
                </div>
            
                <div class="panel-body">
                    <div class="tab-content">
                        
                        <div class="tab-pane fade in active" id="tab1primary" >
                            <div>{{ Form::label('m_timein', 'Monday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('m_timein', Input::get('m_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                            
                            <div>{{ Form::label('m_timeout', 'Monday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('m_timeout', Input::get('m_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>

                            <input type="checkbox" name="copytoallm" onclick="CopyThisM(this.form)">
                                <em>Check this box if you want to apply to all days.</em>
                            
                                     <div>{{ Form::label('Break:')  }}  <button type="button" id="show3">+
                                    </button>
                                    </div>
                                   
                                    <fieldset class = "hideit3">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insMon1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                            </div>     
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsMon1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                    </div>
                                        {{ Form::hidden('day','Monday') }}
                                        <br>  <button type="button" id="show4">+
                                    </button> <button type="reset" id="hide3">-
                                    </button>
                                    </fieldset> 

                                    <fieldset class = "hideit4">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insMon2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                                   </div>          
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsMon2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                        </div>
                                        {{ Form::hidden('day','Monday') }}
                                        <br>  <button type="button" id="show5">+
                                    </button> <button type="reset" id="hide4">-
                                    </button>          
                                    </fieldset>  

                                     <fieldset class = "hideit5">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insMon3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>              
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsMon3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>
                                        {{ Form::hidden('day','Monday') }}
                                        <br>   <button type="reset" id="hide5">-
                                    </button>          
                                    </fieldset> 
                            
                                                    
                        </div>
                        <div class="tab-pane fade" id="tab2primary"> 


                                    <div>{{ Form::label('t_timein', 'Tuesday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('t_timein', Input::get('t_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div>{{ Form::label('t_timeout', 'Tuesday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('t_timeout', Input::get('t_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>

                            <input type="checkbox" name="copytoallt" onclick="CopyThisT(this.form)">
                                <em>Check this box if you want to apply to all days.</em>
                                

                                    <div>{{ Form::label('Break:')  }}  <button type="button" id="show6">+
                                    </button>
                                    </div>
                                   
                                    <fieldset class = "hideit6">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insTue1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                            </div>     
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsTue1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                    </div>
                                        {{ Form::hidden('day','Tuesday') }}
                                        <br>  <button type="button" id="show7">+
                                    </button> <button type="reset" id="hide6">-
                                    </button>
                                    </fieldset> 

                                    <fieldset class = "hideit7">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insTue2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                                   </div>          
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsTue2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                        </div>
                                        {{ Form::hidden('day','Tuesday') }}
                                        <br>  <button type="button" id="show8">+
                                    </button> <button type="reset" id="hide7">-
                                    </button>          
                                    </fieldset>  

                                     <fieldset class = "hideit8">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insTue3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>              
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsTue3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>
                                        {{ Form::hidden('day','Tuesday') }}
                                        <br>   <button type="reset" id="hide8">-
                                    </button>          
                                    </fieldset>

                        </div>
                        <div class="tab-pane fade" id="tab3primary">


                                     <div>{{ Form::label('w_timein', 'Wednesday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('w_timein', Input::get('w_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div>{{ Form::label('w_timeout', 'Wednesday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('w_timeout', Input::get('w_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>

                            <input type="checkbox" name="copytoallw" onclick="CopyThisW(this.form)">
                                <em>Check this box if you want to apply to all days.</em>
                        

                                    <div>{{ Form::label('Break:')  }}  <button type="button" id="show9">+
                                    </button>
                                    </div>
                                   
                                    <fieldset class = "hideit9">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insWed1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                            </div>     
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsWed1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                    </div>
                                        {{ Form::hidden('day','Wednesday') }}
                                        <br>  <button type="button" id="show10">+
                                    </button> <button type="reset" id="hide9">-
                                    </button>
                                    </fieldset> 

                                    <fieldset class = "hideit10">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insWed2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                                   </div>          
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsWed2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                        </div>
                                        {{ Form::hidden('day','Wednesday') }}
                                        <br>  <button type="button" id="show11">+
                                    </button> <button type="reset" id="hide10">-
                                    </button>          
                                    </fieldset>  

                                     <fieldset class = "hideit11">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insWed3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>              
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsWed3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>
                                        {{ Form::hidden('day','Wednesday') }}
                                        <br>   <button type="reset" id="hide11">-
                                    </button>          
                                    </fieldset>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">

                                    <div>{{ Form::label('th_timein', 'Thursday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('th_timein', Input::get('th_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div>{{ Form::label('th_timeout', 'Thursday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('th_timeout', Input::get('th_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>

                                <input type="checkbox" name="copytoallth" onclick="CopyThisTh(this.form)">
                                <em>Check this box if you want to apply to all days.</em>
                        
                                    <div>{{ Form::label('Break:')  }}  <button type="button" id="show12">+
                                    </button>
                                    </div>
                                   
                                    <fieldset class = "hideit12">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insThu1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                            </div>     
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsThu1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                    </div>
                                        {{ Form::hidden('day','Thursday') }}
                                        <br>  <button type="button" id="show13">+
                                    </button> <button type="reset" id="hide12">-
                                    </button>
                                    </fieldset> 

                                    <fieldset class = "hideit13">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insThu2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                                   </div>          
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsThu2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                        </div>
                                        {{ Form::hidden('day','Thursday') }}
                                        <br>  <button type="button" id="show14">+
                                    </button> <button type="reset" id="hide13">-
                                    </button>          
                                    </fieldset>  

                                     <fieldset class = "hideit14">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insThu3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>              
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsThu3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>
                                        {{ Form::hidden('day','Thursday') }}
                                        <br>   <button type="reset" id="hide14">-
                                    </button>          
                                    </fieldset>
                        </div>
                        <div class="tab-pane fade" id="tab5primary">
                           


                                    <div>{{ Form::label('f_timein', 'Friday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('f_timein', Input::get('f_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div>{{ Form::label('f_timeout', 'Friday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('f_timeout', Input::get('f_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                                    <input type="checkbox" name="copytoallf" onclick="CopyThisF(this.form)">
                                <em>Check this box if you want to apply to all days.</em>

                                    <div>{{ Form::label('Break:')  }}  <button type="button" id="show15">+
                                    </button>
                                    </div>
                                   
                                    <fieldset class = "hideit15">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insFri1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                            </div>     
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsFri1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                    </div>
                                        {{ Form::hidden('day','Frirsday') }}
                                        <br>  <button type="button" id="show16">+
                                    </button> <button type="reset" id="hide15">-
                                    </button>
                                    </fieldset> 

                                    <fieldset class = "hideit16">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insFri2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                                   </div>          
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsFri2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                        </div>
                                        {{ Form::hidden('day','Friday') }}
                                        <br>  <button type="button" id="show17">+
                                    </button> <button type="reset" id="hide16">-
                                    </button>          
                                    </fieldset>  

                                     <fieldset class = "hideit17">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insFri3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>              
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsFri3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>
                                        {{ Form::hidden('day','Friday') }}
                                        <br>   <button type="reset" id="hide17">-
                                    </button>          
                                    </fieldset>

                        </div>
                        <div class="tab-pane fade" id="tab6primary">

                                    <div>{{ Form::label('sat_timein', 'Saturday time-in:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('sat_timein', Input::get('sat_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div>{{ Form::label('sat_timeout', 'Saturday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('sat_timeout', Input::get('sat_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>

                                <input type="checkbox" name="copytoallsat" onclick="CopyThisSat(this.form)">
                                <em>Check this box if you want to apply to all days.</em>
                        
                                                <div>{{ Form::label('Break:')  }}  <button type="button" id="show18">+
                                    </button>
                                    </div>
                                   
                                    <fieldset class = "hideit18">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insSat1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                            </div>     
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsSat1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                    </div>
                                        {{ Form::hidden('day','Saturday') }}
                                        <br>  <button type="button" id="show19">+
                                    </button> <button type="reset" id="hide18">-
                                    </button>
                                    </fieldset> 

                                    <fieldset class = "hideit19">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insSat2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                                   </div>          
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsSat2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                        </div>
                                        {{ Form::hidden('day','Saturday') }}
                                        <br>  <button type="button" id="show20">+
                                    </button> <button type="reset" id="hide19">-
                                    </button>          
                                    </fieldset>  

                                     <fieldset class = "hideit20">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insSat3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>              
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsSat3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>
                                        {{ Form::hidden('day','Saturday') }}
                                        <br>   <button type="reset" id="hide20">-
                                    </button>          
                                    </fieldset>
                        </div>
                        <div class="tab-pane fade" id="tab7primary">

                                    {{ Form::label('sun_timein', 'Sunday time-in:') }}
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('sun_timein', Input::get('sun_timein'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>
                        
                            <div>{{ Form::label('sun_timeout', 'Sunday time-out:') }}</div>
                            <div class="input-group clockpicker" style = "background-color:white;">
                            {{ Form::text('sun_timeout', Input::get('sun_timeout'), array('placeholder' => '00:00:00','autocomplete' => 'off', 'size' => '40')) }}</div><br>

                                <input type="checkbox" name="copytoallsun" onclick="CopyThisSun(this.form)">
                                <em>Check this box if you want to apply to all days.</em>

                                    <div>{{ Form::label('Break:')  }}  <button type="button" id="show">+
                                    </button>
                                    </div>
                                   
                                    <fieldset class = "hideit">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insSun1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                            </div>     
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsSun1', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                    </div>
                                        {{ Form::hidden('day','Sunday') }}
                                        <br>  <button type="button" id="show1">+</button> 
                                        <button type="reset" id="hide">-</button>
                                    </fieldset> 

                                    <fieldset class = "hideit1">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insSun2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                                   </div>          
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsSun2', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                        </div>
                                        {{ Form::hidden('day','Sunday') }}
                                        <br>  <button type="button" id="show2">+
                                    </button> <button type="reset" id="hide1">-
                                    </button>          
                                    </fieldset>  

                                     <fieldset class = "hideit2">
                                        <div style="color:black">{{ Form::label('break_in', 'Break in:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_insSun3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>              
                                        <div style="color:black">{{ Form::label('break_out', 'Break out:') }}</div>
                                         <div class="input-group clockpicker" style = "background-color:white; color:black">
                                        {{ Form::text('break_outsSun3', null, array('placeholder' => 'hh:mm:ss','autocomplete' => 'off', 'size' => '40')) }}<br>
                                             </div>
                                        {{ Form::hidden('day','Sunday') }}
                                        <br>   <button type="reset" id="hide2">-
                                    </button>          
                                    </fieldset>  
                        </div>
                    </div>
                    {{ Form::checkbox('break_punches', 'Yes') }}
                    {{ Form::label('lbl_break_punches', 'Include break punches?') }}
                    </div>

            </fieldset>
            <br><br>
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        
        {{ Form::close() }}
    </div>
    <div class = "col-md-4">
      <h3>All Schedules</h3><hr>
      @foreach ($schedules as $schedule)
      
        <div class="col-md-12 greytile" style="padding:5px">
          <div class="col-md-2" >
              <br>  <img style = "height:50px; width:50px; margin-top:-17px;  margin-left:-05px" src="{{ URL::asset('img/Calendars.png') }}">
          </div>
          <div class="col-md-10" style="margin-left:0px">
 
               <p style="color:white; font-size:16px"> {{$schedule->schedule_name}}</p>
                <p style="color:white; font-size:12px">
                    <a href="{{ URL::to('schedules/' . $schedule->id) }}" onclick="window.open('{{ URL::to('schedules/' . $schedule->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                    |
                    <a href="{{ URL::to('schedules/' . $schedule->id . '/edit') }}" onclick="window.open('{{ URL::to('schedules/' . $schedule->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
                  </p>
           </div>
         </div>
      
      @endforeach 
    </div>
  </div>  
</div>
<script>
$(document).ready(function(){
    $(".hideit").hide();

    $("#hide").click(function(){
         $(".hideit").hide();
    });
    $("#show").click(function(){
        $(".hideit").show();
    });
});
</script>
<script>
$(document).ready(function(){
    $(".hideit1").hide();
    $("#hide1").click(function(){
        $(".hideit1").hide();
    });
    $("#show1").click(function(){
        $(".hideit1").show();
    });
});
</script>
<script>
$(document).ready(function(){
    $(".hideit2").hide();
    $("#hide2").click(function(){
        $(".hideit2").hide();
    });
    $("#show2").click(function(){
        $(".hideit2").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit3").hide();

    $("#hide3").click(function(){
         $(".hideit3").hide();
    });
    $("#show3").click(function(){
        $(".hideit3").show();
    });
});
</script>
<script>
$(document).ready(function(){
    $(".hideit4").hide();

    $("#hide4").click(function(){
         $(".hideit4").hide();
    });
    $("#show4").click(function(){
        $(".hideit4").show();
    });
});
</script>
<script>
$(document).ready(function(){
    $(".hideit5").hide();

    $("#hide5").click(function(){
         $(".hideit5").hide();
    });
    $("#show5").click(function(){
        $(".hideit5").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit6").hide();

    $("#hide6").click(function(){
         $(".hideit6").hide();
    });
    $("#show6").click(function(){
        $(".hideit6").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit7").hide();

    $("#hide7").click(function(){
         $(".hideit7").hide();
    });
    $("#show7").click(function(){
        $(".hideit7").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit8").hide();

    $("#hide8").click(function(){
         $(".hideit8").hide();
    });
    $("#show8").click(function(){
        $(".hideit8").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit9").hide();

    $("#hide9").click(function(){
         $(".hideit9").hide();
    });
    $("#show9").click(function(){
        $(".hideit9").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit10").hide();

    $("#hide10").click(function(){
         $(".hideit10").hide();
    });
    $("#show10").click(function(){
        $(".hideit10").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit11").hide();

    $("#hide11").click(function(){
         $(".hideit11").hide();
    });
    $("#show11").click(function(){
        $(".hideit11").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit12").hide();

    $("#hide12").click(function(){
         $(".hideit12").hide();
    });
    $("#show12").click(function(){
        $(".hideit12").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit13").hide();

    $("#hide13").click(function(){
         $(".hideit13").hide();
    });
    $("#show13").click(function(){
        $(".hideit13").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit14").hide();

    $("#hide14").click(function(){
         $(".hideit14").hide();
    });
    $("#show14").click(function(){
        $(".hideit14").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit15").hide();

    $("#hide15").click(function(){
         $(".hideit15").hide();
    });
    $("#show15").click(function(){
        $(".hideit15").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit16").hide();

    $("#hide16").click(function(){
         $(".hideit16").hide();
    });
    $("#show16").click(function(){
        $(".hideit16").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit17").hide();

    $("#hide17").click(function(){
         $(".hideit17").hide();
    });
    $("#show17").click(function(){
        $(".hideit17").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit18").hide();

    $("#hide18").click(function(){
         $(".hideit18").hide();
    });
    $("#show18").click(function(){
        $(".hideit18").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit19").hide();

    $("#hide19").click(function(){
         $(".hideit19").hide();
    });
    $("#show19").click(function(){
        $(".hideit19").show();
    });
});
</script>

<script>
$(document).ready(function(){
    $(".hideit20").hide();

    $("#hide20").click(function(){
         $(".hideit20").hide();
    });
    $("#show20").click(function(){
        $(".hideit20").show();
    });
});
</script>



<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>
<script type="text/javascript">
      $(".sunday").hide();

     $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).attr("value")=="sun"){
                $(".sunday").toggle(500);
            }
        });
    });


</script>
<script type="text/javascript">
      $(".monday").hide();

     $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).attr("value")=="mon"){
                $(".monday").toggle(500);
            }
        });
    });
</script>
<script type="text/javascript">
      $(".tuesday").hide();

     $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).attr("value")=="tue"){
                $(".tuesday").toggle(500);
            }
        });
    });
</script>
<script type="text/javascript">
      $(".wednesday").hide();

     $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).attr("value")=="wed"){
                $(".wednesday").toggle(500);
            }
        });
    });
</script>
<script type="text/javascript">
      $(".thursday").hide();

     $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).attr("value")=="thu"){
                $(".thursday").toggle(500);
            }
        });
    });
</script>
<script type="text/javascript">
      $(".friday").hide();

     $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).attr("value")=="fri"){
                $(".friday").toggle(500);
            }
        });
    });
</script>
<script type="text/javascript">
      $(".saturday").hide();

     $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).attr("value")=="sat"){
                $(".saturday").toggle(500);
            }
        });
    });
</script>

<script type="text/javascript">
  function CopyThisM(f) {
  if(f.copytoallm.checked == true) {
    f.t_timein.value = f.m_timein.value;
    f.t_timeout.value = f.m_timeout.value;
    f.w_timein.value = f.m_timein.value;
    f.w_timeout.value = f.m_timeout.value;
    f.th_timein.value = f.m_timein.value;
    f.th_timeout.value = f.m_timeout.value;
    f.f_timein.value = f.m_timein.value;
    f.f_timeout.value = f.m_timeout.value;
    f.sat_timein.value = f.m_timein.value;
    f.sat_timeout.value = f.m_timeout.value;
    f.sun_timein.value = f.m_timein.value;
    f.sun_timeout.value = f.m_timeout.value;

  }
}
</script>
<script type="text/javascript">
  function CopyThisT(f) {
  if(f.copytoallt.checked == true) {
    f.m_timein.value = f.t_timein.value;
    f.m_timeout.value = f.t_timeout.value;
    f.w_timein.value = f.t_timein.value;
    f.w_timeout.value = f.t_timeout.value;
    f.th_timein.value = f.t_timein.value;
    f.th_timeout.value = f.t_timeout.value;
    f.f_timein.value = f.t_timein.value;
    f.f_timeout.value = f.t_timeout.value;
    f.sat_timein.value = f.t_timein.value;
    f.sat_timeout.value = f.t_timeout.value;
    f.sun_timein.value = f.t_timein.value;
    f.sun_timeout.value = f.t_timeout.value;

  }
}
</script>
<script type="text/javascript">
  function CopyThisW(f) {
  if(f.copytoallw.checked == true) {
    f.t_timein.value = f.w_timein.value;
    f.t_timeout.value = f.w_timeout.value;
    f.m_timein.value = f.w_timein.value;
    f.m_timeout.value = f.w_timeout.value;
    f.th_timein.value = f.w_timein.value;
    f.th_timeout.value = f.w_timeout.value;
    f.f_timein.value = f.w_timein.value;
    f.f_timeout.value = f.w_timeout.value;
    f.sat_timein.value = f.w_timein.value;
    f.sat_timeout.value = f.w_timeout.value;
    f.sun_timein.value = f.w_timein.value;
    f.sun_timeout.value = f.w_timeout.value;

  }
}
</script>
<script type="text/javascript">
  function CopyThisTh(f) {
  if(f.copytoallth.checked == true) {
    f.t_timein.value = f.th_timein.value;
    f.t_timeout.value = f.th_timeout.value;
    f.w_timein.value = f.th_timein.value;
    f.w_timeout.value = f.th_timeout.value;
    f.m_timein.value = f.th_timein.value;
    f.m_timeout.value = f.th_timeout.value;
    f.f_timein.value = f.th_timein.value;
    f.f_timeout.value = f.th_timeout.value;
    f.sat_timein.value = f.th_timein.value;
    f.sat_timeout.value = f.th_timeout.value;
    f.sun_timein.value = f.th_timein.value;
    f.sun_timeout.value = f.th_timeout.value;

  }
}
</script>
<script type="text/javascript">
  function CopyThisF(f) {
  if(f.copytoallf.checked == true) {
    f.t_timein.value = f.f_timein.value;
    f.t_timeout.value = f.f_timeout.value;
    f.w_timein.value = f.f_timein.value;
    f.w_timeout.value = f.f_timeout.value;
    f.th_timein.value = f.f_timein.value;
    f.th_timeout.value = f.f_timeout.value;
    f.m_timein.value = f.f_timein.value;
    f.m_timeout.value = f.f_timeout.value;
    f.sat_timein.value = f.f_timein.value;
    f.sat_timeout.value = f.f_timeout.value;
    f.sun_timein.value = f.f_timein.value;
    f.sun_timeout.value = f.f_timeout.value;

  }
}
</script>
<script type="text/javascript">
  function CopyThisSat(f) {
  if(f.copytoallsat.checked == true) {
    f.t_timein.value = f.sat_timein.value;
    f.t_timeout.value = f.sat_timeout.value;
    f.w_timein.value = f.sat_timein.value;
    f.w_timeout.value = f.sat_timeout.value;
    f.th_timein.value = f.sat_timein.value;
    f.th_timeout.value = f.sat_timeout.value;
    f.f_timein.value = f.sat_timein.value;
    f.f_timeout.value = f.sat_timeout.value;
    f.m_timein.value = f.sat_timein.value;
    f.m_timeout.value = f.sat_timeout.value;
    f.sun_timein.value = f.sat_timein.value;
    f.sun_timeout.value = f.sat_timeout.value;

  }
}
</script>
<script type="text/javascript">
  function CopyThisSun(f) {
  if(f.copytoallsun.checked == true) {
    f.t_timein.value = f.sun_timein.value;
    f.t_timeout.value = f.sun_timeout.value;
    f.w_timein.value = f.sun_timein.value;
    f.w_timeout.value = f.sun_timeout.value;
    f.th_timein.value = f.sun_timein.value;
    f.th_timeout.value = f.sun_timeout.value;
    f.f_timein.value = f.sun_timein.value;
    f.f_timeout.value = f.sun_timeout.value;
    f.sat_timein.value = f.sun_timein.value;
    f.sat_timeout.value = f.sun_timeout.value;
    f.m_timein.value = f.sun_timein.value;
    f.m_timeout.value = f.sun_timeout.value;

  }
}
</script>
@stop
