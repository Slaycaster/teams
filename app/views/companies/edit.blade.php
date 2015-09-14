@extends('layouts.scaffold')

@section('main')

<h1>Edit Company</h1>
{{ Form::model($company, array('method' => 'PATCH', 'route' => array('companies.update', $company->id))) }}
	
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

			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('companies.show', 'Cancel', $company->id, array('class' => 'btn')) }}
		
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
