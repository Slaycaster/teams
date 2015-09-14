@extends("layout")
@section("content")

<head>
    <title>Create Branch | Time and Electronic Attendance Monitoring System</title>
</head>


<div class="col-md-12"  style="margin-bottom:15px; margin-left:-15px">

        <h1>Create Branch</h1>

        @if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
        <div class="btn-group btn-breadcrumb">
            <a href="{{ URL::to('dashboard') }}"  class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
            <a href="{{ URL::to('maintenance') }}"  class="btn btn-default">Maintenance</a>
            <a href="{{ URL::to('branches') }}"  class="btn btn-default">Branches</a>
            <a class="btn btn-default">Add Branch</a>
        </div>
  </div>



{{ Form::open(array('route' => 'branches.store')) }}

            <fieldset class="field">
            <div class="label_white">
                {{ Form::label('branch_name', 'Branch Name:')}}</div>
                {{ Form::text('branch_name', Input::get('branch_name'), array('placeholder' => 'Branch name','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('status', 'Status:') }}</div>
            {{ Form::select('status', array('Enabled' => 'Enabled', 'Disabled' => 'Disabled')) }}<br>

            <div class="label_white">{{ Form::label('code', 'Code:') }}</div>
            {{ Form::text('code', Input::get('code'), array('placeholder' => 'Code','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('address', 'Address:') }}</div>
            {{ Form::text('address', Input::get('address'), array('placeholder' => 'Address','autocomplete' => 'off', 'size' => '40')) }}<br>
            
            <div class="label_white">{{ Form::label('city', 'City:') }}</div>
            {{ Form::text('city', Input::get('city'), array('placeholder' => 'City','autocomplete' => 'off', 'size' => '40')) }}<br>
 
            <div class="label_white">{{ Form::label('country', 'Country:') }}</div>
            {{ Form::text('country', Input::get('country'), array('placeholder' => 'Country','autocomplete' => 'off', 'size' => '40')) }}<br>
 
            <div class="label_white">{{ Form::label('phone', 'Phone:') }}</div>
            {{ Form::text('phone', Input::get('phone'), array('placeholder' => 'Phone','autocomplete' => 'off', 'size' => '40')) }}<br>

            <div class="label_white">{{ Form::label('email', 'Email:') }}</div>
            {{ Form::text('email', Input::get('email'), array('placeholder' => 'Email','autocomplete' => 'off', 'size' => '40')) }}

            </fieldset><br><br>
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
    
            

    </ul>
{{ Form::close() }}


@stop


