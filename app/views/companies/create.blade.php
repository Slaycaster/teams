@extends('layouts.scaffold')

@section('main')

<h1>Create Company</h1>

@if ($errors->any())
	<ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

{{ Form::open(array('route' => 'companies.store')) }}
    
            <div class="label_white">{{ Form::label('company_name', 'Company_name:') }}</div>
            {{ Form::text('company_name') }}<br>
        
            <div class="label_white">{{ Form::label('address', 'Address:') }}</div>
            {{ Form::text('address') }}<br>
        
            <div class="label_white">{{ Form::label('city', 'City:') }}</div>
            {{ Form::text('city') }}<br>
        
            <div class="label_white">{{ Form::label('country', 'Country:') }}</div>
            {{ Form::text('country') }}<br>
        
            <div class="label_white">{{ Form::label('phone', 'Phone:') }}</div>
            {{ Form::text('phone') }}<br><br>
        
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
      
{{ Form::close() }}


@stop


